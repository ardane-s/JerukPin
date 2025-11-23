@extends('layouts.app')

@section('content')
{{-- 1. HERO SECTION --}}
<div class="relative overflow-hidden bg-gradient-to-br from-orange-50 via-white to-green-50">
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-20 right-10 w-72 h-72 bg-gradient-to-br from-orange-200 to-orange-100 rounded-full opacity-30 blur-3xl animate-float"></div>
        <div class="absolute bottom-20 left-10 w-96 h-96 bg-gradient-to-br from-green-200 to-green-100 rounded-full opacity-20 blur-3xl animate-float-delayed"></div>
        <div class="absolute top-1/2 left-1/3 w-64 h-64 bg-gradient-to-br from-yellow-200 to-yellow-100 rounded-full opacity-25 blur-3xl animate-float-slow"></div>
    </div>
    
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center min-h-[70vh] md:min-h-screen">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 md:gap-12 items-center py-8 md:py-0">
            <div class="text-center lg:text-left space-y-4 md:space-y-8">
                <div class="inline-block">
                    <span class="px-3 py-1.5 md:px-4 md:py-2 bg-gradient-to-r from-orange-500 to-orange-600 text-white rounded-full text-xs md:text-sm font-semibold shadow-lg animate-bounce-slow">
                        🎉 Jeruk Segar Premium
                    </span>
                </div>
                
                <h1 class="text-3xl md:text-5xl lg:text-7xl font-heading font-bold leading-tight">
                    <span class="bg-gradient-to-r from-orange-600 via-orange-500 to-yellow-500 bg-clip-text text-transparent">
                        Kesegaran Alami
                    </span>
                    <br/>
                    <span class="text-neutral-800">Langsung ke Rumah</span>
                </h1>
                
                <p class="text-base md:text-xl lg:text-2xl text-neutral-600 leading-relaxed max-w-xl mx-auto lg:mx-0">
                    Nikmati jeruk pilihan terbaik dari kebun organik, dipetik segar dan dikirim dengan cinta 🍊💚
                </p>
                
                <div class="flex flex-col sm:flex-row gap-3 md:gap-4 justify-center lg:justify-start">
                    <a href="{{ route('products.index') }}" 
                       class="group relative px-6 py-3 md:px-8 md:py-4 bg-gradient-to-r from-orange-500 to-orange-600 text-white rounded-2xl font-bold text-base md:text-lg shadow-xl hover:shadow-2xl transform hover:scale-105 transition-all duration-300 overflow-hidden">
                        <span class="relative z-10 flex items-center justify-center gap-2">
                            <svg class="w-5 h-5 md:w-6 md:h-6 group-hover:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            <span>Belanja Sekarang</span>
                        </span>
                        <div class="absolute inset-0 bg-gradient-to-r from-orange-600 to-orange-700 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    </a>
                    
                    @if($activeSession || $upcomingSessions->count() > 0)
                    <a href="{{ route('flash-sales.index') }}" 
                       class="group relative px-6 py-3 md:px-8 md:py-4 bg-white border-2 border-orange-500 text-orange-600 rounded-2xl font-bold text-base md:text-lg shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300">
                        <span class="flex items-center justify-center gap-2">
                            <span class="animate-pulse">🔥</span>
                            <span>Flash Sale Aktif</span>
                        </span>
                    </a>
                    @endif
                </div>
                
                <div class="flex flex-wrap items-center justify-center lg:justify-start gap-6 pt-4">
                    <div class="flex items-center gap-2 text-neutral-600">
                        <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="font-medium">100% Organik</span>
                    </div>
                    <div class="flex items-center gap-2 text-neutral-600">
                        <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                        <span class="font-medium">Pengiriman Cepat</span>
                    </div>
                    <div class="flex items-center gap-2 text-neutral-600">
                        <svg class="w-6 h-6 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                        </svg>
                        <span class="font-medium">Harga Terjangkau</span>
                    </div>
                </div>
            </div>
            
            <div class="relative hidden lg:block">
                <div class="relative z-10">
                    <div class="text-[28rem] leading-none animate-float-gentle filter drop-shadow-2xl">🍊</div>
                    <div class="absolute top-10 right-10 text-8xl animate-spin-slow">🌿</div>
                    <div class="absolute bottom-20 left-10 text-6xl animate-bounce-gentle">🍋</div>
                    <div class="absolute top-1/2 right-20 text-5xl animate-float-delayed">✨</div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="relative">
        <svg class="w-full h-24 fill-white" viewBox="0 0 1200 120" preserveAspectRatio="none">
            <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z"></path>
        </svg>
    </div>
</div>

