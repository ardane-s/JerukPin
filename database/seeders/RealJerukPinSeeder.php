<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\ProductImage;
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
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Ensure admin exists
        User::firstOrCreate(
            ['email' => 'admin@jerukpin.com'],
            [
                'name' => 'Admin JerukPin',
                'phone' => '081234567890',
                'password' => Hash::make('admin123'),
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

        // Product Data with "Human-Made-Inspiration" Descriptions
        $productsData = [
            // Es Jeruk Lokal
            [
                'category' => 'Es Jeruk Lokal',
                'name' => 'Es Jeruk Original',
                'price' => 5000,
                'description' => "Kembali ke kesederhanaan yang sempurna. Es Jeruk Original kami dibuat dari 100% jeruk peras lokal Pontianak yang dipetik saat kematangan puncak. Tanpa pemanis buatan yang berlebihan, kami membiarkan rasa manis alami dan sedikit asam segar dari jeruk berbicara. \n\nSetiap gelas adalah penghormatan terhadap kekayaan alam Indonesia. Disajikan dingin dengan es kristal, minuman ini adalah jawaban paling jujur untuk dahaga Anda di siang hari yang terik. Rasakan bulir-bulir jeruk asli yang menari di lidah Anda.",
                'images' => ['es-jeruk-original-1.png', 'es-jeruk-original-2.png', 'es-jeruk-original-3.png']
            ],
            [
                'category' => 'Es Jeruk Lokal',
                'name' => 'Es Jeruk Susu',
                'price' => 7000,
                'description' => "Sebuah pelukan hangat dalam bentuk minuman dingin. Es Jeruk Susu menggabungkan ketajaman rasa jeruk lokal dengan kelembutan susu kental manis yang creamy. \n\nPerpaduan warna oranye dan putih yang cantik menciptakan gradasi rasa yang unik: segar namun lembut, asam namun manis. Teksturnya yang rich membuat minuman ini bukan sekadar pelepas dahaga, tapi juga 'dessert' cair yang memanjakan. Cocok untuk Anda yang menyukai keseimbangan rasa yang playful.",
                'images' => ['es-jeruk-susu-1.png', 'es-jeruk-susu-2.png', 'es-jeruk-susu-3.png']
            ],
            [
                'category' => 'Es Jeruk Lokal',
                'name' => 'Es Jeruk Madu',
                'price' => 7000,
                'description' => "Kesehatan dan kesegaran dalam satu gelas. Kami memadukan sari jeruk murni dengan madu hutan alami berkualitas tinggi. \n\nRasa manis madu yang khas melengkapi keasaman jeruk dengan sangat elegan, menciptakan aroma floral yang menenangkan saat diminum. Ini adalah pilihan tepat bagi Anda yang peduli kesehatan namun tidak ingin mengorbankan rasa. 'Booster' energi alami yang menyegarkan tubuh dan pikiran.",
                'images' => ['es-jeruk-madu-1.png', 'es-jeruk-madu-2.png', 'es-jeruk-madu-3.png']
            ],
            
            // Es Jeruk Sunkist
            [
                'category' => 'Es Jeruk Sunkist',
                'name' => 'Es Sunkist Original',
                'price' => 7000,
                'description' => "Definisi kesegaran premium. Menggunakan jeruk Sunkist pilihan dengan warna oranye cerah yang menggoda. \n\nKarakter rasa Sunkist yang lebih manis dan aromatik memberikan pengalaman minum yang berbeda. Air jeruknya terasa lebih ringan namun kaya rasa, dengan aftertaste yang bersih dan menyegarkan. Disajikan murni untuk Anda yang mengapresiasi kualitas buah impor terbaik.",
                'images' => ['es-sunkist-original-1.png', 'es-sunkist-original-2.png', 'es-sunkist-original-3.png']
            ],
            [
                'category' => 'Es Jeruk Sunkist',
                'name' => 'Es Sunkist Susu',
                'price' => 8000,
                'description' => "Elegansi dalam setiap tegukan. Jeruk Sunkist yang manis dipadukan dengan susu, menciptakan minuman berwarna oranye pastel yang cantik dan 'instagramable'. \n\nRasa Sunkist yang tidak terlalu asam membuatnya menyatu sempurna dengan susu, menghasilkan rasa seperti 'creamsicle' yang mewah. Minuman ini adalah favorit bagi mereka yang mencari kesegaran dengan sentuhan rasa yang sophisticated.",
                'images' => ['es-sunkist-susu-1.png', 'es-sunkist-susu-2.png', 'es-sunkist-susu-3.png']
            ],
            [
                'category' => 'Es Jeruk Sunkist',
                'name' => 'Es Sunkist Madu',
                'price' => 8000,
                'description' => "Simfoni rasa emas. Warna keemasan dari jeruk Sunkist bertemu dengan kilau emas madu murni. \n\nRasanya? Sebuah kemewahan. Manisnya madu mengangkat aroma citrus dari Sunkist ke level berikutnya. Minuman ini terasa sangat halus di tenggorokan, memberikan sensasi segar yang menenangkan. Pilihan sempurna untuk memanjakan diri setelah hari yang sibuk.",
                'images' => ['es-sunkist-madu-1.png', 'es-sunkist-madu-2.png', 'es-sunkist-madu-3.png']
            ],
            
            // Es Lemon
            [
                'category' => 'Es Lemon',
                'name' => 'Es Lemon Original',
                'price' => 7000,
                'description' => "The ultimate refresher. Bagi pecinta rasa asam yang 'nendang', Es Lemon Original kami adalah jawabannya. \n\nDibuat dari perasan lemon kuning segar yang kaya aroma. Rasanya tajam, bersih, dan seketika membangunkan indra Anda. Kami menyeimbangkannya dengan sedikit gula cair hanya untuk mengangkat rasa buahnya, tanpa menghilangkan karakter aslinya. Teman terbaik saat cuaca panas menyerang.",
                'images' => ['es-lemon-original-1.png', 'es-lemon-original-2.png', 'es-lemon-original-3.png']
            ],
            [
                'category' => 'Es Lemon',
                'name' => 'Es Lemon Susu',
                'price' => 8000,
                'description' => "Kejutan rasa yang menyenangkan. Siapa sangka lemon dan susu bisa berteman baik? \n\nKeasaman lemon yang kuat 'dijinakkan' oleh kelembutan susu, menciptakan rasa unik menyerupai yogurt cair atau lemon cheese cake. Rasanya creamy namun tetap memiliki 'kick' segar di akhir. Sebuah petualangan rasa yang wajib dicoba bagi Anda yang bosan dengan menu biasa.",
                'images' => ['es-lemon-susu-1.png', 'es-lemon-susu-2.png', 'es-lemon-susu-3.png']
            ],
            [
                'category' => 'Es Lemon',
                'name' => 'Es Lemon Madu',
                'price' => 8000,
                'description' => "Klasik yang menyehatkan. Honey Lemon adalah resep kuno untuk kebugaran yang kami sajikan dalam gelas dingin menyegarkan. \n\nPerpaduan lemon yang kaya antioksidan dan madu yang bernutrisi menciptakan minuman detoks yang lezat. Rasanya seimbang antara asam segar dan manis lembut. Minuman ini tidak hanya menyegarkan tenggorokan, tapi juga membuat tubuh terasa lebih bugar.",
                'images' => ['es-lemon-madu-1.png', 'es-lemon-madu-2.png', 'es-lemon-madu-3.png']
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
    }
}
