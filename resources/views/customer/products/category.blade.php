@extends('layouts.app')

@section('title', $category->name . ' - JerukPin')

@section('content')
<!-- Category Hero Section -->
<div class="relative py-20 mb-12 overflow-hidden">
    <!-- Gradient Background -->
    <div class="absolute inset-0 bg-gradient-to-br from-orange-400 via-orange-500 to-orange-600"></div>
    
    <!-- Pattern Overlay -->
    <div class="absolute inset-0 opacity-10" style="background-image: url('data:image/svg+xml,%3Csvg width=&quot;60&quot; height=&quot;60&quot; viewBox=&quot;0 0 60 60&quot; xmlns=&quot;http://www.w3.org/2000/svg&quot;%3E%3Cg fill=&quot;none&quot; fill-rule=&quot;evenodd&quot;%3E%3Cg fill=&quot;%23ffffff&quot; fill-opacity=&quot;1&quot;%3E%3Cpath d=&quot;M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z&quot;/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
    
    <!-- Content -->
    <div class="relative max-w-7xl mx-auto px-4 text-center">
        <!-- Category Icon/Badge -->
        <!-- Category Icon/Badge -->
        <div class="inline-flex items-center justify-center w-20 h-20 bg-white rounded-2xl shadow-xl mb-6 transform hover:scale-110 transition-transform duration-300 overflow-hidden">
            @if($category->image)
                <img src="{{ asset('storage/' . $category->image) }}" 
                     alt="{{ $category->name }}" 
                     class="w-full h-full object-cover">
            @else
                <span class="text-4xl">🍊</span>
            @endif
        </div>
        
        <!-- Category Name -->
        <h1 class="text-5xl md:text-6xl font-bold text-white mb-4 drop-shadow-lg">
            {{ $category->name }}
        </h1>
        
        <!-- Category Description -->
        <p class="text-xl text-white/90 max-w-3xl mx-auto leading-relaxed drop-shadow-md">
            {{ $category->description }}
        </p>
        
        <!-- Product Count Badge -->
        <div class="mt-8 inline-flex items-center gap-2 bg-white/20 backdrop-blur-sm px-6 py-3 rounded-full border-2 border-white/30">
            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
            </svg>
            <span class="text-white font-semibold">{{ $products->total() }} Produk Tersedia</span>
        </div>
    </div>
    
    <!-- Decorative Shapes -->
    <div class="absolute top-10 left-10 w-32 h-32 bg-white/10 rounded-full blur-3xl"></div>
    <div class="absolute bottom-10 right-10 w-40 h-40 bg-yellow-300/20 rounded-full blur-3xl"></div>
</div>

<!-- Products Grid -->
<div class="max-w-7xl mx-auto px-4 pb-16">
    @if($products->count() > 0)
        <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($products as $product)
                <x-product-card :product="$product" />
            @endforeach
        </div>
        
        <!-- Pagination -->
        <div class="mt-12">
            {{ $products->links() }}
        </div>
    @else
        <!-- Empty State -->
        <div class="text-center py-20">
            <div class="inline-flex items-center justify-center w-32 h-32 bg-gradient-to-br from-orange-100 to-orange-200 rounded-full mb-6">
                <span class="text-6xl">🍊</span>
            </div>
            <h3 class="text-2xl font-bold text-neutral-900 mb-3">Belum Ada Produk</h3>
            <p class="text-neutral-600 mb-8 max-w-md mx-auto">
                Saat ini belum ada produk dalam kategori ini. Silakan cek kategori lain atau kembali lagi nanti!
            </p>
            <a href="{{ route('products.index') }}" class="inline-block bg-gradient-to-r from-orange-500 to-orange-600 text-white px-8 py-3 rounded-lg font-semibold hover:shadow-xl transition-all transform hover:scale-105">
                Lihat Semua Produk
            </a>
        </div>
    @endif
</div>
@endsection
