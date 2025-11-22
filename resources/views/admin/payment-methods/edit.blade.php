@extends('admin.layouts.app')

@section('title', 'Edit Metode Pembayaran')

@section('content')
<div class="max-w-2xl">
    <div class="mb-6">
        <a href="{{ route('admin.payment-methods.index') }}" class="text-orange-600 hover:text-orange-800">← Kembali</a>
    </div>

    <h1 class="text-3xl font-heading font-bold text-neutral-900 mb-6">Edit Metode Pembayaran</h1>

    <div class="bg-white rounded-lg shadow-sm p-6">
        <form action="{{ route('admin.payment-methods.update', $paymentMethod) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block text-sm font-bold text-neutral-700 mb-2">Nama Bank *</label>
                <input type="text" name="bank_name" value="{{ old('bank_name', $paymentMethod->bank_name) }}" required
                    class="w-full px-4 py-3 border-2 border-neutral-200 rounded-lg focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition">
                @error('bank_name')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-bold text-neutral-700 mb-2">No. Rekening *</label>
                <input type="text" name="account_number" value="{{ old('account_number', $paymentMethod->account_number) }}" required
                    class="w-full px-4 py-3 border-2 border-neutral-200 rounded-lg focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition">
                @error('account_number')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-bold text-neutral-700 mb-2">Atas Nama *</label>
                <input type="text" name="account_holder" value="{{ old('account_holder', $paymentMethod->account_holder) }}" required
                    class="w-full px-4 py-3 border-2 border-neutral-200 rounded-lg focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition">
                @error('account_holder')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="flex items-center">
                    <input type="checkbox" name="is_active" value="1" {{ $paymentMethod->is_active ? 'checked' : '' }} class="w-5 h-5 text-orange-600 rounded">
                    <span class="ml-2 text-sm font-medium text-neutral-700">Aktifkan metode pembayaran ini</span>
                </label>
            </div>

            <div class="flex gap-3">
                <a href="{{ route('admin.payment-methods.index') }}" class="px-6 py-3 border-2 border-neutral-300 rounded-lg text-neutral-700 hover:bg-neutral-50 font-bold transition">
                    Batal
                </a>
                <button type="submit" class="flex-1 bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white py-3 rounded-lg font-bold shadow-md hover:shadow-lg transition">
                    Update Metode Pembayaran
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
