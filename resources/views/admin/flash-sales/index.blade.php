@extends('admin.layouts.app')

@section('title', 'Flash Sale')
@section('page-title', 'Flash Sale')
@section('page-description', 'Kelola flash sale JerukPin')

@section('content')
<div class="flex justify-end items-center mb-6">
    <a href="{{ route('admin.flash-sales.create') }}" class="bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white px-6 py-3 rounded-lg font-medium shadow-lg hover:shadow-xl transition flex items-center gap-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
        </svg>
        Buat Flash Sale
    </a>
</div>

<!-- Tabs -->
<div class="mb-6">
    <div class="border-b border-neutral-200 bg-white rounded-t-xl px-6">
        <nav class="-mb-px flex space-x-8">
            <button onclick="switchTab('active')" id="tab-active" class="tab-button border-b-2 border-orange-500 py-4 px-1 text-sm font-bold text-orange-600 transition">
                ⚡ Aktif & Akan Datang
                <span class="ml-2 bg-orange-100 text-orange-700 py-0.5 px-2.5 rounded-full text-xs font-bold">{{ $activeFlashSales->total() }}</span>
            </button>
            <button onclick="switchTab('history')" id="tab-history" class="tab-button border-b-2 border-transparent py-4 px-1 text-sm font-bold text-neutral-500 hover:text-neutral-700 hover:border-neutral-300 transition">
                📋 Riwayat (Berakhir)
                <span class="ml-2 bg-neutral-100 text-neutral-600 py-0.5 px-2.5 rounded-full text-xs font-bold">{{ $endedFlashSales->total() }}</span>
            </button>
        </nav>
    </div>
</div>

<!-- Active Flash Sales Tab -->
<div id="content-active" class="tab-content">
    <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-neutral-200">
        <table class="min-w-full divide-y divide-neutral-200">
            <thead class="bg-gradient-to-r from-orange-50 to-orange-100">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-bold text-orange-900 uppercase tracking-wider">Produk</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-orange-900 uppercase tracking-wider">Harga</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-orange-900 uppercase tracking-wider">Stok</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-orange-900 uppercase tracking-wider">Periode</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-orange-900 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-4 text-right text-xs font-bold text-orange-900 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-neutral-200">
                @forelse($activeFlashSales as $sale)
                    <tr class="hover:bg-orange-50/30 transition">
                        <td class="px-6 py-4">
                            <div class="text-sm font-bold text-neutral-900">{{ $sale->productVariant->product->name }}</div>
                            <div class="text-sm text-neutral-600 mt-1">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full bg-blue-100 text-blue-800 text-xs font-medium">
                                    {{ $sale->productVariant->variant_name }}
                                </span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm">
                                <span class="line-through text-neutral-400">Rp {{ number_format($sale->original_price, 0, ',', '.') }}</span>
                                <span class="text-orange-600 font-bold ml-2 text-base">Rp {{ number_format($sale->flash_price, 0, ',', '.') }}</span>
                            </div>
                            <div class="inline-flex items-center gap-1 mt-1 px-2 py-0.5 rounded-full bg-green-100 text-green-800 text-xs font-bold">
                                📉 Diskon {{ $sale->discount_percentage }}%
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-bold text-neutral-700">{{ $sale->flash_sold }} / {{ $sale->flash_stock }}</div>
                            <div class="w-full bg-neutral-200 rounded-full h-2 mt-2">
                                <div class="bg-gradient-to-r from-orange-500 to-orange-600 h-2 rounded-full transition-all" style="width: {{ ($sale->flash_sold / $sale->flash_stock) * 100 }}%"></div>
                            </div>
                            <div class="text-xs text-neutral-500 mt-1">{{ round(($sale->flash_sold / $sale->flash_stock) * 100) }}% terjual</div>
                        </td>
                        <td class="px-6 py-4 text-sm text-neutral-600">
                            <div class="font-medium">📅 {{ $sale->start_time->format('d M Y, H:i') }}</div>
                            <div class="font-medium">⏰ {{ $sale->end_time->format('d M Y, H:i') }}</div>
                            @if($sale->isActive())
                                <div class="mt-2 flex gap-1 text-xs countdown-timer" data-end-time="{{ $sale->end_time }}">
                                    <span class="bg-orange-500 text-white px-2 py-1 rounded font-mono font-bold countdown-hours">00</span>:
                                    <span class="bg-orange-500 text-white px-2 py-1 rounded font-mono font-bold countdown-minutes">00</span>:
                                    <span class="bg-orange-500 text-white px-2 py-1 rounded font-mono font-bold countdown-seconds">00</span>
                                </div>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @if($sale->isActive())
                                <span class="inline-flex items-center px-3 py-1 text-xs font-bold rounded-full bg-green-100 text-green-800">
                                    🔥 Aktif
                                </span>
                            @elseif($sale->start_time > now())
                                <span class="inline-flex items-center px-3 py-1 text-xs font-bold rounded-full bg-blue-100 text-blue-800">
                                    ⏰ Akan Datang
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right text-sm space-x-3">
                            <a href="{{ route('admin.flash-sales.edit', $sale) }}" class="text-orange-600 hover:text-orange-900 font-medium">✏️ Edit</a>
                            @if($sale->is_active)
                                <form action="{{ route('admin.flash-sales.deactivate', $sale) }}" method="POST" class="inline">
                                    @csrf
                                    <button class="text-yellow-600 hover:text-yellow-900 font-medium">⏸️ Nonaktifkan</button>
                                </form>
                            @endif
                            <form action="{{ route('admin.flash-sales.destroy', $sale) }}" method="POST" class="inline" onsubmit="return confirm('Hapus flash sale?')">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-600 hover:text-red-900 font-medium">🗑️ Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <div class="text-6xl mb-4">⚡</div>
                            <p class="text-neutral-500 mb-2">Belum ada flash sale aktif</p>
                            <a href="{{ route('admin.flash-sales.create') }}" class="text-orange-600 hover:text-orange-800 font-medium">Buat flash sale pertama →</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $activeFlashSales->links() }}
    </div>
