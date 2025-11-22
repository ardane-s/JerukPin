@extends('layouts.app')

@section('title', 'Syarat dan Ketentuan')

@section('content')
<div class="bg-neutral-50 min-h-screen py-12">
    <div class="max-w-4xl mx-auto px-4">
        <div class="bg-white rounded-2xl shadow-lg p-8">
            <h1 class="text-3xl font-bold text-neutral-900 mb-6">📋 Syarat dan Ketentuan</h1>
            <p class="text-sm text-neutral-600 mb-8">Terakhir diperbarui: {{ date('d F Y') }}</p>

            <div class="prose max-w-none space-y-6">
                <section>
                    <h2 class="text-2xl font-bold text-neutral-900 mb-3">1. Penerimaan Syarat</h2>
                    <p class="text-neutral-700">
                        Dengan mengakses dan menggunakan website JerukPin, Anda setuju untuk terikat dengan syarat dan 
                        ketentuan ini. Jika Anda tidak setuju, mohon jangan gunakan layanan kami.
                    </p>
                </section>

                <section>
                    <h2 class="text-2xl font-bold text-neutral-900 mb-3">2. Akun Pengguna</h2>
                    <ul class="list-disc pl-6 text-neutral-700 space-y-2">
                        <li>Anda bertanggung jawab untuk menjaga kerahasiaan akun dan password Anda</li>
                        <li>Anda harus memberikan informasi yang akurat dan terkini</li>
                        <li>Anda tidak boleh membagikan akun Anda dengan orang lain</li>
                        <li>Kami berhak menutup akun yang melanggar ketentuan</li>
                    </ul>
                </section>

                <section>
                    <h2 class="text-2xl font-bold text-neutral-900 mb-3">3. Pemesanan dan Pembayaran</h2>
                    <ul class="list-disc pl-6 text-neutral-700 space-y-2">
                        <li>Semua harga dalam Rupiah (IDR) dan sudah termasuk PPN</li>
                        <li>Harga dapat berubah sewaktu-waktu tanpa pemberitahuan</li>
                        <li>Pembayaran harus dilakukan dalam 24 jam setelah pemesanan</li>
                        <li>Pesanan akan diproses setelah pembayaran dikonfirmasi</li>
                        <li>Kami berhak membatalkan pesanan jika terjadi kesalahan harga</li>
                    </ul>
                </section>

                <section>
                    <h2 class="text-2xl font-bold text-neutral-900 mb-3">4. Pengiriman</h2>
                    <ul class="list-disc pl-6 text-neutral-700 space-y-2">
                        <li>Estimasi waktu pengiriman adalah 2-5 hari kerja</li>
                        <li>Biaya pengiriman bervariasi tergantung lokasi</li>
                        <li>Kami tidak bertanggung jawab atas keterlambatan di luar kendali kami</li>
                        <li>Pastikan alamat pengiriman sudah benar sebelum checkout</li>
                    </ul>
                </section>

                <section>
                    <h2 class="text-2xl font-bold text-neutral-900 mb-3">5. Kebijakan Pengembalian</h2>
                    <ul class="list-disc pl-6 text-neutral-700 space-y-2">
                        <li>Produk dapat dikembalikan dalam 3 hari jika ada kerusakan</li>
                        <li>Foto/video unboxing diperlukan untuk klaim kerusakan</li>
                        <li>Produk harus dalam kondisi asli dan tidak rusak</li>
                        <li>Biaya pengiriman pengembalian ditanggung pembeli (kecuali kesalahan kami)</li>
                        <li>Pengembalian dana diproses dalam 7-14 hari kerja</li>
                    </ul>
                </section>

                <section>
                    <h2 class="text-2xl font-bold text-neutral-900 mb-3">6. Garansi Produk</h2>
                    <p class="text-neutral-700">
                        Kami menjamin kesegaran produk kami. Jika produk tidak segar saat diterima, kami akan 
                        mengganti atau mengembalikan dana 100%.
                    </p>
                </section>

                <section>
                    <h2 class="text-2xl font-bold text-neutral-900 mb-3">7. Batasan Tanggung Jawab</h2>
                    <p class="text-neutral-700">
                        JerukPin tidak bertanggung jawab atas kerugian tidak langsung, khusus, atau konsekuensial 
                        yang timbul dari penggunaan layanan kami.
                    </p>
                </section>

                <section>
                    <h2 class="text-2xl font-bold text-neutral-900 mb-3">8. Hak Kekayaan Intelektual</h2>
                    <p class="text-neutral-700">
                        Semua konten di website ini (teks, gambar, logo, dll) adalah milik JerukPin dan dilindungi 
                        oleh hukum hak cipta. Penggunaan tanpa izin dilarang.
                    </p>
                </section>

                <section>
                    <h2 class="text-2xl font-bold text-neutral-900 mb-3">9. Perubahan Syarat</h2>
                    <p class="text-neutral-700">
                        Kami berhak mengubah syarat dan ketentuan ini kapan saja. Perubahan akan berlaku segera 
                        setelah dipublikasikan di website.
                    </p>
                </section>

                <section>
                    <h2 class="text-2xl font-bold text-neutral-900 mb-3">10. Hukum yang Berlaku</h2>
                    <p class="text-neutral-700">
                        Syarat dan ketentuan ini diatur oleh hukum Republik Indonesia. Setiap sengketa akan 
                        diselesaikan di pengadilan Jakarta Selatan.
                    </p>
                </section>

                <section>
                    <h2 class="text-2xl font-bold text-neutral-900 mb-3">11. Kontak</h2>
                    <p class="text-neutral-700">
                        Untuk pertanyaan tentang syarat dan ketentuan, hubungi:
                    </p>
                    <div class="bg-orange-50 rounded-lg p-4 mt-3">
                        <p class="font-semibold">Email: legal@jerukpin.com</p>
                        <p class="font-semibold">Telepon: +62 812-3456-7890</p>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>
@endsection
