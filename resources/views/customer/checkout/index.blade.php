@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<div class="max-w-7xl mx-auto px-3 sm:px-4 lg:px-8 py-4 sm:py-8">
    <h1 class="text-2xl sm:text-3xl font-heading font-bold text-neutral-900 mb-4 sm:mb-6">Checkout</h1>

    @if($errors->any())
        <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-r-lg">
            <div class="flex">
                <div class="ml-3">
                    <h3 class="text-sm font-bold text-red-800">Ada masalah dengan pesanan Anda:</h3>
                    <div class="mt-2 text-sm text-red-700">
                        <ul class="list-disc list-inside space-y-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    @endif

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
                        
                        <div id="new-address-fields" class="{{ $addresses->count() > 0 ? 'hidden' : '' }} space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium mb-2">Nama Penerima *</label>
                                    <input type="text" name="recipient_name" value="{{ old('recipient_name', auth()->user()->name) }}" class="w-full px-4 py-2 border border-neutral-300 rounded-lg focus:ring-orange-500 focus:border-orange-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium mb-2">No. Telepon *</label>
                                    <input type="text" name="phone" value="{{ old('phone', auth()->user()->phone) }}" class="w-full px-4 py-2 border border-neutral-300 rounded-lg focus:ring-orange-500 focus:border-orange-500">
                                </div>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium mb-2">Alamat Lengkap (Jalan, No. Rumah, RT/RW) *</label>
                                <textarea name="address" rows="2" class="w-full px-4 py-2 border border-neutral-300 rounded-lg focus:ring-orange-500 focus:border-orange-500" placeholder="Contoh: Jl. Jeruk Manis No. 12, RT 01/RW 02">{{ old('address') }}</textarea>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-sm font-medium mb-2">Kota/Kabupaten *</label>
                                    <input type="text" name="city" value="{{ old('city') }}" class="w-full px-4 py-2 border border-neutral-300 rounded-lg focus:ring-orange-500 focus:border-orange-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium mb-2">Provinsi *</label>
                                    <input type="text" name="province" value="{{ old('province') }}" class="w-full px-4 py-2 border border-neutral-300 rounded-lg focus:ring-orange-500 focus:border-orange-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium mb-2">Kode Pos *</label>
                                    <input type="text" name="postal_code" value="{{ old('postal_code') }}" class="w-full px-4 py-2 border border-neutral-300 rounded-lg focus:ring-orange-500 focus:border-orange-500">
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium mb-2">Nama Lengkap *</label>
                                    <input type="text" name="guest_name" value="{{ old('guest_name') }}" required class="w-full px-4 py-2 border border-neutral-300 rounded-lg focus:ring-orange-500 focus:border-orange-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium mb-2">Email *</label>
                                    <input type="email" name="guest_email" value="{{ old('guest_email') }}" required class="w-full px-4 py-2 border border-neutral-300 rounded-lg focus:ring-orange-500 focus:border-orange-500">
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium mb-2">No. Telepon *</label>
                                <input type="text" name="guest_phone" value="{{ old('guest_phone') }}" required class="w-full px-4 py-2 border border-neutral-300 rounded-lg focus:ring-orange-500 focus:border-orange-500">
                            </div>

                            <div>
                                <label class="block text-sm font-medium mb-2">Alamat Lengkap (Jalan, No. Rumah, RT/RW) *</label>
                                <textarea name="guest_street" rows="2" required class="w-full px-4 py-2 border border-neutral-300 rounded-lg focus:ring-orange-500 focus:border-orange-500" placeholder="Contoh: Jl. Jeruk Manis No. 12, RT 01/RW 02">{{ old('guest_street') }}</textarea>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-sm font-medium mb-2">Kota/Kabupaten *</label>
                                    <input type="text" name="guest_city" value="{{ old('guest_city') }}" required class="w-full px-4 py-2 border border-neutral-300 rounded-lg focus:ring-orange-500 focus:border-orange-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium mb-2">Provinsi *</label>
                                    <input type="text" name="guest_province" value="{{ old('guest_province') }}" required class="w-full px-4 py-2 border border-neutral-300 rounded-lg focus:ring-orange-500 focus:border-orange-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium mb-2">Kode Pos *</label>
                                    <input type="text" name="guest_postal_code" value="{{ old('guest_postal_code') }}" required class="w-full px-4 py-2 border border-neutral-300 rounded-lg focus:ring-orange-500 focus:border-orange-500">
                                </div>
                            </div>
                        </div>
                    @endauth
                </div>

                <!-- Order Items -->
                <div class="bg-white rounded-lg shadow-sm p-4 sm:p-6">
                    <h2 class="text-lg sm:text-xl font-bold mb-3 sm:mb-4">🛒 Ringkasan Pesanan</h2>
                    @foreach($cartItems as $item)
                        <div class="flex items-center gap-3 py-3 sm:py-4 border-b border-neutral-200">
                            <div class="relative w-20 h-20 flex-shrink-0 bg-orange-50 rounded-lg overflow-hidden">
                                <!-- Placeholder -->
                                <div class="absolute inset-0 flex items-center justify-center bg-gradient-to-br from-orange-50 via-orange-100 to-orange-200">
                                    <span class="text-4xl select-none">🍊</span>
                                </div>
                                <!-- Image -->
                                @if($item->productVariant->product->images->first())
                                    @php
                                        $imageUrl = \App\Helpers\ImageHelper::getImageUrl($item->productVariant->product->images->first()->image_path);
                                    @endphp
                                    @if($imageUrl)
                                        <img src="{{ $imageUrl }}" 
                                             alt="{{ $item->productVariant->product->name }}" 
                                             class="w-full h-full object-cover relative z-10"
                                             onerror="this.style.display='none'">
                                    @endif
                                @endif
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

                <!-- Shipping Method Selection -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h2 class="text-xl font-bold mb-4">🚚 Metode Pengiriman</h2>
                    
                    @if($shippingMethods->count() > 0)
                        <div class="space-y-3">
                            @php $firstShipping = true; @endphp
                            @foreach($shippingMethods as $method)
                                <label class="flex items-center p-4 border-2 rounded-lg cursor-pointer transition hover:border-orange-500 {{ $firstShipping ? 'border-orange-600 bg-orange-50' : 'border-neutral-200' }}">
                                    <input type="radio" name="shipping_method_id" value="{{ $method->id }}" 
                                           data-cost="{{ $method->base_cost }}"
                                           class="shipping-method-radio mr-4" {{ $firstShipping ? 'checked' : '' }} required>
                                    <div class="flex-1">
                                        <div class="flex items-center gap-2">
                                            <span class="text-2xl">{{ $method->icon }}</span>
                                            <div>
                                                <div class="font-bold text-neutral-900">{{ $method->name }}</div>
                                                @if($method->description)
                                                    <div class="text-sm text-neutral-500">{{ $method->description }}</div>
                                                @endif
                                                <div class="text-xs text-neutral-600 mt-1">Estimasi: {{ $method->estimate_text }}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <div class="font-bold text-orange-600">{{ $method->formatted_cost }}</div>
                                    </div>
                                </label>
                                @php $firstShipping = false; @endphp
                            @endforeach
                        </div>
                    @else
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                            <p class="text-yellow-800 font-bold">⚠️ Tidak ada metode pengiriman tersedia</p>
                            <p class="text-sm text-yellow-700">Hubungi admin untuk informasi lebih lanjut.</p>
                        </div>
                    @endif
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
// Update shipping cost and total when shipping method changes
document.querySelectorAll('.shipping-method-radio').forEach(radio => {
    radio.addEventListener('change', function() {
        const shippingCost = parseInt(this.dataset.cost) || 0;
        const subtotal = {{ $subtotal }};
        const total = subtotal + shippingCost;
        
        // Update hidden input
        document.querySelector('input[name="shipping_cost"]').value = shippingCost;
        
        // Update display
        document.getElementById('shipping-cost-display').textContent = shippingCost === 0 ? 'GRATIS! 🎉' : 'Rp ' + shippingCost.toLocaleString('id-ID');
        document.getElementById('total-amount').textContent = 'Rp ' + total.toLocaleString('id-ID');
        
        // Update label styles
        document.querySelectorAll('.shipping-method-radio').forEach(r => {
            r.closest('label').classList.remove('border-orange-600', 'bg-orange-50');
            r.closest('label').classList.add('border-neutral-200');
        });
        this.closest('label').classList.remove('border-neutral-200');
        this.closest('label').classList.add('border-orange-600', 'bg-orange-50');
    });
});

// Trigger change on load to set initial value
document.querySelector('.shipping-method-radio:checked')?.dispatchEvent(new Event('change'));
</script>
@endsection