{{-- 2. FLASH SALE SECTION --}}
@if($activeSession || $upcomingSessions->count() > 0)
<div class="bg-gradient-to-br from-red-100 via-orange-100 to-yellow-100 py-16 relative overflow-hidden">
    {{-- Fiery Firefly Floating Shapes --}}
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        {{-- Large fire orbs - MORE VISIBLE --}}
        <div class="absolute top-10 left-10 w-48 h-48 bg-gradient-to-br from-red-400 to-orange-500 rounded-full opacity-40 blur-3xl animate-firefly-1"></div>
        <div class="absolute top-20 right-20 w-56 h-56 bg-gradient-to-br from-orange-400 to-yellow-400 rounded-full opacity-50 blur-3xl animate-firefly-2"></div>
        <div class="absolute bottom-20 left-1/4 w-52 h-52 bg-gradient-to-br from-red-500 to-orange-400 rounded-full opacity-45 blur-3xl animate-firefly-3"></div>
        <div class="absolute bottom-10 right-1/3 w-44 h-44 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-full opacity-50 blur-3xl animate-firefly-4"></div>
        <div class="absolute top-1/2 left-1/2 w-40 h-40 bg-gradient-to-br from-red-300 to-yellow-400 rounded-full opacity-40 blur-2xl animate-firefly-1" style="animation-delay: 2s;"></div>
        <div class="absolute top-1/3 right-1/2 w-36 h-36 bg-gradient-to-br from-orange-500 to-red-400 rounded-full opacity-45 blur-2xl animate-firefly-3" style="animation-delay: 1s;"></div>
        
        {{-- Medium floating embers --}}
        <div class="absolute top-1/4 left-1/5 w-8 h-8 bg-gradient-to-br from-orange-400 to-red-500 rounded-full opacity-70 blur-sm animate-ember-1 shadow-xl shadow-orange-500/60"></div>
        <div class="absolute top-2/3 right-1/5 w-6 h-6 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-full opacity-80 blur-sm animate-ember-2 shadow-xl shadow-yellow-500/60"></div>
        <div class="absolute bottom-1/3 left-2/5 w-7 h-7 bg-gradient-to-br from-red-400 to-orange-400 rounded-full opacity-75 blur-sm animate-ember-3 shadow-xl shadow-red-500/60"></div>
        <div class="absolute top-1/2 right-2/5 w-6 h-6 bg-gradient-to-br from-orange-500 to-yellow-400 rounded-full opacity-70 blur-sm animate-ember-4 shadow-xl shadow-orange-500/60"></div>
        
        {{-- Small sparkles - BRIGHTER --}}
        <div class="absolute top-1/4 left-1/3 w-4 h-4 bg-yellow-300 rounded-full animate-sparkle-1 shadow-2xl shadow-yellow-300/80"></div>
        <div class="absolute top-1/3 right-1/4 w-3 h-3 bg-orange-400 rounded-full animate-sparkle-2 shadow-2xl shadow-orange-400/80"></div>
        <div class="absolute bottom-1/3 left-1/2 w-4 h-4 bg-red-400 rounded-full animate-sparkle-3 shadow-2xl shadow-red-400/80"></div>
        <div class="absolute top-2/3 right-1/3 w-3 h-3 bg-yellow-400 rounded-full animate-sparkle-4 shadow-2xl shadow-yellow-400/80"></div>
        <div class="absolute bottom-1/4 left-2/3 w-4 h-4 bg-orange-500 rounded-full animate-sparkle-5 shadow-2xl shadow-orange-500/80"></div>
        <div class="absolute top-1/5 right-2/5 w-3 h-3 bg-red-300 rounded-full animate-sparkle-1 shadow-2xl shadow-red-300/80" style="animation-delay: 1s;"></div>
        <div class="absolute bottom-2/5 left-1/5 w-4 h-4 bg-yellow-400 rounded-full animate-sparkle-3 shadow-2xl shadow-yellow-400/80" style="animation-delay: 1.5s;"></div>
        <div class="absolute top-3/5 right-1/5 w-3 h-3 bg-orange-300 rounded-full animate-sparkle-5 shadow-2xl shadow-orange-300/80" style="animation-delay: 0.7s;"></div>
    </div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center mb-12">
            <div class="inline-flex items-center gap-3 px-6 py-3 bg-gradient-to-r from-orange-500 to-red-500 text-white rounded-full font-bold text-lg mb-4 shadow-lg animate-pulse">
                <span class="text-2xl">🔥</span>
                <span>Flash Sale Hari Ini</span>
                <span class="text-2xl">🔥</span>
            </div>
            <h2 class="text-4xl md:text-5xl font-heading font-bold text-neutral-900 mb-4">
                Diskon Hingga <span class="bg-gradient-to-r from-orange-500 to-red-500 bg-clip-text text-transparent">70%</span>
            </h2>
            <p class="text-xl text-neutral-600">Buruan sebelum kehabisan!</p>
        </div>
        
        @if($activeSession)
        {{-- Mobile: Horizontal Scroll --}}
        <div class="md:hidden overflow-x-auto snap-x snap-mandatory scrollbar-hide -mx-4 px-4 mb-8">
            <div class="flex gap-3 pb-4">
                @foreach($activeSession['sales']->take(10) as $sale)
                    <div class="flex-none w-40 snap-start group relative bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden border-2 border-orange-200 hover:border-orange-400">
                        <div class="absolute top-2 right-2 z-10">
                            <div class="px-2 py-0.5 bg-gradient-to-r from-red-500 to-orange-500 text-white text-xs font-bold rounded-full shadow-md">
                                -{{ $sale->discount_percentage }}%
                            </div>
                        </div>
                        
                        <a href="{{ route('product.show', $sale->productVariant->product->slug) }}" class="block">
                                <div class="aspect-square overflow-hidden bg-orange-50 relative">
                                    <!-- Placeholder -->
                                    <div class="absolute inset-0 bg-gradient-to-br from-orange-50 via-orange-100 to-orange-200 flex items-center justify-center">
                                        <span class="text-5xl select-none">🍊</span>
                                    </div>
                                    <!-- Image -->
                                    @if($sale->productVariant->product->images->first())
                                        @php
                                            $imageUrl = \App\Helpers\ImageHelper::getImageUrl($sale->productVariant->product->images->first()->image_path);
                                        @endphp
                                        @if($imageUrl)
                                            <img src="{{ $imageUrl }}" 
                                                 alt="{{ $sale->productVariant->product->name }}"
                                                 class="w-full h-full object-cover relative z-10 group-hover:scale-110 transition-transform duration-500"
                                                 onerror="this.style.display='none'">
                                        @endif
                                    @endif
                                </div>
                            
                            <div class="p-2">
                                <h3 class="font-bold text-xs text-neutral-900 mb-1 line-clamp-2">{{ $sale->productVariant->product->name }}</h3>
                                <div class="space-y-0.5">
                                    <div class="text-xs text-neutral-400 line-through">
                                        Rp {{ number_format($sale->original_price, 0, ',', '.') }}
                                    </div>
                                    <div class="text-sm font-bold bg-gradient-to-r from-orange-600 to-red-600 bg-clip-text text-transparent">
                                        Rp {{ number_format($sale->flash_price, 0, ',', '.') }}
                                    </div>
                                </div>
                                
                                <div class="mt-2">
                                    <div class="flex justify-between text-xs text-neutral-600 mb-0.5">
                                        <span class="text-xs">{{ $sale->flash_sold }}</span>
                                        <span class="text-xs">{{ $sale->flash_stock - $sale->flash_sold }}</span>
                                    </div>
                                    <div class="w-full bg-neutral-200 rounded-full h-1.5">
                                        <div class="bg-gradient-to-r from-orange-500 to-red-500 h-1.5 rounded-full transition-all duration-500" 
                                             style="width: {{ ($sale->flash_sold / $sale->flash_stock) * 100 }}%"></div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Desktop: Grid Layout --}}
        <div class="hidden md:grid md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6 mb-8">
            @foreach($activeSession['sales']->take(10) as $sale)
                <div class="group relative bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border-2 border-orange-200 hover:border-orange-400">
                    <div class="absolute top-3 right-3 z-10">
                        <div class="px-3 py-1 bg-gradient-to-r from-red-500 to-orange-500 text-white text-xs font-bold rounded-full shadow-lg">
                            -{{ $sale->discount_percentage }}%
                        </div>
                    </div>
                    
                    <a href="{{ route('product.show', $sale->productVariant->product->slug) }}" class="block">
                            <div class="aspect-square overflow-hidden bg-orange-50 relative">
                                <!-- Placeholder -->
                                <div class="absolute inset-0 bg-gradient-to-br from-orange-50 via-orange-100 to-orange-200 flex items-center justify-center">
                                    <span class="text-8xl select-none">🍊</span>
                                </div>
                                <!-- Image -->
                                @if($sale->productVariant->product->images->first())
                                    @php
                                        $imageUrl = \App\Helpers\ImageHelper::getImageUrl($sale->productVariant->product->images->first()->image_path);
                                    @endphp
                                    @if($imageUrl)
                                        <img src="{{ $imageUrl }}" 
                                             alt="{{ $sale->productVariant->product->name }}"
                                             class="w-full h-full object-cover relative z-10 group-hover:scale-110 transition-transform duration-500"
                                             onerror="this.style.display='none'">
                                    @endif
                                @endif
                            </div>
                        
                        <div class="p-4">
                            <h3 class="font-bold text-neutral-900 mb-2 line-clamp-2">{{ $sale->productVariant->product->name }}</h3>
                            <div class="space-y-1">
                                <div class="text-sm text-neutral-400 line-through">
                                    Rp {{ number_format($sale->original_price, 0, ',', '.') }}
                                </div>
                                <div class="text-xl font-bold bg-gradient-to-r from-orange-600 to-red-600 bg-clip-text text-transparent">
                                    Rp {{ number_format($sale->flash_price, 0, ',', '.') }}
                                </div>
                            </div>
                            
                            <div class="mt-3">
                                <div class="flex justify-between text-xs text-neutral-600 mb-1">
                                    <span>Terjual {{ $sale->flash_sold }}</span>
                                    <span>Sisa {{ $sale->flash_stock - $sale->flash_sold }}</span>
                                </div>
                                <div class="w-full bg-neutral-200 rounded-full h-2">
                                    <div class="bg-gradient-to-r from-orange-500 to-red-500 h-2 rounded-full transition-all duration-500" 
                                         style="width: {{ ($sale->flash_sold / $sale->flash_stock) * 100 }}%"></div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
        
        <div class="text-center">
            <a href="{{ route('flash-sales.index') }}" 
               class="inline-flex items-center gap-2 px-8 py-4 bg-gradient-to-r from-orange-500 to-red-500 text-white rounded-xl font-bold text-lg shadow-lg hover:shadow-xl transform hover:scale-105 transition-all">
                <span>Lihat Semua Flash Sale</span>
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
        </div>
        @endif
    </div>
