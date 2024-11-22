<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="text-2xl font-semibold mb-6">Book Hotel: {{ $hotel->name }}</h2>

                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900">Hotel Details</h3>
                        <p class="mt-1 text-sm text-gray-600">{{ $hotel->description }}</p>
                        <div class="mt-2">
                            <p><span class="font-semibold">Address:</span> {{ $hotel->address }}</p>
                            @if($hotel->amenities)
                                <div class="mt-2">
                                    <span class="font-semibold">Amenities:</span>
                                    <div class="flex flex-wrap gap-2 mt-1">
                                        @foreach($hotel->amenities as $amenity)
                                            <span class="px-2 py-1 bg-gray-100 rounded-full text-sm">
                                                {{ ucfirst($amenity) }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <form method="POST" action="{{ route('user.booking.store', $hotel) }}" class="mt-6">
                        @csrf
                        
                        <!-- Room Type Selection -->
                        <div class="mb-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Select Room Type</h3>
                            <div class="grid grid-cols-1 gap-4">
                                @foreach($hotel->roomTypes as $type)
                                    <div class="border rounded-lg p-4 @if($roomType && $roomType->id === $type->id) ring-2 ring-blue-500 @endif">
                                        <label class="flex items-start space-x-4">
                                            <input type="radio" name="room_type_id" value="{{ $type->id }}"
                                                {{ ($roomType && $roomType->id === $type->id) ? 'checked' : '' }}
                                                class="mt-1 h-4 w-4 text-blue-600 border-gray-300 focus:ring-blue-500"
                                                required>
                                            <div class="flex-1">
                                                <div class="flex justify-between">
                                                    <span class="font-medium text-gray-900">{{ $type->name }}</span>
                                                    <span class="text-gray-900 font-semibold">
                                                        RM{{ number_format($type->price_per_night, 2) }}/night
                                                    </span>
                                                </div>
                                                <p class="text-sm text-gray-500 mt-1">{{ $type->description }}</p>
                                                <div class="mt-2 text-sm text-gray-600">
                                                    <span class="font-medium">Capacity:</span> {{ $type->capacity }} guests
                                                    <span class="mx-2">•</span>
                                                    <span class="font-medium">Available:</span> {{ $type->total_rooms }} rooms
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="check_in_date" value="Check-in Date" />
                                <x-text-input id="check_in_date" name="check_in" type="date" 
                                    class="mt-1 block w-full" required />
                                <x-input-error class="mt-2" :messages="$errors->get('check_in')" />
                            </div>

                            <div>
                                <x-input-label for="check_out_date" value="Check-out Date" />
                                <x-text-input id="check_out_date" name="check_out" type="date" 
                                    class="mt-1 block w-full" required />
                                <x-input-error class="mt-2" :messages="$errors->get('check_out')" />
                            </div>

                            <div>
                                <x-input-label for="number_of_rooms" value="Number of Rooms" />
                                <x-text-input id="number_of_rooms" name="number_of_rooms" type="number" 
                                    class="mt-1 block w-full" min="1" required />
                                <x-input-error class="mt-2" :messages="$errors->get('number_of_rooms')" />
                            </div>
                        </div>

                        <!-- Price Calculator -->
                        <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                            <h4 class="font-medium text-gray-900">Price Summary</h4>
                            <div id="price-summary" class="mt-2">
                                <p class="text-gray-600">Select dates and room type to see total price</p>
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <x-secondary-button onclick="window.history.back()" type="button" class="mr-3">
                                Cancel
                            </x-secondary-button>
                            <x-primary-button>
                                Book Now
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Set minimum date for check-in to today
        const today = new Date().toISOString().split('T')[0];
        document.getElementById('check_in_date').min = today;

        // Update check-out minimum date when check-in is selected
        document.getElementById('check_in_date').addEventListener('change', function() {
            const checkInDate = new Date(this.value);
            const nextDay = new Date(checkInDate);
            nextDay.setDate(checkInDate.getDate() + 1);
            document.getElementById('check_out_date').min = nextDay.toISOString().split('T')[0];
            updatePriceSummary();
        });

        // Update price summary when inputs change
        document.getElementById('check_out_date').addEventListener('change', updatePriceSummary);
        document.getElementById('number_of_rooms').addEventListener('input', updatePriceSummary);
        document.querySelectorAll('input[name="room_type_id"]').forEach(radio => {
            radio.addEventListener('change', updatePriceSummary);
        });

        function updatePriceSummary() {
            const checkIn = new Date(document.getElementById('check_in_date').value);
            const checkOut = new Date(document.getElementById('check_out_date').value);
            const numberOfRooms = parseInt(document.getElementById('number_of_rooms').value) || 0;
            const selectedRoomType = document.querySelector('input[name="room_type_id"]:checked');

            if (checkIn && checkOut && numberOfRooms && selectedRoomType) {
                const nights = Math.ceil((checkOut - checkIn) / (1000 * 60 * 60 * 24));
                const pricePerNight = parseFloat(selectedRoomType.closest('.border').querySelector('.text-gray-900.font-semibold').textContent.replace(/[^0-9.]/g, ''));
                const totalPrice = nights * numberOfRooms * pricePerNight;

                document.getElementById('price-summary').innerHTML = `
                    <div class="space-y-2">
                        <p><span class="text-gray-600">Price per night:</span> <span class="font-medium">RM${pricePerNight.toFixed(2)}</span></p>
                        <p><span class="text-gray-600">Number of nights:</span> <span class="font-medium">${nights}</span></p>
                        <p><span class="text-gray-600">Number of rooms:</span> <span class="font-medium">${numberOfRooms}</span></p>
                        <div class="border-t pt-2 mt-2">
                            <p class="text-lg font-semibold">Total: RM${totalPrice.toFixed(2)}</p>
                        </div>
                    </div>
                `;
            } else {
                document.getElementById('price-summary').innerHTML = `
                    <p class="text-gray-600">Select dates and room type to see total price</p>
                `;
            }
        }

        // Set max rooms based on selected room type
        document.querySelectorAll('input[name="room_type_id"]').forEach(radio => {
            radio.addEventListener('change', function() {
                const availableRooms = parseInt(this.closest('.border').querySelector('.text-gray-600').textContent.match(/Available: (\d+)/)[1]);
                document.getElementById('number_of_rooms').max = availableRooms;
                document.getElementById('number_of_rooms').value = Math.min(
                    document.getElementById('number_of_rooms').value || 1,
                    availableRooms
                );
            });
        });
    </script>
    @endpush
</x-app-layout> 