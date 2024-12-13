<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RecommendationController extends Controller
{
    public function showRecommendations($userId)
    {
        // Count user bookings
        $userBookingCount = DB::table('user_bookings')
            ->where('user_id', $userId)
            ->count();

        // Check if user has at least 5 bookings
        if ($userBookingCount < 5) {
            return view('user.recommendations', [
                'hotels' => [],
                'message' => 'You need to complete at least 5 bookings to see personalized recommendations.'
            ]);
        }

        // Fetch recommended hotels
        $recommendedHotels = $this->getHotelRecommendations($userId);

        // Fetch hotel details
        $hotels = DB::table('hotels')->whereIn('id', $recommendedHotels)->get();

        return view('user.recommendations', compact('hotels'));
    }

    private function getHotelRecommendations($userId)
    {
        // Find hotels booked by similar users but not the current user
        $userBookings = DB::table('user_bookings')
            ->where('user_id', $userId)
            ->pluck('hotel_id')
            ->toArray();

        $similarUsers = DB::table('user_bookings')
            ->select('user_id')
            ->whereIn('hotel_id', $userBookings)
            ->where('user_id', '<>', $userId)
            ->groupBy('user_id')
            ->pluck('user_id')
            ->toArray();

        $recommendedHotels = DB::table('user_bookings')
            ->whereIn('user_id', $similarUsers)
            ->whereNotIn('hotel_id', $userBookings)
            ->groupBy('hotel_id')
            ->orderByRaw('COUNT(hotel_id) DESC')
            ->pluck('hotel_id')
            ->toArray();

        return $recommendedHotels;
    }
}
