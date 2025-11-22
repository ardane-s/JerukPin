@extends('admin.layouts.app')

@section('title', 'Detail Pesanan')

@section('content')
<div class="max-w-4xl">
    <div class="mb-6">
        <a href="{{ route('admin.orders.index') }}" class="text-primary-600 hover:text-primary-800">← Kembali</a>
    </div>

    <h1 class="text-3xl font-heading font-bold text-neutral-900 mb-6">Detail Pesanan</h1>

    <!-- Order Info -->
    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <p class="text-sm text-neutral-500">Nomor Pesanan</p>
                <p class="font-bold text-lg">{{ $order->order_number }}</p>
            </div>
            <div class="text-right">
                <p class="text-sm text-neutral-500">Tanggal</p>
                <p class="font-medium">{{ $order->created_at->format('d M Y H:i') }}</p>
            </div>
        </div>

        <!-- Status Update -->
        <form action="{{ route('admin.orders.status', $order) }}" method="POST" class="mb-4">
            @csrf
            @method('PUT')
            <div class="flex gap-2">
                <select name="status" class="flex-1 px-4 py-2 border border-neutral-300 rounded-lg">
                    <option value="pending_payment" {{ $order->status == 'pending_payment' ? 'selected' : '' }}>Menunggu Pembayaran</option>
                    <option value="payment_uploaded" {{ $order->status == 'payment_uploaded' ? 'selected' : '' }}>Pembayaran Diupload</option>
                    <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Diproses</option>
                    <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Dikirim</option>
                    <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Selesai</option>
                    <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                </select>
                <button type="submit" class="px-6 py-2 bg-gradient-to-r from-orange-500 to-orange-600 text-white rounded-lg hover:from-orange-600 hover:to-orange-700 font-bold">Update Status</button>
            </div>
        </form>
    </div>

    <!-- Payment Proof -->
    @if($order->payment && $order->payment->paymentProof)
        <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
            <h2 class="text-xl font-bold mb-4">Bukti Pembayaran</h2>
            
            <div class="grid grid-cols-2 gap-6">
                <div>
                    <img src="{{ asset('storage/' . $order->payment->paymentProof->proof_image_path) }}" 
                         alt="Bukti Pembayaran" 
                         class="w-full rounded-lg border">
                </div>
                <div>
                    <div class="space-y-2 mb-4">
                        <div>
                            <p class="text-sm text-neutral-500">Tanggal Transfer</p>
                            <p class="font-medium">{{ $order->payment->paymentProof->payment_date }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-neutral-500">Jumlah Transfer</p>
                            <p class="font-bold text-lg">Rp {{ number_format($order->payment->paymentProof->payment_amount, 0, ',', '.') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-neutral-500">Bank</p>
                            <p class="font-medium">{{ $order->payment->paymentProof->bank_name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-neutral-500">Atas Nama</p>
                            <p class="font-medium">{{ $order->payment->paymentProof->account_name }}</p>
                        </div>
                    </div>

                    @if($order->payment->status == 'pending')
                        <div class="space-y-2">
                            <form action="{{ route('admin.orders.verify', $order) }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full bg-green-500 hover:bg-green-600 text-white py-2 rounded-lg font-bold">
                                    ✓ Verifikasi Pembayaran
                                </button>
                            </form>
                            
                            <details class="border border-red-300 rounded-lg p-3">
                                <summary class="cursor-pointer text-red-600 font-medium">✗ Tolak Pembayaran</summary>
                                <form action="{{ route('admin.orders.reject', $order) }}" method="POST" class="mt-3">
                                    @csrf
                                    <textarea name="rejection_reason" rows="2" placeholder="Alasan penolakan..." required 
                                        class="w-full px-3 py-2 border rounded-lg mb-2"></textarea>
                                    <button type="submit" class="w-full bg-red-500 hover:bg-red-600 text-white py-2 rounded-lg">
                                        Tolak Pembayaran
                                    </button>
                                </form>
                            </details>
                        </div>
                    @elseif($order->payment->status == 'verified')
                        <div class="bg-green-50 border border-green-200 rounded-lg p-3">
                            <p class="text-green-800 font-bold">✓ Pembayaran Terverifikasi</p>
                            <p class="text-sm text-green-700">{{ $order->payment->paymentProof->verified_at->format('d M Y H:i') }}</p>
                        </div>
                    @elseif($order->payment->status == 'rejected')
                        <div class="bg-red-50 border border-red-200 rounded-lg p-3">
                            <p class="text-red-800 font-bold">✗ Pembayaran Ditolak</p>
                            <p class="text-sm text-red-700">{{ $order->payment->paymentProof->rejection_reason }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endif

    <!-- Order Items -->
    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
        <h2 class="text-xl font-bold mb-4">Produk</h2>
        @foreach($order->orderItems as $item)
            <div class="flex justify-between mb-3 pb-3 border-b last:border-b-0">
                <div>
                    <p class="font-bold">{{ $item->product_name }}</p>
                    <p class="text-sm text-neutral-500">{{ $item->variant_name }} × {{ $item->quantity }}</p>
                    @if($item->is_flash_sale)
                        <span class="text-xs bg-primary-100 text-primary-800 px-2 py-0.5 rounded">🔥 Flash Sale</span>
                    @endif
                </div>
                <div class="text-right">
                    <p class="font-bold">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</p>
                </div>
            </div>
        @endforeach
        
        <div class="border-t pt-3 space-y-1">
            <div class="flex justify-between text-sm">
                <span>Subtotal</span>
                <span>Rp {{ number_format($order->total_amount - $order->shipping_cost, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between text-sm">
                <span>Ongkir</span>
                <span>Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between text-lg font-bold">
                <span>Total</span>
                <span class="text-primary-600">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
            </div>
        </div>
    </div>

    <!-- Customer Info -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <h2 class="text-xl font-bold mb-4">Informasi Pelanggan</h2>
        @if($order->user_id)
            <p class="font-bold">{{ $order->user->name }}</p>
            <p class="text-neutral-600">{{ $order->user->email }}</p>
            <p class="text-neutral-600">{{ $order->user->phone }}</p>
            <p class="text-neutral-600 mt-2">{{ $order->address ? $order->address->full_address : $order->shipping_address }}</p>
        @else
            <p class="font-bold">{{ $order->guest_name }} <span class="text-xs bg-neutral-200 px-2 py-0.5 rounded">Guest</span></p>
            <p class="text-neutral-600">{{ $order->guest_email }}</p>
            <p class="text-neutral-600">{{ $order->guest_phone }}</p>
            <p class="text-neutral-600 mt-2">{{ $order->guest_address }}</p>
        @endif
    </div>
</div>
@endsection