</div>

<!-- History Tab -->
<div id="content-history" class="tab-content hidden">
    <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-neutral-200">
        <table class="min-w-full divide-y divide-neutral-200">
            <thead class="bg-gradient-to-r from-neutral-50 to-neutral-100">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-bold text-neutral-700 uppercase tracking-wider">Produk</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-neutral-700 uppercase tracking-wider">Harga</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-neutral-700 uppercase tracking-wider">Terjual</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-neutral-700 uppercase tracking-wider">Periode</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-neutral-700 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-4 text-right text-xs font-bold text-neutral-700 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-neutral-200">
                @forelse($endedFlashSales as $sale)
                    <tr class="bg-neutral-50/50 hover:bg-neutral-100/50 transition">
                        <td class="px-6 py-4">
                            <div class="text-sm font-bold text-neutral-700">{{ $sale->productVariant->product->name }}</div>
                            <div class="text-sm text-neutral-500 mt-1">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full bg-neutral-200 text-neutral-700 text-xs font-medium">
                                    {{ $sale->productVariant->variant_name }}
                                </span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm">
                                <span class="line-through text-neutral-400">Rp {{ number_format($sale->original_price, 0, ',', '.') }}</span>
                                <span class="text-neutral-600 font-bold ml-2">Rp {{ number_format($sale->flash_price, 0, ',', '.') }}</span>
                            </div>
                            <div class="text-xs text-neutral-500 mt-1">Diskon {{ $sale->discount_percentage }}%</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-bold text-neutral-700 text-sm">{{ $sale->flash_sold }} / {{ $sale->flash_stock }}</div>
                            <div class="text-xs text-neutral-500 mt-1">
                                {{ $sale->flash_sold > 0 ? round(($sale->flash_sold / $sale->flash_stock) * 100) : 0 }}% terjual
                            </div>
                            <div class="w-full bg-neutral-200 rounded-full h-1.5 mt-2">
                                <div class="bg-neutral-400 h-1.5 rounded-full" style="width: {{ ($sale->flash_sold / $sale->flash_stock) * 100 }}%"></div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-neutral-500">
                            <div>Mulai: {{ $sale->start_time->format('d M Y, H:i') }}</div>
                            <div>Selesai: {{ $sale->end_time->format('d M Y, H:i') }}</div>
                            <div class="text-xs text-neutral-400 mt-1">{{ $sale->end_time->diffForHumans() }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-3 py-1 text-xs font-bold rounded-full bg-neutral-200 text-neutral-600">
                                ✓ Berakhir
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right text-sm space-x-3">
                            <form action="{{ route('admin.flash-sales.destroy', $sale) }}" method="POST" class="inline" onsubmit="return confirm('Hapus flash sale dari riwayat?')">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-600 hover:text-red-900 font-medium">🗑️ Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <div class="text-6xl mb-4">📋</div>
                            <p class="text-neutral-500">Belum ada riwayat flash sale yang berakhir</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $endedFlashSales->links() }}
    </div>
</div>

<script>
// Tab Switching
function switchTab(tab) {
    // Hide all content
    document.querySelectorAll('.tab-content').forEach(content => {
        content.classList.add('hidden');
    });
    
    // Remove active state from all tabs
    document.querySelectorAll('.tab-button').forEach(button => {
        button.classList.remove('border-orange-500', 'text-orange-600');
        button.classList.add('border-transparent', 'text-neutral-500');
    });
    
    // Show selected content
    document.getElementById('content-' + tab).classList.remove('hidden');
    
    // Activate selected tab
    const activeTab = document.getElementById('tab-' + tab);
    activeTab.classList.remove('border-transparent', 'text-neutral-500');
    activeTab.classList.add('border-orange-500', 'text-orange-600');
}

// Countdown Timers for Active Flash Sales
document.addEventListener('DOMContentLoaded', function() {
    const countdownEls = document.querySelectorAll('.countdown-timer');
    
    countdownEls.forEach(function(countdownEl) {
        const endTime = new Date(countdownEl.dataset.endTime).getTime();
        
        function updateCountdown() {
            const now = new Date().getTime();
            const distance = endTime - now;
            
            if (distance < 0) {
                // Reload page when flash sale ends to move it to history
                location.reload();
                return;
            }
            
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);
            
            countdownEl.querySelector('.countdown-hours').textContent = String(hours).padStart(2, '0');
            countdownEl.querySelector('.countdown-minutes').textContent = String(minutes).padStart(2, '0');
            countdownEl.querySelector('.countdown-seconds').textContent = String(seconds).padStart(2, '0');
        }
        
        updateCountdown();
        setInterval(updateCountdown, 1000);
    });
});
</script>
@endsection
