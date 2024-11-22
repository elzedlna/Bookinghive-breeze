<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-semibold">Edit Hotel</h2>
                        <a href="{{ route('admin.hotels') }}" class="text-blue-600 hover:text-blue-800">← Back to Hotels</a>
                    </div>

                    <form action="{{ route('admin.hotels.update', $hotel) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- Basic Information -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="name" value="Hotel Name" />
                                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                                    value="{{ old('name', $hotel->name) }}" required />
                                <x-input-error class="mt-2" :messages="$errors->get('name')" />
                            </div>

                            <div>
                                <x-input-label for="email" value="Hotel Email" />
                                <x-text-input id="email" name="email" type="email" class="mt-1 block w-full"
                                    value="{{ old('email', $hotel->email) }}" required />
                                <x-input-error class="mt-2" :messages="$errors->get('email')" />
                            </div>

                            <div>
                                <x-input-label for="phone" value="Phone Number" />
                                <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full"
                                    value="{{ old('phone', $hotel->phone) }}" required />
                                <x-input-error class="mt-2" :messages="$errors->get('phone')" />
                            </div>

                            <div>
                                <x-input-label for="address" value="Address" />
                                <x-text-input id="address" name="address" type="text" class="mt-1 block w-full"
                                    value="{{ old('address', $hotel->address) }}" required />
                                <x-input-error class="mt-2" :messages="$errors->get('address')" />
                            </div>
                        </div>

                        <!-- Description -->
                        <div>
                            <x-input-label for="description" value="Description" />
                            <textarea id="description" name="description" rows="4"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                required>{{ old('description', $hotel->description) }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('description')" />
                        </div>

                        <!-- Amenities -->
                        <div>
                            <x-input-label value="Amenities" class="mb-2" />
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                @php
                                    $amenities = ['wifi', 'pool', 'spa', 'gym', 'restaurant', 'parking', 'bar', 'room_service', 'conference_room', 'laundry'];
                                    $hotelAmenities = old('amenities', $hotel->amenities ?? []);
                                @endphp
                                @foreach($amenities as $amenity)
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" name="amenities[]" value="{{ $amenity }}"
                                            {{ in_array($amenity, $hotelAmenities) ? 'checked' : '' }}
                                            class="rounded border-gray-300 text-blue-600 shadow-sm">
                                        <span class="ml-2">{{ ucfirst(str_replace('_', ' ', $amenity)) }}</span>
                                    </label>
                                @endforeach
                            </div>
                            <x-input-error class="mt-2" :messages="$errors->get('amenities')" />
                        </div>

                        <!-- Room Types Section -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Room Types</h3>
                            <div class="space-y-4">
                                @foreach($hotel->roomTypes as $roomType)
                                    <div class="border rounded-lg p-4">
                                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                            <div>
                                                <span class="block text-sm font-medium text-gray-700">Room Type</span>
                                                <span class="text-gray-900">{{ $roomType->name }}</span>
                                            </div>
                                            <div>
                                                <span class="block text-sm font-medium text-gray-700">Price per Night</span>
                                                <span class="text-gray-900">RM{{ number_format($roomType->price_per_night, 2) }}</span>
                                            </div>
                                            <div>
                                                <span class="block text-sm font-medium text-gray-700">Available Rooms</span>
                                                <span class="text-gray-900">{{ $roomType->total_rooms }}</span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Current Images -->
                        @if($hotel->images->count() > 0)
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Current Images</h3>
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                    @foreach($hotel->images as $image)
                                        <div class="relative aspect-video">
                                            <img src="{{ asset('storage/' . $image->image_path) }}" 
                                                alt="Hotel image" 
                                                class="w-full h-full object-cover rounded-lg">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <div class="flex justify-end gap-4">
                            <x-secondary-button onclick="window.history.back()" type="button">
                                Cancel
                            </x-secondary-button>
                            <x-primary-button>
                                Update Hotel
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 