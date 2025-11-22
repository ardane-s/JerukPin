@extends('layouts.app')

@section('title', 'Pengaturan Akun')

@section('content')
<div class="min-h-screen bg-neutral-50 py-12">
    <div class="max-w-2xl mx-auto px-4">
        <div class="bg-white rounded-2xl shadow-lg p-8">
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-neutral-900">⚙️ Pengaturan Akun</h1>
                <p class="text-neutral-600 mt-2">Kelola keamanan dan preferensi akun Anda</p>
            </div>

            <!-- Change Password -->
            <div class="mb-8 pb-8 border-b border-neutral-200">
                <h2 class="text-xl font-bold text-neutral-900 mb-4">Ubah Password</h2>
                <form action="{{ route('password.update') }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="current_password" class="block text-sm font-semibold text-neutral-700 mb-2">Password Saat Ini</label>
                        <input type="password" name="current_password" id="current_password" required
                            class="w-full px-4 py-3 border-2 border-neutral-200 rounded-xl focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition">
                        @error('current_password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-semibold text-neutral-700 mb-2">Password Baru</label>
                        <input type="password" name="password" id="password" required
                            class="w-full px-4 py-3 border-2 border-neutral-200 rounded-xl focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition">
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-semibold text-neutral-700 mb-2">Konfirmasi Password Baru</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" required
                            class="w-full px-4 py-3 border-2 border-neutral-200 rounded-xl focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition">
                    </div>

                    <button type="submit" class="bg-gradient-to-r from-orange-500 to-orange-600 text-white px-6 py-3 rounded-xl font-semibold shadow-md hover:shadow-lg transition">
                        Update Password
                    </button>
                </form>
            </div>

            <!-- Account Actions -->
            <div>
                <h2 class="text-xl font-bold text-neutral-900 mb-4">Aksi Akun</h2>
                <div class="space-y-3">
                    <button onclick="confirm('Yakin ingin logout?') && document.getElementById('logout-form').submit()" 
                        class="w-full flex items-center justify-between px-4 py-3 border-2 border-neutral-200 rounded-xl hover:border-orange-500 transition group">
                        <span class="font-semibold text-neutral-700 group-hover:text-orange-600">Logout</span>
                        <span>👋</span>
                    </button>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                        @csrf
                    </form>
                </div>
            </div>
        </div>

        <div class="mt-6 text-center">
            <a href="{{ route('profile.index') }}" class="text-orange-600 hover:text-orange-700 font-semibold">
                ← Kembali ke Profil
            </a>
        </div>
    </div>
</div>
@endsection
