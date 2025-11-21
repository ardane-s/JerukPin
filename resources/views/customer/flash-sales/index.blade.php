@extends('layouts.app')

@section('title', 'Flash Sale - Diskon Spesial')

@section('content')
<!-- Hero Section -->
<div class="bg-gradient-to-r from-orange-500 via-red-500 to-orange-600 text-white py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-5xl font-heading font-bold mb-4 animate-pulse">🔥 FLASH SALE</h1>
        <p class="text-xl text-orange-100">Diskon Spesial - Buruan Sebelum Kehabisan!</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    
    @if($activeCampaign || $upcomingCampaign)
        
        <!-- ACTIVE CAMPAIGN BANNER -->
        @if($activeCampaign)
        <div class="mb-8">
            <div class="bg-gradient-to-r from-green-50 to-emerald-50 border-2 border-green-300 rounded-2xl p-8 shadow-xl">
                <div class="flex flex-col md:flex-row justify-between items-center gap-6">
                    <div class="flex-1">
                        <div class="flex items-center gap-3 mb-3">
                            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-bold bg-green-600 text-white animate-pulse shadow-lg">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                FLASH SALE AKTIF
                            </span>
                        </div>
                        <h2 class="text-3xl md:text-4xl font-bold text-green-900 mb-2">{{ $activeCampaign->name }}</h2>
                        @if($activeCampaign->description)
                            <p class="text-green-700 text-lg">{{ $activeCampaign->description }}</p>
                        @endif
                        <p class="text-green-600 font-semibold mt-3">{{ $activeCampaign->flashSales->count() }} produk tersedia dengan diskon hingga 70%!</p>
                    </div>
                    <div class="flex-shrink-0">
                        <p class="text-sm text-green-700 mb-2 text-center font-semibold">Berakhir dalam:</p>
                        <div class="flex gap-2 countdown-timer" data-end-time="{{ $activeCampaign->end_time->toIso8601String() }}">
                            <div class="bg-green-600 text-white rounded-xl px-5 py-4 shadow-lg">
                                <div class="text-4xl font-bold countdown-hours">00</div>
                                <div class="text-xs mt-1">Jam</div>
                            </div>
                            <div class="text-4xl font-bold text-green-600">:</div>
                            <div class="bg-green-600 text-white rounded-xl px-5 py-4 shadow-lg">
                                <div class="text-4xl font-bold countdown-minutes">00</div>
                                <div class="text-xs mt-1">Menit</div>
                            </div>
                            <div class="text-4xl font-bold text-green-600">:</div>
                            <div class="bg-green-600 text-white rounded-xl px-5 py-4 shadow-lg">
                                <div class="text-4xl font-bold countdown-seconds">00</div>
                                <div class="text-xs mt-1">Detik</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ACTIVE CAMPAIGN PRODUCTS -->
        <div class="mb-12">
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
                @foreach($activeCampaign->flashSales as $sale)
                    @php
                        $product = $sale->productVariant->product;
                        $variant = $sale->productVariant;
                        $image = $product->images->first();
                    @endphp
                    
                    <div class="bg-white rounded-xl shadow-md hover:shadow-2xl transition-all duration-300 overflow-hidden group border border-neutral-200">
                        <!-- Product Image -->
                        <div class="relative overflow-hidden bg-neutral-100 aspect-square">
                            @if($image)
                                <img src="{{ asset('storage/' . $image->image_path) }}" 
                                     alt="{{ $product->name }}" 
                                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-orange-400 to-orange-600 flex items-center justify-center">
                                    <svg class="w-20 h-20 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                    </svg>
                                </div>
                            @endif
                            
                            <!-- Discount Badge -->
                            <div class="absolute top-2 left-2">
                                <span class="bg-red-600 text-white text-xs font-bold px-3 py-1.5 rounded-full shadow-lg">
                                    -{{ $sale->discount_percentage }}%
                                </span>
                            </div>
                            
                            <!-- Stock Badge -->
                            @if($sale->remaining_stock < 10)
                                <div class="absolute top-2 right-2">
                                    <span class="bg-orange-600 text-white text-xs font-bold px-3 py-1.5 rounded-full shadow-lg">
                                        Sisa {{ $sale->remaining_stock }}
                                    </span>
                                </div>
                            @endif
                        </div>
                        
                        <!-- Product Info -->
                        <div class="p-4">
                            <h3 class="font-semibold text-neutral-900 text-sm mb-2 line-clamp-2 min-h-[2.5rem]">
                                {{ $product->name }}
                            </h3>
                            <p class="text-xs text-neutral-500 mb-2">{{ $variant->variant_name }}</p>
                            
                            <!-- Prices -->
                            <div class="mb-3">
                                <div class="flex items-center gap-2 mb-1">
                                    <span class="text-lg font-bold text-orange-600">
                                        Rp {{ number_format($sale->flash_price, 0, ',', '.') }}
                                    </span>
                                </div>
                                <span class="text-xs text-neutral-400 line-through">
                                    Rp {{ number_format($sale->original_price, 0, ',', '.') }}
                                </span>
                            </div>
                            
                            <!-- Progress Bar -->
                            @if($sale->flash_stock > 0)
                                <div class="mb-3">
                                    <div class="flex justify-between text-xs text-neutral-600 mb-1">
                                        <span>Terjual</span>
                                        <span>{{ $sale->flash_sold }}/{{ $sale->flash_stock }}</span>
                                    </div>
                                    <div class="w-full bg-neutral-200 rounded-full h-2">
                                        <div class="bg-orange-600 h-2 rounded-full transition-all" 
                                             style="width: {{ ($sale->flash_sold / $sale->flash_stock) * 100 }}%"></div>
                                    </div>
                                </div>
                            @endif
                            
                            <!-- Add to Cart Button -->
                            @if($sale->remaining_stock > 0)
                                <form action="{{ route('cart.add') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_variant_id" value="{{ $variant->id }}">
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" 
                                            class="w-full bg-orange-600 hover:bg-orange-700 text-white text-sm font-semibold py-2.5 rounded-lg transition-colors shadow-md hover:shadow-lg">
                                        + Keranjang
                                    </button>
                                </form>
                            @else
                                <button disabled 
                                        class="w-full bg-neutral-300 text-neutral-500 text-sm font-semibold py-2.5 rounded-lg cursor-not-allowed">
                                    Habis
                                </button>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- UPCOMING CAMPAIGN TEASER -->
        @if($upcomingCampaign)
        <div class="mb-8">
            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border-2 border-blue-300 rounded-2xl p-8 shadow-xl">
                <div class="flex flex-col md:flex-row justify-between items-center gap-6">
                    <div class="flex-1">
                        <div class="flex items-center gap-3 mb-3">
                            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-bold bg-blue-600 text-white shadow-lg">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                FLASH SALE BERIKUTNYA
                            </span>
                        </div>
                        <h2 class="text-3xl md:text-4xl font-bold text-blue-900 mb-2">{{ $upcomingCampaign->name }}</h2>
                        @if($upcomingCampaign->description)
                            <p class="text-blue-700 text-lg">{{ $upcomingCampaign->description }}</p>
                        @endif
                        <p class="text-blue-600 font-semibold mt-3">
                            Mulai: {{ $upcomingCampaign->start_time->format('d M Y, H:i') }} WIB
                        </p>
                        <p class="text-blue-500 text-sm mt-1">{{ $upcomingCampaign->flashSales->count() }} produk spesial menanti!</p>
                    </div>
                    <div class="flex-shrink-0">
                        <p class="text-sm text-blue-700 mb-2 text-center font-semibold">Dimulai dalam:</p>
                        <div class="flex gap-2 countdown-timer" data-start-time="{{ $upcomingCampaign->start_time->toIso8601String() }}">
                            <div class="bg-blue-600 text-white rounded-xl px-5 py-4 shadow-lg">
                                <div class="text-4xl font-bold countdown-hours">00</div>
                                <div class="text-xs mt-1">Jam</div>
                            </div>
                            <div class="text-4xl font-bold text-blue-600">:</div>
                            <div class="bg-blue-600 text-white rounded-xl px-5 py-4 shadow-lg">
                                <div class="text-4xl font-bold countdown-minutes">00</div>
                                <div class="text-xs mt-1">Menit</div>
                            </div>
                            <div class="text-4xl font-bold text-blue-600">:</div>
                            <div class="bg-blue-600 text-white rounded-xl px-5 py-4 shadow-lg">
                                <div class="text-4xl font-bold countdown-seconds">00</div>
                                <div class="text-xs mt-1">Detik</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

    @else
        <!-- No Flash Sales -->
        <div class="text-center py-20">
            <svg class="mx-auto h-24 w-24 text-neutral-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
            </svg>
            <h3 class="text-2xl font-bold text-neutral-700 mb-2">Belum Ada Flash Sale Aktif</h3>
            <p class="text-neutral-500">Pantau terus untuk penawaran spesial berikutnya!</p>
        </div>
    @endif
