@extends('admin.layouts.app')

@section('title', 'Produk')
@section('page-title', 'Produk')
@section('page-description', 'Kelola produk JerukPin')

@section('content')
<div class="flex justify-end items-center mb-6">
    <a href="{{ route('admin.products.create') }}" class="bg-orange-600 hover:bg-orange-700 text-white px-5 py-2.5 rounded-lg font-medium shadow-sm hover:shadow transition flex items-center gap-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
        </svg>
        Tambah Produk
    </a>
</div>

<div class="bg-white rounded-xl shadow-sm overflow-hidden border border-neutral-200">
    <table class="min-w-full divide-y divide-neutral-200">
        <thead class="bg-neutral-50">
            <tr>
                <th class="px-6 py-3.5 text-left text-xs font-semibold text-neutral-700 uppercase tracking-wider">Produk</th>
                <th class="px-6 py-3.5 text-left text-xs font-semibold text-neutral-700 uppercase tracking-wider">Kategori</th>
                <th class="px-6 py-3.5 text-left text-xs font-semibold text-neutral-700 uppercase tracking-wider">Varian</th>
                <th class="px-6 py-3.5 text-left text-xs font-semibold text-neutral-700 uppercase tracking-wider">Terjual</th>
                <th class="px-6 py-3.5 text-left text-xs font-semibold text-neutral-700 uppercase tracking-wider">Status</th>
                <th class="px-6 py-3.5 text-right text-xs font-semibold text-neutral-700 uppercase tracking-wider">Aksi</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-neutral-200">
            @forelse($products as $product)
                <tr class="hover:bg-neutral-50 transition">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-lg bg-orange-100 flex items-center justify-center relative overflow-hidden border border-neutral-200">
                                <span class="text-2xl absolute select-none">🍊</span>
                                @if($product->images->first())
                                    <img src="{{ asset('storage/' . $product->images->first()->image_path) }}" 
                                         alt="{{ $product->name }}" 
                                         class="w-full h-full object-cover relative z-10"
                                         onerror="this.style.display='none'">
                                @endif
                            </div>
                            <div>
                                <div class="text-sm font-semibold text-neutral-900">{{ $product->name }}</div>
                                @if($product->isBestSeller())
                                    <span class="inline-flex items-center gap-1 text-xs bg-yellow-100 text-yellow-800 px-2 py-0.5 rounded-full font-medium mt-1">
                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                        Best Seller
                                    </span>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-blue-100 text-blue-800">
                            {{ $product->category->name }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="text-sm font-medium text-neutral-700">{{ $product->variants_count }}</span>
                        <span class="text-xs text-neutral-500">varian</span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-semibold bg-green-100 text-green-800">
                            {{ $product->total_sold_count }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        @if($product->is_active)
                            <span class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                                Aktif
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full bg-neutral-100 text-neutral-600">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                </svg>
                                Nonaktif
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right text-sm font-medium space-x-3">
                        <a href="{{ route('admin.products.edit', $product) }}" class="text-orange-600 hover:text-orange-700 font-medium">Edit</a>
                        <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-700 font-medium">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center">
                        <svg class="mx-auto h-12 w-12 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                        <p class="mt-2 text-sm text-neutral-500">Belum ada produk</p>
                        <a href="{{ route('admin.products.create') }}" class="mt-2 inline-block text-sm text-orange-600 hover:text-orange-700 font-medium">Tambah produk pertama →</a>
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
