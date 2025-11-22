<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'JerukPin - Jeruk Segar Berkualitas')</title>
    
    @if(app()->environment('local'))
        {{-- Local development: use Vite --}}
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        {{-- Production: use Tailwind CDN (faster deployment, no build needed) --}}
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        colors: {
                            primary: '#10b981',
                            secondary: '#3b82f6',
                        }
                    }
                }
            }
        </script>
        @vite(['resources/js/app.js'])
    @endif
    
    <style>
        @keyframes rainbow {
            0% { color: #ff0000; }
            16% { color: #ff7f00; }
            33% { color: #ffff00; }
            50% { color: #00ff00; }
            66% { color: #0000ff; }
            83% { color: #8b00ff; }
            100% { color: #ff0000; }
        }
        .rainbow-text {
            animation: rainbow 3s linear infinite;
            font-weight: bold;
        }
        /* Mobile responsive utilities */
        @media (max-width: 768px) {
            .mobile-hidden { display: none; }
            .mobile-menu { display: block; }
        }
        
        @keyframes fire {
            0% { color: #ff4500; text-shadow: 0 0 5px #ff4500; }
            25% { color: #ff6347; text-shadow: 0 0 10px #ff6347; }
            50% { color: #ff8c00; text-shadow: 0 0 15px #ff8c00; }
            75% { color: #ffa500; text-shadow: 0 0 10px #ffa500; }
            100% { color: #ff4500; text-shadow: 0 0 5px #ff4500; }
        }
        .fire-text {
            animation: fire 2s ease-in-out infinite;
            font-weight: bold;
        }
        
        /* Logo hover gradient animation with smooth fade */
        .logo-text {
            color: white;
            transition: all 0.5s ease-in-out;
        }
        .logo-text:hover {
            background: linear-gradient(to right, #fb923c, #4ade80);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        /* Scroll animations */
        .fade-in-section {
            opacity: 0;
            transform: translateY(30px);
            transition: opacity 0.8s ease-out, transform 0.8s ease-out;
        }
        .fade-in-section.visible {
            opacity: 1;
            transform: translateY(0);
        }
        
        /* Smooth Bouncing Oranges Animation */
        @keyframes smoothBounce {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-15px);
            }
        }
        .bounce-orange {
            animation: smoothBounce 1s ease-in-out infinite;
        }
        .bounce-orange-1 {
            animation-delay: 0s;
        }
        .bounce-orange-2 {
            animation-delay: 0.15s;
        }
        .bounce-orange-3 {
            animation-delay: 0.3s;
        }
        
        /* Navbar - Orange Brand Color */
        .navbar-orange {
            background: linear-gradient(135deg, #FF8A00, #FF6B00);
            box-shadow: 0 2px 8px rgba(255, 138, 0, 0.2);
        }
        .navbar-orange .nav-link {
            color: white !important;
        }
        .navbar-orange .logo-text {
            color: white !important;
        }
        
        /* Homepage transparent navbar */
        .navbar-home-transparent {
            background-color: transparent;
            box-shadow: none;
        }
        .navbar-home-transparent .nav-link {
            color: white !important;
            text-shadow: 0 1px 2px rgba(0,0,0,0.1);
        }
        .navbar-home-transparent .logo-text {
            color: white !important;
            text-shadow: 0 1px 2px rgba(0,0,0,0.1);
        }
        
        /* Back to top button */
        #backToTop {
            position: fixed;
            bottom: 30px;
            right: 30px;
            background: linear-gradient(135deg, #FF8A00, #FF6B00);
            color: white;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: none;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(255, 138, 0, 0.4);
            transition: all 0.3s ease;
            z-index: 1000;
        }
        #backToTop:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 20px rgba(255, 138, 0, 0.6);
        }
        #backToTop.show {
            display: flex;
        }
    </style>
</head>
<body class="bg-neutral-100" style="min-height: 100vh; display: flex; flex-direction: column;">
    <!-- Loading Overlay with Bouncing Oranges -->
    <div id="pageLoader" class="fixed inset-0 bg-white z-[9999] flex items-center justify-center transition-opacity duration-500" style="display: none;">
        <div class="flex items-center gap-4">
            <div class="text-7xl bounce-orange bounce-orange-1">🍊</div>
            <div class="text-7xl bounce-orange bounce-orange-2">🍊</div>
            <div class="text-7xl bounce-orange bounce-orange-3">🍊</div>
        </div>
    </div>
    
    <!-- Navigation -->
    <nav id="mainNav" class="fixed top-0 w-full z-50 transition-all duration-300 navbar-orange">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex items-center gap-2 group">
                    <div class="text-3xl group-hover:scale-110 transition-transform duration-300">🍊</div>
                    <span id="navLogo" class="logo-text text-2xl font-heading font-bold">JerukPin</span>
                </a>

                <!-- Navigation Links with Dropdowns -->
                <div class="hidden md:flex items-center space-x-1">
                    <a href="{{ route('home') }}" class="nav-link font-medium transition hover:opacity-80 px-3 py-2 rounded">Beranda</a>
                    <a href="{{ route('products.index') }}" class="nav-link font-medium transition hover:opacity-80 px-3 py-2 rounded">Produk</a>
                    
                    <!-- Kategori Dropdown -->
                    <div class="relative kategori-dropdown-container">
                        <button class="nav-link font-medium transition hover:opacity-80 px-3 py-2 rounded flex items-center gap-1">
                            <span>Kategori</span>
                        </button>
                        <div class="kategori-dropdown absolute left-0 mt-4 w-64 bg-white rounded-xl shadow-2xl border-2 border-orange-100 overflow-hidden z-50 opacity-0 invisible transform scale-95 origin-top-left transition-all duration-300">
                            <!-- Dropdown Header -->
                            <div class="bg-gradient-to-r from-orange-500 to-orange-600 px-4 py-3">
                                <p class="text-white font-bold text-sm">Kategori Produk</p>
                            </div>
                            
                            <!-- Dropdown Items -->
                            <div class="py-2 max-h-80 overflow-y-auto scrollbar-hide">
                                @php
                                    $categories = \App\Models\Category::orderBy('name')->get();
                                @endphp
                                @forelse($categories as $category)
                                    <a href="{{ route('category.show', $category->slug) }}" class="group flex items-center gap-3 px-4 py-3 text-sm text-neutral-700 hover:bg-gradient-to-r hover:from-orange-50 hover:to-orange-100 transition-all duration-200 border-l-4 border-transparent hover:border-orange-500">
                                        <span class="text-2xl group-hover:scale-110 transition-transform">🍊</span>
                                        <span class="font-medium group-hover:text-orange-600">{{ $category->name }}</span>
                                        <svg class="w-4 h-4 ml-auto opacity-0 group-hover:opacity-100 transition-opacity text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </a>
                                @empty
                                    <div class="px-4 py-3 text-sm text-neutral-500 text-center">Belum ada kategori</div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                    
                    <!-- Promo Dropdown (with Flash Sale) -->
                    <div class="relative promo-dropdown-container">
                        <button class="nav-link font-medium transition hover:opacity-80 px-3 py-2 rounded flex items-center gap-1 relative">
                            <span>Promo</span>
                            @if($hasActiveFlashSales ?? false)
                                <!-- Animated notification dot - aggressive animation -->
                                <span class="absolute -top-1 -right-1 flex h-2.5 w-2.5">
                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-500 opacity-90" style="animation-duration: 0.75s;"></span>
                                    <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-red-600 shadow-lg shadow-red-500/50"></span>
                                </span>
                            @endif
                        </button>
                        <div class="promo-dropdown absolute left-0 mt-4 w-64 bg-white rounded-xl shadow-2xl border-2 border-red-100 overflow-hidden z-50 opacity-0 invisible transform scale-95 origin-top-left transition-all duration-300">
                            <!-- Dropdown Header -->
                            <div class="bg-gradient-to-r from-red-500 to-orange-500 px-4 py-3">
                                <p class="text-white font-bold text-sm">Promo Spesial</p>
                            </div>
                            
                            <!-- Dropdown Items -->
                            <div class="py-2">
                                <a href="{{ route('flash-sales.index') }}" class="group flex items-center gap-3 px-4 py-3 text-sm text-neutral-700 hover:bg-gradient-to-r hover:from-red-50 hover:to-orange-50 transition-all duration-200 border-l-4 border-transparent hover:border-red-500 relative">
                                    <span class="text-2xl group-hover:scale-110 transition-transform">🔥</span>
                                    <span class="font-medium group-hover:text-red-600">Flash Sale</span>
                                    @if($hasActiveFlashSales ?? false)
                                        <span class="ml-auto bg-red-500 text-white text-xs rounded-full px-2 py-0.5 animate-pulse font-bold">Live</span>
                                    @else
                                        <svg class="w-4 h-4 ml-auto opacity-0 group-hover:opacity-100 transition-opacity text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    @endif
                                </a>
                                <a href="{{ route('bundle-deals') }}" class="group flex items-center gap-3 px-4 py-3 text-sm text-neutral-700 hover:bg-gradient-to-r hover:from-orange-50 hover:to-yellow-50 transition-all duration-200 border-l-4 border-transparent hover:border-orange-500">
                                    <span class="text-2xl group-hover:scale-110 transition-transform">🎁</span>
                                    <span class="font-medium group-hover:text-orange-600">Bundle Deals</span>
                                    <svg class="w-4 h-4 ml-auto opacity-0 group-hover:opacity-100 transition-opacity text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                                <a href="{{ route('special-discounts') }}" class="group flex items-center gap-3 px-4 py-3 text-sm text-neutral-700 hover:bg-gradient-to-r hover:from-yellow-50 hover:to-orange-50 transition-all duration-200 border-l-4 border-transparent hover:border-yellow-500">
                                    <span class="text-2xl group-hover:scale-110 transition-transform">🏷️</span>
                                    <span class="font-medium group-hover:text-yellow-600">Diskon Spesial</span>
                                    <svg class="w-4 h-4 ml-auto opacity-0 group-hover:opacity-100 transition-opacity text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Actions -->
                <div class="flex items-center space-x-3">
                    <!-- Search Bar with Hover -->
                    <div class="hidden md:block">
                        <div class="search-hover-container relative">
                            <div class="flex items-center">
                                <button type="button" class="p-2 text-white hover:text-white/80 transition-all duration-300 hover:scale-110">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                </button>
                            </div>
                            <form action="{{ route('products.search') }}" method="GET" class="search-form absolute right-0 top-0 opacity-0 invisible transition-all duration-300">
                                <div class="flex items-center bg-white rounded-lg shadow-lg border border-neutral-200">
                                    <input type="text" name="q" placeholder="Cari produk..." 
                                        class="px-4 py-2 w-64 focus:outline-none text-sm text-neutral-700 placeholder-neutral-400 rounded-l-lg">
                                    <button type="submit" class="px-3 py-2 text-orange-600 hover:text-orange-700 transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                        </svg>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    
                    @auth
                        @if(auth()->user()->role !== 'super_admin')
                            <!-- Cart Button with Hover Dropdown -->
                            <div class="relative cart-dropdown-container">
                                <a href="{{ route('cart.index') }}" class="flex items-center gap-2 px-3 py-2 border border-white/30 rounded-lg bg-white/10 backdrop-blur-sm hover:bg-white/20 transition-all duration-300 group">
                                    <span class="text-lg group-hover:scale-110 transition-transform duration-300">🛒</span>
                                    <span class="hidden sm:inline text-sm font-medium text-white">Keranjang</span>
                                    @php
                                        // Get cart items from database for logged-in users
                                        $cart = auth()->user()->cart;
                                        $cartItems = $cart ? $cart->cartItems()->with('productVariant.product.images')->get() : collect();
                                        $cartCount = $cartItems->sum('quantity');
                                        $subtotal = $cartItems->sum(function($item) {
                                            return $item->price_snapshot * $item->quantity;
                                        });
                                    @endphp
                                    @if($cartCount > 0)
                                        <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center font-bold">{{ $cartCount }}</span>
                                    @endif
                                </a>
                                
                                <!-- Cart Hover Dropdown (moved down) -->
                                <div class="cart-dropdown absolute right-0 mt-4 w-80 bg-white rounded-lg shadow-2xl border border-neutral-200 z-50 opacity-0 invisible transform scale-95 origin-top-right transition-all duration-300">
                                    @if($cartCount > 0)
                                        <div class="p-4">
                                            <h3 class="font-bold text-neutral-900 mb-3">Keranjang Belanja</h3>
                                            <div class="space-y-3 max-h-64 overflow-y-auto scrollbar-hide">
                                                @foreach($cartItems->take(3) as $item)
                                                    <div class="flex gap-3 pb-3 border-b border-neutral-100">
                                                        @if($item->productVariant->product->images->first())
                                                            <img src="{{ asset('storage/' . $item->productVariant->product->images->first()->image_path) }}" 
                                                                 alt="{{ $item->productVariant->product->name }}" 
                                                                 class="w-16 h-16 object-cover rounded flex-shrink-0"
                                                                 onerror="this.onerror=null; this.src=''; this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                                            <div class="w-16 h-16 bg-gradient-to-br from-orange-100 to-orange-200 rounded flex items-center justify-center text-3xl flex-shrink-0" style="display:none;">
                                                                🍊
                                                            </div>
                                                        @else
                                                            <div class="w-16 h-16 bg-gradient-to-br from-orange-100 to-orange-200 rounded flex items-center justify-center text-3xl flex-shrink-0">
                                                                🍊
                                                            </div>
                                                        @endif
                                                        <div class="flex-1 min-w-0">
                                                            <p class="text-sm font-medium text-neutral-900 truncate">{{ $item->productVariant->product->name }}</p>
                                                            <p class="text-xs text-neutral-500">{{ $item->productVariant->variant_name }}</p>
                                                            <p class="text-xs text-neutral-500">{{ $item->quantity }}x @ Rp {{ number_format($item->price_snapshot, 0, ',', '.') }}</p>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                            
                                            <div class="mt-4 pt-3 border-t border-neutral-200">
                                                <div class="flex justify-between items-center mb-3">
                                                    <span class="text-sm font-medium text-neutral-600">Subtotal:</span>
                                                    <span class="text-lg font-bold text-orange-600">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                                                </div>
                                                <div class="grid grid-cols-2 gap-2">
                                                    <a href="{{ route('cart.index') }}" class="px-3 py-2 text-center text-sm font-medium text-orange-600 border border-orange-600 rounded-lg hover:bg-orange-50 transition">
                                                        Lihat Keranjang
                                                    </a>
                                                    <a href="{{ route('checkout.index') }}" class="px-3 py-2 text-center text-sm font-medium text-white bg-orange-600 rounded-lg hover:bg-orange-700 transition">
                                                        Checkout
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <div class="p-6 text-center">
                                            <div class="text-5xl mb-3">🛒</div>
                                            <p class="text-sm text-neutral-500">Keranjang Anda kosong</p>
                                            <a href="{{ route('products.index') }}" class="inline-block mt-3 px-4 py-2 text-sm font-medium text-white bg-orange-600 rounded-lg hover:bg-orange-700 transition">
                                                Belanja Sekarang
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            
                            {{-- User Profile Dropdown --}}
                            <div class="relative user-dropdown-container">
                                <button class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-white/10 transition-all">
                                    {{-- Gradient Initial Avatar --}}
                                    <div class="w-8 h-8 rounded-full bg-gradient-to-br from-orange-400 to-green-400 flex items-center justify-center text-sm font-bold text-white border-2 border-white/30 shadow-md">
                                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                    </div>
                                    <span class="hidden sm:inline text-sm font-medium text-white">{{ Str::limit(auth()->user()->name, 10) }}</span>
                                    <svg class="w-4 h-4 text-white/70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>
                                
                                <!-- Dropdown Menu -->
                                <div class="user-dropdown absolute right-0 mt-2 w-64 bg-white rounded-xl shadow-2xl border border-neutral-200 overflow-hidden opacity-0 invisible transform scale-95 origin-top-right transition-all duration-200 z-50">
                                    <div class="p-4 bg-gradient-to-r from-orange-500 to-orange-600">
                                        <div class="flex items-center gap-3">
                                            <div class="w-12 h-12 rounded-full bg-gradient-to-br from-orange-300 to-green-300 flex items-center justify-center text-2xl font-bold text-white border-2 border-white shadow-lg">
                                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm font-bold text-white truncate">{{ auth()->user()->name }}</p>
                                                <p class="text-xs text-white/80 truncate">{{ auth()->user()->email }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Menu Items -->
                                    <div class="py-2">
                                        <a href="{{ route('profile.index') }}" class="group flex items-center gap-3 px-5 py-3 text-sm text-neutral-700 hover:bg-gradient-to-r hover:from-orange-50 hover:to-yellow-50 transition-all duration-200 border-l-4 border-transparent hover:border-orange-500">
                                            <svg class="w-5 h-5 text-neutral-400 group-hover:text-orange-500 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                            </svg>
                                            <span class="font-medium group-hover:text-orange-600">Akun Saya</span>
                                            <svg class="w-4 h-4 ml-auto opacity-0 group-hover:opacity-100 transition-opacity text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                            </svg>
                                        </a>
                                        <a href="{{ route('orders.index') }}" class="group flex items-center gap-3 px-5 py-3 text-sm text-neutral-700 hover:bg-gradient-to-r hover:from-orange-50 hover:to-yellow-50 transition-all duration-200 border-l-4 border-transparent hover:border-orange-500">
                                            <svg class="w-5 h-5 text-neutral-400 group-hover:text-orange-500 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                            </svg>
                                            <span class="font-medium group-hover:text-orange-600">Riwayat Pesanan</span>
                                            <svg class="w-4 h-4 ml-auto opacity-0 group-hover:opacity-100 transition-opacity text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                            </svg>
                                        </a>
                                        <a href="{{ route('wishlist.index') }}" class="group flex items-center gap-3 px-5 py-3 text-sm text-neutral-700 hover:bg-gradient-to-r hover:from-orange-50 hover:to-yellow-50 transition-all duration-200 border-l-4 border-transparent hover:border-orange-500">
                                            <svg class="w-5 h-5 text-neutral-400 group-hover:text-orange-500 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                            </svg>
                                            <div class="flex-1 flex items-center justify-between">
                                                <span class="font-medium group-hover:text-orange-600">Wishlist</span>
                                                @php
                                                    $wishlistCount = auth()->user()->wishlists()->count();
                                                @endphp
                                                @if($wishlistCount > 0)
                                                    <span class="bg-red-500 text-white text-xs rounded-full px-2 py-0.5 font-bold">{{ $wishlistCount }}</span>
                                                @endif
                                            </div>
                                            <svg class="w-4 h-4 opacity-0 group-hover:opacity-100 transition-opacity text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                            </svg>
                                        </a>
                                        <a href="#" class="group flex items-center gap-3 px-5 py-3 text-sm text-neutral-700 hover:bg-gradient-to-r hover:from-orange-50 hover:to-yellow-50 transition-all duration-200 border-l-4 border-transparent hover:border-orange-500">
                                            <span class="text-2xl group-hover:scale-110 transition-transform">⚙️</span>
                                            <span class="font-medium group-hover:text-orange-600">Pengaturan</span>
                                            <svg class="w-4 h-4 ml-auto opacity-0 group-hover:opacity-100 transition-opacity text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                            </svg>
                                        </a>
                                    </div>
                                    
                                    <!-- Logout Button -->
                                    <div class="border-t-2 border-neutral-100 p-2">
                                        <form action="{{ route('logout') }}" method="POST">
                                            @csrf
                                            <button type="submit" class="w-full group flex items-center gap-3 px-5 py-3 text-sm text-red-600 hover:bg-red-50 rounded-lg transition-all duration-200 font-medium">
                                                <span class="text-2xl group-hover:scale-110 transition-transform">🚪</span>
                                                <span>Logout</span>
                                                <svg class="w-4 h-4 ml-auto opacity-0 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @else
                        {{-- Guest Cart Button - Show on desktop, hidden on mobile (in hamburger menu) --}}
                        <div class="hidden md:block cart-dropdown-container relative">
                            <a href="{{ route('cart.index') }}" class="flex items-center gap-2 px-3 py-2 border border-white/30 rounded-lg bg-white/10 backdrop-blur-sm hover:bg-white/20 transition-all duration-300 group">
                                <span class="text-lg group-hover:scale-110 transition-transform duration-300">🛒</span>
                                <span class="hidden sm:inline text-sm font-medium text-white">Keranjang</span>
                                @php
                                    // Get cart items from session for guests
                                    $sessionCart = session('cart', []);
                                    $guestCartCount = 0;
                                    $guestSubtotal = 0;
                                    $guestCartItems = collect();
                                    
                                    foreach($sessionCart as $variantId => $item) {
                                        $variant = \App\Models\ProductVariant::with('product.images')->find($variantId);
                                        if ($variant) {
                                            $guestCartItems->push((object)[
                                                'id' => $variantId,
                                                'productVariant' => $variant,
                                                'quantity' => $item['quantity'],
                                                'price' => $item['price'],
                                            ]);
                                            $guestCartCount += $item['quantity'];
                                            $guestSubtotal += $item['price'] * $item['quantity'];
                                        }
                                    }
                                @endphp
                                @if($guestCartCount > 0)
                                    <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center font-bold">{{ $guestCartCount }}</span>
                                @endif
                            </a>
                            
                            {{-- Guest Cart Hover Dropdown --}}
                            <div class="cart-dropdown absolute right-0 mt-4 w-80 bg-white rounded-lg shadow-2xl border border-neutral-200 z-50 opacity-0 invisible transform scale-95 origin-top-right transition-all duration-300">
                                @if($guestCartCount > 0)
                                    <div class="p-4">
                                        <h3 class="font-bold text-neutral-900 mb-3">Keranjang Belanja</h3>
                                        <div class="space-y-3 max-h-64 overflow-y-auto scrollbar-hide">
                                            @foreach($guestCartItems->take(3) as $item)
                                                <div class="flex gap-3 pb-3 border-b border-neutral-100">
                                                    @if($item->productVariant->product->images->first())
                                                        <img src="{{ asset('storage/' . $item->productVariant->product->images->first()->image_path) }}" 
                                                             alt="{{ $item->productVariant->product->name }}" 
                                                             class="w-16 h-16 object-cover rounded flex-shrink-0"
                                                             onerror="this.onerror=null; this.src=''; this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                                        <div class="w-16 h-16 bg-gradient-to-br from-orange-100 to-orange-200 rounded flex items-center justify-center text-3xl flex-shrink-0" style="display:none;">
                                                            🍊
                                                        </div>
                                                    @else
                                                        <div class="w-16 h-16 bg-gradient-to-br from-orange-100 to-orange-200 rounded flex items-center justify-center text-3xl flex-shrink-0">
                                                            🍊
                                                        </div>
                                                    @endif
                                                    <div class="flex-1 min-w-0">
                                                        <p class="text-sm font-medium text-neutral-900 truncate">{{ $item->productVariant->product->name }}</p>
                                                        <p class="text-xs text-neutral-500">{{ $item->productVariant->variant_name }}</p>
                                                        <p class="text-xs text-neutral-500">{{ $item->quantity }}x @ Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        
                                        <div class="mt-4 pt-3 border-t border-neutral-200">
                                            <div class="flex justify-between items-center mb-3">
                                                <span class="text-sm font-medium text-neutral-600">Subtotal:</span>
                                                <span class="text-lg font-bold text-orange-600">Rp {{ number_format($guestSubtotal, 0, ',', '.') }}</span>
                                            </div>
                                            <div class="grid grid-cols-2 gap-2">
                                                <a href="{{ route('cart.index') }}" class="px-3 py-2 text-center text-sm font-medium text-orange-600 border border-orange-600 rounded-lg hover:bg-orange-50 transition">
                                                    Lihat Keranjang
                                                </a>
                                                <a href="{{ route('login') }}" class="px-3 py-2 text-center text-sm font-medium text-white bg-orange-600 rounded-lg hover:bg-orange-700 transition">
                                                    Login untuk Checkout
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="p-6 text-center">
                                        <div class="text-5xl mb-3">🛒</div>
                                        <p class="text-sm text-neutral-500">Keranjang Anda kosong</p>
                                        <a href="{{ route('products.index') }}" class="inline-block mt-3 px-4 py-2 text-sm font-medium text-white bg-orange-600 rounded-lg hover:bg-orange-700 transition">
                                            Belanja Sekarang
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endauth
                    @auth
                        @if(auth()->user()->role === 'super_admin')
                            <a href="{{ route('admin.dashboard') }}" class="text-sm rainbow-text hover:opacity-80 px-3 py-2">{{ auth()->user()->name }}</a>
                            <form action="{{ route('logout') }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="text-sm px-4 py-2 text-neutral-600 hover:text-red-600 border border-neutral-300 rounded-lg hover:border-red-300 transition">Logout</button>
                            </form>
                        @endif
                    @else
                        <a href="{{ route('register') }}" class="group relative px-4 py-1.5 bg-gradient-to-r from-orange-500 via-orange-600 to-green-500 text-white rounded-lg font-medium shadow-md hover:shadow-lg transform hover:scale-105 transition-all duration-300 overflow-hidden">
                            <span class="relative z-10 flex items-center gap-1.5 text-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                                </svg>
                                <span>Daftar</span>
                            </span>
                            <div class="absolute inset-0 bg-gradient-to-r from-green-500 to-orange-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        </a>
                    @endguest
                    
                    <!-- Hamburger Menu with Animation -->
                    <div class="relative">
                        <button id="menu-button" class="text-white hover:text-white/80 p-2 rounded-lg hover:bg-white/10 transition-all duration-300 group flex items-center justify-center">
                            <div class="w-6 h-5 flex flex-col justify-center gap-1.5">
                                <span id="hamburger-line-1" class="w-full h-0.5 bg-current transform transition-all duration-300 origin-center"></span>
                                <span id="hamburger-line-2" class="w-full h-0.5 bg-current transition-all duration-300"></span>
                                <span id="hamburger-line-3" class="w-full h-0.5 bg-current transform transition-all duration-300 origin-center"></span>
                            </div>
                        </button>
                        
                        <!-- Mobile Menu Dropdown (Full Navigation) -->
                        <div id="menu-dropdown" class="absolute right-0 mt-4 w-72 sm:w-80 bg-white rounded-lg shadow-xl border border-neutral-200 py-2 z-50 opacity-0 invisible transform scale-95 origin-top-right transition-all duration-300 max-h-[80vh] overflow-y-auto">
                            <!-- Main Navigation Links (Mobile Only) -->
                            <div class="md:hidden border-b border-neutral-200 pb-2 mb-2">
                                <a href="{{ route('home') }}" class="block px-4 py-3 text-sm font-medium text-neutral-700 hover:bg-orange-50 hover:text-orange-600 transition-colors">
                                    <span class="flex items-center gap-3">
                                        <span class="text-xl">🏠</span>
                                        <span>Beranda</span>
                                    </span>
                                </a>
                            
                            <!-- Cart Link in Hamburger -->
                            <a href="{{ route('cart.index') }}" class="block px-4 py-3 text-sm font-medium text-neutral-700 hover:bg-orange-50 hover:text-orange-600 transition-colors">
                                <span class="flex items-center gap-3">
                                    <span class="text-xl">🛒</span>
                                    <span>Keranjang</span>
                                    @auth
                                        @php
                                            $cart = auth()->user()->cart;
                                            $cartItems = $cart ? $cart->cartItems()->get() : collect();
                                            $cartCount = $cartItems->sum('quantity');
                                        @endphp
                                        @if($cartCount > 0)
                                            <span class="ml-auto bg-red-500 text-white text-xs rounded-full px-2 py-0.5 font-bold">{{ $cartCount }}</span>
                                        @endif
                                    @else
                                        @php
                                            $sessionCart = session('cart', []);
                                            $guestCartCount = array_sum(array_column($sessionCart, 'quantity'));
                                        @endphp
                                        @if($guestCartCount > 0)
                                            <span class="ml-auto bg-red-500 text-white text-xs rounded-full px-2 py-0.5 font-bold">{{ $guestCartCount }}</span>
                                        @endif
                                    @endauth
                                </span>
                            </a>
                            
                                <a href="{{ route('products.index') }}" class="block px-4 py-3 text-sm font-medium text-neutral-700 hover:bg-orange-50 hover:text-orange-600 transition-colors">
                                    <span class="flex items-center gap-3">
                                        <span class="text-xl">🍊</span>
                                        <span>Produk</span>
                                    </span>
                                </a>
                                
                                {{-- Kategori Expandable --}}
                                <div class="mobile-kategori-section">
                                    <button id="mobile-kategori-toggle" class="w-full px-4 py-3 text-sm font-medium text-neutral-700 hover:bg-orange-50 hover:text-orange-600 transition-colors flex items-center gap-2">
                                        <span class="text-xl flex-shrink-0">📂</span>
                                        <span class="flex-1 text-left">Kategori</span>
                                        <svg id="mobile-kategori-arrow" class="w-4 h-4 transition-transform flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </button>
                                    <div id="mobile-kategori-list" class="hidden bg-neutral-50 border-l-4 border-orange-500">
                                        @php
                                            $categories = \App\Models\Category::orderBy('name')->get();
                                        @endphp
                                        @forelse($categories as $category)
                                            <a href="{{ route('category.show', $category->slug) }}" class="block px-8 py-2.5 text-sm text-neutral-600 hover:bg-orange-100 hover:text-orange-700 transition-colors">
                                                {{ $category->name }}
                                            </a>
                                        @empty
                                            <div class="px-8 py-2.5 text-sm text-neutral-500">Belum ada kategori</div>
                                        @endforelse
                                    </div>
                                </div>
                                
                                {{-- Promo Expandable --}}
                                <div class="mobile-promo-section">
                                    <button id="mobile-promo-toggle" class="w-full px-4 py-3 text-sm font-medium text-neutral-700 hover:bg-orange-50 hover:text-orange-600 transition-colors flex items-center gap-2">
                                        <span class="text-xl flex-shrink-0">🎁</span>
                                        <span class="flex-1 text-left">Promo</span>
                                        <svg id="mobile-promo-arrow" class="w-4 h-4 transition-transform flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </button>
                                    <div id="mobile-promo-list" class="hidden bg-neutral-50 border-l-4 border-red-500">
                                        <a href="{{ route('flash-sales.index') }}" class="block px-8 py-2.5 text-sm text-neutral-600 hover:bg-red-50 hover:text-red-700 transition-colors">
                                            🔥 Flash Sale
                                        </a>
                                        <a href="{{ route('bundle-deals') }}" class="block px-8 py-2.5 text-sm text-neutral-600 hover:bg-orange-50 hover:text-orange-700 transition-colors">
                                            🎁 Bundle Deals
                                        </a>
                                        <a href="{{ route('special-discounts') }}" class="block px-8 py-2.5 text-sm text-neutral-600 hover:bg-yellow-50 hover:text-yellow-700 transition-colors">
                                            🏷️ Diskon Spesial
                                        </a>
                                    </div>
                                </div>
                            </div>
                            
                            {{-- Utility Links - Consistent styling with main navigation --}}
                            <div class="border-t border-neutral-200">
                                <a href="{{ route('orders.track') }}" class="block px-4 py-3 text-sm font-medium text-neutral-700 hover:bg-orange-50 hover:text-orange-600 transition-colors">
                                    <span class="flex items-center gap-3">
                                        <span class="text-xl">📦</span>
                                        <span>Lacak Pesanan</span>
                                    </span>
                                </a>
                                <a href="{{ route('contact') }}" class="block px-4 py-3 text-sm font-medium text-neutral-700 hover:bg-orange-50 hover:text-orange-600 transition-colors">
                                    <span class="flex items-center gap-3">
                                        <span class="text-xl">📞</span>
                                        <span>Kontak Kami</span>
                                    </span>
                                </a>
                                <a href="{{ route('about') }}" class="block px-4 py-3 text-sm font-medium text-neutral-700 hover:bg-orange-50 hover:text-orange-600 transition-colors">
                                    <span class="flex items-center gap-3">
                                        <span class="text-xl">ℹ️</span>
                                        <span>Tentang Kami</span>
                                    </span>
                                </a>
                                <a href="{{ route('faq') }}" class="block px-4 py-3 text-sm font-medium text-neutral-700 hover:bg-orange-50 hover:text-orange-600 transition-colors">
                                    <span class="flex items-center gap-3">
                                        <span class="text-xl">❓</span>
                                        <span>FAQ</span>
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Back to Top Button -->
    <div id="backToTop" onclick="scrollToTop()">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
        </svg>
    </div>

    <script>
        // Inline expanding search bar
        const searchToggle = document.getElementById('searchToggle');
        const searchForm = document.getElementById('searchForm');
        const searchInput = document.getElementById('searchInput');
        const searchClose = document.getElementById('searchClose');
        let searchOpen = false;
        
        if (searchToggle) {
            searchToggle.addEventListener('click', function(e) {
                e.stopPropagation();
                searchOpen = true;
                // Expand search form inline
                searchForm.style.width = '220px';
                searchForm.style.opacity = '1';
                setTimeout(() => searchInput.focus(), 100);
            });
        }
        
        if (searchClose) {
            searchClose.addEventListener('click', function() {
                searchOpen = false;
                // Collapse search form
                searchForm.style.width = '0';
                searchForm.style.opacity = '0';
                searchInput.value = '';
            });
        }
        
        // Close search when clicking outside
        document.addEventListener('click', function(e) {
            if (searchForm && !searchForm.contains(e.target) && !searchToggle.contains(e.target) && searchOpen) {
                searchOpen = false;
                searchForm.style.width = '0';
                searchForm.style.opacity = '0';
            }
        });
        
        // Adaptive navbar - transparent on homepage hero, solid elsewhere
        const isHomepage = window.location.pathname === '/' || window.location.pathname === '/home';
        
        function updateNavbar() {
            const nav = document.getElementById('mainNav');
            const navLogo = document.getElementById('navLogo');
            const navLinks = document.querySelectorAll('.nav-link');
            const backToTop = document.getElementById('backToTop');
            
            if (isHomepage && window.scrollY <= 100) {
                // Transparent state (only on homepage at top)
                nav.classList.remove('bg-white', 'shadow-md');
                nav.classList.add('bg-transparent');
                navLogo.classList.remove('text-primary-600');
                navLogo.classList.add('text-white');
                navLinks.forEach(link => {
                    link.classList.remove('text-neutral-700');
                    link.classList.add('text-white');
                });
                if (backToTop) backToTop.classList.remove('show');
            } else {
                // Solid state (scrolled or not homepage)
                nav.classList.remove('bg-transparent');
                nav.classList.add('bg-white', 'shadow-md');
                navLogo.classList.remove('text-white');
                navLogo.classList.add('text-primary-600');
                navLinks.forEach(link => {
                    link.classList.remove('text-white');
                    link.classList.add('text-neutral-700');
                });
                if (backToTop && window.scrollY > 100) backToTop.classList.add('show');
            }
        }
        
        // Initialize on page load
        document.addEventListener('DOMContentLoaded', updateNavbar);
        
        // Update on scroll
        window.addEventListener('scroll', updateNavbar);
        
        // Back to top function
        function scrollToTop() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }
        
        // Fade-in sections on scroll
        const fadeInSections = document.querySelectorAll('.fade-in-section');
        
        const sectionObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        });
        
        fadeInSections.forEach(section => {
            sectionObserver.observe(section);
        });
        
        // Hamburger menu toggle with animation
        const menuButton = document.getElementById('menu-button');
        const menuDropdown = document.getElementById('menu-dropdown');
        const hamburgerLine1 = document.getElementById('hamburger-line-1');
        const hamburgerLine2 = document.getElementById('hamburger-line-2');
        const hamburgerLine3 = document.getElementById('hamburger-line-3');
        let menuOpen = false;
        
        menuButton.addEventListener('click', function(e) {
            e.stopPropagation();
            menuOpen = !menuOpen;
            
            if (menuOpen) {
                // Show dropdown with animation
                menuDropdown.classList.remove('opacity-0', 'invisible', 'scale-95');
                menuDropdown.classList.add('opacity-100', 'visible', 'scale-100');
                
                // Animate hamburger to X
                hamburgerLine1.style.transform = 'rotate(45deg) translateY(8px)';
                hamburgerLine2.style.opacity = '0';
                hamburgerLine3.style.transform = 'rotate(-45deg) translateY(-8px)';
            } else {
                // Hide dropdown with animation
                menuDropdown.classList.add('opacity-0', 'invisible', 'scale-95');
                menuDropdown.classList.remove('opacity-100', 'visible', 'scale-100');
                
                // Animate X back to hamburger
                hamburgerLine1.style.transform = 'rotate(0) translateY(0)';
                hamburgerLine2.style.opacity = '1';
                hamburgerLine3.style.transform = 'rotate(0) translateY(0)';
            }
        });

        // Mobile menu expandable sections (Kategori and Promo)
        const mobileKategoriToggle = document.getElementById('mobile-kategori-toggle');
        const mobileKategoriList = document.getElementById('mobile-kategori-list');
        const mobileKategoriArrow = document.getElementById('mobile-kategori-arrow');
        
        if (mobileKategoriToggle) {
            mobileKategoriToggle.addEventListener('click', function(e) {
                e.stopPropagation();
                mobileKategoriList.classList.toggle('hidden');
                if (mobileKategoriList.classList.contains('hidden')) {
                    mobileKategoriArrow.style.transform = 'rotate(0deg)';
                } else {
                    mobileKategoriArrow.style.transform = 'rotate(180deg)';
                }
            });
        }
        
        const mobilePromoToggle = document.getElementById('mobile-promo-toggle');
        const mobilePromoList = document.getElementById('mobile-promo-list');
        const mobilePromoArrow = document.getElementById('mobile-promo-arrow');
        
        if (mobilePromoToggle) {
            mobilePromoToggle.addEventListener('click', function(e) {
                e.stopPropagation();
                mobilePromoList.classList.toggle('hidden');
                if (mobilePromoList.classList.contains('hidden')) {
                    mobilePromoArrow.style.transform = 'rotate(0deg)';
                } else {
                    mobilePromoArrow.style.transform = 'rotate(180deg)';
                }
            });
        }
        
        // User Dropdown Toggle
        const userDropdownContainer = document.querySelector('.user-dropdown-container');
        if (userDropdownContainer) {
            const userButton = userDropdownContainer.querySelector('button');
            const userMenu = userDropdownContainer.querySelector('.user-dropdown');
            
            if (userButton && userMenu) {
                userButton.addEventListener('click', function(e) {
                    e.stopPropagation();
                    userMenu.classList.toggle('opacity-0');
                    userMenu.classList.toggle('invisible');
                    userMenu.classList.toggle('scale-95');
                });
                
                // Close on outside click
                document.addEventListener('click', function() {
                    userMenu.classList.add('opacity-0', 'invisible', 'scale-95');
                });
                
                // Prevent closing when clicking inside menu
                userMenu.addEventListener('click', function(e) {
                    e.stopPropagation();
                });
            }
        }

        // Close menus when clicking outside
        document.addEventListener('click', function(e) {
            // Close hamburger menu
            if (menuDropdown && !menuDropdown.contains(e.target) && !menuButton.contains(e.target) && menuOpen) {
                menuOpen = false;
                menuDropdown.classList.add('opacity-0', 'invisible', 'scale-95');
                menuDropdown.classList.remove('opacity-100', 'visible', 'scale-100');
                
                // Reset hamburger icon
                hamburgerLine1.style.transform = 'rotate(0) translateY(0)';
                hamburgerLine2.style.opacity = '1';
                hamburgerLine3.style.transform = 'rotate(0) translateY(0)';
            }
            
            // Close member dropdown
            if (memberDropdown && !memberDropdown.contains(e.target) && memberBtn && !memberBtn.contains(e.target) && memberOpen) {
                memberOpen = false;
                memberDropdown.classList.add('opacity-0', 'invisible', 'scale-95');
                memberDropdown.classList.remove('opacity-100', 'visible', 'scale-100');
                
                // Reset arrow
                if (memberArrow) {
                    memberArrow.style.transform = 'rotate(0deg)';
                }
            }
        });

        
        // Super admin cart alert
        @if(auth()->check() && auth()->user()->role === 'super_admin')
        document.addEventListener('DOMContentLoaded', function() {
            const addToCartButtons = document.querySelectorAll('[data-add-to-cart]');
            addToCartButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    alert('Super Admin tidak dapat menambahkan produk ke keranjang. Silakan gunakan akun member untuk berbelanja.');
                });
            });
        });
        @endif
    </script>

    <!-- Toast Notification Container -->
    <div id="toast-container" class="fixed top-20 right-4 z-[9999] space-y-3"></div>

    <!-- Toast Notification Script -->
    <script>
        function showToast(message, type = 'success') {
            const container = document.getElementById('toast-container');
            const toast = document.createElement('div');
            
            const icons = {
                success: '✅',
                error: '❌',
                warning: '⚠️',
                info: 'ℹ️'
            };
            
            const colors = {
                success: 'from-green-500 to-green-600',
                error: 'from-red-500 to-red-600',
                warning: 'from-yellow-500 to-yellow-600',
                info: 'from-blue-500 to-blue-600'
            };
            
            toast.className = `flex items-center gap-3 px-6 py-4 bg-gradient-to-r ${colors[type]} text-white rounded-lg shadow-2xl transform translate-x-full transition-all duration-300 min-w-[320px] max-w-md`;
            toast.innerHTML = `
                <span class="text-2xl">${icons[type]}</span>
                <span class="flex-1 font-medium">${message}</span>
                <button onclick="this.parentElement.remove()" class="text-white/80 hover:text-white transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            `;
            
            container.appendChild(toast);
            
            // Animate in
            setTimeout(() => {
                toast.classList.remove('translate-x-full');
            }, 10);
            
            // Auto remove after 5 seconds
            setTimeout(() => {
                toast.classList.add('translate-x-full', 'opacity-0');
                setTimeout(() => toast.remove(), 300);
            }, 5000);
        }

        // Show flash messages as toasts
        @if(session('success'))
            showToast('{{ session('success') }}', 'success');
        @endif

        @if(session('error'))
            showToast('{{ session('error') }}', 'error');
        @endif

        @if(session('warning'))
            showToast('{{ session('warning') }}', 'warning');
        @endif

        @if(session('info'))
            showToast('{{ session('info') }}', 'info');
        @endif
        
        // Confirmation Modal System
        window.showConfirmModal = function(message, onConfirm) {
            // Create modal backdrop
            const backdrop = document.createElement('div');
            backdrop.className = 'fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4 animate-fadeIn';
            backdrop.style.animation = 'fadeIn 0.2s ease-out';
            
            // Create modal
            const modal = document.createElement('div');
            modal.className = 'bg-white rounded-2xl shadow-2xl max-w-md w-full transform scale-95 opacity-0';
            modal.style.animation = 'modalSlideIn 0.3s ease-out forwards';
            
            modal.innerHTML = `
                <div class="p-6">
                    <div class="flex items-center justify-center w-16 h-16 mx-auto mb-4 bg-gradient-to-br from-orange-100 to-red-100 rounded-full">
                        <span class="text-4xl">⚠️</span>
                    </div>
                    <h3 class="text-xl font-bold text-center text-neutral-900 mb-2">Konfirmasi</h3>
                    <p class="text-center text-neutral-600 mb-6">${message}</p>
                    <div class="flex gap-3">
                        <button id="cancelBtn" class="flex-1 px-6 py-3 border-2 border-neutral-300 text-neutral-700 rounded-lg font-medium hover:bg-neutral-50 transition">
                            Batal
                        </button>
                        <button id="confirmBtn" class="flex-1 px-6 py-3 bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white rounded-lg font-bold transition shadow-md hover:shadow-lg">
                            Ya, Hapus
                        </button>
                    </div>
                </div>
            `;
            
            backdrop.appendChild(modal);
            document.body.appendChild(backdrop);
            
            // Add animations
            const style = document.createElement('style');
            style.textContent = `
                @keyframes fadeIn {
                    from { opacity: 0; }
                    to { opacity: 1; }
                }
                @keyframes modalSlideIn {
                    from { transform: scale(0.95); opacity: 0; }
                    to { transform: scale(1); opacity: 1; }
                }
            `;
            document.head.appendChild(style);
            
            // Handle buttons
            const confirmBtn = modal.querySelector('#confirmBtn');
            const cancelBtn = modal.querySelector('#cancelBtn');
            
            const closeModal = () => {
                backdrop.style.animation = 'fadeIn 0.2s ease-out reverse';
                modal.style.animation = 'modalSlideIn 0.2s ease-out reverse';
                setTimeout(() => backdrop.remove(), 200);
            };
            
            confirmBtn.onclick = () => {
                closeModal();
                if (onConfirm) onConfirm();
            };
            
            cancelBtn.onclick = closeModal;
            backdrop.onclick = (e) => {
                if (e.target === backdrop) closeModal();
            };
        };
    </script>

    <!-- Main Content -->
    <main class="pt-16">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gradient-to-br from-neutral-900 via-neutral-800 to-neutral-900 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Main Footer Content -->
            <div class="py-12 border-b border-neutral-700">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-8">
                    <!-- Brand & Newsletter (Larger Column) -->
                    <div class="lg:col-span-5">
                        <div class="flex items-center gap-2 mb-4">
                            <span class="text-4xl">🍊</span>
                            <h3 class="text-3xl font-heading font-bold bg-gradient-to-r from-orange-400 to-green-400 bg-clip-text text-transparent">JerukPin</h3>
                        </div>
                        <p class="text-neutral-400 text-sm mb-6 leading-relaxed">
                            Jeruk segar berkualitas premium langsung dari kebun organik ke rumah Anda. Dipercaya oleh ribuan pelanggan di seluruh Indonesia.
                        </p>
                        
                        <!-- Newsletter -->
                        <div class="bg-neutral-800/50 backdrop-blur-sm rounded-xl p-6 border border-neutral-700">
                            <h4 class="font-bold text-lg mb-2 flex items-center gap-2">
                                <span>📬</span>
                                <span>Dapatkan Promo Terbaru</span>
                            </h4>
                            <p class="text-neutral-400 text-sm mb-4">Berlangganan newsletter untuk info diskon & produk baru!</p>
                            <form action="#" method="POST" class="flex gap-2">
                                @csrf
                                <input type="email" name="email" placeholder="Email Anda" required
                                    class="flex-1 px-4 py-2.5 bg-neutral-700 border border-neutral-600 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent placeholder-neutral-400">
                                <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 rounded-lg font-medium text-sm transition-all duration-300 hover:shadow-lg hover:scale-105">
                                    Subscribe
                                </button>
                            </form>
                        </div>
                    </div>
                    
                    <!-- Quick Links -->
                    <div class="lg:col-span-2">
                        <h4 class="font-bold text-lg mb-4 text-orange-400">Tautan Cepat</h4>
                        <ul class="space-y-2.5 text-sm">
                            <li><a href="{{ route('home') }}" class="text-neutral-400 hover:text-orange-400 transition flex items-center gap-2 group">
                                <span class="text-orange-500 opacity-0 group-hover:opacity-100 transition">→</span>
                                <span>Beranda</span>
                            </a></li>
                            <li><a href="{{ route('products.index') }}" class="text-neutral-400 hover:text-orange-400 transition flex items-center gap-2 group">
                                <span class="text-orange-500 opacity-0 group-hover:opacity-100 transition">→</span>
                                <span>Semua Produk</span>
                            </a></li>
                            <li><a href="{{ route('flash-sales.index') }}" class="text-neutral-400 hover:text-orange-400 transition flex items-center gap-2 group">
                                <span class="text-orange-500 opacity-0 group-hover:opacity-100 transition">→</span>
                                <span>Flash Sale</span>
                            </a></li>
                            <li><a href="{{ route('about') }}" class="text-neutral-400 hover:text-orange-400 transition flex items-center gap-2 group">
                                <span class="text-orange-500 opacity-0 group-hover:opacity-100 transition">→</span>
                                <span>Tentang Kami</span>
                            </a></li>
                            <li><a href="{{ route('contact') }}" class="text-neutral-400 hover:text-orange-400 transition flex items-center gap-2 group">
                                <span class="text-orange-500 opacity-0 group-hover:opacity-100 transition">→</span>
                                <span>Kontak</span>
                            </a></li>
                        </ul>
                    </div>
                    
                    <!-- Customer Service -->
                    <div class="lg:col-span-2">
                        <h4 class="font-bold text-lg mb-4 text-orange-400">Layanan</h4>
                        <ul class="space-y-2.5 text-sm">
                            <li><a href="{{ route('faq') }}" class="text-neutral-400 hover:text-orange-400 transition flex items-center gap-2 group">
                                <span class="text-orange-500 opacity-0 group-hover:opacity-100 transition">→</span>
                                <span>FAQ</span>
                            </a></li>
                            <li><a href="{{ route('orders.track') }}" class="text-neutral-400 hover:text-orange-400 transition flex items-center gap-2 group">
                                <span class="text-orange-500 opacity-0 group-hover:opacity-100 transition">→</span>
                                <span>Lacak Pesanan</span>
                            </a></li>
                            @auth
                            <li><a href="{{ route('orders.index') }}" class="text-neutral-400 hover:text-orange-400 transition flex items-center gap-2 group">
                                <span class="text-orange-500 opacity-0 group-hover:opacity-100 transition">→</span>
                                <span>Riwayat Pesanan</span>
                            </a></li>
                            @endauth
                            <li><a href="#" class="text-neutral-400 hover:text-orange-400 transition flex items-center gap-2 group">
                                <span class="text-orange-500 opacity-0 group-hover:opacity-100 transition">→</span>
                                <span>Kebijakan Privasi</span>
                            </a></li>
                            <li><a href="#" class="text-neutral-400 hover:text-orange-400 transition flex items-center gap-2 group">
                                <span class="text-orange-500 opacity-0 group-hover:opacity-100 transition">→</span>
                                <span>Syarat & Ketentuan</span>
                            </a></li>
                        </ul>
                    </div>
                    
                    <!-- Contact Info -->
                    <div class="lg:col-span-3">
                        <h4 class="font-bold text-lg mb-4 text-orange-400">Hubungi Kami</h4>
                        <ul class="space-y-3 text-sm">
                            <li class="flex items-start gap-3 text-neutral-400">
                                <span class="text-orange-400 text-lg">📧</span>
                                <div>
                                    <p class="font-medium text-white">Email</p>
                                    <p>info@jerukpin.com</p>
                                    <p>support@jerukpin.com</p>
                                </div>
                            </li>
                            <li class="flex items-start gap-3 text-neutral-400">
                                <span class="text-orange-400 text-lg">📞</span>
                                <div>
                                    <p class="font-medium text-white">Telepon</p>
                                    <p>+62 812-3456-7890</p>
                                    <p class="text-xs">Senin - Sabtu, 08:00 - 17:00</p>
                                </div>
                            </li>
                            <li class="flex items-start gap-3 text-neutral-400">
                                <span class="text-orange-400 text-lg">📍</span>
                                <div>
                                    <p class="font-medium text-white">Alamat</p>
                                    <p>Jl. Jeruk Manis No. 123<br/>Jakarta Selatan, 12345</p>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <!-- Bottom Bar -->
            <div class="py-6">
                <div class="flex flex-col lg:flex-row justify-between items-center gap-6">
                    <!-- Copyright -->
                    <div class="text-center lg:text-left">
                        <p class="text-sm text-neutral-400">
                            © 2025 <span class="text-orange-400 font-semibold">JerukPin</span>. All rights reserved.
                        </p>
                    </div>
                    
                    <!-- Social Media -->
                    <div class="flex items-center gap-3">
                        <span class="text-sm text-neutral-400 mr-2">Ikuti Kami:</span>
                        <a href="#" class="w-9 h-9 bg-neutral-800 rounded-lg flex items-center justify-center hover:bg-gradient-to-br hover:from-blue-600 hover:to-blue-700 transition-all duration-300 hover:scale-110 group">
                            <span class="text-lg group-hover:scale-110 transition-transform">📘</span>
                        </a>
                        <a href="#" class="w-9 h-9 bg-neutral-800 rounded-lg flex items-center justify-center hover:bg-gradient-to-br hover:from-pink-600 hover:to-purple-600 transition-all duration-300 hover:scale-110 group">
                            <span class="text-lg group-hover:scale-110 transition-transform">📷</span>
                        </a>
                        <a href="#" class="w-9 h-9 bg-neutral-800 rounded-lg flex items-center justify-center hover:bg-gradient-to-br hover:from-blue-400 hover:to-blue-500 transition-all duration-300 hover:scale-110 group">
                            <span class="text-lg group-hover:scale-110 transition-transform">🐦</span>
                        </a>
                        <a href="#" class="w-9 h-9 bg-neutral-800 rounded-lg flex items-center justify-center hover:bg-gradient-to-br hover:from-green-500 hover:to-green-600 transition-all duration-300 hover:scale-110 group">
                            <span class="text-lg group-hover:scale-110 transition-transform">💬</span>
                        </a>
                    </div>
                    
                    <!-- Payment & Shipping Badges -->
                    <div class="flex flex-wrap justify-center gap-4">
                        <div class="flex items-center gap-2 px-4 py-2 bg-neutral-800 rounded-lg border border-neutral-700">
                            <span class="text-lg">💳</span>
                            <span class="text-xs text-neutral-400">BCA • Mandiri • BNI</span>
                        </div>
                        <div class="flex items-center gap-2 px-4 py-2 bg-neutral-800 rounded-lg border border-neutral-700">
                            <span class="text-lg">🚚</span>
                            <span class="text-xs text-neutral-400">JNE • J&T • SiCepat</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    
    <!-- Hover Dropdowns Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Cart Hover Dropdown
            const cartContainer = document.querySelector('.cart-dropdown-container');
            const cartDropdown = document.querySelector('.cart-dropdown');
            let cartHoverTimeout;
            
            if (cartContainer && cartDropdown) {
                cartContainer.addEventListener('mouseenter', function() {
                    clearTimeout(cartHoverTimeout);
                    cartDropdown.classList.remove('opacity-0', 'invisible', 'scale-95');
                    cartDropdown.classList.add('opacity-100', 'visible', 'scale-100');
                });
                
                cartContainer.addEventListener('mouseleave', function() {
                    cartHoverTimeout = setTimeout(() => {
                        cartDropdown.classList.add('opacity-0', 'invisible', 'scale-95');
                        cartDropdown.classList.remove('opacity-100', 'visible', 'scale-100');
                    }, 200);
                });
            }
            
            // Hamburger Hover Dropdown
            const menuButton = document.getElementById('menu-button');
            const menuDropdown = document.getElementById('menu-dropdown');
            const hamburgerLine1 = document.getElementById('hamburger-line-1');
            const hamburgerLine2 = document.getElementById('hamburger-line-2');
            const hamburgerLine3 = document.getElementById('hamburger-line-3');
            let hamburgerHoverTimeout;
            
            if (menuButton && menuDropdown) {
                const hamburgerContainer = menuButton.parentElement;
                
                hamburgerContainer.addEventListener('mouseenter', function() {
                    clearTimeout(hamburgerHoverTimeout);
                    menuDropdown.classList.remove('opacity-0', 'invisible', 'scale-95');
                    menuDropdown.classList.add('opacity-100', 'visible', 'scale-100');
                    
                    // Animate to X
                    if (hamburgerLine1 && hamburgerLine2 && hamburgerLine3) {
                        hamburgerLine1.style.transform = 'rotate(45deg) translateY(0)';
                        hamburgerLine2.style.opacity = '0';
                        hamburgerLine3.style.transform = 'rotate(-45deg) translateY(0)';
                    }
                });
                
                hamburgerContainer.addEventListener('mouseleave', function() {
                    hamburgerHoverTimeout = setTimeout(() => {
                        menuDropdown.classList.add('opacity-0', 'invisible', 'scale-95');
                        menuDropdown.classList.remove('opacity-100', 'visible', 'scale-100');
                        
                        // Animate back to hamburger
                        if (hamburgerLine1 && hamburgerLine2 && hamburgerLine3) {
                            hamburgerLine1.style.transform = 'rotate(0) translateY(0)';
                            hamburgerLine2.style.opacity = '1';
                            hamburgerLine3.style.transform = 'rotate(0) translateY(0)';
                        }
                    }, 200);
                });
            }
            
            // Kategori Dropdown Hover
            const kategoriContainer = document.querySelector('.kategori-dropdown-container');
            const kategoriDropdown = document.querySelector('.kategori-dropdown');
            const kategoriArrow = document.querySelector('.kategori-arrow');
            let kategoriHoverTimeout;
            
            if (kategoriContainer && kategoriDropdown) {
                kategoriContainer.addEventListener('mouseenter', function() {
                    clearTimeout(kategoriHoverTimeout);
                    kategoriDropdown.classList.remove('opacity-0', 'invisible', 'scale-95');
                    kategoriDropdown.classList.add('opacity-100', 'visible', 'scale-100');
                    if (kategoriArrow) kategoriArrow.style.transform = 'rotate(180deg)';
                });
                
                kategoriContainer.addEventListener('mouseleave', function() {
                    kategoriHoverTimeout = setTimeout(() => {
                        kategoriDropdown.classList.add('opacity-0', 'invisible', 'scale-95');
                        kategoriDropdown.classList.remove('opacity-100', 'visible', 'scale-100');
                        if (kategoriArrow) kategoriArrow.style.transform = 'rotate(0deg)';
                    }, 200);
                });
            }
            
            // Promo Dropdown Hover
            const promoContainer = document.querySelector('.promo-dropdown-container');
            const promoDropdown = document.querySelector('.promo-dropdown');
            const promoArrow = document.querySelector('.promo-arrow');
            let promoHoverTimeout;
            
            if (promoContainer && promoDropdown) {
                promoContainer.addEventListener('mouseenter', function() {
                    clearTimeout(promoHoverTimeout);
                    promoDropdown.classList.remove('opacity-0', 'invisible', 'scale-95');
                    promoDropdown.classList.add('opacity-100', 'visible', 'scale-100');
                    if (promoArrow) promoArrow.style.transform = 'rotate(180deg)';
                });
                
                promoContainer.addEventListener('mouseleave', function() {
                    promoHoverTimeout = setTimeout(() => {
                        promoDropdown.classList.add('opacity-0', 'invisible', 'scale-95');
                        promoDropdown.classList.remove('opacity-100', 'visible', 'scale-100');
                        if (promoArrow) promoArrow.style.transform = 'rotate(0deg)';
                    }, 200);
                });
            }
            
            // Search Bar Hover Reveal (Fixed)
            const searchContainer = document.querySelector('.search-hover-container');
            const searchForm = document.querySelector('.search-form');
            const searchInput = searchForm ? searchForm.querySelector('input[name="q"]') : null;
            let searchHoverTimeout;
            
            if (searchContainer && searchForm) {
                searchContainer.addEventListener('mouseenter', function() {
                    clearTimeout(searchHoverTimeout);
                    searchForm.classList.remove('opacity-0', 'invisible');
                    searchForm.classList.add('opacity-100', 'visible');
                    setTimeout(() => {
                        if (searchInput) searchInput.focus();
                    }, 100);
                });
                
                searchContainer.addEventListener('mouseleave', function() {
                    searchHoverTimeout = setTimeout(() => {
                        if (!searchInput || searchInput.value === '') {
                            searchForm.classList.add('opacity-0', 'invisible');
                            searchForm.classList.remove('opacity-100', 'visible');
                        }
                    }, 300);
                });
            }
        });
    </script>
    
    <!-- Page Loader Script - Improved & Faster -->
    <script>
        const loader = document.getElementById('pageLoader');
        let loaderTimeout;
        
        // Function to show loader (faster - 200ms)
        function showLoader() {
            if (loader) {
                clearTimeout(loaderTimeout);
                loader.style.display = 'flex';
                loader.style.opacity = '1';
            }
        }
        
        // Function to hide loader (faster)
        function hideLoader() {
            if (loader) {
                loader.style.opacity = '0';
                setTimeout(() => {
                    loader.style.display = 'none';
                    loader.style.opacity = '1';
                }, 200); //  Faster transition
            }
        }
        
        // Show loader when clicking navigation links
        document.addEventListener('click', function(e) {
            const link = e.target.closest('a');
            if (link && link.href && !link.target && !link.href.startsWith('#') && !link.href.startsWith('javascript:')) {
                // Don't show loader for same-page hash links or javascript links
                if (link.href !== window.location.href) {
                    showLoader();
                }
            }
        });
        
        // Show loader when submitting forms
        document.addEventListener('submit', function(e) {
            const form = e.target;
            if (form && form.tagName === 'FORM') {
                // Only show if it's not an AJAX form
                if (!form.hasAttribute('data-ajax')) {
                    showLoader();
                }
            }
        });
        
        // Hide loader when page loads
        window.addEventListener('load', function() {
            hideLoader();
        });
        
        // IMPORTANT: Handle back/forward button navigation (prevents stuck loader)
        window.addEventListener('pageshow', function(event) {
            // If page was loaded from cache (back button)
            if (event.persisted || (window.performance && window.performance.navigation.type === 2)) {
                hideLoader();
            }
        });
        
        // Fallback: Auto-hide loader after 2 seconds (reduced from 3)
        window.addEventListener('DOMContentLoaded', function() {
            loaderTimeout = setTimeout(function() {
                if (loader && loader.style.display !== 'none') {
                    hideLoader();
                }
            }, 2000);
        });
    </script>
    
    <!-- WhatsApp Floating Button -->
    <a href="https://wa.me/6281234567890?text=Halo%20JerukPin%2C%20saya%20mau%20bertanya%20tentang%20produk" 
       target="_blank"
       class="fixed bottom-6 right-6 z-50 bg-green-500 hover:bg-green-600 text-white w-14 h-14 rounded-full shadow-2xl flex items-center justify-center transition-all hover:scale-110 group"
       title="Chat via WhatsApp">
        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24">
            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.890-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
        </svg>
    </a>
</body>
</html>
