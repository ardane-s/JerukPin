@extends('layouts.app')

@section('title', 'Pembayaran')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-orange-50 via-white to-green-50 py-8">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-6">
            <nav class="flex items-center gap-2 text-sm text-neutral-600 mb-4">
                <a href="{{ route('home') }}" class="hover:text-orange-600 transition">🏠 Beranda</a>
                <span>›</span>
                @auth
                    <a href="{{ route('orders.index') }}" class="hover:text-orange-600 transition">Pesanan Saya</a>
                    <span>›</span>
                @endauth
                <a href="{{ route('orders.show', $order->order_number) }}" class="hover:text-orange-600 transition">Detail Pesanan</a>
                <span>›</span>
                <span class="text-neutral-900 font-medium">Pembayaran</span>
            </nav>
            <h1 class="text-3xl font-heading font-bold text-neutral-900">💳 Pembayaran</h1>
        </div>

        <!-- Payment Card -->
        <div class="bg-white rounded-2xl shadow-lg border-2 border-orange-100 overflow-hidden">
            <div class="bg-gradient-to-r from-orange-500 to-orange-600 px-6 py-4">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-orange-100 text-sm font-medium">Nomor Pesanan</p>
                        <p class="text-white text-2xl font-bold">{{ $order->order_number }}</p>
                    </div>
                    <div>
                        <p class="text-orange-100 text-sm font-medium">Total Pembayaran</p>
                        <p class="text-white text-2xl font-bold">Rp {{ number_format($order->total, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>

            <div class="p-6">
                <!-- Payment Instructions -->
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border-l-4 border-blue-500 p-4 rounded-lg mb-6">
                    <div class="flex items-start gap-3">
                        <div class="text-3xl">ℹ️</div>
                        <div>
                            <h3 class="font-bold text-blue-900 mb-2">Petunjuk Pembayaran</h3>
                            <ul class="text-sm text-blue-800 space-y-1">
                                <li>• Klik tombol "Bayar Sekarang" di bawah</li>
                                <li>• Pilih metode pembayaran yang Anda inginkan</li>
                                <li>• Ikuti instruksi pembayaran yang muncul</li>
                                <li>• Setelah pembayaran berhasil, status pesanan akan otomatis diperbarui</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="border-t border-neutral-200 pt-4 mb-6">
                    <h3 class="font-bold text-neutral-900 mb-3">Ringkasan Pesanan</h3>
                    <div class="space-y-2">
                        <div class="flex justify-between text-neutral-700">
                            <span>Subtotal</span>
                            <span class="font-medium">Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-neutral-700">
                            <span>Ongkos Kirim</span>
                            <span class="font-medium">Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</span>
                        </div>
                        <div class="border-t-2 border-dashed border-neutral-200 pt-2">
                            <div class="flex justify-between items-center">
                                <span class="text-lg font-bold text-neutral-900">Total</span>
                                <span class="text-2xl font-bold text-orange-600">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payment Button -->
                <button id="pay-button" class="w-full bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white px-6 py-4 rounded-xl font-bold text-lg transition shadow-lg hover:shadow-xl flex items-center justify-center gap-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                    </svg>
                    Bayar Sekarang
                </button>

                <!-- Cancel Link -->
                <div class="text-center mt-4">
                    <a href="{{ route('orders.show', $order->order_number) }}" class="text-neutral-600 hover:text-neutral-900 text-sm transition">
                        ← Kembali ke Detail Pesanan
                    </a>
                </div>
            </div>
        </div>

        <!-- Payment Methods Info -->
        <div class="mt-6 bg-white rounded-xl shadow-md p-6">
            <h3 class="font-bold text-neutral-900 mb-3">Metode Pembayaran yang Tersedia</h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="text-center p-3 bg-neutral-50 rounded-lg">
                    <div class="text-2xl mb-1">💳</div>
                    <p class="text-xs text-neutral-600">Kartu Kredit</p>
                </div>
                <div class="text-center p-3 bg-neutral-50 rounded-lg">
                    <div class="text-2xl mb-1">🏦</div>
                    <p class="text-xs text-neutral-600">Transfer Bank</p>
                </div>
                <div class="text-center p-3 bg-neutral-50 rounded-lg">
                    <div class="text-2xl mb-1">📱</div>
                    <p class="text-xs text-neutral-600">GoPay / ShopeePay</p>
                </div>
                <div class="text-center p-3 bg-neutral-50 rounded-lg">
                    <div class="text-2xl mb-1">📲</div>
                    <p class="text-xs text-neutral-600">QRIS</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Midtrans Snap Script -->
<script src="{{ config('midtrans.snap_url') }}" data-client-key="{{ config('midtrans.client_key') }}"></script>

<script type="text/javascript">
    document.getElementById('pay-button').onclick = function(){
        // Disable button to prevent double click
        this.disabled = true;
        this.innerHTML = '<svg class="animate-spin h-5 w-5 mr-3" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Memproses...';
        
        // Trigger snap popup
        snap.pay('{{ $payment->snap_token }}', {
            onSuccess: function(result){
                console.log('Payment success:', result);
                window.location.href = '{{ route("payment.callback") }}?order_id={{ $order->order_number }}&transaction_status=settlement';
            },
            onPending: function(result){
                console.log('Payment pending:', result);
                window.location.href = '{{ route("payment.callback") }}?order_id={{ $order->order_number }}&transaction_status=pending';
            },
            onError: function(result){
                console.log('Payment error:', result);
                window.location.href = '{{ route("payment.callback") }}?order_id={{ $order->order_number }}&transaction_status=error';
            },
            onClose: function(){
                console.log('Payment popup closed');
                // Re-enable button
                document.getElementById('pay-button').disabled = false;
                document.getElementById('pay-button').innerHTML = '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg> Bayar Sekarang';
            }
        });
    };
</script>
@endsection
