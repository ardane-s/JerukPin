@extends('layouts.app')

@section('title', 'Tambah Alamat')

@section('content')
<div class="min-h-screen bg-neutral-50 py-12">
    <div class="max-w-2xl mx-auto px-4">
        <div class="bg-white rounded-2xl shadow-lg p-8">
            <h1 class="text-2xl font-bold text-neutral-900 mb-6">Tambah Alamat Baru</h1>

            <form action="{{ route('addresses.store') }}" method="POST" class="space-y-5">
                @csrf

                <div>
                    <label for="label" class="block text-sm font-semibold text-neutral-700 mb-2">Label Alamat</label>
                    <input type="text" name="label" id="label" value="{{ old('label') }}" required
                        class="w-full px-4 py-3 border-2 border-neutral-200 rounded-xl focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition"
                        placeholder="Rumah, Kantor, dll">
                    @error('label')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="recipient_name" class="block text-sm font-semibold text-neutral-700 mb-2">Nama Penerima</label>
                    <input type="text" name="recipient_name" id="recipient_name" value="{{ old('recipient_name') }}" required
                        class="w-full px-4 py-3 border-2 border-neutral-200 rounded-xl focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition">
                    @error('recipient_name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="phone" class="block text-sm font-semibold text-neutral-700 mb-2">Nomor Telepon</label>
                    <input type="tel" name="phone" id="phone" value="{{ old('phone') }}" required
                        class="w-full px-4 py-3 border-2 border-neutral-200 rounded-xl focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition"
                        placeholder="08123456789">
                    @error('phone')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="address" class="block text-sm font-semibold text-neutral-700 mb-2">Alamat Lengkap</label>
                    <textarea name="address" id="address" rows="3" required
                        class="w-full px-4 py-3 border-2 border-neutral-200 rounded-xl focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition"
                        placeholder="Jalan, RT/RW, Kelurahan">{{ old('address') }}</textarea>
                    @error('address')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="city" class="block text-sm font-semibold text-neutral-700 mb-2">Kota/Kabupaten</label>
                        <input type="text" name="city" id="city" value="{{ old('city') }}" required
                            class="w-full px-4 py-3 border-2 border-neutral-200 rounded-xl focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition">
                        @error('city')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="province" class="block text-sm font-semibold text-neutral-700 mb-2">Provinsi</label>
                        <input type="text" name="province" id="province" value="{{ old('province') }}" required
                            class="w-full px-4 py-3 border-2 border-neutral-200 rounded-xl focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition">
                        @error('province')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="postal_code" class="block text-sm font-semibold text-neutral-700 mb-2">Kode Pos</label>
                    <input type="text" name="postal_code" id="postal_code" value="{{ old('postal_code') }}" required
                        class="w-full px-4 py-3 border-2 border-neutral-200 rounded-xl focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition"
                        placeholder="12345">
                    @error('postal_code')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center gap-3">
                    <input type="checkbox" name="is_default" id="is_default" value="1" {{ old('is_default') ? 'checked' : '' }}
                        class="w-5 h-5 text-orange-600 border-neutral-300 rounded focus:ring-orange-500">
                    <label for="is_default" class="text-sm font-medium text-neutral-700">Jadikan alamat utama</label>
                </div>

                <div class="flex gap-4 pt-4">
                    <button type="submit" class="flex-1 bg-gradient-to-r from-orange-500 to-orange-600 text-white py-3 rounded-xl font-bold shadow-lg hover:shadow-xl transition">
                        Simpan Alamat
                    </button>
                    <a href="{{ route('addresses.index') }}" class="px-6 py-3 border-2 border-neutral-300 text-neutral-700 rounded-xl font-semibold hover:bg-neutral-50 transition">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
