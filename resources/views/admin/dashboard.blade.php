@extends('admin.layouts.app')

@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard')
@section('page-description', 'Ringkasan performa toko JerukPin')

@section('content')
<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Products Card -->
    <div class="bg-white rounded-xl shadow-sm border border-neutral-200 p-6 hover:shadow-md transition">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-neutral-600 mb-1">Total Produk</p>
                <p class="text-3xl font-bold text-neutral-900">{{ $stats['total_products'] }}</p>
                <a href="{{ route('admin.products.index') }}" class="text-xs text-orange-600 hover:text-orange-700 font-medium mt-2 inline-block">
                    Lihat semua →
                </a>
            </div>
            <div class="w-14 h-14 bg-blue-100 rounded-xl flex items-center justify-center">
                <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                </svg>
            </div>
        </div>
    </div>

    <!-- Categories Card -->
    <div class="bg-white rounded-xl shadow-sm border border-neutral-200 p-6 hover:shadow-md transition">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-neutral-600 mb-1">Total Kategori</p>
                <p class="text-3xl font-bold text-neutral-900">{{ $stats['total_categories'] }}</p>
                <a href="{{ route('admin.categories.index') }}" class="text-xs text-orange-600 hover:text-orange-700 font-medium mt-2 inline-block">
                    Lihat semua →
                </a>
            </div>
            <div class="w-14 h-14 bg-green-100 rounded-xl flex items-center justify-center">
                <svg class="w-7 h-7 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>
                </svg>
            </div>
        </div>
    </div>

    <!-- Flash Sales Card -->
    <div class="bg-white rounded-xl shadow-sm border border-neutral-200 p-6 hover:shadow-md transition">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-neutral-600 mb-1">Flash Sale Aktif</p>
                <p class="text-3xl font-bold text-neutral-900">{{ $stats['active_flash_sales'] }}</p>
                <a href="{{ route('admin.flash-sales.index') }}" class="text-xs text-orange-600 hover:text-orange-700 font-medium mt-2 inline-block">
                    Lihat semua →
                </a>
            </div>
            <div class="w-14 h-14 bg-orange-100 rounded-xl flex items-center justify-center">
                <svg class="w-7 h-7 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                </svg>
            </div>
        </div>
    </div>

    <!-- Orders Card -->
    <div class="bg-white rounded-xl shadow-sm border border-neutral-200 p-6 hover:shadow-md transition">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-neutral-600 mb-1">Total Pesanan</p>
                <p class="text-3xl font-bold text-neutral-900">{{ $stats['total_orders'] }}</p>
                <a href="{{ route('admin.orders.index') }}" class="text-xs text-orange-600 hover:text-orange-700 font-medium mt-2 inline-block">
                    Lihat semua →
                </a>
            </div>
            <div class="w-14 h-14 bg-purple-100 rounded-xl flex items-center justify-center">
                <svg class="w-7 h-7 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                </svg>
            </div>
        </div>
    </div>
</div>

<!-- Review & Customer Satisfaction -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <!-- Total Reviews -->
    <div class="bg-white rounded-xl shadow-sm border border-neutral-200 p-6">
        <div class="flex items-center justify-between mb-4">
            <div>
                <p class="text-sm font-medium text-neutral-600">Total Review</p>
                <p class="text-2xl font-bold text-neutral-900 mt-1">{{ $stats['total_reviews'] }}</p>
            </div>
            <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                </svg>
            </div>
        </div>
        <p class="text-xs text-neutral-500">Rating Rata-rata: <span class="font-bold text-neutral-700">{{ $stats['average_rating'] }}/5.0</span></p>
    </div>

    <!-- Pending Reviews -->
    <div class="bg-white rounded-xl shadow-sm border border-neutral-200 p-6">
        <div class="flex items-center justify-between mb-4">
            <div>
                <p class="text-sm font-medium text-neutral-600">Review Masuk</p>
                <p class="text-2xl font-bold text-neutral-900 mt-1">{{ $stats['pending_reviews'] }}</p>
            </div>
            <div class="w-12 h-12 bg-pink-100 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                </svg>
            </div>
        </div>
        <p class="text-xs text-neutral-500">Perlu ditanggapi</p>
    </div>

    <!-- Customer Satisfaction -->
    <div class="bg-white rounded-xl shadow-sm border border-neutral-200 p-6">
        <div class="flex items-center justify-between mb-4">
            <div>
                <p class="text-sm font-medium text-neutral-600">Kepuasan Pelanggan</p>
                <p class="text-2xl font-bold text-neutral-900 mt-1">{{ number_format(($stats['average_rating'] / 5) * 100, 0) }}%</p>
            </div>
            <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                </svg>
            </div>
        </div>
        <div class="flex gap-0.5">
            @for($i = 1; $i <= 5; $i++)
                @if($i <= floor($stats['average_rating']))
                    <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                @else
                    <svg class="w-4 h-4 text-neutral-300" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                @endif
            @endfor
        </div>
    </div>