</div>

<!-- Countdown Timer Script -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Function to update countdown
    function updateCountdown(timer) {
        const endTime = timer.dataset.endTime;
        const startTime = timer.dataset.startTime;
        const targetTime = endTime ? new Date(endTime) : new Date(startTime);
        
        const hoursEl = timer.querySelector('.countdown-hours');
        const minutesEl = timer.querySelector('.countdown-minutes');
        const secondsEl = timer.querySelector('.countdown-seconds');
        
        function update() {
            const now = new Date();
            const diff = targetTime - now;
            
            if (diff <= 0) {
                hoursEl.textContent = '00';
                minutesEl.textContent = '00';
                secondsEl.textContent = '00';
                // Reload page when countdown ends
                setTimeout(() => window.location.reload(), 1000);
                return;
            }
            
            const hours = Math.floor(diff / (1000 * 60 * 60));
            const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((diff % (1000 * 60)) / 1000);
            
            hoursEl.textContent = String(hours).padStart(2, '0');
            minutesEl.textContent = String(minutes).padStart(2, '0');
            secondsEl.textContent = String(seconds).padStart(2, '0');
        }
        
        update();
        setInterval(update, 1000);
    }
    
    // Initialize all countdown timers
    document.querySelectorAll('.countdown-timer').forEach(updateCountdown);
});
</script>
@endsection
