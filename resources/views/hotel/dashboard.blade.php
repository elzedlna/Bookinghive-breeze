<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif
            
            <!-- Header with Create Button -->
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-semibold text-gray-900">My Hotels</h1>
                <div class="space-x-4">
                    <a href="{{ route('hotel.bookings') }}"
                        class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg">
                        Manage Bookings
                    </a>
                    <a href="{{ route('hotel.create') }}"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                        Add New Hotel
                    </a>
                </div>
            </div>

            <!-- Hotels Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse ($hotels as $hotel)
                    <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                        <!-- Hotel Image -->
                        <div class="h-48 overflow-hidden">
                            @if ($hotel->images->count() > 0)
                                <img src="{{ asset('storage/' . $hotel->images->first()->image_path) }}"
                                    alt="{{ $hotel->name }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                                    <span class="text-gray-400">No image available</span>
                                </div>
                            @endif
                        </div>

                        <!-- Hotel Details -->
                        <div class="p-6">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <h3 class="text-xl font-semibold text-gray-900">{{ $hotel->name }}</h3>
                                    <p class="text-gray-600">{{ $hotel->address }}</p>
                                </div>
                                <div class="flex items-center">
                                    <span class="text-yellow-400">★</span>
                                    <span class="ml-1 text-gray-600">{{ $hotel->rating }}</span>
                                </div>
                            </div>

                            <!-- Hotel Info -->
                            <div class="space-y-2">
                                <p class="text-sm text-gray-600">
                                    <span class="font-medium">Rooms:</span> {{ $hotel->total_rooms }}
                                </p>
                                <p class="text-sm text-gray-600">
                                    <span class="font-medium">Contact:</span> {{ $hotel->phone }}
                                </p>

                                <!-- Amenities -->
                                @if ($hotel->amenities)
                                    <div class="mt-4">
                                        <p class="text-sm font-medium text-gray-700 mb-2">Amenities:</p>
                                        <div class="flex flex-wrap gap-2">
                                            @foreach ($hotel->amenities as $amenity)
                                                <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">
                                                    {{ $amenity }}
                                                </span>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <!-- Action Buttons -->
                            <div class="mt-6 flex justify-end space-x-3">
                                <a href="{{ route('hotel.edit', $hotel->id) }}"
                                    class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">
                                    Edit
                                </a>
                                <form action="{{ route('hotel.destroy', $hotel->id) }}" method="POST" class="inline"
                                    onsubmit="return confirm('Are you sure you want to delete this hotel? This action cannot be undone.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                        class="px-4 py-2 bg-red-100 text-red-700 rounded-lg hover:bg-red-200">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full bg-white rounded-lg shadow-sm p-6 text-center">
                        <p class="text-gray-500">You haven't registered any hotels yet.</p>
                        <a href="{{ route('hotel.create') }}"
                            class="mt-4 inline-block bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                            Register Your First Hotel
                        </a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
