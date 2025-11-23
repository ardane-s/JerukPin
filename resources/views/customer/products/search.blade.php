@extends('layouts.app')

@section('title', 'Pencarian: ' . $search . ' - JerukPin')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">Hasil Pencarian: "{{ $search }}"</h1>

    @if($products->count() > 0)
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($products as $product)
                <x-product-card :product="$product" />
            @endforeach
        </div>
        
        <div class="mt-8">
            {{ $products->links() }}
        </div>
    @else
        <div class="text-center py-12">
            <p class="text-gray-500 text-lg">Tidak ada produk yang ditemukan.</p>
            <a href="{{ route('products.index') }}" class="mt-4 inline-block text-orange-500 hover:text-orange-600">
                Lihat Semua Produk
            </a>
        </div>
    @endif
</div>
@endsection
