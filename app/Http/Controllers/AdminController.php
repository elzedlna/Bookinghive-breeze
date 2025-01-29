<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Hotel;
use App\Models\Review;
use Illuminate\Http\Request;
use App\Mail\SeasonalEmail;
use Illuminate\Support\Facades\Mail;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalUsers = User::count();
        $totalHotels = Hotel::count();
        $totalReviews = Review::count();
        
        return view('admin.dashboard', compact('totalUsers', 'totalHotels', 'totalReviews'));
    }

    public function users(Request $request)
    {
        $query = User::query();

        // Apply search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Apply role filter
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        // Fetch paginated results
        $users = $query->latest()->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    public function editUser(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function updateUser(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,hotel,user'
        ]);

        $user->update($validated);

        return redirect()->route('admin.users')
            ->with('success', 'User updated successfully');
    }

    public function hotels(Request $request)
    {
        $query = Hotel::with(['user', 'roomTypes']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%")
                  ->orWhereHas('user', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $hotels = $query->latest()->paginate(10);
        return view('admin.hotels.index', compact('hotels'));
    }

    public function editHotel(Hotel $hotel)
    {
        return view('admin.hotels.edit', compact('hotel'));
    }

    public function updateHotel(Request $request, Hotel $hotel)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'description' => 'required|string',
            'amenities' => 'nullable|array',
            'amenities.*' => 'string|in:wifi,pool,spa,gym,restaurant,parking,bar,room_service,conference_room,laundry',
        ]);

        $hotel->update($validated);

        return redirect()->route('admin.hotels')
            ->with('success', 'Hotel updated successfully');
    }

   public function sendSeasonalEmail()
    {
        try {
            // Fetch only users with the role of 'user'
           $users = User::where('role', 'user')->get();
        
         foreach ($users as $user) {
             // Queue email with a delay to avoid rate-limiting issues
               Mail::to($user->email)
                  ->later(now()->addSeconds($users->search($user) * 5), new SeasonalEmail($user));
         }
        
          return redirect()->back()
             ->with('success', 'Seasonal emails queued for ' . $users->count() . ' users');
     }   catch (\Exception $e) {
         return redirect()->back()
             ->with('error', 'Failed to queue emails: ' . $e->getMessage());
        }
    }

    public function showUserDetails(User $user)
    {
    // Assuming you have a relationship 'bookings' on the User model that fetches their bookings
    $bookings = $user->bookings()->with('hotel')->get();

    return view('admin.users.userdetails', compact('user', 'bookings'));
    }

    public function showHotelDetails(Request $request)
    {
    // Fetch all hotels with optional filtering if necessary
    $query = Hotel::query();

    // Apply search filter for hotels
    if ($request->filled('search')) {
        $search = $request->search;
        $query->where('name', 'like', "%{$search}%")
              ->orWhere('address', 'like', "%{$search}%");
    }

    // Fetch paginated results
    $hotels = $query->with(['user', 'bookings'])->paginate(10);

    return view('admin.hotels.details', compact('hotels'));
    }
}
