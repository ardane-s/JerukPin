@extends('layouts.app')

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-xl p-6 shadow-md">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                        <span class="text-2xl">📦</span>
                    </div>
                    <div>
                        <p class="text-sm text-neutral-600">Total Pesanan</p>
                        <p class="text-2xl font-bold text-neutral-900">{{ auth()->user()->orders()->count() }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-xl p-6 shadow-md">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
            <a href="{{ route('orders.index') }}" class="bg-white rounded-xl p-6 shadow-md hover:shadow-xl transition group">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center group-hover:scale-110 transition">
                            <span class="text-2xl">📋</span>
                        </div>
                        <div>
                            <h3 class="font-bold text-neutral-900 text-lg">Pesanan Saya</h3>
                            <p class="text-sm text-neutral-600">Lihat riwayat pesanan</p>
                        </div>
                    </div>
                    <svg class="w-6 h-6 text-neutral-400 group-hover:text-orange-600 group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </div>
            </a>

            <a href="{{ route('wishlist.index') }}" class="bg-white rounded-xl p-6 shadow-md hover:shadow-xl transition group">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-pink-100 rounded-lg flex items-center justify-center group-hover:scale-110 transition">
                            <span class="text-2xl">❤️</span>
                        </div>
                        <div>
                            <h3 class="font-bold text-neutral-900 text-lg">Wishlist</h3>
                            <p class="text-sm text-neutral-600">Produk favorit</p>
                        </div>
                    </div>
                    <svg class="w-6 h-6 text-neutral-400 group-hover:text-pink-600 group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </div>
            </a>

            <a href="{{ route('addresses.index') }}" class="bg-white rounded-xl p-6 shadow-md hover:shadow-xl transition group">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center group-hover:scale-110 transition">
                            <span class="text-2xl">🏠</span>
                        </div>
                        <div>
                            <h3 class="font-bold text-neutral-900 text-lg">Alamat</h3>
                            <p class="text-sm text-neutral-600">Kelola alamat pengiriman</p>
                        </div>
                    </div>
                    <svg class="w-6 h-6 text-neutral-400 group-hover:text-blue-600 group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </div>
            </a>

            <a href="{{ route('settings.index') }}" class="bg-white rounded-xl p-6 shadow-md hover:shadow-xl transition group">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center group-hover:scale-110 transition">
                            <span class="text-2xl">⚙️</span>
                        </div>
                        <div>
                            <h3 class="font-bold text-neutral-900 text-lg">Pengaturan</h3>
                            <p class="text-sm text-neutral-600">Keamanan & preferensi</p>
                        </div>
                    </div>
                    <svg class="w-6 h-6 text-neutral-400 group-hover:text-purple-600 group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </div>
            </a>
        </div>
    </div>
</div>
@endsection