</div>

<!-- Order Status Breakdown -->
<div class="bg-white rounded-xl shadow-sm border border-neutral-200 p-6 mb-8">
    <h2 class="text-lg font-bold text-neutral-900 mb-6">Status Pesanan</h2>
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
        <!-- Pending Payment -->
        <div class="text-center p-4 bg-yellow-50 rounded-xl border-2 border-yellow-200">
            <p class="text-3xl font-bold text-yellow-600">{{ $stats['pending_payment'] }}</p>
            <p class="text-xs text-yellow-700 mt-2 font-medium">Menunggu Pembayaran</p>
        </div>

        <!-- Payment Uploaded -->
        <div class="text-center p-4 bg-blue-50 rounded-xl border-2 border-blue-200">
            <p class="text-3xl font-bold text-blue-600">{{ $stats['payment_uploaded'] }}</p>
            <p class="text-xs text-blue-700 mt-2 font-medium">Perlu Verifikasi</p>
        </div>

        <!-- Processing -->
        <div class="text-center p-4 bg-purple-50 rounded-xl border-2 border-purple-200">
            <p class="text-3xl font-bold text-purple-600">{{ $stats['processing'] }}</p>
            <p class="text-xs text-purple-700 mt-2 font-medium">Diproses</p>
        </div>

        <!-- Shipped -->
        <div class="text-center p-4 bg-indigo-50 rounded-xl border-2 border-indigo-200">
            <p class="text-3xl font-bold text-indigo-600">{{ $stats['shipped'] }}</p>
            <p class="text-xs text-indigo-700 mt-2 font-medium">Dikirim</p>
        </div>

        <!-- Delivered -->
        <div class="text-center p-4 bg-green-50 rounded-xl border-2 border-green-200">
            <p class="text-3xl font-bold text-green-600">{{ $stats['delivered'] }}</p>
            <p class="text-xs text-green-700 mt-2 font-medium">Selesai</p>
        </div>

        <!-- Cancelled -->
        <div class="text-center p-4 bg-red-50 rounded-xl border-2 border-red-200">
            <p class="text-3xl font-bold text-red-600">{{ $stats['cancelled'] }}</p>
            <p class="text-xs text-red-700 mt-2 font-medium">Dibatalkan</p>
        </div>
    </div>
</div>

<!-- Top Rated Products & Recent Reviews -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Top Rated Products -->
    <div class="bg-white rounded-xl shadow-sm border border-neutral-200 p-6">
        <h2 class="text-lg font-bold text-neutral-900 mb-6">Produk Rating Tertinggi</h2>
        <div class="space-y-4">
            @forelse($topRatedProducts as $product)
                <div class="flex items-center justify-between p-4 bg-neutral-50 rounded-xl hover:bg-neutral-100 transition">
                    <div class="flex-1">
                        <p class="font-bold text-neutral-900 text-sm">{{ $product->name }}</p>
                        <div class="flex items-center gap-2 mt-2">
                            <div class="flex gap-0.5">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= floor($product->reviews_avg_rating))
                                        <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                    @else
                                        <svg class="w-4 h-4 text-neutral-300" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                    @endif
                                @endfor
                            </div>
                            <span class="text-sm font-bold text-neutral-600">{{ number_format($product->reviews_avg_rating, 1) }}</span>
                            <span class="text-xs text-neutral-500">({{ $product->reviews_count }} review)</span>
                        </div>
                    </div>
                    <a href="{{ route('admin.products.edit', $product) }}" class="text-orange-600 hover:text-orange-700 text-sm font-medium ml-4">
                        Lihat →
                    </a>
                </div>
            @empty
                <div class="text-center py-8">
                    <p class="text-neutral-500 text-sm">Belum ada review produk</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Recent Reviews -->
    <div class="bg-white rounded-xl shadow-sm border border-neutral-200 p-6">
        <h2 class="text-lg font-bold text-neutral-900 mb-6">Review Terbaru</h2>
        <div class="space-y-4 max-h-96 overflow-y-auto">
            @forelse($recentReviews as $review)
                <div class="p-4 bg-neutral-50 rounded-xl border border-neutral-200">
                    <div class="flex items-start justify-between mb-2">
                        <div>
                            <p class="font-bold text-neutral-900 text-sm">{{ $review->user->name }}</p>
                            <p class="text-xs text-neutral-500">{{ $review->product->name }}</p>
                        </div>
                        <div class="flex gap-0.5">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $review->rating)
                                    <svg class="w-3.5 h-3.5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                @else
                                    <svg class="w-3.5 h-3.5 text-neutral-300" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                @endif
                            @endfor
                        </div>
                    </div>
                    <p class="text-sm text-neutral-600">{{ $review->comment }}</p>
                    <p class="text-xs text-neutral-400 mt-2">{{ $review->created_at->diffForHumans() }}</p>
                </div>
            @empty
                <div class="text-center py-8">
                    <p class="text-neutral-500 text-sm">Belum ada review</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
