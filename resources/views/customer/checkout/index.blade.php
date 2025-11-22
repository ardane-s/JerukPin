@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-heading font-bold text-neutral-900 mb-6">Checkout</h1>

    <form action="{{ route('checkout.store') }}" method="POST">
        @csrf
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Shipping Info -->
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h2 class="text-xl font-bold mb-4">Informasi Pengiriman</h2>
                    
                    @auth
                        @if($addresses->count() > 0)
                            <div class="mb-4">
                                <label class="flex items-center mb-2">
                                    <input type="radio" name="use_saved_address" value="1" checked class="mr-2">
                                    <span class="font-medium">Gunakan alamat tersimpan</span>
                                </label>
                                <select name="address_id" class="w-full px-4 py-2 border border-neutral-300 rounded-lg">
                                    @foreach($addresses as $address)
                                        <option value="{{ $address->id }}">{{ $address->full_address }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="mb-4">
                                <label class="flex items-center">
                                    <input type="radio" name="use_saved_address" value="0" class="mr-2">
                                    <span class="font-medium">Gunakan alamat baru</span>
                                </label>
                            </div>
                        @endif
                        
                        <div id="new-address-fields" class="{{ $addresses->count() > 0 ? 'hidden' : '' }}">
                            <div class="mb-4">
                                <label class="block text-sm font-medium mb-2">Alamat Lengkap *</label>
                                <textarea name="shipping_address" rows="3" class="w-full px-4 py-2 border border-neutral-300 rounded-lg">{{ old('shipping_address') }}</textarea>
                            </div>
                            <div class="mb-4">
                                <label class="block text-sm font-medium mb-2">No. Telepon *</label>
                                <input type="text" name="phone" value="{{ old('phone') }}" class="w-full px-4 py-2 border border-neutral-300 rounded-lg">
                            </div>
                        </div>
                    @else
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-2">Nama Lengkap *</label>
                            <input type="text" name="guest_name" value="{{ old('guest_name') }}" required class="w-full px-4 py-2 border border-neutral-300 rounded-lg">
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-2">Email *</label>
                            <input type="email" name="guest_email" value="{{ old('guest_email') }}" required class="w-full px-4 py-2 border border-neutral-300 rounded-lg">
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-2">No. Telepon *</label>
                            <input type="text" name="guest_phone" value="{{ old('guest_phone') }}" required class="w-full px-4 py-2 border border-neutral-300 rounded-lg">
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-2">Alamat Lengkap *</label>
                            <textarea name="guest_address" rows="3" required class="w-full px-4 py-2 border border-neutral-300 rounded-lg">{{ old('guest_address') }}</textarea>
                        </div>
                    @endauth
                </div>

                <!-- Order Items -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h2 class="text-xl font-bold mb-4">🛒 Ringkasan Pesanan</h2>
                    @foreach($cartItems as $item)
                        <div class="flex items-center gap-4 py-4 border-b border-neutral-200">
                            <div class="relative w-20 h-20 flex-shrink-0">
                                <img src="{{ $item->productVariant->product->images->first() ? asset('storage/' . $item->productVariant->product->images->first()->image_path) : asset('images/placeholder.jpg') }}" 
                                     alt="{{ $item->productVariant->product->name }}" 
                                     class="w-20 h-20 object-cover rounded-lg"
                                     onerror="this.onerror=null; this.parentElement.innerHTML='<div class=\'w-20 h-20 bg-gradient-to-br from-orange-50 via-orange-100 to-orange-200 flex items-center justify-center rounded-lg text-4xl\'>🍊</div>';">
                            </div>
                            <div class="flex-1">
                                <h3 class="font-bold">{{ $item->productVariant->product->name }}</h3>
                                <p class="text-sm text-neutral-600">{{ $item->productVariant->variant_name }}</p>
                                <p class="text-sm text-neutral-600">Qty: {{ $item->quantity }}</p>
                            </div>
                            <div class="text-right">
                                <p class="font-bold">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Payment Method Selection -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h2 class="text-xl font-bold mb-4">💳 Metode Pembayaran</h2>
                    
                    @php
                        $paymentMethods = \App\Models\PaymentMethod::active()->ordered()->get();
                        $groupedMethods = $paymentMethods->groupBy('type');
                        $firstMethod = true;
                    @endphp
                    
                    @if($paymentMethods->count() > 0)
                        <div class="space-y-3">
                            @foreach($groupedMethods as $type => $methods)
                                <label class="flex items-center p-4 border-2 border-neutral-200 rounded-lg cursor-pointer hover:border-orange-500 transition">
                                    <input type="radio" name="payment_method" value="{{ $type }}" {{ $firstMethod ? 'checked' : '' }} class="mr-3 w-5 h-5 text-orange-500">
                                    <div class="flex-1">
                                        @if($type === 'bank_transfer')
                                            <div class="font-bold text-neutral-900">💳 Transfer Bank</div>
                                            <div class="text-sm text-neutral-500">{{ $methods->pluck('method_name')->join(', ') }}</div>
                                        @elseif($type === 'e_wallet')
                                            <div class="font-bold text-neutral-900">📱 E-Wallet / QRIS</div>
                                            <div class="text-sm text-neutral-500">{{ $methods->pluck('method_name')->join(', ') }}</div>
                                        @elseif($type === 'cod')
                                            <div class="font-bold text-neutral-900">💵 Bayar di Tempat (COD)</div>
                                            <div class="text-sm text-neutral-500">Bayar saat barang diterima</div>
                                        @endif
                                    </div>
                                </label>
                                @php $firstMethod = false; @endphp
                            @endforeach
                        </div>
                    @else
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                            <p class="text-yellow-800 font-bold">⚠️ Tidak ada metode pembayaran tersedia</p>
                            <p class="text-sm text-yellow-700">Hubungi admin untuk informasi lebih lanjut.</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Order Summary -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-sm p-6 sticky top-20">
                    <h2 class="text-xl font-bold mb-4">Ringkasan</h2>
                    
                    <div class="space-y-2 mb-4">
                        <div class="flex justify-between">
                            <span>Subtotal</span>
                            <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Ongkir</span>
                            @if($shippingCost == 0)
                                <span class="text-green-600 font-bold">GRATIS! 🎉</span>
                            @else
                                <span>Rp {{ number_format($shippingCost, 0, ',', '.') }}</span>
                            @endif
                        </div>
                        @if($subtotal < $freeShippingThreshold && $shippingCost > 0)
                            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-2 text-xs">
                                <p class="text-yellow-800">💡 Belanja <strong>Rp {{ number_format($freeShippingThreshold - $subtotal, 0, ',', '.') }}</strong> lagi untuk gratis ongkir!</p>
                            </div>
                        @endif
                    </div>
                    
                    <input type="hidden" name="shipping_cost" value="{{ $shippingCost }}">
                    
                    <div class="border-t pt-4 mb-6">
                        <div class="flex justify-between text-lg font-bold">
                            <span>Total</span>
                            <span class="text-orange-600">Rp {{ number_format($subtotal + $shippingCost, 0, ',', '.') }}</span>
                        </div>
                    </div>
                    
                    <button type="submit" class="w-full bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white py-3 rounded-lg font-bold shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200">
                        🛒 Buat Pesanan
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
document.querySelectorAll('input[name="use_saved_address"]').forEach(radio => {
    radio.addEventListener('change', function() {
        document.getElementById('new-address-fields').classList.toggle('hidden', this.value === '1');
    });
});

document.querySelector('input[name="shipping_cost"]').addEventListener('input', function() {
    const subtotal = {{ $subtotal }};
    const shipping = parseInt(this.value) || 0;
    const total = subtotal + shipping;
    document.getElementById('total-amount').textContent = total.toLocaleString('id-ID');
});
</script>
@endsection
