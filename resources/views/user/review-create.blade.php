<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h2 class="text-2xl font-semibold mb-6">Review for {{ $booking->hotel->name }}</h2>

                    <form action="{{ route('user.review.store', $booking) }}" method="POST" class="space-y-6">
                        @csrf

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Rating</label>
                            <div class="mt-2">
                                <div class="my-rating"></div>
                                <input type="hidden" name="rating" id="rating-value" value="4" required>
                            </div>
                            @error('rating')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="comment" class="block text-sm font-medium text-gray-700">Your Review</label>
                            <textarea id="comment" name="comment" rows="4" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
                            @error('comment')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex justify-end">
                            <button type="submit"
                                class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                                Submit Review
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function() {
                console.log('Document ready');
                console.log('jQuery version:', $.fn.jquery);

                try {
                    $(".my-rating").starRating({
                        initialRating: 4,
                        strokeColor: '#894A00',
                        strokeWidth: 10,
                        starSize: 25,
                        useFullStars: true,
                        callback: function(currentRating, $el) {
                            // Round the rating to the nearest integer
                            const roundedRating = Math.round(currentRating);
                            // Update the hidden input when rating changes
                            $('#rating-value').val(roundedRating);
                            console.log('Rating updated:', roundedRating);
                        }
                    });
                    console.log('Star rating initialized');
                } catch (error) {
                    console.error('Error initializing star rating:', error);
                }
            });
        </script>
    @endpush
</x-app-layout>
