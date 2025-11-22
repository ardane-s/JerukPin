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
        
        // Keep users but clear carts and orders if needed
        DB::table('cart_items')->truncate();
        DB::table('order_items')->truncate();
        DB::table('orders')->truncate();
        DB::table('flash_sales')->truncate();
        
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Ensure admin exists
        $admin = User::firstOrCreate(
            ['email' => 'admin@jerukpin.com'],
            [
                'name' => 'Admin JerukPin',
                'phone' => '081234567890',
                'password' => Hash::make('admin123'),
                'role' => 'super_admin',
            ]
        );

        // Create Categories
        $categories = [
            [
                'name' => 'Es Jeruk Lokal',
                'slug' => 'es-jeruk-lokal',
                'description' => 'Minuman segar dari jeruk lokal pilihan',
            ],
            [
                'name' => 'Es Jeruk Sunkist',
                'slug' => 'es-jeruk-sunkist',
                'description' => 'Minuman segar dari jeruk sunkist premium',
            ],
            [
                'name' => 'Es Lemon',
                'slug' => 'es-lemon',
                'description' => 'Minuman segar dari lemon asli',
            ],
        ];

        foreach ($categories as $categoryData) {
            Category::create($categoryData);
        }

        // Product data with real menu
        $productsData = [
            // Es Jeruk Lokal
            [
                'category' => 'Es Jeruk Lokal',
                'name' => 'Es Jeruk Original',
                'price' => 5000,
                'description' => 'Es jeruk lokal segar tanpa campuran, rasakan keaslian jeruk lokal pilihan',
                'emoji' => '🍊'
            ],
            [
                'category' => 'Es Jeruk Lokal',
                'name' => 'Es Jeruk Susu',
                'price' => 7000,
                'description' => 'Perpaduan sempurna jeruk lokal segar dengan susu, creamy dan menyegarkan',
                'emoji' => '🥛'
            ],
            [
                'category' => 'Es Jeruk Lokal',
                'name' => 'Es Jeruk Madu',
                'price' => 7000,
                'description' => 'Es jeruk lokal dengan sentuhan madu alami, manis dan segar',
                'emoji' => '🍯'
            ],
            
            // Es Jeruk Sunkist
            [
                'category' => 'Es Jeruk Sunkist',
                'name' => 'Es Sunkist Original',
                'price' => 7000,
                'description' => 'Es jeruk sunkist premium murni, rasa jeruk yang lebih kaya dan segar',
                'emoji' => '🧃'
            ],
            [
                'category' => 'Es Jeruk Sunkist',
                'name' => 'Es Sunkist Susu',
                'price' => 8000,
                'description' => 'Kombinasi istimewa jeruk sunkist premium dengan susu, kenikmatan berlapis',
                'emoji' => '🥛'
            ],
            [
                'category' => 'Es Jeruk Sunkist',
                'name' => 'Es Sunkist Madu',
                'price' => 8000,
                'description' => 'Jeruk sunkist premium dipermanis dengan madu pilihan, segar dan sehat',
                'emoji' => '🍯'
            ],
            
            // Es Lemon
            [
                'category' => 'Es Lemon',
                'name' => 'Es Lemon Original',
                'price' => 7000,
                'description' => 'Es lemon asli yang segar, sempurna untuk menghilangkan dahaga',
                'emoji' => '🍋'
            ],
            [
                'category' => 'Es Lemon',
                'name' => 'Es Lemon Susu',
                'price' => 8000,
                'description' => 'Kesegaran lemon bertemu kelembutan susu, sensasi unik yang memanjakan',
                'emoji' => '🥛'
            ],
            [
                'category' => 'Es Lemon',
                'name' => 'Es Lemon Madu',
                'price' => 8000,
                'description' => 'Lemon segar dengan madu alami, kombinasi vitamin C dan manfaat madu',
                'emoji' => '🍯'
            ],
        ];

        foreach ($productsData as $index => $productData) {
            $category = Category::where('name', $productData['category'])->first();
            
            $product = Product::create([
                'category_id' => $category->id,
                'name' => $productData['name'],
                'slug' => \Illuminate\Support\Str::slug($productData['name']),
                'description' => $productData['description'],
                'is_active' => true,
            ]);

            // Create variants: Regular and with Nata de Coco
            $variants = [
                [
                    'name' => 'Regular',
                    'price' => $productData['price'],
                    'stock' => 100
                ],
                [
                    'name' => 'Dengan Nata de Coco',
                    'price' => $productData['price'] + 1000, // +1k for topping
                    'stock' => 100
                ]
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

            // Create product image placeholder
            ProductImage::create([
                'product_id' => $product->id,
                'image_path' => 'products/placeholder-drink.jpg', // We'll generate these
                'is_primary' => true,
            ]);
        }

        $this->command->info('✅ Real JerukPin menu data seeded successfully!');
        $this->command->info('📊 Created:');
        $this->command->info('   - 3 categories');
        $this->command->info('   - 9 products');
        $this->command->info('   - 18 variants (each with Regular and Nata de Coco option)');
    }
}
