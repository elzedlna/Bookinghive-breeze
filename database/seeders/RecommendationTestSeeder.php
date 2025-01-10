<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Hotel;
use App\Models\Booking;
use App\Models\Review;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RecommendationTestSeeder extends Seeder
{
    public function run()
    {
        // Create test users
        $users = collect([
            User::create([
                'name' => 'Test User',
                'email' => 'test@ex1.com',
                'password' => Hash::make('password'),
            ]),
        ]);

        // Create 4 more test users
        for ($i = 1; $i <= 4; $i++) {
            $users->push(
                User::create([
                    'name' => "Test User {$i}",
                    'email' => "test{$i}@ex1.com",
                    'password' => Hash::make('password'),
                ])
            );
        }

        // Create 10 hotels
        $hotels = collect();
        for ($i = 1; $i <= 10; $i++) {
            $hotels->push(
                Hotel::create([
                    'user_id' => $users[rand(0, 4)]->id,  // Randomly assign to one of our test users
                    'name' => "Test Hotel {$i}",
                    'description' => "Description for Hotel {$i}",
                    'address' => "Location {$i}",
                    'price_per_night' => rand(100, 500),
                    'total_rooms' => rand(5, 20),
                    'phone' => '0111' . rand(1000000, 9999999),
                    'email' => "hotel{$i}@example.com",
                    'amenities' => ["wifi", "pool", "parking"],
                    'rating' => 0.0,
                ])
            );
        }

        // Create bookings and reviews to simulate patterns
        // Main test user books hotels 1, 2, and 3
        // Create bookings and reviews to simulate patterns
        // Main test user books hotels 1, 2, and 3
        $mainUser = $users[0];
        foreach ([0, 1, 2] as $index) {
            $booking = Booking::create([
                'user_id' => $mainUser->id,
                'hotel_id' => $hotels[$index]->id,
                'check_in' => now()->addDays(rand(1, 30)),
                'check_out' => now()->addDays(rand(31, 60)),
                'number_of_rooms' => rand(1, 3),
                'price_per_night' => $hotels[$index]->price_per_night,
                'total_price' => rand(300, 1500),
                'status' => 'confirmed', // Use lowercase as per your database
                'room_type_id' => 1  // Assuming you have room types set up
            ]);

            Review::create([
                'user_id' => $mainUser->id,
                'hotel_id' => $hotels[$index]->id,
                'booking_id' => $booking->id,
                'rating' => rand(4, 5),
                'comment' => "Great stay at hotel {$index}",
            ]);
        }

        // Similar users (1 and 2) book some of the same hotels
        foreach ([0, 1, 2, 3] as $hotelIndex) {
            foreach ([1, 2] as $userIndex) {
                $booking = Booking::create([
                    'user_id' => $users[$userIndex]->id,
                    'hotel_id' => $hotels[$hotelIndex]->id,
                    'check_in' => now()->addDays(rand(1, 30)),
                    'check_out' => now()->addDays(rand(31, 60)),
                    'number_of_rooms' => rand(1, 3),
                    'price_per_night' => $hotels[$index]->price_per_night,
                    'total_price' => rand(300, 1500),
                    'status' => 'confirmed', // Use lowercase as per your database
                    'room_type_id' => 1  // Assuming you have room types set up
                ]);

                Review::create([
                    'user_id' => $users[$userIndex]->id,
                    'hotel_id' => $hotels[$hotelIndex]->id,
                    'booking_id' => $booking->id,
                    'rating' => rand(4, 5),
                    'comment' => "Nice hotel, enjoyed the stay!",
                ]);
            }
        }

        // Different users (3 and 4) book different hotels
        foreach ([6, 7, 8, 9] as $hotelIndex) {
            foreach ([3, 4] as $userIndex) {
                $booking = Booking::create([
                    'user_id' => $users[$userIndex]->id,
                    'hotel_id' => $hotels[$hotelIndex]->id,
                    'check_in' => now()->addDays(rand(1, 30)),
                    'check_out' => now()->addDays(rand(31, 60)),
                    'number_of_rooms' => rand(1, 3),
                    'price_per_night' => $hotels[$index]->price_per_night,
                    'total_price' => rand(300, 1500),
                    'status' => 'confirmed', // Use lowercase as per your database
                    'room_type_id' => 1  // Assuming you have room types set up
                ]);

                Review::create([
                    'user_id' => $users[$userIndex]->id,
                    'hotel_id' => $hotels[$hotelIndex]->id,
                    'booking_id' => $booking->id,
                    'rating' => rand(3, 5),
                    'comment' => "Standard hotel experience",
                ]);
            }
        }

        // Create some popular hotels (hotels 4 and 5) with high ratings
        foreach ([4, 5] as $hotelIndex) {
            foreach ($users as $user) {
                if ($user->id !== $mainUser->id) {
                    $booking = Booking::create([
                        'user_id' => $user->id,
                        'hotel_id' => $hotels[$hotelIndex]->id,
                        'check_in' => now()->addDays(rand(1, 30)),
                        'check_out' => now()->addDays(rand(31, 60)),
                        'number_of_rooms' => rand(1, 3),
                        'price_per_night' => $hotels[$index]->price_per_night,
                        'total_price' => rand(300, 1500),
                        'status' => 'confirmed', // Use lowercase as per your database
                        'room_type_id' => 1  // Assuming you have room types set up
                    ]);

                    Review::create([
                        'user_id' => $user->id,
                        'hotel_id' => $hotels[$hotelIndex]->id,
                        'booking_id' => $booking->id,
                        'rating' => 5,
                        'comment' => "Excellent hotel, highly recommended!",
                    ]);
                }
            }
        }
    }
}
