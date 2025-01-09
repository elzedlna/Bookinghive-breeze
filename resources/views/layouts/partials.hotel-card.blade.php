<div class="bg-white rounded-lg shadow-lg overflow-hidden">
    @if($hotel->image_url)
        <img src="{{ $hotel->image_url }}" alt="{{ $hotel->name }}" class="w-full h-48 object-cover">
    @else
        <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
            </svg>
        </div>
    @endif

    <div class="p-6">
        <h3 class="text-xl font-semibold text-gray-800 mb-2">{{ $hotel->name }}</h3>
        <div class="flex items-center mb-2">
            <div class="flex items-center">
                @for($i = 1; $i <= 5; $i++)
                    @if($i <= round($hotel->reviews_avg_rating ?? 0))
                        <svg class="w-5 h-5 text-yellow-400 fill-current" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                    @else
                        <svg class="w-5 h-5 text-gray-300 fill-current" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                    @endif
                @endfor
                <span class="ml-2 text-gray-600">
                    {{ number_format($hotel->reviews_avg_rating ?? 0, 1) }}
                </span>
            </div>
        </div>
        <p class="text-gray-600 mb-4">{{ Str::limit($hotel->description, 100) }}</p>
        <a href="{{ route('hotels.show', $hotel->id) }}" 
           class="inline-block bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition-colors">
            View Details
        </a>
    </div>
</div>