@extends('admin.layouts.app')

@section('title', 'Kategori')
@section('page-title', 'Kategori Produk')
@section('page-description', 'Kelola kategori produk JerukPin')

@section('content')
<div class="flex justify-end items-center mb-6">
    <a href="{{ route('admin.categories.create') }}" class="bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white px-6 py-3 rounded-lg font-medium shadow-lg hover:shadow-xl transition flex items-center gap-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
        </svg>
        Tambah Kategori
    </a>
</div>

<div class="bg-white rounded-lg shadow-sm overflow-hidden border border-neutral-200">
    <table class="min-w-full divide-y divide-neutral-200">
        <thead class="bg-gradient-to-r from-orange-50 to-orange-100">
            <tr>
                <th class="px-6 py-4 text-left text-xs font-bold text-orange-900 uppercase tracking-wider">Nama</th>
                <th class="px-6 py-3 text-left text-xs font-bold text-orange-900 uppercase tracking-wider">Slug</th>
                <th class="px-6 py-3 text-left text-xs font-bold text-orange-900 uppercase tracking-wider">Jumlah Produk</th>
                <th class="px-6 py-3 text-left text-xs font-bold text-orange-900 uppercase tracking-wider">Status</th>
                <th class="px-6 py-3 text-right text-xs font-bold text-orange-900 uppercase tracking-wider">Aksi</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-neutral-200">
            @forelse($categories as $category)
                <tr class="hover:bg-orange-50/50 transition">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-bold text-neutral-900">{{ $category->name }}</div>
                        @if($category->description)
                            <div class="text-sm text-neutral-500 mt-1">{{ Str::limit($category->description, 50) }}</div>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <code class="text-xs bg-neutral-100 px-2 py-1 rounded text-neutral-600">{{ $category->slug }}</code>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-orange-100 text-orange-800">
                            🍊 {{ $category->products_count }} produk
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($category->is_active)
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-green-100 text-green-800">
                                ✓ Aktif
                            </span>
                        @else
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-neutral-100 text-neutral-600">
                                ✗ Nonaktif
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-3">
                        <a href="{{ route('admin.categories.edit', $category) }}" class="text-orange-600 hover:text-orange-900 font-medium">✏️ Edit</a>
                        <form action="{{ route('admin.categories.destroy', $category) }}\" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900 font-medium">🗑️ Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center">
                        <div class="text-6xl mb-4">📁</div>
                        <p class="text-neutral-500 mb-2">Belum ada kategori</p>
                        <a href="{{ route('admin.categories.create') }}" class="text-orange-600 hover:text-orange-800 font-medium">Tambah kategori pertama →</a>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-6">
    {{ $categories->links() }}
</div>
@endsection
