@extends('admin.layouts.app')

@section('title', 'Metode Pembayaran')

@section('content')
<div class="max-w-6xl">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-heading font-bold text-neutral-900">Metode Pembayaran</h1>
        <a href="{{ route('admin.payment-methods.create') }}" class="bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white px-6 py-3 rounded-lg font-bold shadow-md hover:shadow-lg transition">
            + Tambah Metode Pembayaran
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6 rounded-r-lg">
            <p class="text-green-800 font-medium">{{ session('success') }}</p>
        </div>
    @endif

    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        @if($paymentMethods->count() > 0)
            <table class="min-w-full divide-y divide-neutral-200">
                <thead class="bg-neutral-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">Bank</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">No. Rekening</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">Atas Nama</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-neutral-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-neutral-200">
                    @foreach($paymentMethods as $method)
                        <tr class="hover:bg-neutral-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-bold text-neutral-900">{{ $method->bank_name }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-neutral-600">{{ $method->account_number }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-neutral-600">{{ $method->account_holder }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <form action="{{ route('admin.payment-methods.toggle', $method) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold {{ $method->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $method->is_active ? '✓ Aktif' : '✗ Nonaktif' }}
                                    </button>
                                </form>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('admin.payment-methods.edit', $method) }}" class="text-orange-600 hover:text-orange-900 mr-3">Edit</a>
                                <form action="{{ route('admin.payment-methods.destroy', $method) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus metode pembayaran ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="text-center py-12">
                <p class="text-neutral-500">Belum ada metode pembayaran</p>
                <a href="{{ route('admin.payment-methods.create') }}" class="mt-4 inline-block text-orange-600 hover:text-orange-800 font-medium">+ Tambah Metode Pembayaran</a>
            </div>
        @endif
    </div>
</div>
@endsection
