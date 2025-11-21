@extends('admin.layouts.app')

@section('title', 'Review')
@section('page-title', 'Review Produk')
@section('page-description', 'Kelola review pelanggan JerukPin')

@section('content')
<!-- Filter Tabs -->
<div class="bg-white rounded-xl shadow-sm mb-6 border border-neutral-200 overflow-hidden">
    <div class="flex border-b border-neutral-200">
        <a href="{{ route('admin.reviews.index') }}" 
           class="px-6 py-4 text-sm font-bold transition {{ !request('status') ? 'border-b-2 border-orange-500 text-orange-600 bg-orange-50/50' : 'text-neutral-600 hover:text-orange-600 hover:bg-neutral-50' }}">
            📋 Semua Review
            <span class="ml-2 bg-neutral-100 text-neutral-700 py-0.5 px-2.5 rounded-full text-xs font-bold">{{ $reviews->total() }}</span>
        </a>
        <a href="{{ route('admin.reviews.index', ['status' => 'pending']) }}" 
           class="px-6 py-4 text-sm font-bold transition {{ request('status') === 'pending' ? 'border-b-2 border-orange-500 text-orange-600 bg-orange-50/50' : 'text-neutral-600 hover:text-orange-600 hover:bg-neutral-50' }}">
            ⏳ Pending
            @if($pendingCount > 0)
                <span class="ml-2 bg-orange-500 text-white py-0.5 px-2.5 rounded-full text-xs font-bold animate-pulse">{{ $pendingCount }}</span>
            @else
                <span class="ml-2 bg-neutral-100 text-neutral-700 py-0.5 px-2.5 rounded-full text-xs font-bold">0</span>
            @endif
        </a>
        <a href="{{ route('admin.reviews.index', ['status' => 'approved']) }}" 
           class="px-6 py-4 text-sm font-bold transition {{ request('status') === 'approved' ? 'border-b-2 border-orange-500 text-orange-600 bg-orange-50/50' : 'text-neutral-600 hover:text-orange-600 hover:bg-neutral-50' }}">
            ✅ Approved
        </a>
    </div>
</div>

<!-- Reviews Table -->
<div class="bg-white rounded-xl shadow-sm overflow-hidden border border-neutral-200">
    <table class="min-w-full">
        <thead class="bg-gradient-to-r from-orange-50 to-orange-100">
            <tr>
                <th class="px-6 py-4 text-left text-xs font-bold text-orange-900 uppercase tracking-wider">Produk</th>
                <th class="px-6 py-4 text-left text-xs font-bold text-orange-900 uppercase tracking-wider">Pelanggan</th>
                <th class="px-6 py-4 text-left text-xs font-bold text-orange-900 uppercase tracking-wider">Rating</th>
                <th class="px-6 py-4 text-left text-xs font-bold text-orange-900 uppercase tracking-wider">Review</th>
                <th class="px-6 py-4 text-left text-xs font-bold text-orange-900 uppercase tracking-wider">Status</th>
                <th class="px-6 py-4 text-left text-xs font-bold text-orange-900 uppercase tracking-wider">Tanggal</th>
                <th class="px-6 py-4 text-right text-xs font-bold text-orange-900 uppercase tracking-wider">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-neutral-200">
            @forelse($reviews as $review)
            <tr class="hover:bg-orange-50/30 transition">
                <td class="px-6 py-4">
                    <div class="flex items-center gap-3">
                        @if($review->product->images->first())
                            <img src="{{ asset('storage/' . $review->product->images->first()->image_path) }}" 
                                 alt="{{ $review->product->name }}" 
                                 class="w-14 h-14 rounded-lg object-cover border-2 border-neutral-200 shadow-sm">
                        @else
                            <div class="w-14 h-14 bg-gradient-to-br from-orange-400 to-orange-500 rounded-lg flex items-center justify-center text-2xl shadow-sm">🍊</div>
                        @endif
                        <div>
                            <div class="text-sm font-bold text-neutral-900">{{ $review->product->name }}</div>
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4">
                    <div class="text-sm font-bold text-neutral-900">{{ $review->user->name }}</div>
                    <div class="text-xs text-neutral-500 mt-0.5">{{ $review->user->email }}</div>
                </td>
                <td class="px-6 py-4">
                    <div class="flex items-center gap-2">
                        <div class="flex gap-0.5">
                            @for($i = 1; $i <= 5; $i++)
                                <svg class="w-5 h-5 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-neutral-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            @endfor
                        </div>
                        <span class="text-sm font-bold text-neutral-700">({{ $review->rating }}/5)</span>
                    </div>
                </td>
                <td class="px-6 py-4">
                    <div class="text-sm text-neutral-700 max-w-xs">
                        <p class="line-clamp-2">{{ $review->comment ?? 'Tidak ada komentar' }}</p>
                    </div>
                </td>
                <td class="px-6 py-4">
                    @if($review->is_approved)
                        <span class="inline-flex items-center px-3 py-1 text-xs font-bold rounded-full bg-green-100 text-green-800">
                            ✅ Approved
                        </span>
                    @else
                        <span class="inline-flex items-center px-3 py-1 text-xs font-bold rounded-full bg-yellow-100 text-yellow-800">
                            ⏳ Pending
                        </span>
                    @endif
                </td>
                <td class="px-6 py-4 text-sm text-neutral-600 font-medium">
                    <div>📅 {{ $review->created_at->format('d M Y') }}</div>
                    <div class="text-xs text-neutral-500">⏰ {{ $review->created_at->format('H:i') }}</div>
                </td>
                <td class="px-6 py-4 text-right">
                    <div class="flex justify-end gap-3">
                        @if(!$review->is_approved)
                            <form action="{{ route('admin.reviews.approve', $review) }}" method="POST">
                                @csrf
                                <button type="submit" class="text-green-600 hover:text-green-900 text-sm font-medium">
                                    ✓ Approve
                                </button>
                            </form>
                        @endif
                        <form action="{{ route('admin.reviews.destroy', $review) }}" method="POST" 
                              onsubmit="return confirm('Yakin ingin menghapus review ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900 text-sm font-medium">
                                🗑️ Hapus
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="px-6 py-12 text-center">
                    <div class="text-6xl mb-4">⭐</div>
                    <p class="text-neutral-500">Belum ada review</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Pagination -->
<div class="mt-6">
    {{ $reviews->links() }}
</div>
@endsection
