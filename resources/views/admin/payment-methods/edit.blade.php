@extends('admin.layouts.app')

@section('title', 'Edit Metode Pembayaran')

@section('content')
<div class="max-w-3xl">
    <div class="mb-6">
        <a href="{{ route('admin.payment-methods.index') }}" class="text-orange-600 hover:text-orange-800">← Kembali</a>
    </div>

    <h1 class="text-3xl font-heading font-bold text-neutral-900 mb-6">Edit Metode Pembayaran</h1>

    <div class="bg-white rounded-lg shadow-sm p-6">
        <form action="{{ route('admin.payment-methods.update', $paymentMethod) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Payment Type -->
            <div class="mb-6">
                <label class="block text-sm font-bold text-neutral-700 mb-2">Tipe Pembayaran *</label>
                <select name="type" id="paymentType" required
                    class="w-full px-4 py-3 border-2 border-neutral-200 rounded-lg focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition">
                    <option value="bank_transfer" {{ $paymentMethod->type == 'bank_transfer' ? 'selected' : '' }}>💳 Transfer Bank</option>
                    <option value="e_wallet" {{ $paymentMethod->type == 'e_wallet' ? 'selected' : '' }}>📱 E-Wallet / QRIS</option>
                    <option value="cod" {{ $paymentMethod->type == 'cod' ? 'selected' : '' }}>💵 Bayar di Tempat (COD)</option>
                </select>
            </div>

            <!-- Method Name -->
            <div class="mb-6">
                <label class="block text-sm font-bold text-neutral-700 mb-2">Nama Metode *</label>
                <input type="text" name="method_name" value="{{ old('method_name', $paymentMethod->method_name) }}" required
                    class="w-full px-4 py-3 border-2 border-neutral-200 rounded-lg focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition">
            </div>

            <!-- Account Info -->
            <div class="mb-6" id="accountInfoField">
                <label class="block text-sm font-bold text-neutral-700 mb-2">Info Akun <span class="text-neutral-400">(Opsional)</span></label>
                <input type="text" name="account_info" value="{{ old('account_info', $paymentMethod->account_info) }}"
                    class="w-full px-4 py-3 border-2 border-neutral-200 rounded-lg focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition">
            </div>

            <!-- Account Name -->
            <div class="mb-6" id="accountNameField">
                <label class="block text-sm font-bold text-neutral-700 mb-2">Atas Nama <span class="text-neutral-400">(Opsional)</span></label>
                <input type="text" name="account_name" value="{{ old('account_name', $paymentMethod->account_name) }}"
                    class="w-full px-4 py-3 border-2 border-neutral-200 rounded-lg focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition">
            </div>

            <!-- QR Image Upload -->
            <div class="mb-6 {{ $paymentMethod->type == 'e_wallet' ? '' : 'hidden' }}" id="qrImageField">
                <label class="block text-sm font-bold text-neutral-700 mb-2">Upload QR Code <span class="text-neutral-400">(Opsional)</span></label>
                
                @if($paymentMethod->qr_image)
                    <div class="mb-3">
                        <img src="{{ asset('storage/' . $paymentMethod->qr_image) }}" class="max-w-xs rounded-lg border-2 border-neutral-200">
                        <p class="text-xs text-neutral-500 mt-1">QR Code saat ini</p>
                    </div>
                @endif
                
                <div class="border-2 border-dashed border-neutral-300 rounded-lg p-6 text-center hover:border-orange-500 transition">
                    <input type="file" name="qr_image" id="qrImageInput" accept="image/*" class="hidden">
                    <label for="qrImageInput" class="cursor-pointer">
                        <div class="text-orange-600 mb-2">
                            <svg class="w-12 h-12 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                            </svg>
                        </div>
                        <p class="text-sm text-neutral-600 font-medium">Klik untuk {{ $paymentMethod->qr_image ? 'ganti' : 'upload' }} QR Code</p>
                        <p class="text-xs text-neutral-500 mt-1">PNG, JPG hingga 2MB</p>
                    </label>
                </div>
                <div id="qrPreview" class="mt-4 hidden">
                    <img id="qrPreviewImage" class="max-w-xs mx-auto rounded-lg border-2 border-neutral-200">
                </div>
            </div>

            <!-- Instructions -->
            <div class="mb-6">
                <label class="block text-sm font-bold text-neutral-700 mb-2">Instruksi Pembayaran <span class="text-neutral-400">(Opsional)</span></label>
                <textarea name="instructions" rows="4"
                    class="w-full px-4 py-3 border-2 border-neutral-200 rounded-lg focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition">{{ old('instructions', $paymentMethod->instructions) }}</textarea>
            </div>

            <!-- Active Status -->
            <div class="mb-6">
                <label class="flex items-center p-4 bg-orange-50 border-2 border-orange-200 rounded-lg cursor-pointer hover:bg-orange-100 transition">
                    <input type="checkbox" name="is_active" value="1" {{ $paymentMethod->is_active ? 'checked' : '' }} class="w-5 h-5 text-orange-600 rounded">
                    <span class="ml-3 text-sm font-bold text-neutral-800">✓ Aktifkan metode pembayaran ini</span>
                </label>
            </div>

            <!-- Action Buttons -->
            <div class="flex gap-3">
                <a href="{{ route('admin.payment-methods.index') }}" class="px-6 py-3 border-2 border-neutral-300 rounded-lg text-neutral-700 hover:bg-neutral-50 font-bold transition">
                    Batal
                </a>
                <button type="submit" class="flex-1 bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white py-3 rounded-lg font-bold shadow-md hover:shadow-lg transition">
                    💾 Update Metode Pembayaran
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Payment type change handler
document.getElementById('paymentType').addEventListener('change', function() {
    const type = this.value;
    const accountInfoField = document.getElementById('accountInfoField');
    const accountNameField = document.getElementById('accountNameField');
    const qrImageField = document.getElementById('qrImageField');
    
    if (type === 'bank_transfer') {
        accountInfoField.classList.remove('hidden');
        accountNameField.classList.remove('hidden');
        qrImageField.classList.add('hidden');
    } else if (type === 'e_wallet') {
        accountInfoField.classList.remove('hidden');
        accountNameField.classList.remove('hidden');
        qrImageField.classList.remove('hidden');
    } else if (type === 'cod') {
        accountInfoField.classList.add('hidden');
        accountNameField.classList.add('hidden');
        qrImageField.classList.add('hidden');
    }
});

// QR Image preview
document.getElementById('qrImageInput').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('qrPreviewImage').src = e.target.result;
            document.getElementById('qrPreview').classList.remove('hidden');
        };
        reader.readAsDataURL(file);
    }
});

// Initialize visibility based on current type
window.addEventListener('DOMContentLoaded', function() {
    document.getElementById('paymentType').dispatchEvent(new Event('change'));
});
</script>
@endsection
