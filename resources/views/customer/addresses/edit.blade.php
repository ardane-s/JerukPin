@extends('layouts.app')

@section('title', 'Edit Alamat')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6">Edit Alamat</h1>
    
    <form action="{{ route('addresses.update', $address) }}" method="POST" class="bg-white rounded-lg shadow-sm p-6">
        @csrf
        @method('PUT')
        
        <div class="space-y-4">
            <!-- Label -->
            <div>
                <label class="block text-sm font-semibold mb-2">Label Alamat</label>
                <input type="text" name="label" value="{{ old('label', $address->label) }}" 
                       class="w-full px-4 py-2 border border-neutral-300 rounded-lg focus:border-orange-600 focus:ring-2 focus:ring-orange-100"
                       placeholder="Contoh: Rumah, Kantor, Kost" required>
                @error('label')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Recipient Name -->
            <div>
                <label class="block text-sm font-semibold mb-2">Nama Penerima</label>
                <input type="text" name="recipient_name" value="{{ old('recipient_name', $address->recipient_name) }}" 
                       class="w-full px-4 py-2 border border-neutral-300 rounded-lg focus:border-orange-600 focus:ring-2 focus:ring-orange-100"
                       required>
                @error('recipient_name')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Phone -->
            <div>
                <label class="block text-sm font-semibold mb-2">Nomor Telepon</label>
                <input type="text" name="phone" value="{{ old('phone', $address->phone) }}" 
                       class="w-full px-4 py-2 border border-neutral-300 rounded-lg focus:border-orange-600 focus:ring-2 focus:ring-orange-100"
                       required>
                @error('phone')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Address -->
            <div>
                <label class="block text-sm font-semibold mb-2">Alamat Lengkap</label>
                <textarea name="address" rows="3" 
                          class="w-full px-4 py-2 border border-neutral-300 rounded-lg focus:border-orange-600 focus:ring-2 focus:ring-orange-100"
                          required>{{ old('address', $address->address) }}</textarea>
                @error('address')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- City -->
            <div>
                <label class="block text-sm font-semibold mb-2">Kota/Kabupaten</label>
                <input type="text" name="city" value="{{ old('city', $address->city) }}" 
                       class="w-full px-4 py-2 border border-neutral-300 rounded-lg focus:border-orange-600 focus:ring-2 focus:ring-orange-100"
                       required>
                @error('city')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Province -->
            <div>
                <label class="block text-sm font-semibold mb-2">Provinsi</label>
                <input type="text" name="province" value="{{ old('province', $address->province) }}" 
                       class="w-full px-4 py-2 border border-neutral-300 rounded-lg focus:border-orange-600 focus:ring-2 focus:ring-orange-100"
                       required>
                @error('province')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Postal Code -->
            <div>
                <label class="block text-sm font-semibold mb-2">Kode Pos</label>
                <input type="text" name="postal_code" value="{{ old('postal_code', $address->postal_code) }}" 
                       class="w-full px-4 py-2 border border-neutral-300 rounded-lg focus:border-orange-600 focus:ring-2 focus:ring-orange-100"
                       required>
                @error('postal_code')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Is Default -->
            <div class="flex items-center gap-3 p-4 bg-neutral-50 rounded-lg">
                <input type="checkbox" name="is_default" id="is_default" value="1" 
                       {{ old('is_default', $address->is_default) ? 'checked' : '' }}
                       class="w-5 h-5 text-orange-600 border-neutral-300 rounded focus:ring-2 focus:ring-orange-100">
                <label for="is_default" class="text-sm font-semibold cursor-pointer">
                    Jadikan alamat utama
                </label>
            </div>
        </div>

        <!-- Actions -->
        <div class="flex gap-3 mt-6 pt-6 border-t">
            <button type="submit" class="bg-orange-600 hover:bg-orange-700 text-white px-6 py-2.5 rounded-lg font-semibold transition">
                Update Alamat
            </button>
            <a href="{{ route('addresses.index') }}" class="bg-neutral-100 hover:bg-neutral-200 text-neutral-700 px-6 py-2.5 rounded-lg font-semibold transition">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection
