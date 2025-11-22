@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
<div class="min-h-screen bg-neutral-50 py-12">
    <div class="max-w-4xl mx-auto px-4">
        <!-- Header -->
        <div class="bg-gradient-to-r from-orange-500 to-orange-600 rounded-2xl p-8 mb-8 text-white shadow-xl">
            <div class="flex items-center gap-6">
                <div class="w-24 h-24 bg-white rounded-full flex items-center justify-center text-orange-600 font-bold text-4xl shadow-lg">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div class="flex-1">
                    <h1 class="text-3xl font-bold mb-2">{{ auth()->user()->name }}</h1>
                    <p class="opacity-90">{{ auth()->user()->email }}</p>
                    <p class="text-sm opacity-80 mt-1">Bergabung sejak {{ auth()->user()->created_at->format('F Y') }}</p>
                </div>
                <a href="{{ route('profile.edit') }}" class="bg-white text-orange-600 px-6 py-3 rounded-lg font-semibold hover:shadow-lg transition">
                    Edit Profil
                </a>
            </div>
        </div>

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
                        <span class="text-2xl">✅</span>
                    </div>
                    <div>
                        <p class="text-sm text-neutral-600">Selesai</p>
                        <p class="text-2xl font-bold text-neutral-900">{{ auth()->user()->orders()->where('status', 'delivered')->count() }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-xl p-6 shadow-md">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                        <span class="text-2xl">⭐</span>
                    </div>
                    <div>
                        <p class="text-sm text-neutral-600">Review Diberikan</p>
                        <p class="text-2xl font-bold text-neutral-900">{{ auth()->user()->reviews()->count() }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
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
