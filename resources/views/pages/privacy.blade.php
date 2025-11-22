@extends('layouts.app')

@section('title', 'Kebijakan Privasi')

@section('content')
<div class="bg-neutral-50 min-h-screen py-12">
    <div class="max-w-4xl mx-auto px-4">
        <div class="bg-white rounded-2xl shadow-lg p-8">
            <h1 class="text-3xl font-bold text-neutral-900 mb-6">🔒 Kebijakan Privasi</h1>
            <p class="text-sm text-neutral-600 mb-8">Terakhir diperbarui: {{ date('d F Y') }}</p>

            <div class="prose max-w-none space-y-6">
                <section>
                    <h2 class="text-2xl font-bold text-neutral-900 mb-3">1. Informasi yang Kami Kumpulkan</h2>
                    <p class="text-neutral-700">Kami mengumpulkan informasi yang Anda berikan secara langsung, termasuk:</p>
                    <ul class="list-disc pl-6 text-neutral-700 space-y-1">
                        <li>Nama lengkap</li>
                        <li>Alamat email</li>
                        <li>Nomor telepon</li>
                        <li>Alamat pengiriman</li>
                        <li>Informasi pembayaran</li>
                    </ul>
                </section>

                <section>
                    <h2 class="text-2xl font-bold text-neutral-900 mb-3">2. Penggunaan Informasi</h2>
                    <p class="text-neutral-700">Kami menggunakan informasi Anda untuk:</p>
                    <ul class="list-disc pl-6 text-neutral-700 space-y-1">
                        <li>Memproses dan mengirimkan pesanan Anda</li>
                        <li>Mengirim konfirmasi dan update pesanan</li>
                        <li>Merespons pertanyaan dan permintaan Anda</li>
                        <li>Mengirim promosi dan penawaran (dengan persetujuan Anda)</li>
                        <li>Meningkatkan layanan kami</li>
                    </ul>
                </section>

                <section>
                    <h2 class="text-2xl font-bold text-neutral-900 mb-3">3. Keamanan Data</h2>
                    <p class="text-neutral-700">
                        Kami menerapkan langkah-langkah keamanan yang sesuai untuk melindungi informasi pribadi Anda 
                        dari akses, penggunaan, atau pengungkapan yang tidak sah. Data Anda dienkripsi dan disimpan 
                        dengan aman di server terpercaya.
                    </p>
                </section>

                <section>
                    <h2 class="text-2xl font-bold text-neutral-900 mb-3">4. Berbagi Informasi</h2>
                    <p class="text-neutral-700">
                        Kami tidak akan menjual, menyewakan, atau membagikan informasi pribadi Anda kepada pihak 
                        ketiga kecuali:
                    </p>
                    <ul class="list-disc pl-6 text-neutral-700 space-y-1">
                        <li>Untuk memproses pembayaran (gateway pembayaran)</li>
                        <li>Untuk pengiriman produk (jasa kurir)</li>
                        <li>Jika diwajibkan oleh hukum</li>
                        <li>Dengan persetujuan eksplisit dari Anda</li>
                    </ul>
                </section>

                <section>
                    <h2 class="text-2xl font-bold text-neutral-900 mb-3">5. Cookies</h2>
                    <p class="text-neutral-700">
                        Kami menggunakan cookies untuk meningkatkan pengalaman Anda di website kami. Cookies membantu 
                        kami mengingat preferensi Anda dan menganalisis traffic website. Anda dapat menonaktifkan 
                        cookies melalui pengaturan browser Anda.
                    </p>
                </section>

                <section>
                    <h2 class="text-2xl font-bold text-neutral-900 mb-3">6. Hak Anda</h2>
                    <p class="text-neutral-700">Anda memiliki hak untuk:</p>
                    <ul class="list-disc pl-6 text-neutral-700 space-y-1">
                        <li>Mengakses data pribadi Anda</li>
                        <li>Memperbaiki data yang tidak akurat</li>
                        <li>Menghapus data Anda</li>
                        <li>Menolak penggunaan data untuk marketing</li>
                        <li>Meminta salinan data Anda</li>
                    </ul>
                </section>

                <section>
                    <h2 class="text-2xl font-bold text-neutral-900 mb-3">7. Perubahan Kebijakan</h2>
                    <p class="text-neutral-700">
                        Kami dapat memperbarui kebijakan privasi ini dari waktu ke waktu. Kami akan memberitahu Anda 
                        tentang perubahan signifikan melalui email atau pemberitahuan di website.
                    </p>
                </section>

                <section>
                    <h2 class="text-2xl font-bold text-neutral-900 mb-3">8. Hubungi Kami</h2>
                    <p class="text-neutral-700">
                        Jika Anda memiliki pertanyaan tentang kebijakan privasi ini, silakan hubungi kami di:
                    </p>
                    <div class="bg-orange-50 rounded-lg p-4 mt-3">
                        <p class="font-semibold">Email: info@jerukpin.com</p>
                        <p class="font-semibold">Telepon: +62 812-3456-7890</p>
                        <p class="font-semibold">Alamat: Jl. Jeruk Manis No. 123, Jakarta Selatan</p>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>
@endsection
