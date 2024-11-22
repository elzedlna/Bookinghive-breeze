<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Hotel;
use App\Models\RoomType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function create(Request $request, Hotel $hotel)
    {
        $roomType = null;
        if ($request->has('room_type')) {
            $roomType = $hotel->roomTypes()->findOrFail($request->room_type);
        }
        
        return view('user.booking.create', compact('hotel', 'roomType'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'hotel_id' => 'required|exists:hotels,id',
            'room_type_id' => 'required|exists:room_types,id',
            'check_in_date' => 'required|date|after:today',
            'check_out_date' => 'required|date|after:check_in_date',
            'number_of_rooms' => 'required|integer|min:1'
        ]);

        $roomType = RoomType::findOrFail($validated['room_type_id']);
        
        // Check if enough rooms are available
        if ($roomType->total_rooms < $validated['number_of_rooms']) {
            return back()->withErrors(['number_of_rooms' => 'Not enough rooms available.']);
        }

        $booking = Booking::create([
            'user_id' => Auth::id(),
            'hotel_id' => $validated['hotel_id'],
            'room_type_id' => $validated['room_type_id'],
            'check_in_date' => $validated['check_in_date'],
            'check_out_date' => $validated['check_out_date'],
            'number_of_rooms' => $validated['number_of_rooms'],
            'price_per_night' => $roomType->price_per_night,
            'status' => 'pending'
        ]);

        return redirect()->route('user.bookings')->with('success', 'Booking request submitted successfully!');
    }
} 