@extends('admin.layouts.app')

@section('title', 'Pengaturan Ongkir')

@section('content')
<div class="max-w-2xl">
    <h1 class="text-3xl font-heading font-bold text-neutral-900 mb-6">Pengaturan Ongkos Kirim</h1>

    @if(session('success'))
        <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6 rounded-r-lg">
            <p class="text-green-800 font-medium">{{ session('success') }}</p>
        </div>
    @endif

    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
        <form action="{{ route('admin.settings.shipping.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-6">
                <label class="block text-sm font-bold text-neutral-700 mb-2">Biaya Ongkir Dasar (Rp) *</label>
                <input type="number" name="shipping_cost" value="{{ old('shipping_cost', $shippingCost) }}" required min="0"
                    class="w-full px-4 py-3 border-2 border-neutral-200 rounded-lg focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition">
                <p class="text-sm text-neutral-500 mt-1">Biaya ongkir yang dikenakan jika pesanan di bawah batas gratis ongkir</p>
                @error('shipping_cost')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="block text-sm font-bold text-neutral-700 mb-2">Batas Gratis Ongkir (Rp) *</label>
                <input type="number" name="free_shipping_threshold" value="{{ old('free_shipping_threshold', $freeShippingThreshold) }}" required min="0"
                    class="w-full px-4 py-3 border-2 border-neutral-200 rounded-lg focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition">
                <p class="text-sm text-neutral-500 mt-1">Minimal belanja untuk mendapat gratis ongkir</p>
                @error('free_shipping_threshold')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="w-full bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white py-3 rounded-lg font-bold shadow-md hover:shadow-lg transition">
                Simpan Pengaturan
            </button>
        </form>
    </div>

    <!-- Info Card -->
    <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-r-lg">
        <h3 class="font-bold text-blue-900 mb-2">ℹ️ Cara Kerja Ongkir</h3>
        <ul class="text-sm text-blue-800 space-y-1">
            <li>• Jika total belanja <strong>>= Rp {{ number_format($freeShippingThreshold, 0, ',', '.') }}</strong> → <span class="font-bold text-green-600">Gratis Ongkir!</span></li>
            <li>• Jika total belanja <strong>< Rp {{ number_format($freeShippingThreshold, 0, ',', '.') }}</strong> → Ongkir <span class="font-bold">Rp {{ number_format($shippingCost, 0, ',', '.') }}</span></li>
        </ul>
    </div>
</div>
@endsection
