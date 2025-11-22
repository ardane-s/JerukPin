@extends('layouts.app')

@section('title', $product->name . ' - JerukPin')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-neutral-50 to-white">
    <!-- Breadcrumb -->
    <div class="bg-white border-b border-neutral-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex items-center gap-2 text-sm">
                <a href="{{ route('home') }}" class="text-neutral-500 hover:text-primary-600 transition">Beranda</a>
                <svg class="w-4 h-4 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
                <a href="{{ route('category.show', $product->category->slug) }}" class="text-neutral-500 hover:text-primary-600 transition">{{ $product->category->name }}</a>
                <svg class="w-4 h-4 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
                <span class="text-neutral-900 font-medium">{{ $product->name }}</span>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 mb-16">
            <!-- Left Column - Images -->
            <div class="lg:sticky lg:top-24 lg:self-start">
                <!-- Main Image -->
                <div class="relative group mb-4 bg-white rounded-2xl shadow-lg overflow-hidden">
                    @if($product->images->count() > 0)
                        @php
                            $primaryImage = $product->images->where('is_primary', true)->first();
                            $isPlaceholder = $primaryImage && $primaryImage->image_path === 'products/placeholder-orange.jpg';
                        @endphp
                        
                        @if($isPlaceholder)
                            <div class="aspect-square bg-gradient-to-br from-orange-100 via-orange-50 to-orange-100 flex items-center justify-center">
                                <div class="text-9xl animate-bounce">🍊</div>
                            </div>
                        @else
                            <img src="{{ asset('storage/' . $primaryImage->image_path) }}" 
                                 alt="{{ $product->name }}" 
                                 id="main-image"
                                 class="w-full aspect-square object-cover transition-transform duration-500 group-hover:scale-105"
                                 onerror="this.onerror=null; this.parentElement.innerHTML='<div class=\'aspect-square bg-gradient-to-br from-orange-50 via-orange-100 to-orange-200 flex items-center justify-center text-9xl\'>🍊</div>';">
                        @endif
                    @else
                        <div class="aspect-square bg-gradient-to-br from-orange-100 via-orange-50 to-orange-100 flex items-center justify-center">
                            <div class="text-9xl animate-bounce">🍊</div>
                        </div>
                    @endif
                    
                    <!-- Wishlist Button -->
                    <div class="absolute top-4 right-4">
                        <x-wishlist-button :productId="$product->id" />
                    </div>
                    
                    <!-- Best Seller Badge -->
                    @if($product->isBestSeller())
                        <div class="absolute top-4 left-4">
                            <div class="bg-gradient-to-r from-yellow-400 to-orange-500 text-white px-4 py-2 rounded-full shadow-lg flex items-center gap-2 font-bold text-sm">
                                <span>⭐</span>
                                <span>Best Seller</span>
                            </div>
                        </div>
                    @endif
                </div>
                
                <!-- Thumbnail Gallery -->
                @if($product->images->count() > 1)
                    <div class="grid grid-cols-5 gap-3">
                        @foreach($product->images as $image)
                            <button onclick="document.getElementById('main-image').src = '{{ asset('storage/' . $image->image_path) }}'"
                                    class="aspect-square rounded-lg overflow-hidden border-2 transition-all duration-300 hover:border-primary-500 hover:shadow-md {{ $image->is_primary ? 'border-primary-500 ring-2 ring-primary-200' : 'border-neutral-200' }}">
                                @if($image->image_path !== 'products/placeholder-orange.jpg')
                                    <img src="{{ asset('storage/' . $image->image_path) }}" 
                                         alt="{{ $product->name }}"
                                         class="w-full h-full object-cover hover:scale-110 transition-transform duration-300">
                                @else
                                    <div class="w-full h-full bg-gradient-to-br from-orange-100 to-orange-200 flex items-center justify-center text-3xl">🍊</div>
                                @endif
                            </button>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Right Column - Product Info -->
            <div class="space-y-6">
                <!-- Product Title & Category -->
                <div>
                    <div class="flex items-center gap-2 mb-3">
                        <span class="px-3 py-1 bg-primary-100 text-primary-700 rounded-full text-sm font-medium">
                            {{ $product->category->name }}
                        </span>
                    </div>
                    <h1 class="text-4xl font-heading font-bold text-neutral-900 mb-3">{{ $product->name }}</h1>
                    
                    <!-- Rating & Reviews -->
                    @if($product->reviewsCount() > 0)
                        <div class="flex items-center gap-4 mb-4">
                            <div class="flex items-center gap-2">
                                <div class="flex">
                                    @for($i = 1; $i <= 5; $i++)
                                        <svg class="w-5 h-5 {{ $i <= round($product->averageRating()) ? 'text-yellow-400' : 'text-neutral-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                    @endfor
                                </div>
                                <span class="text-lg font-bold text-neutral-900">{{ number_format($product->averageRating(), 1) }}</span>
                            </div>
                            <div class="h-6 w-px bg-neutral-300"></div>
                            <button onclick="switchTab('reviews')" class="text-primary-600 hover:text-primary-700 font-medium transition">
                                {{ $product->reviewsCount() }} Ulasan
                            </button>
                        </div>
                    @endif
                    
                    <p class="text-neutral-600 leading-relaxed">{{ $product->description }}</p>
                </div>

                <!-- Trust Badges -->
                <div class="flex flex-wrap gap-4 py-4 border-y border-neutral-200">
                    <div class="flex items-center gap-2 text-sm text-neutral-600">
                        <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>Produk Original</span>
                    </div>
                    <div class="flex items-center gap-2 text-sm text-neutral-600">
                        <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>Pengiriman Cepat</span>
                    </div>
                    <div class="flex items-center gap-2 text-sm text-neutral-600">
                        <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>Terjual {{ $product->total_sold_count }}</span>
                    </div>
                </div>

                <!-- Variant Selection -->
                <div>
                    <h3 class="text-lg font-bold text-neutral-900 mb-4">Pilih Varian</h3>
                    <form action="{{ route('cart.add') }}" method="POST" id="add-to-cart-form">
                        @csrf
                        <input type="hidden" name="product_variant_id" id="selected-variant-id">
                        <input type="hidden" name="quantity" id="quantity-input" value="1">
                        
                        <div class="grid grid-cols-1 gap-3 mb-6">
                            @foreach($product->variants as $variant)
                                <label class="variant-option cursor-pointer" data-variant-id="{{ $variant->id }}">
                                    <input type="radio" name="variant" value="{{ $variant->id }}" class="hidden variant-radio" {{ $loop->first ? 'checked' : '' }}>
                                    <div class="relative p-4 pl-12 border-2 border-neutral-200 rounded-xl transition-all duration-300 hover:border-primary-300 hover:shadow-md bg-white">
                                        <!-- Visible Radio Circle on LEFT -->
                                        <div class="absolute top-1/2 -translate-y-1/2 left-4 w-6 h-6 rounded-full border-2 border-neutral-400 flex items-center justify-center transition-all duration-300 selected-indicator bg-white">
                                            <div class="w-3 h-3 rounded-full bg-orange-600 scale-0 transition-transform duration-300"></div>
                                        </div>
                                        
                                        <div class="flex items-center justify-between">
                                            <div class="flex-1">
                                                <div class="flex items-center gap-3 mb-2">
                                                    <h4 class="font-bold text-neutral-900">{{ $variant->variant_name }}</h4>
                                                    @if($variant->hasActiveFlashSale())
                                                        @php
                                                            $flashSale = $variant->activeFlashSale();
                                                        @endphp
                                                        <span class="px-2 py-1 bg-gradient-to-r from-orange-500 to-red-500 text-white text-xs font-bold rounded-full animate-pulse">
                                                            🔥 -{{ $flashSale->discount_percentage }}%
                                                        </span>
                                                    @endif
                                                </div>
                                                <div class="flex items-center gap-2">
                                                    <span class="text-sm text-neutral-500">Stok:</span>
                                                    <span class="text-sm font-semibold {{ $variant->stock > 10 ? 'text-green-600' : 'text-orange-600' }}">
                                                        {{ $variant->stock }} tersedia
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="text-right">
                                                @if($variant->hasActiveFlashSale())
                                                    @php
                                                        $flashSale = $variant->activeFlashSale();
                                                    @endphp
                                                    <div class="text-sm text-neutral-400 line-through mb-1">
                                                        Rp {{ number_format($variant->price, 0, ',', '.') }}
                                                    </div>
                                                    <div class="text-2xl font-bold text-red-600">
                                                        Rp {{ number_format($flashSale->flash_price, 0, ',', '.') }}
                                                    </div>
                                                @else
                                                    <div class="text-2xl font-bold text-green-700">
                                                        Rp {{ number_format($variant->price, 0, ',', '.') }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </form>
                </div>

                <!-- Quantity Selector -->
                <div>
                    <h3 class="text-lg font-bold text-neutral-900 mb-4">Jumlah</h3>
                    <div class="flex items-center gap-4">
                        <div class="flex items-center border-2 border-neutral-300 rounded-lg overflow-hidden">
                            <button type="button" onclick="decreaseQuantity()" class="px-4 py-3 bg-neutral-100 hover:bg-neutral-200 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                </svg>
                            </button>
                            <input type="number" id="quantity-display" value="1" min="1" readonly
                                   class="w-16 text-center font-bold text-lg border-none focus:outline-none">
                            <button type="button" onclick="increaseQuantity()" class="px-4 py-3 bg-neutral-100 hover:bg-neutral-200 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Add to Cart Button -->
                <div class="sticky bottom-0 bg-white pt-6 pb-4 -mx-4 px-4 border-t border-neutral-200 lg:static lg:border-0 lg:mx-0 lg:px-0">
                    <button type="submit" form="add-to-cart-form" 
                            class="w-full group relative overflow-hidden bg-gradient-to-r from-orange-500 via-orange-600 to-orange-700 text-white py-4 rounded-xl font-bold text-lg shadow-lg hover:shadow-2xl transform hover:scale-[1.02] transition-all duration-300">
                        <span class="relative z-10 flex items-center justify-center gap-2">
                            <svg class="w-6 h-6 group-hover:animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            <span>Tambah ke Keranjang</span>
                        </span>
                        <div class="absolute inset-0 bg-gradient-to-r from-orange-700 to-orange-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    </button>
                </div>
            </div>
        </div>

        <!-- Tabs Section -->
        <div class="bg-white rounded-2xl shadow-lg p-8 mb-12">
            <div class="border-b border-neutral-200 mb-8">
                <nav class="-mb-px flex gap-8">
                    <button onclick="switchTab('description')" id="tab-description" class="tab-btn border-b-2 border-primary-500 py-4 px-2 text-primary-600 font-semibold">
                        Deskripsi Produk
                    </button>
                    @if($product->reviews()->approved()->count() > 0)
                        <button onclick="switchTab('reviews')" id="tab-reviews" class="tab-btn border-b-2 border-transparent py-4 px-2 text-neutral-500 hover:text-neutral-700 font-semibold">
                            Ulasan ({{ $product->reviewsCount() }})
                        </button>
                    @endif
                </nav>
            </div>

            <!-- Description Tab -->
            <div id="content-description" class="tab-content">
                <div class="prose max-w-none">
                    <p class="text-neutral-700 leading-relaxed text-lg">{{ $product->description }}</p>
                </div>
            </div>

            <!-- Reviews Tab -->
            @if($product->reviews()->approved()->count() > 0)
                <div id="content-reviews" class="tab-content hidden">
                    <!-- Rating Summary -->
                    <div class="bg-gradient-to-br from-neutral-50 to-white rounded-xl p-6 mb-8 border border-neutral-200">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="text-center md:border-r border-neutral-200">
                                <div class="text-6xl font-bold bg-gradient-to-r from-primary-600 to-secondary-600 bg-clip-text text-transparent mb-2">
                                    {{ $product->averageRating() }}
                                </div>
                                <div class="flex items-center justify-center mb-2">
                                    @for($i = 1; $i <= 5; $i++)
                                        <svg class="w-6 h-6 {{ $i <= round($product->averageRating()) ? 'text-yellow-400' : 'text-neutral-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                    @endfor
                                </div>
                                <div class="text-sm text-neutral-600">Dari {{ $product->reviewsCount() }} ulasan</div>
                            </div>
                            
                            <div class="space-y-2">
                                @foreach($product->ratingDistribution() as $star => $count)
                                    <div class="flex items-center gap-3">
                                        <span class="text-sm text-neutral-600 w-12">{{ $star }} ⭐</span>
                                        <div class="flex-1 bg-neutral-200 rounded-full h-2.5">
                                            <div class="bg-gradient-to-r from-yellow-400 to-orange-500 h-2.5 rounded-full transition-all duration-500" 
                                                 style="width: {{ $product->reviewsCount() > 0 ? ($count / $product->reviewsCount()) * 100 : 0 }}%"></div>
                                        </div>
                                        <span class="text-sm text-neutral-600 w-12 text-right">{{ $count }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    
                    <!-- Reviews List -->
                    <div class="space-y-6">
                        @foreach($product->reviews()->approved()->latest()->take(5)->get() as $review)
                            <div class="border-b border-neutral-200 pb-6 last:border-0">
                                <div class="flex items-start gap-4">
                                    <div class="flex-shrink-0 w-12 h-12 bg-gradient-to-br from-primary-500 to-secondary-500 rounded-full flex items-center justify-center text-white font-bold text-lg shadow-md">
                                        {{ strtoupper(substr($review->user->name, 0, 1)) }}
                                    </div>
                                    <div class="flex-1">
                                        <div class="flex items-center justify-between mb-2">
                                            <h4 class="font-bold text-neutral-900">{{ $review->user->name }}</h4>
                                            <span class="text-xs text-neutral-500">{{ $review->created_at->diffForHumans() }}</span>
                                        </div>
                                        <div class="flex items-center gap-2 mb-2">
                                            <div class="flex">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <svg class="w-4 h-4 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-neutral-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                    </svg>
                                                @endfor
                                            </div>
                                            @if($review->orderItem)
                                                <span class="px-2 py-0.5 bg-green-100 text-green-700 text-xs font-semibold rounded-full">✓ Verified Purchase</span>
                                            @endif
                                        </div>
                                        @if($review->comment)
                                            <p class="text-neutral-700 leading-relaxed">{{ $review->comment }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Write Review Form -->
                    <div class="mt-12 pt-8 border-t-2 border-neutral-200">
                        <h3 class="text-2xl font-bold text-neutral-900 mb-6">✍️ Tulis Ulasan Anda</h3>
                        
                        @guest
                            <div class="bg-orange-50 border-2 border-orange-200 rounded-xl p-6 text-center">
                                <p class="text-neutral-700 mb-4">Anda harus login terlebih dahulu untuk memberikan ulasan</p>
                                <a href="{{ route('login') }}" class="inline-block bg-gradient-to-r from-orange-500 to-orange-600 text-white px-6 py-3 rounded-lg font-semibold hover:shadow-lg transform hover:scale-105 transition-all">
                                    Login Sekarang
                                </a>
                            </div>
                        @else
                            <form action="{{ route('reviews.store') }}" method="POST" class="space-y-6">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                
                                <!-- Star Rating -->
                                <div>
                                    <label class="block text-sm font-semibold text-neutral-700 mb-3">Rating Anda</label>
                                    <div class="flex items-center gap-2">
                                        <div class="flex gap-1" id="star-rating">
                                            @for($i = 1; $i <= 5; $i++)
                                                <button type="button" onclick="setRating({{ $i }})" class="star-btn focus:outline-none transition-transform hover:scale-110" data-rating="{{ $i }}">
                                                    <svg class="w-10 h-10 text-neutral-300" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                    </svg>
                                                </button>
                                            @endfor
                                        </div>
                                        <span id="rating-text" class="text-sm font-semibold text-neutral-600 ml-2"></span>
                                    </div>
                                    <input type="hidden" name="rating" id="rating-input" required>
                                    @error('rating')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Comment -->
                                <div>
                                    <label for="comment" class="block text-sm font-semibold text-neutral-700 mb-2">Ulasan Anda</label>
                                    <textarea name="comment" id="comment" rows="4" 
                                        class="w-full px-4 py-3 border-2 border-neutral-200 rounded-xl focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition-all"
                                        placeholder="Ceritakan pengalaman Anda dengan produk ini..."></textarea>
                                    @error('comment')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Submit Button -->
                                <button type="submit" class="w-full bg-gradient-to-r from-orange-500 to-orange-600 text-white py-4 rounded-xl font-bold text-lg shadow-lg hover:shadow-xl transform hover:scale-[1.02] transition-all">
                                    Kirim Ulasan
                                </button>
                            </form>

                            <script>
                                let selectedRating = 0;
                                const ratingTexts = ['', 'Sangat Buruk', 'Buruk', 'Cukup', 'Baik', 'Sangat Baik'];

                                function setRating(rating) {
                                    selectedRating = rating;
                                    document.getElementById('rating-input').value = rating;
                                    document.getElementById('rating-text').textContent = ratingTexts[rating];
                                    
                                    // Update star colors
                                    document.querySelectorAll('.star-btn').forEach((btn, index) => {
                                        const svg = btn.querySelector('svg');
                                        if (index < rating) {
                                            svg.classList.remove('text-neutral-300');
                                            svg.classList.add('text-yellow-400');
                                        } else {
                                            svg.classList.add('text-neutral-300');
                                            svg.classList.remove('text-yellow-400');
                                        }
                                    });
                                }
                            </script>
                        @endguest
                    </div>
                </div>
            @endif
        </div>

        <!-- Related Products -->
        @if($relatedProducts->count() > 0)
            <div>
                <div class="flex items-center justify-between mb-8">
                    <h2 class="text-3xl font-heading font-bold text-neutral-900">Produk Terkait</h2>
                    <a href="{{ route('category.show', $product->category->slug) }}" class="text-primary-600 hover:text-primary-700 font-medium flex items-center gap-1 group">
                        <span>Lihat Semua</span>
                        <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                    @foreach($relatedProducts as $related)
                        <x-product-card :product="$related" />
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>

<script>
// Variant Selection
document.querySelectorAll('.variant-option').forEach(option => {
    option.addEventListener('click', function() {
        // Remove selection from all
        document.querySelectorAll('.variant-option').forEach(opt => {
            const radioInput = opt.querySelector('.variant-radio');
            const borderDiv = opt.querySelector('div');
            const indicator = opt.querySelector('.selected-indicator div');
            
            radioInput.checked = false;
            borderDiv.classList.remove('border-primary-500', 'bg-primary-50', 'shadow-lg');
            borderDiv.classList.add('border-neutral-200');
            indicator.classList.remove('scale-100');
            indicator.classList.add('scale-0');
        });
        
        // Add selection to clicked
        const radio = this.querySelector('.variant-radio');
        const borderDiv = this.querySelector('div');
        const indicator = this.querySelector('.selected-indicator div');
        
        radio.checked = true;
        borderDiv.classList.add('border-primary-500', 'bg-primary-50', 'shadow-lg');
        borderDiv.classList.remove('border-neutral-200');
        indicator.classList.remove('scale-0');
        indicator.classList.add('scale-100');
        
        // Update hidden input
        document.getElementById('selected-variant-id').value = this.dataset.variantId;
    });
});

// Set initial variant (first one)
const firstVariant = document.querySelector('.variant-option');
if (firstVariant) {
    const firstRadio = firstVariant.querySelector('.variant-radio');
    const firstBorderDiv = firstVariant.querySelector('div');
    const firstIndicator = firstVariant.querySelector('.selected-indicator div');
    
    firstRadio.checked = true;
    firstBorderDiv.classList.add('border-primary-500', 'bg-primary-50', 'shadow-lg');
    firstBorderDiv.classList.remove('border-neutral-200');
    firstIndicator.classList.remove('scale-0');
    firstIndicator.classList.add('scale-100');
    
    document.getElementById('selected-variant-id').value = firstVariant.dataset.variantId;
}


// Quantity Controls
function increaseQuantity() {
    const input = document.getElementById('quantity-display');
    const hiddenInput = document.getElementById('quantity-input');
    const newValue = parseInt(input.value) + 1;
    input.value = newValue;
    hiddenInput.value = newValue;
}

function decreaseQuantity() {
    const input = document.getElementById('quantity-display');
    const hiddenInput = document.getElementById('quantity-input');
    const newValue = Math.max(1, parseInt(input.value) - 1);
    input.value = newValue;
    hiddenInput.value = newValue;
}

// Tab Switching
function switchTab(tab) {
    // Hide all content
    document.querySelectorAll('.tab-content').forEach(content => {
        content.classList.add('hidden');
    });
    
    // Remove active state from all tabs
    document.querySelectorAll('.tab-btn').forEach(button => {
        button.classList.remove('border-primary-500', 'text-primary-600');
        button.classList.add('border-transparent', 'text-neutral-500');
    });
    
    // Show selected content
    document.getElementById('content-' + tab).classList.remove('hidden');
    
    // Activate selected tab
    const activeTab = document.getElementById('tab-' + tab);
    activeTab.classList.remove('border-transparent', 'text-neutral-500');
    activeTab.classList.add('border-primary-500', 'text-primary-600');
}
</script>
@endsection
