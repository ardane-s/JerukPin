{{-- ADD THIS CODE SNIPPET in customer order detail view --}}
{{-- Place this after shipping cost line and before total line in the order summary --}}

@if($order->shippingMethod)
    <div class="bg-gradient-to-r from-blue-50 to-white p-3 rounded-lg border border-blue-100 mt-2">
        <p class="text-xs text-neutral-600 mb-1">Metode Pengiriman</p>
        <div class="flex items-center gap-2">
            <span class="text-xl">{{ $order->shippingMethod->icon }}</span>
            <div>
                <p class="font-bold text-neutral-900 text-sm">{{ $order->shippingMethod->name }}</p>
                <p class="text-xs text-neutral-500">Estimasi: {{ $order->shippingMethod->estimate_text }}</p>
            </div>
        </div>
    </div>
@endif
