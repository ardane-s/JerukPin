@extends('admin.layouts.app')

@section('title', 'Review')
@section('page-title', 'Review Produk')
@section('page-description', 'Kelola review pelanggan JerukPin')

@section('content')
<!-- Filter Tabs -->
<div class="bg-white rounded-xl shadow-sm mb-6 border border-neutral-200 overflow-hidden">
    <div class="flex border-b border-neutral-200">
        <a href="{{ route('admin.reviews.index') }}" 
           class="px-6 py-3.5 text-sm font-semibold transition {{ !request('status') ? 'border-b-2 border-orange-600 text-orange-600 bg-orange-50/50' : 'text-neutral-600 hover:text-orange-600 hover:bg-neutral-50' }}">
            Semua Review
            <span class="ml-2 bg-neutral-100 text-neutral-700 py-0.5 px-2.5 rounded-full text-xs font-semibold">{{ $reviews->total() }}</span>
        </a>
        <a href="{{ route('admin.reviews.index', ['status' => 'pending']) }}" 
           class="px-6 py-3.5 text-sm font-semibold transition {{ request('status') === 'pending' ? 'border-b-2 border-orange-600 text-orange-600 bg-orange-50/50' : 'text-neutral-600 hover:text-orange-600 hover:bg-neutral-50' }}">
            Pending
            @if($pendingCount > 0)
                <span class="ml-2 bg-orange-600 text-white py-0.5 px-2.5 rounded-full text-xs font-semibold">{{ $pendingCount }}</span>
            @else
                <span class="ml-2 bg-neutral-100 text-neutral-700 py-0.5 px-2.5 rounded-full text-xs font-semibold">0</span>
            @endif
        </a>
        <a href="{{ route('admin.reviews.index', ['status' => 'approved']) }}" 
           class="px-6 py-3.5 text-sm font-semibold transition {{ request('status') === 'approved' ? 'border-b-2 border-orange-600 text-orange-600 bg-orange-50/50' : 'text-neutral-600 hover:text-orange-600 hover:bg-neutral-50' }}">
            Approved
        </a>
    </div>
</div>

<!-- Reviews Table -->
<div class="bg-white rounded-xl shadow-sm overflow-hidden border border-neutral-200">
    <table class="min-w-full">
        <thead class="bg-neutral-50">
            <tr>
                <th class="px-6 py-3.5 text-left text-xs font-semibold text-neutral-700 uppercase tracking-wider">Produk</th>
                <th class="px-6 py-3.5 text-left text-xs font-semibold text-neutral-700 uppercase tracking-wider">Pelanggan</th>
                <th class="px-6 py-3.5 text-left text-xs font-semibold text-neutral-700 uppercase tracking-wider">Rating</th>
                <th class="px-6 py-3.5 text-left text-xs font-semibold text-neutral-700 uppercase tracking-wider">Review</th>
                <th class="px-6 py-3.5 text-left text-xs font-semibold text-neutral-700 uppercase tracking-wider">Status</th>
                <th class="px-6 py-3.5 text-left text-xs font-semibold text-neutral-700 uppercase tracking-wider">Tanggal</th>
                <th class="px-6 py-3.5 text-right text-xs font-semibold text-neutral-700 uppercase tracking-wider">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($reviews as $review)
            <tr class="border-b border-neutral-100 hover:bg-neutral-50">
                <td class="px-6 py-4">
                    <div class="flex items-center gap-3">
                        @if($review->product && $review->product->images->count() > 0)
                            <img src="{{ asset('storage/' . $review->product->images->first()->image_path) }}" 
                                 alt="{{ $review->product->name }}" 
                                 class="w-12 h-12 rounded object-cover">
                        @else
                            <div class="w-12 h-12 rounded bg-neutral-100 flex items-center justify-center">
                                <span class="text-neutral-400 text-xs">No img</span>
                            </div>
                        @endif
                        <div>
                            <p class="font-medium text-neutral-900">{{ $review->product->name ?? 'Produk dihapus' }}</p>
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4">
                    <div>
                        <p class="font-medium text-neutral-900">{{ $review->user->name }}</p>
                        <p class="text-sm text-neutral-500">{{ $review->user->email }}</p>
                    </div>
                </td>
                <td class="px-6 py-4">
                    <div class="flex items-center gap-2">
                        <div class="flex gap-0.5">
                            @for($i = 1; $i <= 5; $i++)
                                <svg class="w-4 h-4 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-neutral-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            @endfor
                        </div>
                        <span class="text-sm font-semibold text-neutral-700">({{ $review->rating }}/5)</span>
                    </div>
                </td>
                <td class="px-6 py-4">
                    <div class="text-sm text-neutral-700 max-w-xs">
                        <p class="line-clamp-2">{{ $review->comment ?? 'Tidak ada komentar' }}</p>
                    </div>
                </td>
                <td class="px-6 py-4">
                    @if($review->is_approved)
                        <span class="inline-flex items-center px-2.5 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            Approved
                        </span>
                    @else
                        <span class="inline-flex items-center px-2.5 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                            </svg>
                            Pending
                        </span>
                    @endif
                </td>
                <td class="px-6 py-4 text-sm text-neutral-600">
                    <div>{{ $review->created_at->format('d M Y') }}</div>
                    <div class="text-xs text-neutral-500">{{ $review->created_at->format('H:i') }}</div>
                </td>
                <td class="px-6 py-4 text-right">
                    <div class="flex justify-end gap-3">
                        @if(!$review->is_approved)
                            <form action="{{ route('admin.reviews.approve', $review) }}" method="POST">
                                @csrf
                                <button type="submit" class="text-green-600 hover:text-green-700 text-sm font-medium">
                                    Approve
                                </button>
                            </form>
                        @endif
                        <form action="{{ route('admin.reviews.destroy', $review) }}" method="POST" 
                              onsubmit="return confirm('Yakin ingin menghapus review ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-700 text-sm font-medium">
                                Hapus
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="px-6 py-12 text-center">
                    <svg class="mx-auto h-12 w-12 text-neutral-400" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                    <p class="mt-2 text-sm text-neutral-500">Belum ada review</p>
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
