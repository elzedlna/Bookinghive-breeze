<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\Booking;
use Illuminate\Support\Facades\DB;

class RecommendationController extends Controller
{
    public function getRecommendedHotelsForDashboard($userId, $limit = 3)
    {
        // Check if the user has made at least 3 bookings
        $userBookingsCount = Booking::where('user_id', $userId)->count();

        if ($userBookingsCount < 3) {
            // No recommendations for new users or those with fewer than 3 bookings
            return collect();
        }

        // Get hotels booked by the user
        $userBookedHotels = Booking::where('user_id', $userId)
            ->pluck('hotel_id')
            ->toArray();

        // Find similar users based on booking history
        $similarUsers = $this->findSimilarUsersByBookings($userId, $userBookedHotels);

        // Get hotel recommendations based on similar users
        return $this->getRecommendedHotels($userId, $similarUsers, $limit);
    }

    private function findSimilarUsersByBookings($userId, $userBookedHotels)
    {
        // Find users who booked the same hotels
        return DB::table('bookings as b1')
            ->join('bookings as b2', 'b1.hotel_id', '=', 'b2.hotel_id')
            ->where('b1.user_id', $userId)
            ->where('b2.user_id', '!=', $userId)
            ->whereIn('b1.hotel_id', $userBookedHotels)
            ->groupBy('b2.user_id')
            ->select(
                'b2.user_id',
                DB::raw('COUNT(*) as common_bookings') // Count overlapping bookings
            )
            ->orderByDesc('common_bookings') // Users with more common bookings appear first
            ->limit(5) // Limit to top 5 similar users
            ->pluck('b2.user_id');
    }

    private function getRecommendedHotels($userId, $similarUsers, $limit)
    {
        // Suggest hotels booked by similar users but not yet booked by the current user
        return Hotel::whereHas('bookings', function ($query) use ($similarUsers) {
                $query->whereIn('user_id', $similarUsers);
            })
            ->whereDoesntHave('bookings', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->withAvg('reviews', 'rating') // Include average ratings for additional context
            ->orderByDesc('reviews_avg_rating')
            ->take($limit)
            ->get();
    }
}