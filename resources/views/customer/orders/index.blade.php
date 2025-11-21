@extends('layouts.app')

@section('title', 'Pesanan Saya')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-heading font-bold text-neutral-900 mb-6">Pesanan Saya</h1>

    @forelse($orders as $order)
        <div class="bg-white rounded-lg shadow-sm p-6 mb-4">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <p class="text-sm text-neutral-500">{{ $order->created_at->format('d M Y H:i') }}</p>
                    <p class="font-bold">{{ $order->order_number }}</p>
                </div>
                <div>
                    @if($order->status == 'pending_payment')
                        <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-sm">Menunggu Pembayaran</span>
                    @elseif($order->status == 'payment_uploaded')
                        <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm">Pembayaran Diupload</span>
                    @elseif($order->status == 'processing')
                        <span class="px-3 py-1 bg-purple-100 text-purple-800 rounded-full text-sm">Diproses</span>
                    @elseif($order->status == 'shipped')
                        <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm">Dikirim</span>
                    @elseif($order->status == 'delivered')
                        <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm">Selesai</span>
                    @endif
                </div>
            </div>

            <div class="border-t pt-4">
                <p class="text-sm text-neutral-600 mb-2">{{ $order->orderItems->count() }} produk</p>
                <p class="text-lg font-bold text-primary-600 mb-4">Rp {{ number_format($order->total, 0, ',', '.') }}</p>
                <a href="{{ route('orders.show', $order->order_number) }}" class="text-primary-600 hover:text-primary-800 font-medium">
                    Lihat Detail →
                </a>
            </div>
        </div>
    @empty
        <div class="bg-white rounded-lg shadow-sm p-12 text-center">
            <div class="text-6xl mb-4">📦</div>
            <h2 class="text-2xl font-bold text-neutral-900 mb-2">Belum Ada Pesanan</h2>
            <p class="text-neutral-600 mb-6">Mulai belanja sekarang!</p>
            <a href="{{ route('products.index') }}" class="inline-block bg-primary-500 hover:bg-primary-600 text-white px-8 py-3 rounded-lg font-bold">
                Mulai Belanja
            </a>
        </div>
    @endforelse

    @if($orders->count() > 0)
        <div class="mt-6">
            {{ $orders->links() }}
        </div>
    @endif
</div>
@endsection
