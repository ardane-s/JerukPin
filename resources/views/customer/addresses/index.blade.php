@extends('layouts.app')

@section('title', 'Alamat Saya')

@section('content')
<div class="min-h-screen bg-neutral-50 py-12">
    <div class="max-w-4xl mx-auto px-4">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold text-neutral-900">🏠 Alamat Pengiriman</h1>
                <p class="text-neutral-600 mt-2">Kelola alamat untuk pengiriman pesanan</p>
            </div>
            <a href="{{ route('addresses.create') }}" class="bg-gradient-to-r from-orange-500 to-orange-600 text-white px-6 py-3 rounded-xl font-semibold shadow-lg hover:shadow-xl transition">
                + Tambah Alamat
            </a>
        </div>

        @if($addresses->count() > 0)
            <div class="space-y-4">
                @foreach($addresses as $address)
                    <div class="bg-white rounded-xl shadow-md p-6 {{ $address->is_default ? 'border-2 border-orange-500' : '' }}">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <div class="flex items-center gap-3 mb-3">
                                    <h3 class="font-bold text-lg text-neutral-900">{{ $address->label }}</h3>
                                    @if($address->is_default)
                                        <span class="px-3 py-1 bg-orange-100 text-orange-700 text-xs font-semibold rounded-full">Utama</span>
                                    @endif
                                </div>
                                <p class="font-semibold text-neutral-800">{{ $address->recipient_name }}</p>
                                <p class="text-neutral-600">{{ $address->phone }}</p>
                                <p class="text-neutral-600 mt-2">{{ $address->address }}</p>
                                <p class="text-neutral-600">{{ $address->city }}, {{ $address->province }} {{ $address->postal_code }}</p>
                            </div>
                            <div class="flex gap-2">
                                <a href="{{ route('addresses.edit', $address) }}" class="px-4 py-2 border-2 border-orange-500 text-orange-600 rounded-lg font-semibold hover:bg-orange-50 transition">
                                    Edit
                                </a>
                                @if(!$address->is_default)
                                    <form action="{{ route('addresses.destroy', $address) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus alamat ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-4 py-2 border-2 border-red-500 text-red-600 rounded-lg font-semibold hover:bg-red-50 transition">
                                            Hapus
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="bg-white rounded-2xl shadow-lg p-12 text-center">
                <div class="text-6xl mb-4">📍</div>
                <h2 class="text-2xl font-bold text-neutral-900 mb-2">Belum Ada Alamat</h2>
                <p class="text-neutral-600 mb-6">Tambahkan alamat untuk memudahkan checkout</p>
                <a href="{{ route('addresses.create') }}" class="inline-block bg-gradient-to-r from-orange-500 to-orange-600 text-white px-8 py-3 rounded-xl font-bold shadow-lg hover:shadow-xl transition">
                    + Tambah Alamat
                </a>
            </div>
        @endif

        <div class="mt-6 text-center">
            <a href="{{ route('profile.index') }}" class="text-orange-600 hover:text-orange-700 font-semibold">
                ← Kembali ke Profil
            </a>
        </div>
    </div>
</div>
@endsection
