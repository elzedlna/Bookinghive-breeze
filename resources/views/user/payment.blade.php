<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="text-2xl font-semibold mb-6">Payment Details</h2>

                    <!-- Booking Summary -->
                    <div class="mb-8 p-4 bg-gray-50 rounded-lg">
                        <h3 class="text-lg font-medium mb-4">Booking Summary</h3>
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <p><span class="font-medium">Hotel:</span> {{ $booking->hotel->name }}</p>
                                <p><span class="font-medium">Room Type:</span> {{ $booking->roomType->name }}</p>
                                <p><span class="font-medium">Check-in:</span> {{ $booking->check_in->format('M d, Y') }}</p>
                                <p><span class="font-medium">Check-out:</span> {{ $booking->check_out->format('M d, Y') }}</p>
                            </div>
                            <div>
                                <p><span class="font-medium">Number of Rooms:</span> {{ $booking->number_of_rooms }}</p>
                                <p><span class="font-medium">Price per Night:</span> RM{{ number_format($booking->price_per_night, 2) }}</p>
                                <p><span class="font-medium">Number of Nights:</span> {{ $booking->check_in->diffInDays($booking->check_out) }}</p>
                                <p class="text-lg font-bold mt-2">Total: RM{{ number_format($booking->total_price, 2) }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Form -->
                    <form action="{{ route('user.payment.process', $booking) }}" method="POST" class="space-y-6">
                        @csrf

                        <!-- Card Information -->
                        <div class="border rounded-lg p-4">
                            <h3 class="text-lg font-medium mb-4">Card Information</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="col-span-2">
                                    <x-input-label for="card_number" value="Card Number" />
                                    <x-text-input id="card_number" name="card_number" type="text" 
                                        class="mt-1 block w-full" required placeholder="4111 1111 1111 1111" />
                                </div>

                                <div>
                                    <x-input-label for="expiry" value="Expiry Date" />
                                    <x-text-input id="expiry" name="expiry" type="text" 
                                        class="mt-1 block w-full" required placeholder="MM/YY" />
                                </div>

                                <div>
                                    <x-input-label for="cvv" value="CVV" />
                                    <x-text-input id="cvv" name="cvv" type="text" 
                                        class="mt-1 block w-full" required placeholder="123" />
                                </div>

                                <div class="col-span-2">
                                    <x-input-label for="card_holder" value="Card Holder Name" />
                                    <x-text-input id="card_holder" name="card_holder" type="text" 
                                        class="mt-1 block w-full" required placeholder="John Doe" />
                                </div>
                            </div>
                        </div>

                        <!-- Billing Address -->
                        <div class="border rounded-lg p-4">
                            <h3 class="text-lg font-medium mb-4">Billing Address</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="col-span-2">
                                    <x-input-label for="address" value="Street Address" />
                                    <x-text-input id="address" name="address" type="text" 
                                        class="mt-1 block w-full" required />
                                </div>

                                <div>
                                    <x-input-label for="city" value="City" />
                                    <x-text-input id="city" name="city" type="text" 
                                        class="mt-1 block w-full" required />
                                </div>

                                <div>
                                    <x-input-label for="postal_code" value="Postal Code" />
                                    <x-text-input id="postal_code" name="postal_code" type="text" 
                                        class="mt-1 block w-full" required />
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-between items-center">
                            <p class="text-lg font-bold">Total Payment: RM{{ number_format($booking->total_price, 2) }}</p>
                            <x-primary-button>
                                Pay Now
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Simple card number formatting
        document.getElementById('card_number').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            value = value.replace(/(\d{4})/g, '$1 ').trim();
            e.target.value = value.substring(0, 19);
        });

        // Expiry date formatting
        document.getElementById('expiry').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length >= 2) {
                value = value.substring(0, 2) + '/' + value.substring(2);
            }
            e.target.value = value.substring(0, 5);
        });

        // CVV length restriction
        document.getElementById('cvv').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            e.target.value = value.substring(0, 3);
        });
    </script>
    @endpush
</x-app-layout> 