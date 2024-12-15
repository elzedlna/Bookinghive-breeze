<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\Review;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

class RecommendationController extends Controller
{
    public function getRecommendedHotelsForDashboard($userId, $limit = 3)
    {
        // Get user's ratings
        $userRatings = Review::where('user_id', $userId)
            ->pluck('rating', 'hotel_id');

        if ($userRatings->isEmpty()) {
            // If no ratings, return popular hotels
            return Hotel::withAvg('reviews', 'rating')
                ->having('reviews_avg_rating', '>=', 4)
                ->orderByDesc('reviews_avg_rating')
                ->take($limit)
                ->get();
        }

        // Get all users who rated the same hotels
        $similarUsers = $this->findSimilarUsers($userId);

        // Get recommended hotels
        return $this->getRecommendedHotels($userId, $similarUsers, $limit);
    }

    private function findSimilarUsers($userId)
    {
        return DB::table('reviews as r1')
            ->join('reviews as r2', 'r1.hotel_id', '=', 'r2.hotel_id')
            ->where('r1.user_id', $userId)
            ->where('r2.user_id', '!=', $userId)
            ->groupBy('r2.user_id')
            ->select(
                'r2.user_id',
                DB::raw('COUNT(*) as common_ratings'),
                DB::raw('SUM(ABS(r1.rating - r2.rating)) as rating_diff')
            )
            ->orderByRaw('SUM(ABS(r1.rating - r2.rating)) / COUNT(*) ASC')
            ->limit(5)
            ->pluck('r2.user_id');
    }

    private function getRecommendedHotels($userId, $similarUsers, $limit)
    {
        return Hotel::whereHas('reviews', function ($query) use ($similarUsers) {
                $query->whereIn('user_id', $similarUsers)
                    ->where('rating', '>=', 4);
            })
            ->whereDoesntHave('reviews', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->whereDoesntHave('bookings', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->withAvg('reviews', 'rating')
            ->orderByDesc('reviews_avg_rating')
            ->take($limit)
            ->get();
    }
}