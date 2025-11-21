@props(['product'])

<div class="group bg-white rounded-xl shadow-sm hover:shadow-2xl transition-all duration-300 relative">
    <x-wishlist-button :productId="$product->id" />
    <a href="{{ route('product.show', $product->slug) }}" class="block">
        <div class="relative overflow-hidden rounded-t-xl" id="product-image-{{ $product->id }}">
            @if($product->images->first() && $product->images->first()->image_path !== 'products/placeholder-orange.jpg')
                <img src="{{ asset('storage/' . $product->images->first()->image_path) }}" 
                     alt="{{ $product->name }}" 
                     class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-500"
                     onerror="this.style.display='none'; document.getElementById('placeholder-product-{{ $product->id }}').style.display='flex';">
                <!-- Orange Placeholder (hidden by default, shown on error) -->
                <div id="placeholder-product-{{ $product->id }}" class="w-full h-48 bg-gradient-to-br from-orange-50 via-orange-100 to-orange-200 flex items-center justify-center group-hover:scale-105 transition-transform duration-500 text-9xl" style="display: none;">🍊</div>
            @else
                <!-- Orange Placeholder matching the design -->
                <div class="w-full h-48 bg-gradient-to-br from-orange-50 via-orange-100 to-orange-200 flex items-center justify-center group-hover:scale-105 transition-transform duration-500 text-9xl">🍊</div>
            @endif
            <!-- Gradient Overlay on Hover -->
            <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
        </div>
        <div class="p-4">
            @if($product->isBestSeller())
                <span class="inline-block text-xs bg-gradient-to-r from-yellow-400 to-orange-400 text-white px-2.5 py-1 rounded-full font-semibold shadow-sm">⭐ Best Seller</span>
            @endif
            <h3 class="font-bold mt-2 mb-1 text-neutral-800 group-hover:text-primary-600 transition-colors">{{ $product->name }}</h3>
            <p class="text-sm text-neutral-500 mb-2">{{ $product->category->name }}</p>
            @if($product->variants->first())
                <p class="text-lg font-bold bg-gradient-to-r from-primary-600 to-secondary-600 bg-clip-text text-transparent">Mulai Rp {{ number_format($product->variants->min('price'), 0, ',', '.') }}</p>
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
