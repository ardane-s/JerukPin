@props(['product'])

<div class="group bg-white rounded-xl shadow-sm hover:shadow-2xl transition-all duration-300 relative">
    <x-wishlist-button :productId="$product->id" />
    <a href="{{ route('product.show', $product->slug) }}" class="block">
        <div class="relative overflow-hidden rounded-t-xl aspect-square bg-orange-50" id="product-image-{{ $product->id }}">
            <!-- Orange Placeholder (Always present behind image) -->
            <div class="absolute inset-0 bg-gradient-to-br from-orange-50 via-orange-100 to-orange-200 flex items-center justify-center group-hover:scale-105 transition-transform duration-500">
                <span class="text-6xl sm:text-7xl md:text-9xl select-none">🍊</span>
            </div>
            
            <!-- Product Image (Overlay) -->
            @if($product->images->first())
                @php
                    $imageUrl = \App\Helpers\ImageHelper::getImageUrl($product->images->first()->image_path);
                @endphp
                @if($imageUrl)
                    <img src="{{ $imageUrl }}" 
                         alt="{{ $product->name }}" 
                         class="w-full h-full object-cover relative z-10 group-hover:scale-105 transition-transform duration-500"
                         onerror="this.style.display='none'">
                @endif
            @endif
            
            <!-- Gradient Overlay on Hover -->
            <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 z-20"></div>
        </div>
        <div class="p-2 sm:p-3 md:p-4">
            @if($product->isBestSeller())
                <span class="inline-block text-xs bg-gradient-to-r from-yellow-400 to-orange-400 text-white px-2 py-0.5 rounded-full font-semibold shadow-sm">⭐ Best Seller</span>
            @endif
            <h3 class="font-bold mt-2 mb-1 text-sm sm:text-base text-neutral-800 group-hover:text-primary-600 transition-colors line-clamp-2">{{ $product->name }}</h3>
            <p class="text-xs text-neutral-500 mb-1 sm:mb-2">{{ $product->category->name }}</p>
            @if($product->variants->first())
                <p class="text-sm sm:text-base md:text-lg font-bold text-green-700">Mulai Rp {{ number_format($product->variants->min('price'), 0, ',', '.') }}</p>
            @endif
            <div class="flex items-center justify-between mt-2">
                <p class="text-xs text-neutral-500">📦 Terjual {{ $product->total_sold_count }}</p>
                <div class="opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </div>
            </div>
        </div>
    </a>
</div>
