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
                            <div class="mt-2 flex items-center">
                                <div class="flex">
                                    @for($i = 1; $i <= 5; $i++)
                                    <label class="cursor-pointer p-1 star-rating-label">
                                        <div id="star-rating"></div>
                                        <input type="hidden" name="rating" id="rating-value">
                                        <!--<input type="radio" name="rating" value="{{ $i }}" class="sr-only peer" required>-->
                                        <svg class="w-8 h-8 star-svg" data-rating="{{ $i }}" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                    </label>
                                    @endfor
                                </div>
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
</x-app-layout> 

@push('scripts')
<script>
    $(document).ready(function() {
        // Initialize the star rating
        $("#star-rating").starRating({
            starSize: 25, // Size of the stars
            totalStars: 5, // Total number of stars
            emptyColor: 'lightgray', // Color of empty stars
            activeColor: 'gold', // Color of filled stars
            initialRating: 0, // Default rating
            strokeColor: 'black', // Optional stroke around stars
            strokeWidth: 1, // Optional stroke width
            callback: function(currentRating, $el) {
                // Update hidden input value
                $("#rating-value").val(currentRating);
                console.log("Selected rating: ", currentRating);
            }
        });
    });
</script>
@endpush