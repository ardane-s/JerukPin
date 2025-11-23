@extends('layouts.app')

@section('title', 'Keranjang Belanja')

@section('content')
<!-- Breadcrumbs -->
<div class="bg-gradient-to-r from-orange-50 to-yellow-50 border-b border-orange-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
        <nav class="flex items-center gap-2 text-sm">
            <a href="{{ route('home') }}" class="text-neutral-600 hover:text-orange-600 transition">🏠 Beranda</a>
            <span class="text-neutral-400">›</span>
            <span class="text-orange-600 font-medium">Keranjang Belanja</span>
        </nav>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-2xl sm:text-3xl md:text-4xl font-heading font-bold text-neutral-900 mb-2">
            <span class="bg-gradient-to-r from-orange-500 to-orange-600 bg-clip-text text-transparent">🛒 Keranjang Belanja</span>
        </h1>
        @if($cartItems->count() > 0)
            <p class="text-neutral-600">
                Anda memiliki <span class="font-bold text-orange-600">{{ $cartItems->count() }}</span> item di keranjang
            </p>
        @endif
    </div>

    @if($cartItems->count() > 0)
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Cart Items -->
            <div class="lg:col-span-2 space-y-4">
                @foreach($cartItems as $item)
                    <div class="bg-white rounded-2xl shadow-lg border-2 border-orange-100 p-4 sm:p-6 hover:shadow-xl transition">
                        <div class="flex flex-col sm:flex-row gap-4 sm:gap-6">
                            <!-- Product Image -->
                            <div class="w-24 h-24 sm:w-32 sm:h-32 rounded-xl border-2 border-orange-200 mx-auto sm:mx-0 relative overflow-hidden flex-shrink-0 bg-orange-50">
                                <!-- Placeholder -->
                                <div class="absolute inset-0 flex items-center justify-center bg-gradient-to-br from-orange-100 to-yellow-100">
                                    <span class="text-4xl sm:text-5xl select-none">🍊</span>
                                </div>
                                <!-- Image -->
                                @if($item->productVariant->product->images->first())
                                    <img src="{{ Storage::url($item->productVariant->product->images->first()->image_path) }}" 
                                         alt="{{ $item->productVariant->product->name }}" 
                                         class="w-full h-full object-cover relative z-10"
                                         onerror="this.style.display='none'">
                                @endif
                            </div>
                            
                            <!-- Product Info -->
                            <div class="flex-1 flex flex-col justify-between">
                                <div>
                                    <h3 class="font-bold text-lg sm:text-xl text-neutral-900 mb-1">{{ $item->productVariant->product->name }}</h3>
                                    <p class="text-sm text-neutral-500 mb-2">📦 {{ $item->productVariant->variant_name }}</p>
                                    <p class="text-sm text-neutral-600 mb-1">{{ $item->quantity }}x @ Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                                    <p class="text-xl sm:text-2xl font-bold text-orange-600">
                                        Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}
                                    </p>
                                </div>
                                
                                <!-- Quantity Controls -->
                                <div class="flex flex-col sm:flex-row items-center gap-4 mt-4">
                                    <div class="flex items-center gap-2 w-full sm:w-auto justify-center">
                                        <form action="{{ route('cart.update', $item->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="quantity" value="{{ max(1, $item->quantity - 1) }}">
                                            <button type="submit" class="w-10 h-10 bg-orange-100 hover:bg-orange-200 text-orange-600 rounded-lg font-bold transition flex items-center justify-center">
                                                −
                                            </button>
                                        </form>
                                        
                                        <span class="w-16 text-center font-bold text-lg">{{ $item->quantity }}</span>
                                        
                                        <form action="{{ route('cart.update', $item->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="quantity" value="{{ $item->quantity + 1 }}">
                                            <button type="submit" class="w-10 h-10 bg-orange-500 hover:bg-orange-600 text-white rounded-lg font-bold transition flex items-center justify-center">
                                                +
                                            </button>
                                        </form>
                                    </div>
                                    
                                    <div class="flex-1 text-center sm:text-right">
                                        <p class="text-sm text-neutral-600">Subtotal</p>
                                        <p class="text-lg sm:text-xl font-bold text-neutral-900">
                                            Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Remove Button -->
                            <div class="absolute top-4 right-4 sm:relative sm:top-0 sm:right-0">
                                <form action="{{ route('cart.remove', $item->id) }}" method="POST" id="removeForm{{ $item->id }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" onclick="showConfirmModal('Hapus item ini dari keranjang?', () => document.getElementById('removeForm{{ $item->id }}').submit())" class="w-10 h-10 bg-red-100 hover:bg-red-200 text-red-600 rounded-lg transition flex items-center justify-center">
                                        🗑️
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
                
                <!-- Clear Cart Button -->
                <div class="flex justify-between items-center pt-4">
                    <form action="{{ route('cart.clear') }}" method="POST" id="clearCartForm">
                        @csrf
                        @method('DELETE')
                        <button type="button" onclick="showConfirmModal('Kosongkan semua item dari keranjang?', () => document.getElementById('clearCartForm').submit())" class="text-red-600 hover:text-red-800 font-medium transition">
                            🗑️ Kosongkan Keranjang
                        </button>
                    </form>
                    
                    <a href="{{ route('products.index') }}" class="text-orange-600 hover:text-orange-800 font-medium transition">
                        ← Lanjut Belanja
                    </a>
                </div>
            </div>

            <!-- Order Summary Sidebar -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-lg border-2 border-orange-100 p-4 sm:p-6 lg:sticky lg:top-24">
                    <h2 class="text-xl sm:text-2xl font-bold mb-4 sm:mb-6 flex items-center gap-2">
                        📋 Ringkasan Pesanan
                    </h2>
                    
                    <!-- Coupon Section -->
                    <div class="mb-6 p-5 bg-gradient-to-br from-orange-50 to-yellow-50 rounded-xl border-2 border-orange-200 shadow-sm">
                        <div class="flex items-center gap-2 mb-3">
                            <span class="text-2xl">🎟️</span>
                            <h3 class="font-bold text-neutral-900">Punya Kode Promo?</h3>
                        </div>
                        <p class="text-xs text-neutral-600 mb-3">Masukkan kode promo untuk mendapatkan diskon spesial</p>
                        <div class="flex gap-2">
                            <input type="text" 
                                   placeholder="Masukkan kode promo" 
                                   class="flex-1 px-4 py-3 border-2 border-orange-300 rounded-lg focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition text-sm bg-white">
                            <button class="px-5 py-3 bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white rounded-lg font-bold transition shadow-md hover:shadow-lg text-sm whitespace-nowrap">
                                Terapkan
                            </button>
                        </div>
                    </div>
                    
                    <!-- Price Breakdown -->
                    <div class="space-y-3 mb-6">
                        <div class="flex justify-between text-neutral-600">
                            <span>Subtotal ({{ $cartItems->count() }} item)</span>
                            <span class="font-medium">Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-neutral-600">
                            <span>Ongkos Kirim</span>
                            <span class="text-sm text-orange-600 font-medium">Dihitung di checkout</span>
                        </div>
                        <div class="flex justify-between text-neutral-600">
                            <span>Diskon</span>
                            <span class="text-green-600 font-medium">Rp 0</span>
                        </div>
                    </div>
                    
                    <!-- Total -->
                    <div class="border-t-2 border-neutral-200 pt-4 mb-6">
                        <div class="flex justify-between items-center">
                            <span class="text-lg font-bold text-neutral-900">Total</span>
                            <span class="text-2xl sm:text-3xl font-bold text-orange-600">Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                    </div>
                    
                    <!-- Checkout Button -->
                    <a href="{{ route('checkout.index') }}" class="block w-full bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white text-center py-3 sm:py-4 rounded-lg sm:rounded-xl font-bold text-base sm:text-lg transition shadow-lg hover:shadow-xl active:scale-95">
                        🚀 Lanjut ke Checkout
                    </a>
                    
                    <!-- Continue Shopping -->
                    <a href="{{ route('products.index') }}" class="block w-full text-center text-orange-600 hover:text-orange-800 py-3 font-medium transition">
                        ← Lanjut Belanja
                    </a>
                    
                    <!-- Trust Badges -->
                    <div class="mt-6 pt-6 border-t border-neutral-200 space-y-2">
                        <div class="flex items-center gap-2 text-sm text-neutral-600">
                            <span class="text-green-500">✓</span>
                            <span>Pembayaran Aman</span>
                        </div>
                        <div class="flex items-center gap-2 text-sm text-neutral-600">
                            <span class="text-green-500">✓</span>
                            <span>Gratis Ongkir >Rp 100.000</span>
                        </div>
                        <div class="flex items-center gap-2 text-sm text-neutral-600">
                            <span class="text-green-500">✓</span>
                            <span>Jaminan Segar</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <!-- Empty Cart State -->
        <div class="bg-white rounded-2xl shadow-lg border-2 border-orange-100 p-16 text-center">
            <div class="text-8xl mb-6">🛒</div>
            <h2 class="text-3xl font-bold text-neutral-900 mb-3">Keranjang Belanja Kosong</h2>
            <p class="text-neutral-600 mb-8 text-lg">Belum ada produk di keranjang Anda. Yuk mulai belanja!</p>
            <a href="{{ route('products.index') }}" class="inline-block bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white px-12 py-4 rounded-xl font-bold text-lg transition shadow-lg hover:shadow-xl">
                🛍️ Mulai Belanja
            </a>
            
            <!-- Quick Links -->
            <div class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-6">
                <a href="{{ route('home') }}" class="p-6 bg-gradient-to-br from-orange-50 to-yellow-50 rounded-xl border-2 border-orange-200 hover:border-orange-400 transition">
                    <div class="text-4xl mb-2">🏠</div>
                    <h3 class="font-bold text-neutral-900">Beranda</h3>
                    <p class="text-sm text-neutral-600">Kembali ke halaman utama</p>
                </a>
                <a href="{{ route('products.index') }}" class="p-6 bg-gradient-to-br from-orange-50 to-yellow-50 rounded-xl border-2 border-orange-200 hover:border-orange-400 transition">
                    <div class="text-4xl mb-2">🍊</div>
                    <h3 class="font-bold text-neutral-900">Semua Produk</h3>
                    <p class="text-sm text-neutral-600">Lihat koleksi lengkap</p>
                </a>
                <a href="{{ route('flash-sales.index') }}" class="p-6 bg-gradient-to-br from-red-50 to-orange-50 rounded-xl border-2 border-red-200 hover:border-red-400 transition">
                    <div class="text-4xl mb-2">⚡</div>
                    <h3 class="font-bold text-neutral-900">Flash Sale</h3>
                    <p class="text-sm text-neutral-600">Diskon spesial hari ini</p>
                </a>
            </div>
        </div>
    @endif
</div>
@endsection
