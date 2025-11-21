@extends('admin.layouts.app')

@section('title', 'Produk')
@section('page-title', 'Produk')
@section('page-description', 'Kelola produk JerukPin')

@section('content')
<div class="flex justify-end items-center mb-6">
    <a href="{{ route('admin.products.create') }}" class="bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white px-6 py-3 rounded-lg font-medium shadow-lg hover:shadow-xl transition flex items-center gap-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
        </svg>
        Tambah Produk
    </a>
</div>

<div class="bg-white rounded-xl shadow-sm overflow-hidden border border-neutral-200">
    <table class="min-w-full divide-y divide-neutral-200">
        <thead class="bg-gradient-to-r from-orange-50 to-orange-100">
            <tr>
                <th class="px-6 py-4 text-left text-xs font-bold text-orange-900 uppercase tracking-wider">Produk</th>
                <th class="px-6 py-4 text-left text-xs font-bold text-orange-900 uppercase tracking-wider">Kategori</th>
                <th class="px-6 py-4 text-left text-xs font-bold text-orange-900 uppercase tracking-wider">Varian</th>
                <th class="px-6 py-4 text-left text-xs font-bold text-orange-900 uppercase tracking-wider">Terjual</th>
                <th class="px-6 py-4 text-left text-xs font-bold text-orange-900 uppercase tracking-wider">Status</th>
                <th class="px-6 py-4 text-right text-xs font-bold text-orange-900 uppercase tracking-wider">Aksi</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-neutral-200">
            @forelse($products as $product)
                <tr class="hover:bg-orange-50/30 transition">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            @if($product->images->first())
                                <img src="{{ asset('storage/' . $product->images->first()->image_path) }}" 
                                     alt="{{ $product->name }}" 
                                     class="w-14 h-14 rounded-lg object-cover border-2 border-neutral-200 shadow-sm">
                            @else
                                <div class="w-14 h-14 bg-gradient-to-br from-orange-400 to-orange-500 rounded-lg flex items-center justify-center text-2xl shadow-sm">🍊</div>
                            @endif
                            <div>
                                <div class="text-sm font-bold text-neutral-900">{{ $product->name }}</div>
                                @if($product->isBestSeller())
                                    <span class="inline-flex items-center gap-1 text-xs bg-yellow-100 text-yellow-800 px-2 py-0.5 rounded-full font-medium mt-1">
                                        ⭐ Best Seller
                                    </span>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                            {{ $product->category->name }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="text-sm font-semibold text-neutral-700">{{ $product->variants_count }} varian</span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold bg-green-100 text-green-800">
                            {{ $product->total_sold_count }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        @if($product->is_active)
                            <span class="inline-flex items-center px-3 py-1 text-xs font-bold rounded-full bg-green-100 text-green-800">
                                ✓ Aktif
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 text-xs font-bold rounded-full bg-neutral-100 text-neutral-600">
                                ✗ Nonaktif
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right text-sm font-medium space-x-3">
                        <a href="{{ route('admin.products.edit', $product) }}" class="text-orange-600 hover:text-orange-900 font-medium">✏️ Edit</a>
                        <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900 font-medium">🗑️ Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center">
                        <div class="text-6xl mb-4">🍊</div>
                        <p class="text-neutral-500 mb-2">Belum ada produk</p>
                        <a href="{{ route('admin.products.create') }}" class="text-orange-600 hover:text-orange-800 font-medium">Tambah produk pertama →</a>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-6">
    {{ $products->links() }}
</div>
@endsection
