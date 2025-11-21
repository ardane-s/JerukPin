@extends('layouts.app')

@section('title', 'Detail Pesanan')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-orange-50 via-white to-green-50 py-8">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header with Breadcrumb -->
        <div class="mb-6">
            <nav class="flex items-center gap-2 text-sm text-neutral-600 mb-4">
                <a href="{{ route('home') }}" class="hover:text-orange-600 transition">🏠 Beranda</a>
                <span>›</span>
                @auth
                    <a href="{{ route('orders.index') }}" class="hover:text-orange-600 transition">Pesanan Saya</a>
                    <span>›</span>
                @endauth
                <span class="text-neutral-900 font-medium">Detail Pesanan</span>
            </nav>
            <div class="flex justify-between items-center">
                <h1 class="text-3xl font-heading font-bold text-neutral-900">📦 Detail Pesanan</h1>
                @if(in_array($order->status, ['delivered', 'shipped', 'processing', 'payment_verified']))
                    <a href="{{ route('orders.invoice', $order->order_number) }}" target="_blank" class="bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white px-6 py-3 rounded-lg font-bold transition shadow-md hover:shadow-lg">
                        🖨️ Print Invoice
                    </a>
                @endif
            </div>
        </div>

        <!-- Order Header Card -->
        <div class="bg-white rounded-2xl shadow-lg border-2 border-orange-100 overflow-hidden mb-6">
            <div class="bg-gradient-to-r from-orange-500 to-orange-600 px-6 py-4">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-orange-100 text-sm font-medium">Nomor Pesanan</p>
                        <p class="text-white text-2xl font-bold">{{ $order->order_number }}</p>
                    </div>
                    <div>
                        @if($order->status == 'pending_payment')
                            <span class="px-4 py-2 bg-yellow-400 text-yellow-900 rounded-full text-sm font-bold shadow-md">⏳ Menunggu Pembayaran</span>
                        @elseif($order->status == 'payment_uploaded')
                            <span class="px-4 py-2 bg-blue-400 text-blue-900 rounded-full text-sm font-bold shadow-md">📤 Pembayaran Diupload</span>
                        @elseif($order->status == 'payment_verified')
                            <span class="px-4 py-2 bg-purple-400 text-purple-900 rounded-full text-sm font-bold shadow-md">✅ Pembayaran Terverifikasi</span>
                        @elseif($order->status == 'processing')
                            <span class="px-4 py-2 bg-indigo-400 text-indigo-900 rounded-full text-sm font-bold shadow-md">⚙️ Diproses</span>
                        @elseif($order->status == 'shipped')
                            <span class="px-4 py-2 bg-blue-500 text-white rounded-full text-sm font-bold shadow-md">🚚 Dikirim</span>
                        @elseif($order->status == 'delivered')
                            <span class="px-4 py-2 bg-green-500 text-white rounded-full text-sm font-bold shadow-md">✅ Selesai</span>
                        @else
                            <span class="px-4 py-2 bg-red-400 text-red-900 rounded-full text-sm font-bold shadow-md">❌ Dibatalkan</span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Payment Info for Pending Payment -->
            @if($order->status == 'pending_payment')
                @if($order->payment_method == 'cod')
                    <div class="bg-gradient-to-r from-green-50 to-emerald-50 border-t-4 border-green-400 px-6 py-5">
                        <div class="flex items-start gap-4">
                            <div class="text-4xl">💵</div>
                            <div class="flex-1">
                                <h3 class="font-bold text-green-900 text-lg mb-2">Pembayaran COD (Cash on Delivery)</h3>
                                <p class="text-sm text-green-800 mb-2">Pesanan Anda akan segera diproses.</p>
                                <p class="text-sm text-green-800">Silakan siapkan uang tunai sebesar <span class="font-bold text-lg">Rp {{ number_format($order->total, 0, ',', '.') }}</span> saat barang tiba.</p>
                                <div class="flex gap-3 mt-4">
                                    <button type="button" onclick="showCancelModal()" class="bg-red-500 hover:bg-red-600 text-white px-6 py-3 rounded-lg font-bold transition shadow-md hover:shadow-lg">
                                        ❌ Batalkan Pesanan
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="bg-gradient-to-r from-yellow-50 to-orange-50 border-t-4 border-yellow-400 px-6 py-5">
                        <div class="flex items-start gap-4">
                            <div class="text-4xl">💳</div>
                            <div class="flex-1">
                                <h3 class="font-bold text-yellow-900 text-lg mb-2">Informasi Pembayaran</h3>
                                <p class="text-sm text-yellow-800 mb-4">Silakan transfer ke rekening berikut:</p>
                                <div class="bg-white rounded-xl p-4 shadow-md space-y-2">
                                    <div class="flex justify-between items-center">
                                        <span class="text-neutral-600 font-medium">Bank:</span>
                                        <span class="font-bold text-neutral-900">BCA</span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="text-neutral-600 font-medium">No. Rekening:</span>
                                        <span class="font-bold text-neutral-900">1234567890</span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="text-neutral-600 font-medium">Atas Nama:</span>
                                        <span class="font-bold text-neutral-900">JerukPin Indonesia</span>
                                    </div>
                                    <div class="border-t-2 border-dashed border-neutral-200 pt-2 mt-2">
                                        <div class="flex justify-between items-center">
                                            <span class="text-neutral-600 font-medium">Jumlah Transfer:</span>
                                            <span class="text-2xl font-bold text-orange-600">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex gap-3 mt-4">
                                    <a href="{{ route('orders.payment', $order->order_number) }}" 
                                       class="flex-1 bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white px-6 py-3 rounded-lg font-bold text-center transition shadow-md hover:shadow-lg">
                                        📤 Upload Bukti Pembayaran
                                    </a>
                                    <button type="button" onclick="showCancelModal()" class="flex-1 bg-red-500 hover:bg-red-600 text-white px-6 py-3 rounded-lg font-bold transition shadow-md hover:shadow-lg">
                                        ❌ Batalkan Pesanan
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @elseif($order->status == 'payment_uploaded')
                <div class="bg-blue-50 border-t-4 border-blue-400 px-6 py-4">
                    <div class="flex items-center gap-3">
                        <div class="text-3xl">⏳</div>
                        <div class="flex-1">
                            <p class="font-bold text-blue-900">Pembayaran Anda sedang diverifikasi</p>
                            <p class="text-sm text-blue-700">Kami akan memproses pesanan Anda setelah pembayaran dikonfirmasi.</p>
                        </div>
                        <button type="button" onclick="showCancelModal()" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg font-bold transition text-sm">
                            ❌ Batalkan
                        </button>
                    </div>
                </div>
            @endif
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Column: Products & Shipping -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Order Items -->
                <div class="bg-white rounded-2xl shadow-lg border-2 border-orange-100 p-6">
                    <h2 class="text-xl font-bold text-neutral-900 mb-4 flex items-center gap-2">
                        <span>🛍️</span> Produk Pesanan
                    </h2>
                    <div class="space-y-4">
                        @foreach($order->orderItems as $item)
                            <div class="flex gap-4 p-4 bg-gradient-to-r from-orange-50 to-white rounded-xl border border-orange-100 hover:shadow-md transition">
                                @if($item->productVariant && $item->productVariant->product && $item->productVariant->product->images->first())
                                    <div class="relative w-20 h-20 flex-shrink-0">
                                        <img src="{{ asset('storage/' . $item->productVariant->product->images->first()->image_path) }}" 
                                             alt="{{ $item->product_name }}" 
                                             class="w-20 h-20 object-cover rounded-lg shadow-md"
                                             onerror="this.onerror=null; this.parentElement.innerHTML='<div class=\'w-20 h-20 bg-gradient-to-br from-orange-50 via-orange-100 to-orange-200 flex items-center justify-center rounded-lg text-4xl\'>🍊</div>';">
                                    </div>
                                @else
                                    <div class="w-20 h-20 bg-gradient-to-br from-orange-400 to-orange-500 rounded-lg flex items-center justify-center text-4xl shadow-md">
                                        🍊
                                    </div>
                                @endif
                                <div class="flex-1">
                                    <h3 class="font-bold text-neutral-900">{{ $item->product_name }}</h3>
                                    <p class="text-sm text-neutral-600">{{ $item->variant_name }}</p>
                                    <div class="flex items-center gap-2 mt-1">
                                        <span class="text-sm text-neutral-500">Qty: {{ $item->quantity }}</span>
                                        @if($item->is_flash_sale)
                                            <span class="text-xs bg-red-500 text-white px-2 py-0.5 rounded-full font-bold">🔥 Flash Sale</span>
                                        @endif
                                    </div>
                                    
                                    @auth
                                        @if($order->status === 'delivered')
                                            @php
                                                $existingReview = \App\Models\Review::where('order_item_id', $item->id)
                                                    ->where('user_id', auth()->id())
                                                    ->first();
                                            @endphp
                                            
                                            @if($existingReview)
                                                <div class="mt-2">
                                                    @if($existingReview->is_approved)
                                                        <span class="text-sm text-green-600 font-medium">✓ Review dipublikasikan</span>
                                                    @else
                                                        <span class="text-sm text-yellow-600 font-medium">⏳ Review menunggu persetujuan</span>
                                                    @endif
                                                </div>
                                            @else
                                                <button onclick="openReviewModal({{ $item->id }}, {{ $item->productVariant->product->id }}, '{{ addslashes($item->product_name) }}')" 
                                                        class="mt-2 text-sm text-orange-600 hover:text-orange-700 font-bold flex items-center gap-1">
                                                    ⭐ Tulis Review
                                                </button>
                                            @endif
                                        @endif
                                    @endauth
                                </div>
                                <div class="text-right">
                                    <p class="text-sm text-neutral-500">@ Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                                    <p class="text-lg font-bold text-orange-600">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Shipping Info -->
                <div class="bg-white rounded-2xl shadow-lg border-2 border-orange-100 p-6">
                    <h2 class="text-xl font-bold text-neutral-900 mb-4 flex items-center gap-2">
                        <span>📍</span> Informasi Pengiriman
                    </h2>
                    <div class="bg-gradient-to-r from-orange-50 to-white p-4 rounded-xl border border-orange-100">
                        @if($order->user_id)
                            <p class="font-bold text-neutral-900 text-lg">{{ $order->user->name }}</p>
                            <p class="text-neutral-600 mt-2">{{ $order->address ? $order->address->full_address : 'Alamat tidak tersedia' }}</p>
                            <p class="text-neutral-600 mt-1 flex items-center gap-2">
                                <span>📞</span> {{ $order->user->phone ?? 'Nomor telepon tidak tersedia' }}
                            </p>
                        @else
                            <p class="font-bold text-neutral-900 text-lg">{{ $order->guest_name }}</p>
                            <p class="text-neutral-600 mt-2">{{ $order->guest_address }}</p>
                            <p class="text-neutral-600 mt-1 flex items-center gap-2">
                                <span>📞</span> {{ $order->guest_phone }}
                            </p>
                            <p class="text-neutral-600 mt-1 flex items-center gap-2">
                                <span>📧</span> {{ $order->guest_email }}
                            </p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Right Column: Summary -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-lg border-2 border-orange-100 p-6 sticky top-20">
                    <h2 class="text-xl font-bold text-neutral-900 mb-4 flex items-center gap-2">
                        <span>💰</span> Ringkasan Pesanan
                    </h2>
                    
                    <div class="space-y-3 mb-4">
                        <div class="flex justify-between text-neutral-700">
                            <span>Subtotal</span>
                            <span class="font-medium">Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-neutral-700">
                            <span>Ongkos Kirim</span>
                            <span class="font-medium">Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</span>
                        </div>
                        <div class="border-t-2 border-dashed border-neutral-200 pt-3">
                            <div class="flex justify-between items-center">
                                <span class="text-lg font-bold text-neutral-900">Total</span>
                                <span class="text-2xl font-bold text-orange-600">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Method -->
                    @if($order->payment_method)
                        <div class="bg-gradient-to-r from-orange-50 to-white p-4 rounded-xl border border-orange-100 mt-4">
                            <p class="text-sm text-neutral-600 mb-1">Metode Pembayaran</p>
                            <p class="font-bold text-neutral-900">
                                @if($order->payment_method == 'bank_transfer')
                                    🏦 Transfer Bank
                                @elseif($order->payment_method == 'e_wallet')
                                    📱 E-Wallet
                                @else
                                    💵 COD
                                @endif
                            </p>
                        </div>
                    @endif

                    <!-- Order Date -->
                    <div class="bg-neutral-50 p-4 rounded-xl mt-4">
                        <p class="text-sm text-neutral-600 mb-1">Tanggal Pesanan</p>
                        <p class="font-bold text-neutral-900">{{ $order->created_at->format('d M Y, H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Cancel Order Modal -->
<div id="cancelModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-2xl p-6 max-w-md w-full mx-4 shadow-2xl">
        <div class="text-center mb-4">
            <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <span class="text-4xl">⚠️</span>
            </div>
            <h3 class="text-2xl font-bold text-neutral-900 mb-2">Batalkan Pesanan?</h3>
            <p class="text-neutral-600">Apakah Anda yakin ingin membatalkan pesanan ini?</p>
        </div>
        
        <div class="flex gap-3">
            <button type="button" onclick="hideCancelModal()" class="flex-1 px-4 py-3 border-2 border-neutral-300 rounded-lg hover:bg-neutral-50 font-bold transition">
                Tidak
            </button>
            <button type="button" onclick="confirmCancel()" class="flex-1 px-4 py-3 bg-red-500 hover:bg-red-600 text-white rounded-lg font-bold transition shadow-md hover:shadow-lg">
                Ya, Batalkan
            </button>
        </div>
    </div>
</div>

<!-- Hidden form for cancel submission -->
<form id="cancelForm" action="{{ route('orders.cancel', $order->order_number) }}" method="POST" class="hidden">
    @csrf
</form>

<!-- Review Modal -->
@auth
<div id="reviewModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-2xl p-6 max-w-md w-full mx-4 shadow-2xl">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-2xl font-bold text-neutral-900">⭐ Tulis Review</h3>
            <button onclick="closeReviewModal()" class="text-neutral-400 hover:text-neutral-600 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        
        <form action="{{ route('reviews.store') }}" method="POST" id="reviewForm">
            @csrf
            <input type="hidden" name="order_item_id" id="review_order_item_id">
            <input type="hidden" name="product_id" id="review_product_id">
            
            <div class="mb-4">
                <p class="font-bold text-lg text-neutral-900" id="review_product_name"></p>
            </div>
            
            <div class="mb-4">
                <label class="block text-sm font-bold text-neutral-700 mb-2">Rating</label>
                <div class="flex gap-2">
                    @for($i = 1; $i <= 5; $i++)
                        <button type="button" onclick="setRating({{ $i }})" class="rating-star">
                            <svg class="w-10 h-10 text-neutral-300 hover:text-yellow-400 transition" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                        </button>
                    @endfor
                </div>
                <input type="hidden" name="rating" id="review_rating" required>
            </div>
            
            <div class="mb-4">
                <label class="block text-sm font-bold text-neutral-700 mb-2">Komentar (Opsional)</label>
                <textarea name="comment" rows="4" class="w-full border-2 border-neutral-200 rounded-lg p-3 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition" placeholder="Bagikan pengalaman Anda..."></textarea>
            </div>
            
            <div class="flex gap-3">
                <button type="button" onclick="closeReviewModal()" class="flex-1 px-4 py-3 border-2 border-neutral-300 rounded-lg hover:bg-neutral-50 font-bold transition">
                    Batal
                </button>
                <button type="submit" class="flex-1 px-4 py-3 bg-gradient-to-r from-orange-500 to-orange-600 text-white rounded-lg hover:from-orange-600 hover:to-orange-700 font-bold transition shadow-md hover:shadow-lg">
                    Kirim Review
                </button>
            </div>
        </form>
    </div>
</div>
@endauth

<script>
// Cancel Modal Functions - Available for all users
function showCancelModal() {
    const modal = document.getElementById('cancelModal');
    if (modal) {
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }
}

function hideCancelModal() {
    const modal = document.getElementById('cancelModal');
    if (modal) {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
}

function confirmCancel() {
    const form = document.getElementById('cancelForm');
    if (form) {
        form.submit();
    }
}

// Close cancel modal on outside click
const cancelModal = document.getElementById('cancelModal');
if (cancelModal) {
    cancelModal.addEventListener('click', function(e) {
        if (e.target === this) {
            hideCancelModal();
        }
    });
}

@auth
// Review Modal Functions - Only for authenticated users
let currentRating = 0;

function openReviewModal(orderItemId, productId, productName) {
    document.getElementById('review_order_item_id').value = orderItemId;
    document.getElementById('review_product_id').value = productId;
    document.getElementById('review_product_name').textContent = productName;
    document.getElementById('reviewModal').classList.remove('hidden');
    document.getElementById('reviewModal').classList.add('flex');
    currentRating = 0;
    updateStars();
}

function closeReviewModal() {
    document.getElementById('reviewModal').classList.add('hidden');
    document.getElementById('reviewModal').classList.remove('flex');
    document.getElementById('reviewForm').reset();
    currentRating = 0;
    updateStars();
}

function setRating(rating) {
    currentRating = rating;
    document.getElementById('review_rating').value = rating;
    updateStars();
}

function updateStars() {
    const stars = document.querySelectorAll('.rating-star svg');
    stars.forEach((star, index) => {
        if (index < currentRating) {
            star.classList.remove('text-neutral-300');
            star.classList.add('text-yellow-400');
        } else {
            star.classList.remove('text-yellow-400');
            star.classList.add('text-neutral-300');
        }
    });
}

// Close review modal on outside click
const reviewModal = document.getElementById('reviewModal');
if (reviewModal) {
    reviewModal.addEventListener('click', function(e) {
        if (e.target === this) {
            closeReviewModal();
        }
    });
}
@endauth
</script>
@endsection
