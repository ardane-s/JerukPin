<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\ProductImage;
use App\Models\PaymentMethod;
use App\Models\Setting;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class RealJerukPinSeeder extends Seeder
{
    public function run(): void
    {
        // Clear all existing data
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        ProductImage::truncate();
        ProductVariant::truncate();
        Product::truncate();
        Category::truncate();
        DB::table('cart_items')->truncate();
        DB::table('order_items')->truncate();
        DB::table('orders')->truncate();
        DB::table('flash_sales')->truncate();
        PaymentMethod::truncate();
        Setting::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        // Ensure admin exists
        User::firstOrCreate(
            ['email' => 'jerukpin@gmail.com'],
            [
                'name' => 'Admin JerukPin',
                'phone' => '081234567890',
                'password' => Hash::make('Jerukjerukjerukpin!'),
                'role' => 'super_admin',
            ]
        );

        // Create Categories with Rich Descriptions
        $categories = [
            [
                'name' => 'Es Jeruk Lokal',
                'slug' => 'es-jeruk-lokal',
                'description' => 'Kesegaran otentik dari kebun nusantara. Jeruk lokal pilihan dengan karakter rasa manis-asam yang khas, membangkitkan semangat di setiap tegukan.',
                'image' => 'categories/es-jeruk-lokal.png'
            ],
            [
                'name' => 'Es Jeruk Sunkist',
                'slug' => 'es-jeruk-sunkist',
                'description' => 'Kemewahan rasa jeruk premium. Sunkist impor dengan bulir bulir segar yang meletup di mulut, menghadirkan sensasi manis yang elegan dan menyegarkan.',
                'image' => 'categories/es-jeruk-sunkist.png'
            ],
            [
                'name' => 'Es Lemon',
                'slug' => 'es-lemon',
                'description' => 'Ledakan vitamin C yang menyegarkan. Lemon segar pilihan yang diperas sempurna, memberikan sensasi "zing" yang membersihkan dahaga seketika.',
                'image' => 'categories/es-lemon.png'
            ],
        ];

        foreach ($categories as $categoryData) {
            // Handle image separately as it's not in the fillable/schema yet (we'll assume we add it or use a placeholder logic in view)
            // For now, we'll store it but the model might need updating if we want to save it in DB. 
            // Actually, let's just create the category first.
            Category::create([
                'name' => $categoryData['name'],
                'slug' => $categoryData['slug'],
                'description' => $categoryData['description'],
                'image' => $categoryData['image'],
            ]);
        }

        // Product Data - Professional E-Commerce Gen-Z Style
        $productsData = [
            // Es Jeruk Lokal
            [
                'category' => 'Es Jeruk Lokal',
                'name' => 'Es Jeruk Original',
                'price' => 5000,
                'description' => "Minuman segar yang udah jadi favorit banyak orang! 🍊 Es Jeruk Original dibuat dari 100% jeruk lokal Pontianak pilihan yang dipetik saat matang sempurna. Tanpa pengawet dan pemanis buatan berlebihan.\n\nRasa manis dan asamnya pas banget di lidah, super refreshing especially pas cuaca lagi panas! Es batu yang crispy bikin sensasi dinginnya lebih terasa. Cocok buat kamu yang suka kesederhanaan tapi tetep pengen rasa yang natural dan enak.\n\nPerfect untuk menemani aktivitas sehari-hari atau sekadar bersantai. Dijamin bikin seger! ✨",
                'images' => ['es-jeruk-original-1.png', 'es-jeruk-original-2.png', 'es-jeruk-original-3.png', 'es-jeruk-original-4.png', 'es-jeruk-original-5.png']
            ],
            [
                'category' => 'Es Jeruk Lokal',
                'name' => 'Es Jeruk Susu',
                'price' => 7000,
                'description' => "Perpaduan unik yang lagi hits! 🧡 Es Jeruk Susu menggabungkan kesegaran jeruk lokal dengan kelembutan susu kental manis premium. Warnanya yang cantik dengan gradasi orange-white bikin tampilannya aesthetic banget!\n\nRasanya creamy tapi tetep fresh, manis tapi ada sedikit kick asem yang bikin ga eneg. Teksturnya smooth dan rich, seperti minum dessert cair yang menyegarkan. Recommended banget buat kamu yang suka minuman dengan rasa yang playful dan Instagram-worthy!\n\nCocok dinikmati kapan aja, dari pagi sampe malam. Pasti jadi favoritmu! 💯",
                'images' => ['es-jeruk-susu-1.png', 'es-jeruk-susu-2.png', 'es-jeruk-susu-3.png', 'es-jeruk-susu-4.png', 'es-jeruk-susu-5.png']
            ],
            [
                'category' => 'Es Jeruk Lokal',
                'name' => 'Es Jeruk Madu',
                'price' => 7000,
                'description' => "Pilihan sehat yang tetep enak! 🍯 Es Jeruk Madu memadukan vitamin C dari jeruk segar dengan manfaat madu hutan asli. Kombinasi yang pas untuk kamu yang peduli kesehatan tapi ga mau kompromi soal rasa.\n\nManis alami dari madu menyempurnakan keasaman jeruk, menciptakan harmoni rasa yang unik dengan aroma floral yang menenangkan. Bukan cuma menyegarkan, tapi juga baik untuk daya tahan tubuh!\n\nIdeal untuk boost energi alami di tengah aktivitas padat. Natural, sehat, dan pastinya enak! 💪🌿",
                'images' => ['es-jeruk-madu-1.png', 'es-jeruk-madu-2.png', 'es-jeruk-madu-3.png', 'es-jeruk-madu-4.png', 'es-jeruk-madu-5.png']
            ],
            
            // Es Jeruk Sunkist
            [
                'category' => 'Es Jeruk Sunkist',
                'name' => 'Es Sunkist Original',
                'price' => 7000,
                'description' => "Experience premium refreshment! 💎 Es Sunkist Original menggunakan jeruk Sunkist import pilihan yang terkenal dengan warna orange cerah dan aroma khas yang menggugah selera.\n\nKarakter rasanya yang lebih manis dan aromatic memberikan pengalaman minum yang beda dari jeruk biasa. Ringan di perut tapi kaya rasa, dengan aftertaste yang clean dan menyegarkan. Zero guilty feeling!\n\nBuat kamu yang appreciate kualitas premium dan rasa yang sophisticated. Worth every sip! ⭐",
                'images' => ['es-sunkist-original-1.png', 'es-sunkist-original-2.png', 'es-sunkist-original-3.png', 'es-sunkist-original-4.png', 'es-sunkist-original-5.png']
            ],
            [
                'category' => 'Es Jeruk Sunkist',
                'name' => 'Es Sunkist Susu',
                'price' => 8000,
                'description' => "Minuman aesthetic yang super Instagram-worthy! 📸 Es Sunkist Susu hadir dengan warna pastel orange yang cantik banget, hasil perpaduan Sunkist import premium dengan susu creamy berkualitas.\n\nRasanya? Absolutely delicious! Manisnya Sunkist yang natural berpadu sempurna dengan susu, menciptakan taste experience seperti creamsicle premium. Smooth, creamy, dan tetep refreshing!\n\nPerfect choice buat kamu yang suka minuman yang enak dan tampilannya juga on point. Foto dulu, baru minum! 🎀",
                'images' => ['es-sunkist-susu-1.png', 'es-sunkist-susu-2.png', 'es-sunkist-susu-3.png', 'es-sunkist-susu-4.png', 'es-sunkist-susu-5.png']
            ],
            [
                'category' => 'Es Jeruk Sunkist',
                'name' => 'Es Sunkist Madu',
                'price' => 8000,
                'description' => "Luxury in a cup! ✨ Es Sunkist Madu menggabungkan jeruk Sunkist premium dengan madu murni berkualitas tinggi. Warna keemasannya yang glowing mencerminkan kualitas ingredients yang digunakan.\n\nRasa manis madu yang rich mengangkat citrus aroma dari Sunkist ke level berikutnya. Sangat smooth di tenggorokan dan memberikan sensasi relaksasi yang menenangkan. Premium quality you can taste!\n\nTreat yourself after a long day! Kamu deserve the best. Minuman ini perfect untuk me-time yang berkualitas. 👑",
                'images' => ['es-sunkist-madu-1.png', 'es-sunkist-madu-2.png', 'es-sunkist-madu-3.png', 'es-sunkist-madu-4.png', 'es-sunkist-madu-5.png']
            ],
            
            // Es Lemon
            [
                'category' => 'Es Lemon',
                'name' => 'Es Lemon Original',
                'price' => 7000,
                'description' => "Instant energy booster! ⚡ Es Lemon Original adalah solusi terbaik untuk mengusir rasa kantuk dan refresh pikiran. Dibuat dari fresh-pressed lemon dengan kandungan vitamin C tinggi.\n\nRasa asamnya yang kuat tapi balanced bikin senses langsung aktif! Tajam, bersih, dan instantly refreshing tanpa rasa pahit. Seperti natural energy drink yang sehat dan menyegarkan.\n\nPerfect companion saat lagi butuh extra boost atau cuaca lagi terik banget. One sip = instant refresh! 🔋",
                'images' => ['es-lemon-original-1.png', 'es-lemon-original-2.png', 'es-lemon-original-3.png', 'es-lemon-original-4.png', 'es-lemon-original-5.png']
            ],
            [
                'category' => 'Es Lemon',
                'name' => 'Es Lemon Susu',
                'price' => 8000,
                'description' => "Unexpected combination that works! 💛 Lemon dan susu mungkin terdengar unusual, tapi trust us - kombinasi ini surprisingly delicious! Tekstur dan rasanya unik banget, mirip yogurt drink atau lemon cheesecake versi minuman.\n\nKeasaman lemon yang di-balance dengan creamy susu menciptakan flavor profile yang rich tapi tetep refreshing. Definitely a must-try untuk kamu yang suka eksperimen dengan rasa baru!\n\nBuat adventurous souls yang ga takut nyobain hal baru. Dijamin ga nyesel! 🌟",
                'images' => ['es-lemon-susu-1.png', 'es-lemon-susu-2.png', 'es-lemon-susu-3.png', 'es-lemon-susu-4.png', 'es-lemon-susu-5.png']
            ],
            [
                'category' => 'Es Lemon',
                'name' => 'Es Lemon Madu',
                'price' => 8000,
                'description' => "Classic wellness drink with a twist! 🍯 Honey Lemon adalah resep tradisional yang sudah terbukti manfaatnya, sekarang disajikan dingin dan super refreshing. Loaded dengan antioksidan dan nutrisi alami.\n\nPerpaduan lemon yang kaya vitamin C dengan madu yang penuh manfaat kesehatan, menciptakan minuman detox yang actually enak! Balance sempurna antara sour dan sweet.\n\nHealthy choice yang ga compromise soal rasa. Bikin badan berasa lebih ringan dan segar! Good for body, good for soul. 💚",
                'images' => ['es-lemon-madu-1.png', 'es-lemon-madu-2.png', 'es-lemon-madu-3.png', 'es-lemon-madu-4.png', 'es-lemon-madu-5.png']
            ],
        ];

        foreach ($productsData as $productData) {
            $category = Category::where('name', $productData['category'])->first();
            
            $product = Product::create([
                'category_id' => $category->id,
                'name' => $productData['name'],
                'slug' => \Illuminate\Support\Str::slug($productData['name']),
                'description' => $productData['description'],
                'is_active' => true,
            ]);

            // Create variants
            $variants = [
                ['name' => 'Regular', 'price' => $productData['price'], 'stock' => 100],
                ['name' => 'Dengan Nata de Coco', 'price' => $productData['price'] + 1000, 'stock' => 100]
            ];

            foreach ($variants as $variantData) {
                ProductVariant::create([
                    'product_id' => $product->id,
                    'variant_name' => $variantData['name'],
                    'price' => $variantData['price'],
                    'stock' => $variantData['stock'],
                    'sku' => 'JP-' . str_pad($product->id, 3, '0', STR_PAD_LEFT) . '-' . ($variantData['name'] === 'Regular' ? 'REG' : 'NATA'),
                ]);
            }

            // Create Multiple Images
            foreach ($productData['images'] as $index => $imagePath) {
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => 'products/' . $imagePath,
                    'is_primary' => $index === 0, // First image is primary
                    'sort_order' => $index,
                ]);
            }
        }

        // Seed Payment Methods
        PaymentMethod::create([
            'type' => 'bank_transfer',
            'method_name' => 'BCA',
            'account_info' => '1234567890',
            'account_name' => 'PT JerukPin Indonesia',
            'instructions' => 'Transfer ke rekening BCA di atas, lalu upload bukti transfer pada halaman pembayaran.',
            'is_active' => true,
            'sort_order' => 1,
        ]);

        PaymentMethod::create([
            'type' => 'bank_transfer',
            'method_name' => 'Mandiri',
            'account_info' => '9876543210',
            'account_name' => 'PT JerukPin Indonesia',
            'instructions' => 'Transfer ke rekening Mandiri di atas, lalu upload bukti transfer pada halaman pembayaran.',
            'is_active' => true,
            'sort_order' => 2,
        ]);

        PaymentMethod::create([
            'type' => 'e_wallet',
            'method_name' => 'GoPay',
            'account_info' => '08123456789',
            'account_name' => 'Toko JerukPin',
            'instructions' => 'Transfer ke nomor GoPay di atas, lalu screenshot bukti pembayaran dan upload pada halaman pembayaran.',
            'is_active' => true,
            'sort_order' => 3,
        ]);

        PaymentMethod::create([
            'type' => 'cod',
            'method_name' => 'Cash on Delivery',
            'instructions' => 'Bayar dengan uang tunai saat barang diterima. Siapkan uang pas untuk mempermudah transaksi.',
            'is_active' => true,
            'sort_order' => 4,
        ]);

        // Seed Settings
        Setting::create([
            'key' => 'shipping_cost',
            'value' => '10000',
            'type' => 'integer',
        ]);

        Setting::create([
            'key' => 'free_shipping_threshold',
            'value' => '50000',
            'type' => 'integer',
        ]);
    }
}
