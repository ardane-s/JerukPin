@extends('admin.layouts.app')

@section('title', 'Kategori')
@section('page-title', 'Kategori Produk')
@section('page-description', 'Kelola kategori produk JerukPin')

@section('content')
<div class="flex justify-end items-center mb-6">
    <a href="{{ route('admin.categories.create') }}" class="bg-orange-600 hover:bg-orange-700 text-white px-5 py-2.5 rounded-lg font-medium shadow-sm hover:shadow transition flex items-center gap-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
        </svg>
        Tambah Kategori
    </a>
</div>

<div class="bg-white rounded-xl shadow-sm overflow-hidden border border-neutral-200">
    <table class="min-w-full divide-y divide-neutral-200">
        <thead class="bg-neutral-50">
            <tr>
                <th class="px-6 py-3.5 text-left text-xs font-semibold text-neutral-700 uppercase tracking-wider">Nama</th>
                <th class="px-6 py-3.5 text-left text-xs font-semibold text-neutral-700 uppercase tracking-wider">Slug</th>
                <th class="px-6 py-3.5 text-left text-xs font-semibold text-neutral-700 uppercase tracking-wider">Jumlah Produk</th>
                <th class="px-6 py-3.5 text-left text-xs font-semibold text-neutral-700 uppercase tracking-wider">Status</th>
                <th class="px-6 py-3.5 text-right text-xs font-semibold text-neutral-700 uppercase tracking-wider">Aksi</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-neutral-200">
            @forelse($categories as $category)
                <tr class="hover:bg-neutral-50 transition">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-semibold text-neutral-900">{{ $category->name }}</div>
                        @if($category->description)
                            <div class="text-sm text-neutral-500 mt-1">{{ Str::limit($category->description, 50) }}</div>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <code class="text-xs bg-neutral-100 px-2.5 py-1 rounded text-neutral-600 font-mono">{{ $category->slug }}</code>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-orange-100 text-orange-800">
                            {{ $category->products_count }} produk
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($category->is_active)
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
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-3">
                        <a href="{{ route('admin.categories.edit', $category) }}" class="text-orange-600 hover:text-orange-700 font-medium">Edit</a>
                        <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-700 font-medium">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center">
                        <svg class="mx-auto h-12 w-12 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>
                        </svg>
                        <p class="mt-2 text-sm text-neutral-500">Belum ada kategori</p>
                        <a href="{{ route('admin.categories.create') }}" class="mt-2 inline-block text-sm text-orange-600 hover:text-orange-700 font-medium">Tambah kategori pertama →</a>
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
