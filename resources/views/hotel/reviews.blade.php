<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="text-2xl font-semibold mb-6">Manage Reviews</h2>

                    <!-- Search and Filter Form -->
                    <div class="mb-6 bg-gray-50 p-4 rounded-lg">
                        <form action="{{ route('hotel.reviews') }}" method="GET" class="space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <x-input-label for="search" value="Search Guest" />
                                    <x-text-input id="search" name="search" type="text" 
                                        class="mt-1 block w-full"
                                        placeholder="Guest name..."
                                        value="{{ request('search') }}" />
                                </div>

                                <div>
                                    <x-input-label for="rating" value="Rating" />
                                    <select id="rating" name="rating" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                        <option value="">All Ratings</option>
                                        @foreach(range(5, 1) as $rating)
                                            <option value="{{ $rating }}" {{ request('rating') == $rating ? 'selected' : '' }}>
                                                {{ $rating }} Stars
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <x-input-label for="has_reply" value="Reply Status" />
                                    <select id="has_reply" name="has_reply" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                        <option value="">All Reviews</option>
                                        <option value="yes" {{ request('has_reply') === 'yes' ? 'selected' : '' }}>Replied</option>
                                        <option value="no" {{ request('has_reply') === 'no' ? 'selected' : '' }}>Not Replied</option>
                                    </select>
                                </div>
                            </div>

                            <div class="flex justify-end space-x-2">
                                <a href="{{ route('hotel.reviews') }}" class="px-4 py-2 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200">
                                    Clear Filters
                                </a>
                                <x-primary-button>
                                    Search Reviews
                                </x-primary-button>
                            </div>
                        </form>
                    </div>

                    <!-- Reviews List -->
                    <div class="space-y-6">
                        @forelse($reviews as $review)
                            <div class="border rounded-lg p-4">
                                <div class="flex justify-between items-start mb-4">
                                    <div>
                                        <h3 class="font-semibold text-lg">{{ $review->hotel->name }}</h3>
                                        <p class="text-sm text-gray-600">
                                            By {{ $review->user->name }} on {{ $review->created_at->format('M d, Y') }}
                                        </p>
                                    </div>
                                    <div class="flex items-center">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <svg class="w-5 h-5 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }}"
                                                fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                        @endfor
                                    </div>
                                </div>

                                <p class="text-gray-700 mb-4">{{ $review->comment }}</p>

                                @if($review->reply)
                                    <div class="mt-4 bg-gray-50 p-4 rounded-lg">
                                        <div class="flex items-center mb-2">
                                            <span class="font-medium text-blue-600">Your Response</span>
                                            <span class="text-sm text-gray-500 ml-2">{{ $review->reply->created_at->format('M d, Y') }}</span>
                                        </div>
                                        <p class="text-gray-700">{{ $review->reply->reply }}</p>
                                    </div>
                                @else
                                    <form action="{{ route('hotel.review.reply', $review) }}" method="POST" class="mt-4">
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
                                @endif
                            </div>
                        @empty
                            <p class="text-center text-gray-500">No reviews found.</p>
                        @endforelse

                        <!-- Pagination -->
                        <div class="mt-6">
                            {{ $reviews->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 