</div>
@endif

{{-- 3. WHY CHOOSE US SECTION (Moved from #5) --}}
<div class="bg-gradient-to-br from-orange-50 via-white to-green-50 py-12 md:py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-8 md:mb-16">
            <h2 class="text-2xl md:text-4xl lg:text-5xl font-heading font-bold text-neutral-900 mb-2 md:mb-4">
                Kenapa Pilih <span class="bg-gradient-to-r from-orange-500 to-orange-600 bg-clip-text text-transparent">JerukPin</span>?
            </h2>
            <p class="text-base md:text-xl text-neutral-600">Komitmen kami untuk kualitas dan kepuasan Anda</p>
        </div>
        
        <div class="grid grid-cols-2 md:grid-cols-3 gap-4 md:gap-8">
            <div class="group bg-white rounded-xl md:rounded-2xl p-4 md:p-6 shadow-md md:shadow-lg hover:shadow-xl md:hover:shadow-2xl transition-all duration-300 border-2 border-transparent hover:border-orange-200">
                <div class="w-10 h-10 md:w-16 md:h-16 bg-gradient-to-br from-green-400 to-green-500 rounded-xl md:rounded-2xl flex items-center justify-center text-xl md:text-3xl mb-3 md:mb-6 group-hover:scale-110 transition-transform shadow-md md:shadow-lg">
                    🌱
                </div>
                <h3 class="text-base md:text-2xl font-bold text-neutral-900 mb-2 md:mb-3">100% Organik</h3>
                <p class="text-xs md:text-base text-neutral-600 leading-relaxed">
                    Ditanam tanpa pestisida berbahaya, dipetik langsung dari kebun organik terpilih untuk kesehatan keluarga Anda.
                </p>
            </div>
            
            <div class="group bg-white rounded-xl md:rounded-2xl p-4 md:p-6 shadow-md md:shadow-lg hover:shadow-xl md:hover:shadow-2xl transition-all duration-300 border-2 border-transparent hover:border-orange-200">
                <div class="w-10 h-10 md:w-16 md:h-16 bg-gradient-to-br from-blue-400 to-blue-500 rounded-xl md:rounded-2xl flex items-center justify-center text-xl md:text-3xl mb-3 md:mb-6 group-hover:scale-110 transition-transform shadow-md md:shadow-lg">
                    🚚
                </div>
                <h3 class="text-base md:text-2xl font-bold text-neutral-900 mb-2 md:mb-3">Pengiriman Cepat</h3>
                <p class="text-xs md:text-base text-neutral-600 leading-relaxed">
                    Sistem logistik terpercaya memastikan jeruk sampai dalam kondisi segar maksimal 24 jam setelah pemesanan.
                </p>
            </div>
            
            <div class="group bg-white rounded-xl md:rounded-2xl p-4 md:p-6 shadow-md md:shadow-lg hover:shadow-xl md:hover:shadow-2xl transition-all duration-300 border-2 border-transparent hover:border-orange-200 col-span-2 md:col-span-1">
                <div class="w-10 h-10 md:w-16 md:h-16 bg-gradient-to-br from-orange-400 to-orange-500 rounded-xl md:rounded-2xl flex items-center justify-center text-xl md:text-3xl mb-3 md:mb-6 group-hover:scale-110 transition-transform shadow-md md:shadow-lg">
                    💰
                </div>
                <h3 class="text-base md:text-2xl font-bold text-neutral-900 mb-2 md:mb-3">Harga Terbaik</h3>
                <p class="text-xs md:text-base text-neutral-600 leading-relaxed">
                    Langsung dari petani ke konsumen, tanpa perantara. Harga terjangkau dengan kualitas premium terjamin.
                </p>
            </div>
        </div>
    </div>
</div>
<!-- Wave Divider -->
<div class="relative -mt-1">
    <svg class="w-full h-48" viewBox="0 0 1440 320" preserveAspectRatio="none" style="display: block;">
        <defs>
            <linearGradient id="grad2" x1="0%" y1="0%" x2="0%" y2="100%">
                <stop offset="0%" style="stop-color:rgb(254, 215, 170);stop-opacity:1" />
                <stop offset="100%" style="stop-color:rgb(255, 255, 255);stop-opacity:1" />
            </linearGradient>
        </defs>
        <path fill="url(#grad2)" d="M0,160L48,176C96,192,192,224,288,213.3C384,203,480,149,576,149.3C672,149,768,203,864,213.3C960,224,1056,192,1152,165.3C1248,139,1344,117,1392,106.7L1440,96L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
    </svg>
</div>

{{-- 4. CATEGORIES SECTION --}}
@if($categories->count() > 0)
<div class="bg-white py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <div class="inline-block px-4 py-2 bg-green-100 text-green-800 rounded-full text-sm font-semibold mb-4">
                🌿 Kategori Produk
            </div>
            <h2 class="text-4xl md:text-5xl font-heading font-bold text-neutral-900 mb-4">
                Jelajahi <span class="bg-gradient-to-r from-green-500 to-green-600 bg-clip-text text-transparent">Koleksi Kami</span>
            </h2>
            <p class="text-xl text-neutral-600">Berbagai pilihan jeruk segar untuk kebutuhan Anda</p>
        </div>
        
        <div class="grid grid-cols-2 md:grid-cols-3 gap-6">
            @foreach($categories as $category)
                <a href="{{ route('category.show', $category->slug) }}" 
                   class="group relative overflow-hidden rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:scale-105">
                    <div class="aspect-square bg-orange-50 flex items-center justify-center overflow-hidden relative">
                        <!-- Placeholder -->
                        <div class="absolute inset-0 bg-gradient-to-br from-orange-100 via-orange-50 to-green-50 flex items-center justify-center">
                            <span class="text-8xl group-hover:scale-110 transition-transform duration-300 select-none">🍊</span>
                        </div>
                        <!-- Image -->
                        @if($category->image)
                            @php
                                $imageUrl = \App\Helpers\ImageHelper::getImageUrl($category->image);
                            @endphp
                            @if($imageUrl)
                                <img src="{{ $imageUrl }}" 
                                     alt="{{ $category->name }}" 
                                     class="w-full h-full object-cover relative z-10 group-hover:scale-110 transition-transform duration-300"
                                     onerror="this.style.display='none'">
                            @endif
                        @endif
                    </div>
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent flex items-end p-6">
                        <div class="text-white">
                            <h3 class="text-2xl font-bold mb-1">{{ $category->name }}</h3>
                            <p class="text-sm opacity-90">{{ $category->products_count }} produk</p>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</div>
<!-- Wave Divider -->
<div class="relative -mt-1">
    <svg class="w-full h-48" viewBox="0 0 1440 320" preserveAspectRatio="none" style="display: block;">
        <defs>
            <linearGradient id="grad1" x1="0%" y1="0%" x2="0%" y2="100%">
                <stop offset="0%" style="stop-color:rgb(254, 215, 170);stop-opacity:1" />
                <stop offset="100%" style="stop-color:rgb(255, 237, 213);stop-opacity:1" />
            </linearGradient>
        </defs>
        <path fill="url(#grad1)" d="M0,96L48,112C96,128,192,160,288,165.3C384,171,480,149,576,128C672,107,768,85,864,90.7C960,96,1056,128,1152,149.3C1248,171,1344,181,1392,186.7L1440,192L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
    </svg>
</div>
@endif

{{-- 5. BENEFITS SECTION (NEW) --}}
<div class="bg-gradient-to-br from-orange-500 via-orange-600 to-red-500 py-12 md:py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-6 md:mb-12">
            <h2 class="text-2xl md:text-4xl lg:text-5xl font-heading font-bold text-white mb-2 md:mb-4">
                Keuntungan Belanja di JerukPin
            </h2>
            <p class="text-base md:text-xl text-white/90">Pengalaman berbelanja yang menyenangkan dan menguntungkan</p>
        </div>
        
        <div class="grid grid-cols-2 md:grid-cols-4 gap-3 md:gap-6">
            <div class="bg-white/10 backdrop-blur-sm rounded-xl md:rounded-2xl p-4 md:p-6 border border-white/20 hover:bg-white/20 transition-all duration-300">
                <div class="text-3xl md:text-5xl mb-2 md:mb-4">🌱</div>
                <h3 class="text-base md:text-xl font-bold text-white mb-1 md:mb-2">100% Organik</h3>
                <p class="text-white/80 text-xs md:text-sm">Jeruk dari kebun organik bersertifikat tanpa pestisida</p>
            </div>
            
            <div class="bg-white/10 backdrop-blur-sm rounded-xl md:rounded-2xl p-4 md:p-6 border border-white/20 hover:bg-white/20 transition-all duration-300">
                <div class="text-3xl md:text-5xl mb-2 md:mb-4">🚚</div>
                <h3 class="text-base md:text-xl font-bold text-white mb-1 md:mb-2">Pengiriman 24 Jam</h3>
                <p class="text-white/80 text-xs md:text-sm">Sampai dalam 24 jam untuk area Jakarta & sekitarnya</p>
            </div>
            
            <div class="bg-white/10 backdrop-blur-sm rounded-xl md:rounded-2xl p-4 md:p-6 border border-white/20 hover:bg-white/20 transition-all duration-300">
                <div class="text-3xl md:text-5xl mb-2 md:mb-4">💯</div>
                <h3 class="text-base md:text-xl font-bold text-white mb-1 md:mb-2">Jaminan Segar</h3>
                <p class="text-white/80 text-xs md:text-sm">Garansi uang kembali 100% jika produk tidak segar</p>
            </div>
            
            <div class="bg-white/10 backdrop-blur-sm rounded-xl md:rounded-2xl p-4 md:p-6 border border-white/20 hover:bg-white/20 transition-all duration-300">
                <div class="text-3xl md:text-5xl mb-2 md:mb-4">🎁</div>
                <h3 class="text-base md:text-xl font-bold text-white mb-1 md:mb-2">Gratis Ongkir</h3>
                <p class="text-white/80 text-xs md:text-sm">Untuk pembelian minimal Rp 100.000</p>
            </div>
        </div>
    </div>
</div>
<!-- Curved Divider -->
<div class="relative -mt-1">
    <svg class="w-full h-56" viewBox="0 0 1440 320" preserveAspectRatio="none" style="display: block;">
        <defs>
            <linearGradient id="grad3" x1="0%" y1="0%" x2="0%" y2="100%">
                <stop offset="0%" style="stop-color:rgb(249, 115, 22);stop-opacity:0.6" />
                <stop offset="50%" style="stop-color:rgb(251, 146, 60);stop-opacity:0.8" />
                <stop offset="100%" style="stop-color:rgb(255, 255, 255);stop-opacity:1" />
            </linearGradient>
        </defs>
        <path fill="url(#grad3)" fill-opacity="0.5" d="M0,96L48,122.7C96,149,192,203,288,197.3C384,192,480,128,576,128C672,128,768,192,864,197.3C960,203,1056,149,1152,133.3C1248,117,1344,139,1392,149.3L1440,160L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
        <path fill="url(#grad3)" fill-opacity="0.7" d="M0,224L48,213.3C96,203,192,181,288,181.3C384,181,480,203,576,192C672,181,768,139,864,128C960,117,1056,139,1152,154.7C1248,171,1344,181,1392,186.7L1440,192L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
        <path fill="#ffffff" d="M0,256L48,240C96,224,192,192,288,181.3C384,171,480,181,576,197.3C672,213,768,235,864,229.3C960,224,1056,192,1152,165.3C1248,139,1344,117,1392,106.7L1440,96L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
    </svg>
</div>

{{-- 6. BEST SELLERS SECTION (Moved from #3) --}}
@if($bestSellers->count() > 0)
<div class="bg-gradient-to-b from-white to-orange-50 py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <div class="inline-block px-4 py-2 bg-yellow-100 text-yellow-800 rounded-full text-sm font-semibold mb-4">
                ⭐ Paling Laris
            </div>
            <h2 class="text-4xl md:text-5xl font-heading font-bold text-neutral-900 mb-4">
                Produk <span class="bg-gradient-to-r from-orange-500 to-yellow-500 bg-clip-text text-transparent">Favorit</span>
            </h2>
            <p class="text-xl text-neutral-600">Dipilih oleh ribuan pelanggan setia</p>
        </div>
        
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            @foreach($bestSellers->take(8) as $product)
                <x-product-card :product="$product" />
            @endforeach
        </div>
        
        <div class="text-center mt-12">
            <a href="{{ route('products.index') }}" 
               class="inline-flex items-center gap-2 px-6 py-3 border-2 border-orange-500 text-orange-600 rounded-xl font-bold hover:bg-orange-50 transition-all">
                <span>Lihat Semua Produk</span>
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
        </div>
    </div>
</div>
@endif
<!-- Slant Divider -->
<div class="relative -mt-1">
    <svg class="w-full h-40" viewBox="0 0 1440 320" preserveAspectRatio="none" style="display: block;">
        <defs>
            <linearGradient id="grad4" x1="0%" y1="0%" x2="100%" y2="0%">
                <stop offset="0%" style="stop-color:rgb(252, 211, 77);stop-opacity:1" />
                <stop offset="100%" style="stop-color:rgb(255, 255, 255);stop-opacity:1" />
            </linearGradient>
        </defs>
        <path fill="url(#grad4)" d="M0,320L1440,64L1440,320Z"></path>
    </svg>
</div>

{{-- 7. CUSTOMER REVIEWS SECTION (NEW) --}}
<div class="bg-white py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-6 md:mb-12">
            <div class="inline-block px-3 py-1.5 md:px-4 md:py-2 bg-purple-100 text-purple-800 rounded-full text-xs md:text-sm font-semibold mb-2 md:mb-4">
                💬 Testimoni Pelanggan
            </div>
            <h2 class="text-2xl md:text-4xl lg:text-5xl font-heading font-bold text-neutral-900 mb-2 md:mb-4">
                Apa Kata <span class="bg-gradient-to-r from-purple-500 to-pink-500 bg-clip-text text-transparent">Mereka</span>?
            </h2>
            <p class="text-base md:text-xl text-neutral-600">Ribuan pelanggan puas dengan produk kami</p>
        </div>
        
        {{-- Mobile: Horizontal Scroll --}}
        <div class="md:hidden overflow-x-auto snap-x snap-mandatory scrollbar-hide -mx-4 px-4">
            <div class="flex gap-3 pb-4">
                <div class="flex-none w-72 snap-start bg-gradient-to-br from-orange-50 to-white rounded-xl p-4 shadow-md border border-orange-100">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-12 h-12 bg-gradient-to-br from-orange-400 to-orange-500 rounded-full flex items-center justify-center text-2xl flex-shrink-0">
                            🍊
                        </div>
                        <div class="min-w-0">
                            <h4 class="font-bold text-neutral-900 text-sm">Ibu Sarah</h4>
                            <p class="text-xs text-neutral-600">Jakarta Selatan</p>
                            <div class="flex gap-0.5 mt-0.5">
                                <span class="text-yellow-400 text-xs">⭐⭐⭐⭐⭐</span>
                            </div>
                        </div>
                    </div>
                    <p class="text-neutral-700 italic text-sm">"Jeruknya segar banget! Anak-anak suka sekali. Pengiriman cepat dan packaging rapi. Pasti order lagi!"</p>
                </div>
                
                <div class="flex-none w-72 snap-start bg-gradient-to-br from-green-50 to-white rounded-xl p-4 shadow-md border border-green-100">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-12 h-12 bg-gradient-to-br from-green-400 to-green-500 rounded-full flex items-center justify-center text-2xl flex-shrink-0">
                            🍊
                        </div>
                        <div class="min-w-0">
                            <h4 class="font-bold text-neutral-900 text-sm">Pak Budi</h4>
                            <p class="text-xs text-neutral-600">Tangerang</p>
                            <div class="flex gap-0.5 mt-0.5">
                                <span class="text-yellow-400 text-xs">⭐⭐⭐⭐⭐</span>
                            </div>
                        </div>
                    </div>
                    <p class="text-neutral-700 italic text-sm">"Harga terjangkau dengan kualitas premium. Jeruknya manis dan juicy. Recommended untuk yang cari jeruk organik!"</p>
                </div>
                
                <div class="flex-none w-72 snap-start bg-gradient-to-br from-blue-50 to-white rounded-xl p-4 shadow-md border border-blue-100">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-12 h-12 bg-gradient-to-br from-blue-400 to-blue-500 rounded-full flex items-center justify-center text-2xl flex-shrink-0">
                            🍊
                        </div>
                        <div class="min-w-0">
                            <h4 class="font-bold text-neutral-900 text-sm">Mbak Dina</h4>
                            <p class="text-xs text-neutral-600">Bekasi</p>
                            <div class="flex gap-0.5 mt-0.5">
                                <span class="text-yellow-400 text-xs">⭐⭐⭐⭐⭐</span>
                            </div>
                        </div>
                    </div>
                    <p class="text-neutral-700 italic text-sm">"Pelayanan ramah, produk berkualitas. Flash sale-nya juga sering ada diskon besar. Langganan terus deh!"</p>
                </div>
            </div>
        </div>

        {{-- Desktop: Grid Layout --}}
        <div class="hidden md:grid md:grid-cols-3 gap-8">
            <div class="bg-gradient-to-br from-orange-50 to-white rounded-2xl p-6 shadow-lg border border-orange-100">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-16 h-16 bg-gradient-to-br from-orange-400 to-orange-500 rounded-full flex items-center justify-center text-3xl">
                        🍊
                    </div>
                    <div>
                        <h4 class="font-bold text-neutral-900">Ibu Sarah</h4>
                        <p class="text-sm text-neutral-600">Jakarta Selatan</p>
                        <div class="flex gap-1 mt-1">
                            <span class="text-yellow-400">⭐⭐⭐⭐⭐</span>
                        </div>
                    </div>
                </div>
                <p class="text-neutral-700 italic">"Jeruknya segar banget! Anak-anak suka sekali. Pengiriman cepat dan packaging rapi. Pasti order lagi!"</p>
            </div>
            
            <div class="bg-gradient-to-br from-green-50 to-white rounded-2xl p-6 shadow-lg border border-green-100">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-16 h-16 bg-gradient-to-br from-green-400 to-green-500 rounded-full flex items-center justify-center text-3xl">
                        🍊
                    </div>
                    <div>
                        <h4 class="font-bold text-neutral-900">Pak Budi</h4>
                        <p class="text-sm text-neutral-600">Tangerang</p>
                        <div class="flex gap-1 mt-1">
                            <span class="text-yellow-400">⭐⭐⭐⭐⭐</span>
                        </div>
                    </div>
                </div>
                <p class="text-neutral-700 italic">"Harga terjangkau dengan kualitas premium. Jeruknya manis dan juicy. Recommended untuk yang cari jeruk organik!"</p>
            </div>
            
            <div class="bg-gradient-to-br from-blue-50 to-white rounded-2xl p-6 shadow-lg border border-blue-100">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-400 to-blue-500 rounded-full flex items-center justify-center text-3xl">
                        🍊
                    </div>
                    <div>
                        <h4 class="font-bold text-neutral-900">Mbak Dina</h4>
                        <p class="text-sm text-neutral-600">Bekasi</p>
                        <div class="flex gap-1 mt-1">
                            <span class="text-yellow-400">⭐⭐⭐⭐⭐</span>
                        </div>
                    </div>
                </div>
                <p class="text-neutral-700 italic">"Pelayanan ramah, produk berkualitas. Flash sale-nya juga sering ada diskon besar. Langganan terus deh!"</p>
            </div>
        </div>
    </div>
</div>
<!-- Wave Divider -->
<div class="relative -mt-1">
    <svg class="w-full h-48" viewBox="0 0 1440 320" preserveAspectRatio="none" style="display: block;">
        <defs>
            <linearGradient id="grad5" x1="0%" y1="0%" x2="0%" y2="100%">
                <stop offset="0%" style="stop-color:rgb(255, 255, 255);stop-opacity:1" />
                <stop offset="100%" style="stop-color:rgb(254, 215, 170);stop-opacity:1" />
            </linearGradient>
        </defs>
        <path fill="url(#grad5)" d="M0,64L48,85.3C96,107,192,149,288,154.7C384,160,480,128,576,122.7C672,117,768,139,864,138.7C960,139,1056,117,1152,101.3C1248,85,1344,75,1392,69.3L1440,64L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
    </svg>
</div>

{{-- 8. NEW PRODUCTS SECTION (NEW) --}}
<div class="bg-gradient-to-b from-orange-50 to-white py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <div class="inline-block px-4 py-2 bg-blue-100 text-blue-800 rounded-full text-sm font-semibold mb-4">
                ✨ Produk Terbaru
            </div>
            <h2 class="text-4xl md:text-5xl font-heading font-bold text-neutral-900 mb-4">
                Baru <span class="bg-gradient-to-r from-blue-500 to-cyan-500 bg-clip-text text-transparent">Datang</span>!
            </h2>
            <p class="text-xl text-neutral-600">Jangan lewatkan produk-produk terbaru kami</p>
        </div>
        
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            @php
                $newProducts = \App\Models\Product::latest()->take(4)->get();
            @endphp
            @foreach($newProducts as $product)
                <x-product-card :product="$product" />
            @endforeach
        </div>
        
        <div class="text-center mt-12">
            <a href="{{ route('products.index') }}" 
               class="inline-flex items-center gap-2 px-8 py-4 bg-gradient-to-r from-blue-500 to-cyan-500 text-white rounded-xl font-bold shadow-lg hover:shadow-xl transform hover:scale-105 transition-all">
                <span>Lihat Semua Produk Baru</span>
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
        </div>
    </div>
</div>
<!-- Triangle Divider -->
<div class="relative -mt-1">
    <svg class="w-full h-48" viewBox="0 0 1440 320" preserveAspectRatio="none" style="display: block;">
        <defs>
            <linearGradient id="grad6" x1="0%" y1="0%" x2="0%" y2="100%">
                <stop offset="0%" style="stop-color:rgb(254, 215, 170);stop-opacity:1" />
                <stop offset="50%" style="stop-color:rgb(249, 115, 22);stop-opacity:1" />
                <stop offset="100%" style="stop-color:rgb(234, 88, 12);stop-opacity:1" />
            </linearGradient>
        </defs>
        <path fill="url(#grad6)" d="M0,160L720,320L1440,160L1440,320L0,320Z"></path>
    </svg>
</div>

{{-- 9. NEWSLETTER SECTION --}}
<div class="bg-gradient-to-r from-orange-500 via-orange-600 to-orange-500 py-16">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="text-6xl mb-6">📧</div>
        <h2 class="text-3xl md:text-4xl font-heading font-bold text-white mb-4">
            Dapatkan Penawaran Spesial!
        </h2>
        <p class="text-xl text-white/90 mb-8">
            Daftar newsletter dan dapatkan diskon 10% untuk pembelian pertama Anda
        </p>
        
        <form class="flex flex-col sm:flex-row gap-4 max-w-2xl mx-auto">
            <input type="email" 
                   placeholder="Masukkan email Anda..." 
                   class="flex-1 px-6 py-4 rounded-xl text-lg focus:outline-none focus:ring-4 focus:ring-white/50 shadow-lg">
            <button type="submit" 
                    class="px-8 py-4 bg-white text-orange-600 rounded-xl font-bold text-lg shadow-lg hover:shadow-xl transform hover:scale-105 transition-all">
                Daftar Sekarang
            </button>
        </form>
        
        <p class="text-sm text-white/80 mt-4">
            *Kami menghargai privasi Anda. Email tidak akan dibagikan ke pihak ketiga.
        </p>
    </div>
</div>

{{-- Custom Animations --}}
<style>
@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-20px); }
}

@keyframes float-delayed {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-30px); }
}

@keyframes float-slow {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-15px); }
}

