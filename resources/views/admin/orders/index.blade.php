@extends('admin.layouts.app')

@section('title', 'Pesanan')
@section('page-title', 'Pesanan')
@section('page-description', 'Kelola pesanan pelanggan JerukPin')

@section('content')
<!-- Filter -->
<div class="bg-white rounded-xl shadow-sm p-5 mb-6 border border-neutral-200">
    <form action="{{ route('admin.orders.index') }}" method="GET" class="flex gap-4 items-center">
        <label class="text-sm font-semibold text-neutral-700">Filter Status:</label>
        <select name="status" class="px-4 py-2 border border-neutral-300 rounded-lg focus:border-orange-600 focus:ring-2 focus:ring-orange-100 transition font-medium text-sm" onchange="this.form.submit()">
            <option value="">Semua Status</option>
            <option value="pending_payment" {{ request('status') == 'pending_payment' ? 'selected' : '' }}>Menunggu Pembayaran</option>
            <option value="payment_uploaded" {{ request('status') == 'payment_uploaded' ? 'selected' : '' }}>Pembayaran Diupload</option>
            <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Diproses</option>
            <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>Dikirim</option>
            <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>Selesai</option>
            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
        </select>
    </form>
</div>

<div class="bg-white rounded-xl shadow-sm overflow-hidden border border-neutral-200">
    <table class="min-w-full divide-y divide-neutral-200">
        <thead class="bg-neutral-50">
            <tr>
                <th class="px-6 py-3.5 text-left text-xs font-semibold text-neutral-700 uppercase tracking-wider">Nomor Pesanan</th>
                <th class="px-6 py-3.5 text-left text-xs font-semibold text-neutral-700 uppercase tracking-wider">Pelanggan</th>
                <th class="px-6 py-3.5 text-left text-xs font-semibold text-neutral-700 uppercase tracking-wider">Total</th>
                <th class="px-6 py-3.5 text-left text-xs font-semibold text-neutral-700 uppercase tracking-wider">Status</th>
                <th class="px-6 py-3.5 text-left text-xs font-semibold text-neutral-700 uppercase tracking-wider">Tanggal</th>
                <th class="px-6 py-3.5 text-right text-xs font-semibold text-neutral-700 uppercase tracking-wider">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-neutral-200">
            @forelse($orders as $order)
                <tr class="hover:bg-neutral-50 transition">
                    <td class="px-6 py-4">
                        <div class="font-semibold text-neutral-900 text-sm">{{ $order->order_number }}</div>
                        @if($order->payment && $order->payment->paymentProof)
                            <span class="inline-flex items-center gap-1 mt-1 text-xs text-blue-700 bg-blue-100 px-2 py-0.5 rounded-md font-medium">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8 4a3 3 0 00-3 3v4a5 5 0 0010 0V7a1 1 0 112 0v4a7 7 0 11-14 0V7a5 5 0 0110 0v4a3 3 0 11-6 0V7a1 1 0 012 0v4a1 1 0 102 0V7a3 3 0 00-3-3z" clip-rule="evenodd"/>
                                </svg>
                                Bukti tersedia
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        @if($order->user_id)
                            <div class="text-sm font-semibold text-neutral-900">{{ $order->user->name }}</div>
                            <div class="text-xs text-neutral-500 mt-0.5">{{ $order->user->email }}</div>
                        @else
                            <div class="text-sm font-semibold text-neutral-900">{{ $order->guest_name }}</div>
                            <div class="text-xs text-neutral-500 mt-0.5">{{ $order->guest_email }}</div>
                            <span class="inline-flex items-center gap-1 mt-1 text-xs bg-purple-100 text-purple-700 px-2 py-0.5 rounded-md font-medium">
                                Guest
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <span class="text-sm font-semibold text-neutral-900">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                    </td>
                    <td class="px-6 py-4">
                        @if($order->status == 'pending_payment')
                            <span class="inline-flex items-center px-2.5 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                Menunggu Pembayaran
                            </span>
                        @elseif($order->status == 'payment_uploaded')
                            <span class="inline-flex items-center px-2.5 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                Perlu Verifikasi
                            </span>
                        @elseif($order->status == 'processing')
                            <span class="inline-flex items-center px-2.5 py-1 text-xs font-semibold rounded-full bg-purple-100 text-purple-800">
                                Diproses
                            </span>
                        @elseif($order->status == 'shipped')
                            <span class="inline-flex items-center px-2.5 py-1 text-xs font-semibold rounded-full bg-indigo-100 text-indigo-800">
                                Dikirim
                            </span>
                        @elseif($order->status == 'delivered')
                            <span class="inline-flex items-center px-2.5 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                Selesai
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                Dibatalkan
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-sm text-neutral-600">
                        <div>{{ $order->created_at->format('d M Y') }}</div>
                        <div class="text-xs text-neutral-500">{{ $order->created_at->format('H:i') }}</div>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <a href="{{ route('admin.orders.show', $order) }}" class="text-orange-600 hover:text-orange-700 font-medium text-sm">
                            Detail
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center">
                        <svg class="mx-auto h-12 w-12 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                        <p class="mt-2 text-sm text-neutral-500">Belum ada pesanan</p>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-6">
    {{ $orders->links() }}
</div>
@endsection
