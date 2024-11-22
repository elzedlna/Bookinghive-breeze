<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Hotel Images Gallery -->
            <div class="bg-white rounded-lg overflow-hidden mb-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 p-4">
                    @if ($hotel->images->isNotEmpty())
                        <div class="md:col-span-2 h-96">
                            <img src="{{ asset('storage/' . $hotel->images->first()->image_path) }}"
                                alt="{{ $hotel->name }}" class="w-full h-full object-cover rounded-lg">
                        </div>
                        <div class="grid grid-cols-2 gap-4 h-96">
                            @foreach ($hotel->images->skip(1)->take(4) as $image)
                                <div class="h-44">
                                    <img src="{{ asset('storage/' . $image->image_path) }}" alt="{{ $hotel->name }}"
                                        class="w-full h-full object-cover rounded-lg">
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="col-span-full h-96 bg-gray-200 flex items-center justify-center rounded-lg">
                            <span class="text-gray-400">No images available</span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Hotel Information -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Main Content -->
                <div class="md:col-span-2 space-y-6">
                    <!-- Basic Info -->
                    <div class="bg-white rounded-lg p-6">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h1 class="text-3xl font-bold text-gray-900">{{ $hotel->name }}</h1>
                                <p class="text-gray-600">{{ $hotel->address }}</p>
                            </div>
                            <div class="flex items-center bg-blue-100 px-3 py-1 rounded-full">
                                <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                <span class="ml-1 font-semibold">{{ number_format($hotel->rating, 1) }}</span>
                            </div>
                        </div>

                        <div class="prose max-w-none">
                            <p>{{ $hotel->description }}</p>
                        </div>
                    </div>

                    <!-- Amenities -->
                    <div class="bg-white rounded-lg p-6">
                        <h2 class="text-xl font-semibold mb-4">Amenities</h2>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                            @foreach ($hotel->amenities as $amenity)
                                <div class="flex items-center space-x-2">
                                    <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span>{{ ucfirst($amenity) }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Available Rooms -->
                    <div class="bg-white rounded-lg p-6">
                        <h2 class="text-xl font-semibold mb-4">Available Rooms</h2>
                        <div class="space-y-6">
                            @forelse ($hotel->roomTypes as $roomType)
                                <div class="border rounded-lg p-4 hover:shadow-md transition-shadow">
                                    <div class="flex justify-between items-start mb-2">
                                        <div>
                                            <h3 class="text-lg font-semibold">{{ $roomType->name }}</h3>
                                            <p class="text-sm text-gray-600">Fits up to {{ $roomType->capacity }} guests</p>
                                        </div>
                                        <div class="text-right">
                                            <div class="text-lg font-bold text-gray-900">
                                                RM{{ number_format($roomType->price_per_night, 2) }}
                                            </div>
                                            <div class="text-sm text-gray-500">per night</div>
                                        </div>
                                    </div>
                                    
                                    <p class="text-gray-700 mb-4">{{ $roomType->description }}</p>
                                    
                                    <div class="flex justify-between items-center">
                                        <div class="text-sm text-gray-600">
                                            {{ $roomType->total_rooms }} rooms available
                                        </div>
                                        <a href="{{ route('user.booking.create', ['hotel' => $hotel, 'room_type' => $roomType]) }}" 
                                            class="inline-block bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition duration-150">
                                            Book Now
                                        </a>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-4">
                                    <p class="text-gray-500">No room types available at the moment.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Reviews -->
                    <div class="bg-white rounded-lg p-6">
                        <h2 class="text-xl font-semibold mb-4">Guest Reviews</h2>
                        <div class="space-y-4">
                            @forelse($hotel->reviews as $review)
                                <div class="border-b border-gray-200 pb-4 last:border-0">
                                    <div class="flex justify-between items-start mb-2">
                                        <div>
                                            <p class="font-medium">{{ $review->user->name }}</p>
                                            <p class="text-sm text-gray-500">
                                                {{ $review->created_at->format('M d, Y') }}</p>
                                        </div>
                                        <div class="flex items-center">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <svg class="w-4 h-4 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }}"
                                                    fill="currentColor" viewBox="0 0 20 20">
                                                    <path
                                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                </svg>
                                            @endfor
                                        </div>
                                    </div>
                                    <p class="text-gray-700">{{ $review->comment }}</p>

                                    <!-- Owner's Reply -->
                                    @if($review->reply)
                                        <div class="mt-4 ml-6 p-4 bg-gray-50 rounded-lg">
                                            <div class="flex items-center mb-2">
                                                <span class="font-medium text-blue-600">Hotel Response</span>
                                                <span class="text-sm text-gray-500 ml-2">{{ $review->reply->created_at->format('M d, Y') }}</span>
                                            </div>
                                            <p class="text-gray-700">{{ $review->reply->reply }}</p>
                                        </div>
                                    @endif

                                    <!-- Reply Form for Hotel Owner -->
                                    @if(Auth::id() === $hotel->user_id && !$review->reply)
                                        <div class="mt-4 ml-6">
                                            <form action="{{ route('hotel.review.reply', $review) }}" method="POST">
                                                @csrf
                                                <div class="mb-2">
                                                    <textarea name="reply" rows="3" required
                                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                                                        placeholder="Write your response..."></textarea>
                                                </div>
                                                <div class="flex justify-end">
                                                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                                                        Post Reply
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    @endif
                                </div>
                            @empty
                                <p class="text-gray-500 text-center">No reviews yet.</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="md:col-span-1">
                    <div class="bg-white rounded-lg p-6 sticky top-6">
                        <div class="text-center mb-4">
                            <span
                                class="text-2xl font-bold text-gray-900">RM{{ number_format($hotel->price_per_night, 2) }}</span>
                            <span class="text-gray-600">/night</span>
                        </div>

                        <div class="space-y-4 mb-6">
                            <div>
                                <span class="block text-sm font-medium text-gray-700">Available Rooms</span>
                                <span class="text-lg font-semibold text-gray-900">{{ $hotel->total_rooms }}</span>
                            </div>
                            <div>
                                <span class="block text-sm font-medium text-gray-700">Contact</span>
                                <span class="text-gray-900">{{ $hotel->phone }}</span>
                            </div>
                            <div>
                                <span class="block text-sm font-medium text-gray-700">Email</span>
                                <span class="text-gray-900">{{ $hotel->email }}</span>
                            </div>
                        </div>

                        <a href="{{ route('user.booking.create', $hotel) }}"
                            class="block w-full bg-blue-600 text-white text-center px-4 py-2 rounded-lg hover:bg-blue-700 transition duration-150">
                            Book Now
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
