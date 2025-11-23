@extends('admin.layouts.app')

@section('title', 'Detail Pesanan')

@section('content')
<div class="max-w-6xl mx-auto px-3 sm:px-4 lg:px-6">
    <!-- Back Button -->
    <div class="mb-4 sm:mb-6">
        <a href="{{ route('admin.orders.index') }}" class="inline-flex items-center gap-2 text-orange-600 hover:text-orange-700 font-medium transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Kembali ke Daftar Pesanan
        </a>
    </div>

    <!-- Page Header -->
    <div class="bg-white rounded-xl shadow-md border border-neutral-200 p-4 sm:p-6 mb-4 sm:mb-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-heading font-bold text-neutral-900 mb-2">Detail Pesanan</h1>
                <div class="flex flex-wrap items-center gap-3 text-sm sm:text-base">
                    <div class="flex items-center gap-2">
                        <span class="text-neutral-500">Nomor:</span>
                        <span class="font-bold text-orange-600">{{ $order->order_number }}</span>
                    </div>
                    <div class="hidden sm:block w-px h-4 bg-neutral-300"></div>
                    <div class="flex items-center gap-2">
                        <span class="text-neutral-500">Tanggal:</span>
                        <span class="font-medium text-neutral-700">{{ $order->created_at->format('d M Y H:i') }}</span>
                    </div>
                </div>
            </div>
            
            <!-- Status Badge -->
            <div class="flex items-center gap-2">
                @php
                    $statusConfig = [
                        'pending_payment' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-800', 'label' => 'Menunggu Pembayaran'],
                        'payment_uploaded' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-800', 'label' => 'Pembayaran Diupload'],
                        'processing' => ['bg' => 'bg-purple-100', 'text' => 'text-purple-800', 'label' => 'Diproses'],
                        'shipped' => ['bg' => 'bg-indigo-100', 'text' => 'text-indigo-800', 'label' => 'Dikirim'],
                        'delivered' => ['bg' => 'bg-green-100', 'text' => 'text-green-800', 'label' => 'Selesai'],
                        'cancelled' => ['bg' => 'bg-red-100', 'text' => 'text-red-800', 'label' => 'Dibatalkan'],
                    ];
                    $status = $statusConfig[$order->status] ?? ['bg' => 'bg-neutral-100', 'text' => 'text-neutral-800', 'label' => $order->status];
                @endphp
                <span class="px-4 py-2 {{ $status['bg'] }} {{ $status['text'] }} rounded-full text-sm font-bold">
                    {{ $status['label'] }}
                </span>
            </div>
        </div>
        
        <!-- Status Update Form -->
        <form action="{{ route('admin.orders.status', $order) }}" method="POST" class="mt-4 sm:mt-6">
            @csrf
            @method('PUT')
            <div class="flex flex-col sm:flex-row gap-3">
                <select name="status" class="flex-1 px-4 py-2.5 border-2 border-neutral-300 rounded-lg focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition text-sm sm:text-base">
                    <option value="pending_payment" {{ $order->status == 'pending_payment' ? 'selected' : '' }}>Menunggu Pembayaran</option>
                    <option value="payment_uploaded" {{ $order->status == 'payment_uploaded' ? 'selected' : '' }}>Pembayaran Diupload</option>
                    <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Diproses</option>
                    <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Dikirim</option>
                    <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Selesai</option>
                    <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                </select>
                <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white rounded-lg font-bold shadow-md hover:shadow-lg transition-all transform active:scale-95 text-sm sm:text-base whitespace-nowrap">
                    Update Status
                </button>
            </div>
        </form>
    </div>

    <!-- Payment Proof Section - REDESIGNED -->
    @if($order->payment && $order->payment->paymentProof)
        <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl shadow-lg border-2 border-blue-200 p-4 sm:p-6 mb-4 sm:mb-6">
            <div class="flex items-center gap-3 mb-4 sm:mb-6">
                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-blue-500 rounded-lg flex items-center justify-center text-2xl sm:text-3xl">
                    💳
                </div>
                <div>
                    <h2 class="text-xl sm:text-2xl font-bold text-neutral-900">Bukti Pembayaran</h2>
                    <p class="text-sm text-neutral-600">Di upload: {{$order->payment->paymentProof->uploaded_at->format('d M Y H:i') }}</p>
                </div>
            </div>
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6">
                <!-- Payment Proof Image -->
                <div class="order-2 lg:order-1">
                    <div class="bg-white rounded-xl shadow-md overflow-hidden border-2 border-neutral-200">
                        <img src="{{ asset('storage/' . $order->payment->paymentProof->proof_image_path) }}" 
                             alt="Bukti Pembayaran" 
                             class="w-full h-auto cursor-pointer hover:opacity-90 transition"
                             onclick="window.open(this.src, '_blank')">
                    </div>
                    <p class="text-xs text-center text-neutral-500 mt-2">Klik gambar untuk memperbesar</p>
                </div>
                
                <!-- Payment Details & Actions -->
                <div class="order-1 lg:order-2 space-y-4">
                    <!-- Payment Info Card -->
                    <div class="bg-white rounded-xl shadow-md p-4 sm:p-5 space-y-3">
                        <h3 class="font-bold text-lg text-neutral-900 border-b border-neutral-200 pb-2">Detail Pembayaran</h3>
                        
                        <div class="grid grid-cols-2 gap-3 text-sm">
                            <div>
                                <p class="text-neutral-500 mb-1">Tanggal Transfer</p>
                                <p class="font-semibold text-neutral-900">{{ \Carbon\Carbon::parse($order->payment->paymentProof->payment_date)->format('d M Y') }}</p>
                            </div>
                            <div>
                                <p class="text-neutral-500 mb-1">Bank</p>
                                <p class="font-semibold text-neutral-900">{{ $order->payment->paymentProof->bank_name }}</p>
                            </div>
                            <div class="col-span-2">
                                <p class="text-neutral-500 mb-1">Atas Nama</p>
                                <p class="font-semibold text-neutral-900">{{ $order->payment->paymentProof->account_name }}</p>
                            </div>
                            <div class="col-span-2 bg-orange-50 rounded-lg p-3 border-2 border-orange-200">
                                <p class="text-neutral-500 text-xs mb-1">Jumlah Transfer</p>
                                <p class="text-2xl font-bold text-orange-600">Rp {{ number_format($order->payment->paymentProof->payment_amount, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Verification Actions -->
                    @if($order->payment->status == 'pending')
                        <div class="space-y-3">
                            <!-- Verify Button -->
                            <form action="{{ route('admin.orders.verify', $order) }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white py-3 sm:py-3.5 rounded-xl font-bold shadow-lg hover:shadow-xl transition-all transform active:scale-95 flex items-center justify-center gap-2 text-sm sm:text-base">
                                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Verifikasi Pembayaran
                                </button>
                            </form>
                            
                            <!-- Reject Section -->
                            <details class="bg-white border-2 border-red-300 rounded-xl overflow-hidden shadow-sm">
                                <summary class="cursor-pointer text-red-600 font-bold px-4 py-3 hover:bg-red-50 transition flex items-center justify-between">
                                    <span class="flex items-center gap-2 text-sm sm:text-base">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        Tolak Pembayaran
                                    </span>
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </summary>
                                <form action="{{ route('admin.orders.reject', $order) }}" method="POST" class="p-4 bg-red-50">
                                    @csrf
                                    <label class="block text-sm font-semibold text-neutral-700 mb-2">Alasan Penolakan</label>
                                    <textarea name="rejection_reason" rows="3" placeholder="Jelaskan mengapa pembayaran ditolak..." required 
                                        class="w-full px-4 py-3 border-2 border-red-300 rounded-lg focus:border-red-500 focus:ring-2 focus:ring-red-200 transition mb-3 text-sm"></textarea>
                                    <button type="submit" class="w-full bg-red-500 hover:bg-red-600 text-white py-2.5 rounded-lg font-bold transition">
                                        Tolak Pembayaran
                                    </button>
                                </form>
                            </details>
                        </div>
                    @elseif($order->payment->status == 'verified')
                        <div class="bg-gradient-to-r from-green-50 to-emerald-50 border-2 border-green-300 rounded-xl p-4 sm:p-5">
                            <div class="flex items-center gap-3 mb-2">
                                <div class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-green-800 font-bold text-base sm:text-lg">Pembayaran Terverifikasi</p>
                                    <p class="text-sm text-green-700">{{ $order->payment->paymentProof->verified_at->format('d M Y H:i') }}</p>
                                </div>
                            </div>
                        </div>
                    @elseif($order->payment->status == 'rejected')
                        <div class="bg-gradient-to-r from-red-50 to-pink-50 border-2 border-red-300 rounded-xl p-4 sm:p-5">
                            <div class="flex items-start gap-3">
                                <div class="w-10 h-10 bg-red-500 rounded-full flex items-center justify-center flex-shrink-0">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-red-800 font-bold text-base sm:text-lg mb-2">Pembayaran Ditolak</p>
                                    <p class="text-sm text-red-700">{{ $order->payment->paymentProof->verification_notes ?? 'Tidak ada catatan' }}</p>
                                </div>
                            </div>
                        </div>
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
                <span>Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between text-sm">
                <span>Ongkir</span>
                <span>Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between text-lg font-bold">
                <span>Total</span>
                <span class="text-primary-600">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
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
