<x-app-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <!-- Invoice Header -->
                    <div class="border-b pb-4 mb-4">
                        <div class="flex justify-between items-start">
                            <div>
                                <h1 class="text-2xl font-bold text-gray-900">Booking Invoice</h1>
                                <p class="text-gray-600">Invoice #{{ str_pad($booking->id, 8, '0', STR_PAD_LEFT) }}</p>
                            </div>
                            <div class="text-right">
                                <p class="font-medium">Booking Date</p>
                                <p class="text-gray-600">{{ $booking->created_at->format('M d, Y') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Hotel and Guest Information -->
                    <div class="grid grid-cols-2 gap-8 mb-8">
                        <div>
                            <h2 class="font-semibold text-gray-800 mb-2">Hotel Information</h2>
                            <div class="text-gray-600">
                                <p class="font-medium text-gray-900">{{ $booking->hotel->name }}</p>
                                <p>{{ $booking->hotel->address }}</p>
                                <p>Email: {{ $booking->hotel->email }}</p>
                                <p>Phone: {{ $booking->hotel->phone }}</p>
                            </div>
                        </div>
                        <div>
                            <h2 class="font-semibold text-gray-800 mb-2">Guest Information</h2>
                            <div class="text-gray-600">
                                <p class="font-medium text-gray-900">{{ $booking->user->name }}</p>
                                <p>Email: {{ $booking->user->email }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Booking Details -->
                    <div class="mb-8">
                        <h2 class="font-semibold text-gray-800 mb-4">Booking Details</h2>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <div class="grid grid-cols-2 gap-4 mb-4">
                                <div>
                                    <p class="text-sm text-gray-600">Room Type</p>
                                    <p class="font-medium">{{ $booking->roomType->name }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">Number of Rooms</p>
                                    <p class="font-medium">{{ $booking->number_of_rooms }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">Check-in Date</p>
                                    <p class="font-medium">{{ $booking->check_in->format('M d, Y') }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">Check-out Date</p>
                                    <p class="font-medium">{{ $booking->check_out->format('M d, Y') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Price Breakdown -->
                    <div class="mb-8">
                        <h2 class="font-semibold text-gray-800 mb-4">Price Breakdown</h2>
                        <div class="border rounded-lg">
                            <table class="w-full">
                                <tbody class="divide-y">
                                    <tr>
                                        <td class="px-4 py-3">Price per Night</td>
                                        <td class="px-4 py-3 text-right">RM{{ number_format($booking->price_per_night, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td class="px-4 py-3">Number of Nights</td>
                                        <td class="px-4 py-3 text-right">{{ $booking->check_in->diffInDays($booking->check_out) }}</td>
                                    </tr>
                                    <tr>
                                        <td class="px-4 py-3">Number of Rooms</td>
                                        <td class="px-4 py-3 text-right">{{ $booking->number_of_rooms }}</td>
                                    </tr>
                                    <tr class="bg-gray-50">
                                        <td class="px-4 py-3 font-semibold">Total Amount</td>
                                        <td class="px-4 py-3 font-semibold text-right">RM{{ number_format($booking->total_price, 2) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Status and Actions -->
                    <div class="flex justify-between items-center">
                        <div class="flex items-center space-x-2">
                            <span class="text-sm font-medium">Status:</span>
                            <span class="px-2 py-1 text-sm rounded-full 
                                @if($booking->status === 'confirmed') bg-green-100 text-green-800
                                @elseif($booking->status === 'pending') bg-yellow-100 text-yellow-800
                                @else bg-red-100 text-red-800 @endif">
                                {{ ucfirst($booking->status) }}
                            </span>
                        </div>
                        <div class="space-x-2">
                            <button onclick="window.print()" class="px-4 py-2 text-sm bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">
                                Print Invoice
                            </button>
                            <a href="{{ route('user.dashboard') }}" class="px-4 py-2 text-sm bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                                Back to Dashboard
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 