@keyframes float-gentle {
    0%, 100% { transform: translateY(0px) rotate(0deg); }
    50% { transform: translateY(-10px) rotate(5deg); }
}

@keyframes bounce-gentle {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-10px); }
}

@keyframes bounce-slow {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-5px); }
}

@keyframes spin-slow {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

/* Fiery Firefly Animations - Random Flying Patterns */
@keyframes firefly-1 {
    0% { 
        transform: translate(0, 0) scale(1);
        opacity: 0.2;
    }
    15% { 
        transform: translate(80px, -60px) scale(1.2);
        opacity: 0.4;
    }
    35% { 
        transform: translate(-40px, -120px) scale(0.8);
        opacity: 0.3;
    }
    55% { 
        transform: translate(120px, -80px) scale(1.1);
        opacity: 0.45;
    }
    75% { 
        transform: translate(-60px, -40px) scale(0.9);
        opacity: 0.25;
    }
    100% { 
        transform: translate(0, 0) scale(1);
        opacity: 0.2;
    }
}

@keyframes firefly-2 {
    0% { 
        transform: translate(0, 0) scale(1);
        opacity: 0.25;
    }
    20% { 
        transform: translate(-100px, 80px) scale(1.3);
        opacity: 0.5;
    }
    40% { 
        transform: translate(60px, 140px) scale(0.9);
        opacity: 0.35;
    }
    60% { 
        transform: translate(-80px, 60px) scale(1.15);
        opacity: 0.45;
    }
    80% { 
        transform: translate(40px, 20px) scale(0.95);
        opacity: 0.3;
    }
    100% { 
        transform: translate(0, 0) scale(1);
        opacity: 0.25;
    }
}

@keyframes firefly-3 {
    0% { 
        transform: translate(0, 0) scale(1);
        opacity: 0.2;
    }
    25% { 
        transform: translate(140px, 70px) scale(1.25);
        opacity: 0.45;
    }
    50% { 
        transform: translate(-90px, 130px) scale(0.85);
        opacity: 0.3;
    }
    75% { 
        transform: translate(70px, -50px) scale(1.1);
        opacity: 0.4;
    }
    100% { 
        transform: translate(0, 0) scale(1);
        opacity: 0.2;
    }
}

@keyframes firefly-4 {
    0% { 
        transform: translate(0, 0) scale(1);
        opacity: 0.3;
    }
    18% { 
        transform: translate(-70px, -90px) scale(1.2);
        opacity: 0.5;
    }
    42% { 
        transform: translate(50px, -130px) scale(0.9);
        opacity: 0.35;
    }
    68% { 
        transform: translate(-110px, -60px) scale(1.15);
        opacity: 0.45;
    }
    88% { 
        transform: translate(30px, -20px) scale(0.95);
        opacity: 0.35;
    }
    100% { 
        transform: translate(0, 0) scale(1);
        opacity: 0.3;
    }
}

/* Ember Animations - Medium floating particles */
@keyframes ember-1 {
    0%, 100% { 
        transform: translate(0, 0) rotate(0deg);
        opacity: 0.7;
    }
    25% { 
        transform: translate(20px, -30px) rotate(90deg);
        opacity: 0.9;
    }
    50% { 
        transform: translate(-15px, -60px) rotate(180deg);
        opacity: 0.6;
    }
    75% { 
        transform: translate(25px, -40px) rotate(270deg);
        opacity: 0.8;
    }
}

@keyframes ember-2 {
    0%, 100% { 
        transform: translate(0, 0) rotate(0deg);
        opacity: 0.8;
    }
    33% { 
        transform: translate(-25px, 35px) rotate(120deg);
        opacity: 1;
    }
    66% { 
        transform: translate(20px, 70px) rotate(240deg);
        opacity: 0.7;
    }
}

@keyframes ember-3 {
    0%, 100% { 
        transform: translate(0, 0) rotate(0deg);
        opacity: 0.75;
    }
    40% { 
        transform: translate(30px, 25px) rotate(144deg);
        opacity: 0.9;
    }
    80% { 
        transform: translate(-20px, 50px) rotate(288deg);
        opacity: 0.65;
    }
}

@keyframes ember-4 {
    0%, 100% { 
        transform: translate(0, 0) rotate(0deg);
        opacity: 0.7;
    }
    50% { 
        transform: translate(-20px, -45px) rotate(180deg);
        opacity: 0.85;
    }
}

/* Sparkle Animations */
@keyframes sparkle-1 {
    0%, 100% { 
        transform: translate(0, 0) scale(0);
        opacity: 0;
    }
    10% { 
        transform: translate(10px, -20px) scale(1);
        opacity: 1;
    }
    20% { 
        transform: translate(20px, -40px) scale(0);
        opacity: 0;
    }
}

@keyframes sparkle-2 {
    0%, 100% { 
        transform: translate(0, 0) scale(0);
        opacity: 0;
    }
    15% { 
        transform: translate(-15px, 25px) scale(1);
        opacity: 1;
    }
    30% { 
        transform: translate(-30px, 50px) scale(0);
        opacity: 0;
    }
}

@keyframes sparkle-3 {
    0%, 100% { 
        transform: translate(0, 0) scale(0);
        opacity: 0;
    }
    20% { 
        transform: translate(20px, 30px) scale(1);
        opacity: 1;
    }
    40% { 
        transform: translate(40px, 60px) scale(0);
        opacity: 0;
    }
}

@keyframes sparkle-4 {
    0%, 100% { 
        transform: translate(0, 0) scale(0);
        opacity: 0;
    }
    25% { 
        transform: translate(-10px, -30px) scale(1);
        opacity: 1;
    }
    50% { 
        transform: translate(-20px, -60px) scale(0);
        opacity: 0;
    }
}

@keyframes sparkle-5 {
    0%, 100% { 
        transform: translate(0, 0) scale(0);
        opacity: 0;
    }
    30% { 
        transform: translate(15px, -25px) scale(1);
        opacity: 1;
    }
    60% { 
        transform: translate(30px, -50px) scale(0);
        opacity: 0;
    }
}

.animate-float {
    animation: float 6s ease-in-out infinite;
}

.animate-float-delayed {
    animation: float-delayed 8s ease-in-out infinite;
}

.animate-float-slow {
    animation: float-slow 10s ease-in-out infinite;
}

.animate-float-gentle {
    animation: float-gentle 4s ease-in-out infinite;
}

.animate-bounce-gentle {
    animation: bounce-gentle 3s ease-in-out infinite;
}

.animate-bounce-slow {
    animation: bounce-slow 2s ease-in-out infinite;
}

.animate-spin-slow {
    animation: spin-slow 20s linear infinite;
}

/* Firefly classes */
.animate-firefly-1 {
    animation: firefly-1 8s ease-in-out infinite;
}

.animate-firefly-2 {
    animation: firefly-2 10s ease-in-out infinite;
}

.animate-firefly-3 {
    animation: firefly-3 7s ease-in-out infinite;
}

.animate-firefly-4 {
    animation: firefly-4 9s ease-in-out infinite;
}

/* Ember classes */
.animate-ember-1 {
    animation: ember-1 5s ease-in-out infinite;
}

.animate-ember-2 {
    animation: ember-2 6s ease-in-out infinite;
}

.animate-ember-3 {
    animation: ember-3 5.5s ease-in-out infinite;
}

.animate-ember-4 {
    animation: ember-4 6.5s ease-in-out infinite;
}

/* Sparkle classes */
.animate-sparkle-1 {
    animation: sparkle-1 3s ease-in-out infinite;
}

.animate-sparkle-2 {
    animation: sparkle-2 3.5s ease-in-out infinite 0.5s;
}

.animate-sparkle-3 {
    animation: sparkle-3 4s ease-in-out infinite 1s;
}

.animate-sparkle-4 {
    animation: sparkle-4 3.2s ease-in-out infinite 1.5s;
}

.animate-sparkle-5 {
    animation: sparkle-5 3.8s ease-in-out infinite 2s;
}
</style>
@endsection
