@extends('layouts.app')

@section('title', 'Wishlist Saya')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-heading font-bold text-neutral-900 mb-6">💝 Wishlist Saya</h1>

    @if($wishlists->count() > 0)
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            @foreach($wishlists as $wishlist)
                @php
                    $product = $wishlist->product;
                @endphp
                <div class="bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-md transition relative">
                    <!-- Remove Button -->
                    <form action="{{ route('wishlist.destroy', $product->id) }}" method="POST" class="absolute top-2 right-2 z-10">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-white rounded-full p-2 shadow-md hover:bg-red-50 transition">
                            <svg class="w-5 h-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                            @if($product->reviewsCount() > 0)
                                <div class="flex items-center mb-2">
                                    @for($i = 1; $i <= 5; $i++)
                                        <svg class="w-3 h-3 {{ $i <= round($product->averageRating()) ? 'text-yellow-400' : 'text-neutral-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                    @endfor
                                    <span class="ml-1 text-xs text-neutral-500">({{ $product->reviewsCount() }})</span>
                                </div>
                            @endif
                            
                            @if($product->variants->first())
                                <p class="text-lg font-bold text-primary-600">Mulai Rp {{ number_format($product->variants->min('price'), 0, ',', '.') }}</p>
                            @endif
                            
                            @if($product->isBestSeller())
                                <span class="inline-block mt-2 bg-primary-100 text-primary-800 px-2 py-0.5 rounded text-xs font-bold">⭐ Best Seller</span>
                            @endif
                            
                            <!-- Stock Status -->
                            @if($product->variants->sum('stock') > 0)
                                <p class="text-xs text-green-600 mt-2">✓ Tersedia</p>
                            @else
                                <p class="text-xs text-red-600 mt-2">✗ Stok Habis</p>
                            @endif
                        </div>
                    </a>
                    
                    <!-- Add to Cart Button -->
                    @if($product->variants->sum('stock') > 0)
                        <div class="p-4 pt-0">
                            <a href="{{ route('product.show', $product->slug) }}" class="block w-full bg-primary-500 hover:bg-primary-600 text-white text-center py-2 rounded-lg font-medium text-sm">
                                🛒 Tambah ke Keranjang
                            </a>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    @else
        <div class="bg-white rounded-lg shadow-sm p-12 text-center">
            <div class="text-6xl mb-4">💝</div>
            <h2 class="text-2xl font-bold text-neutral-900 mb-2">Wishlist Kosong</h2>
            <p class="text-neutral-600 mb-6">Belum ada produk yang Anda simpan di wishlist.</p>
            <a href="{{ route('products.index') }}" class="inline-block bg-primary-500 hover:bg-primary-600 text-white px-8 py-3 rounded-lg font-bold">
                Mulai Belanja
            </a>
        </div>
    @endif
</div>
@endsection
