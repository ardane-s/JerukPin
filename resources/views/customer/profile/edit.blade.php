@extends('layouts.app')

@section('title', 'Edit Profil')

@section('content')
<div class="min-h-screen bg-neutral-50 py-12">
    <div class="max-w-2xl mx-auto px-4">
        <div class="bg-white rounded-2xl shadow-lg p-8">
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-neutral-900">Edit Profil</h1>
                <p class="text-neutral-600 mt-2">Perbarui informasi pribadi Anda</p>
            </div>

            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Profile Avatar - Display Only -->
                <div class="flex flex-col items-center mb-6">
                    <div class="w-32 h-32 rounded-full bg-gradient-to-br from-orange-500 to-green-500 flex items-center justify-center text-white text-4xl font-bold shadow-lg border-4 border-orange-200">
                        {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                    </div>
                    <p class="mt-3 text-sm text-neutral-500">Avatar Anda</p>
                </div>

                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-semibold text-neutral-700 mb-2">Nama Lengkap</label>
                    <input type="text" name="name" id="name" value="{{ old('name', auth()->user()->name) }}" required
                        class="w-full px-4 py-3 border-2 border-neutral-200 rounded-xl focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-semibold text-neutral-700 mb-2">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email', auth()->user()->email) }}" required
                        class="w-full px-4 py-3 border-2 border-neutral-200 rounded-xl focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition">
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Phone -->
                <div>
                    <label for="phone" class="block text-sm font-semibold text-neutral-700 mb-2">Nomor Telepon</label>
                    <input type="tel" name="phone" id="phone" value="{{ old('phone', auth()->user()->phone) }}"
                        class="w-full px-4 py-3 border-2 border-neutral-200 rounded-xl focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition"
                        placeholder="08123456789">
                    @error('phone')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Buttons -->
                <div class="flex gap-4 pt-4">
                    <button type="submit" class="flex-1 bg-gradient-to-r from-orange-500 to-orange-600 text-white py-3 rounded-xl font-bold shadow-lg hover:shadow-xl transform hover:scale-[1.02] transition">
                        Simpan Perubahan
                    </button>
                    <a href="{{ route('profile.index') }}" class="px-6 py-3 border-2 border-neutral-300 text-neutral-700 rounded-xl font-semibold hover:bg-neutral-50 transition">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
