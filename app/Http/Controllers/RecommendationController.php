<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\Booking;
use Illuminate\Support\Facades\DB;

class RecommendationController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $hotels = $this->getRecommendedHotelsForDashboard($user->id, 6);
        $popularHotels = null;
        $message = null;

        if ($hotels->isEmpty()) {
            $message = "No recommendations available yet. Start booking and rating hotels to get personalized suggestions!";
            
            // Get popular hotels as fallback
            $popularHotels = Hotel::withAvg('reviews', 'rating')
                ->having('reviews_avg_rating', '>=', 4)
                ->orderByDesc('reviews_avg_rating')
                ->take(6)
                ->get();
        }

        return view('user.recommend', compact('hotels', 'popularHotels', 'message'));
    }

    public function getRecommendedHotelsForDashboard($userId, $limit = 6)
    {
        // Check if the user has any bookings
        $userBookingsCount = Booking::where('user_id', $userId)->count();

        if ($userBookingsCount === 0) {
            return collect();
        }

        // Get hotels booked by the user
        $userBookedHotels = Booking::where('user_id', $userId)
            ->pluck('hotel_id')
            ->toArray();

        // If user has less than 3 bookings, recommend similar hotels based on ratings
        if ($userBookingsCount < 3) {
            return $this->getRecommendationsByRatings($userId, $userBookedHotels, $limit);
        }

        // Find similar users based on booking history
        $similarUsers = $this->findSimilarUsersByBookings($userId, $userBookedHotels);

        if ($similarUsers->isEmpty()) {
            return $this->getRecommendationsByRatings($userId, $userBookedHotels, $limit);
        }

        // Get hotel recommendations based on similar users
        return $this->getRecommendedHotels($userId, $similarUsers, $limit);
    }

    private function getRecommendationsByRatings($userId, $userBookedHotels, $limit)
    {
        // Get the average rating given by the user
        $userAvgRating = DB::table('reviews')
            ->where('user_id', $userId)
            ->avg('rating') ?? 4; // Default to 4 if no ratings

        return Hotel::whereNotIn('id', $userBookedHotels)
            ->withAvg('reviews', 'rating')
            ->having('reviews_avg_rating', '>=', $userAvgRating - 1)
            ->orderByDesc('reviews_avg_rating')
            ->take($limit)
            ->get();
    }

    private function findSimilarUsersByBookings($userId, $userBookedHotels)
    {
        return DB::table('bookings as b1')
            ->join('bookings as b2', 'b1.hotel_id', '=', 'b2.hotel_id')
            ->where('b1.user_id', $userId)
            ->where('b2.user_id', '!=', $userId)
            ->whereIn('b1.hotel_id', $userBookedHotels)
            ->groupBy('b2.user_id')
            ->select(
                'b2.user_id',
                DB::raw('COUNT(*) as common_bookings')
            )
            ->orderByDesc('common_bookings')
            ->limit(5)
            ->pluck('b2.user_id');
    }

    private function getRecommendedHotels($userId, $similarUsers, $limit)
    {
        return Hotel::whereHas('bookings', function ($query) use ($similarUsers) {
                $query->whereIn('user_id', $similarUsers);
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