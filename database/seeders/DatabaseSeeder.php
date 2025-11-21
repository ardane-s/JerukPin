<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\ProductImage;
use App\Models\FlashSaleCampaign;
use App\Models\FlashSale;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Review;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    private $customers = [];
    private $products = [];
    private $categories = [];

    public function run(): void
    {
        echo "🚀 Starting database seeding...\n\n";

        // Step 1: Create Main Accounts
        $this->createMainAccounts();
        
        // Step 2: Create Customer Accounts
        $this->createCustomerAccounts();
        
        // Step 3: Create Categories
        $this->createCategories();
        
        // Step 4: Create Products (255+)
        $this->createAllProducts();
        
        // Step 5: Create Flash Sale Campaigns
        $this->createFlashSaleCampaigns();
        
        // Step 6: Create Orders (realistic behavior)
        $this->createRealisticOrders();
        
        // Step 7: Create Reviews
        $this->createRealisticReviews();

        echo "\n✅ Database seeding completed!\n";
        $this->printSummary();
    }

    private function createMainAccounts()
    {
        echo "👤 Creating main accounts...\n";

        User::create([
            'name' => 'Admin',
            'email' => 'jerukpin@gmail.com',
            'password' => Hash::make('Jerukjerukjerukpin!'),
            'role' => 'super_admin',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Antigravity',
            'email' => 'antigravity@gmail.com',
            'password' => Hash::make('AntigravityDev2024!'),
            'role' => 'member',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Dane',
            'email' => 'komangaris2004@gmail.com',
            'password' => Hash::make('Jerukjerukjerukpin!'),
            'role' => 'member',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Aris',
            'email' => 'komangaris2910@gmail.com',
            'password' => Hash::make('Jerukjerukjerukpin!'),
            'role' => 'member',
            'email_verified_at' => now(),
        ]);

        echo "   ✓ Created 4 main accounts\n";
    }

    private function createCustomerAccounts()
    {
        echo "👥 Creating customer accounts...\n";

        $names = [
            'Budi Santoso', 'Siti Nurhaliza', 'Ahmad Wijaya', 'Dewi Lestari', 'Rudi Hartono',
            'Maya Sari', 'Eko Prasetyo', 'Rina Kusuma', 'Agus Setiawan', 'Lina Marlina',
            'Doni Pratama', 'Fitri Handayani', 'Hendra Gunawan', 'Novi Andriani', 'Bambang Susilo',
            'Ratna Dewi', 'Yudi Permana', 'Sari Indah', 'Tono Sukirman', 'Lia Amelia',
            'Joko Widodo', 'Mega Putri', 'Andi Saputra', 'Dina Mariana', 'Fajar Nugroho'
        ];

        foreach ($names as $name) {
            $email = strtolower(str_replace(' ', '.', $name)) . '@gmail.com';
            $this->customers[] = User::create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make('password123'),
                'role' => 'member',
                'email_verified_at' => now(),
            ]);
        }

        echo "   ✓ Created " . count($this->customers) . " customer accounts\n";
    }

    private function createCategories()
    {
        echo "📁 Creating categories...\n";

        $categoriesData = [
            ['name' => 'Buah Segar', 'slug' => 'buah-segar'],
            ['name' => 'Sayuran Organik', 'slug' => 'sayuran-organik'],
            ['name' => 'Rempah & Bumbu', 'slug' => 'rempah-bumbu'],
            ['name' => 'Beras & Biji-bijian', 'slug' => 'beras-biji-bijian'],
            ['name' => 'Minyak & Saus', 'slug' => 'minyak-saus'],
            ['name' => 'Makanan Ringan', 'slug' => 'makanan-ringan'],
            ['name' => 'Minuman', 'slug' => 'minuman'],
            ['name' => 'Produk Susu', 'slug' => 'produk-susu'],
            ['name' => 'Daging & Seafood', 'slug' => 'daging-seafood'],
            ['name' => 'Frozen Food', 'slug' => 'frozen-food'],
            ['name' => 'Kue & Roti', 'slug' => 'kue-roti'],
            ['name' => 'Bumbu Instan', 'slug' => 'bumbu-instan'],
            ['name' => 'Kebutuhan Dapur', 'slug' => 'kebutuhan-dapur'],
        ];

        foreach ($categoriesData as $cat) {
            $this->categories[$cat['slug']] = Category::create([
                'name' => $cat['name'],
                'slug' => $cat['slug'],
                'description' => 'Kategori ' . $cat['name'],
                'is_active' => true,
            ]);
        }

        echo "   ✓ Created " . count($this->categories) . " categories\n";
    }

    private function createAllProducts()
    {
        echo "🍊 Creating 255+ products...\n";

        // Call ProductDataSeeder
        $this->call(ProductDataSeeder::class);

        $this->products = Product::all();
        echo "   ✓ Created " . $this->products->count() . " products\n";
    }

    private function createFlashSaleCampaigns()
    {
        echo "⚡ Creating flash sale campaigns...\n";

        // Active Campaign
        $activeCampaign = FlashSaleCampaign::create([
            'name' => 'Weekend Super Sale',
            'description' => 'Diskon besar-besaran akhir pekan! Hemat hingga 70%',
            'start_time' => now()->subHours(2),
            'end_time' => now()->addHours(22),
            'is_active' => true,
            'status' => 'active',
            'show_teaser' => false,
        ]);

        // Track used variant IDs to avoid duplicates
        $usedVariantIds = [];

        // Add 25 random products to active campaign
        $randomProducts = Product::inRandomOrder()->limit(50)->get(); // Get more to ensure we have enough
        $addedCount = 0;
        foreach ($randomProducts as $product) {
            if ($addedCount >= 25) break;
            
            $variant = $product->variants->first();
            if ($variant && !in_array($variant->id, $usedVariantIds)) {
                $usedVariantIds[] = $variant->id;
                $discount = rand(20, 70);
                $flashPrice = $variant->price * (100 - $discount) / 100;
                
                FlashSale::create([
                    'campaign_id' => $activeCampaign->id,
                    'product_variant_id' => $variant->id,
                    'original_price' => $variant->price,
                    'flash_price' => $flashPrice,
                    'discount_percentage' => $discount,
                    'flash_stock' => rand(10, 50),
                    'flash_sold' => rand(0, 15),
                    'start_time' => $activeCampaign->start_time,
                    'end_time' => $activeCampaign->end_time,
                    'is_active' => true,
                ]);
                $addedCount++;
            }
        }

        // Upcoming Campaign
        $upcomingCampaign = FlashSaleCampaign::create([
            'name' => 'Midnight Flash Sale',
            'description' => 'Flash sale spesial tengah malam! Jangan sampai kehabisan!',
            'start_time' => now()->addHours(6),
            'end_time' => now()->addHours(12),
            'is_active' => false,
            'status' => 'scheduled',
            'show_teaser' => true,
        ]);

        // Add 20 products to upcoming campaign (different from active)
        $upcomingProducts = Product::inRandomOrder()->limit(50)->get();
        $addedCount = 0;
        foreach ($upcomingProducts as $product) {
            if ($addedCount >= 20) break;
            
            $variant = $product->variants->first();
            if ($variant && !in_array($variant->id, $usedVariantIds)) {
                $usedVariantIds[] = $variant->id;
                $discount = rand(30, 80);
                $flashPrice = $variant->price * (100 - $discount) / 100;
                
                FlashSale::create([
                    'campaign_id' => $upcomingCampaign->id,
                    'product_variant_id' => $variant->id,
                    'original_price' => $variant->price,
                    'flash_price' => $flashPrice,
                    'discount_percentage' => $discount,
                    'flash_stock' => rand(15, 60),
                    'flash_sold' => 0,
                    'start_time' => $upcomingCampaign->start_time,
                    'end_time' => $upcomingCampaign->end_time,
                    'is_active' => false,
                ]);
                $addedCount++;
            }
        }

        // Ended Campaign
        $endedCampaign = FlashSaleCampaign::create([
            'name' => 'Black Friday Sale',
            'description' => 'Flash sale Black Friday terbesar tahun ini!',
            'start_time' => now()->subDays(3),
            'end_time' => now()->subDays(2),
            'is_active' => false,
            'status' => 'ended',
            'show_teaser' => false,
        ]);

        echo "   ✓ Created 3 flash sale campaigns\n";
    }

    private function createRealisticOrders()
    {
        echo "📦 Creating realistic orders...\n";

        $statuses = ['pending_payment', 'payment_verified', 'processing', 'shipped', 'delivered', 'cancelled'];
        $orderCount = 0;

        foreach ($this->customers as $customer) {
            // Each customer makes 1-4 orders (realistic behavior)
            $numOrders = rand(1, 4);
            
            for ($i = 0; $i < $numOrders; $i++) {
                $status = $statuses[array_rand($statuses)];
                $createdAt = now()->subDays(rand(1, 30));
                
                // Random 1-5 items per order
                $numItems = rand(1, 5);
                $randomProducts = Product::inRandomOrder()->limit($numItems)->get();
                
                $subtotal = 0;
                $orderItems = [];
                
                foreach ($randomProducts as $product) {
                    $variant = $product->variants->first();
                    if ($variant) {
                        $quantity = rand(1, 3);
                        $price = $variant->price;
                        $subtotal += $price * $quantity;
                        
                        $orderItems[] = [
                            'product_variant_id' => $variant->id,
                            'product_name' => $product->name,
                            'variant_name' => $variant->variant_name,
                            'quantity' => $quantity,
                            'price' => $price,
                        ];
                    }
                }
                
                $shippingCost = rand(10000, 30000);
                $total = $subtotal + $shippingCost;
                
                $order = Order::create([
                    'user_id' => $customer->id,
                    'order_number' => 'ORD-' . strtoupper(Str::random(8)),
                    'subtotal' => $subtotal,
                    'shipping_cost' => $shippingCost,
                    'total' => $total,
                    'status' => $status,
                    'payment_method' => 'bank_transfer',
                    'guest_address' => $customer->name . ', Jl. Contoh No. ' . rand(1, 100) . ', Jakarta',
                    'created_at' => $createdAt,
                    'updated_at' => $createdAt,
                ]);
                
                foreach ($orderItems as $item) {
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_variant_id' => $item['product_variant_id'],
                        'product_name' => $item['product_name'],
                        'variant_name' => $item['variant_name'],
                        'quantity' => $item['quantity'],
                        'price' => $item['price'],
                    ]);
                }
                
                $orderCount++;
            }
        }

        echo "   ✓ Created $orderCount orders\n";
    }

    private function createRealisticReviews()
    {
        echo "⭐ Creating realistic reviews...\n";

        $reviewTexts = [
            5 => ['Produk sangat bagus! Kualitas terbaik!', 'Sangat puas dengan pembelian ini', 'Recommended banget!', 'Mantap, akan beli lagi'],
            4 => ['Produk bagus, sesuai deskripsi', 'Cukup memuaskan', 'Bagus tapi ada sedikit kekurangan', 'Overall oke'],
            3 => ['Biasa saja', 'Sesuai harga', 'Lumayan', 'Standar'],
            2 => ['Kurang memuaskan', 'Tidak sesuai ekspektasi', 'Agak mengecewakan', 'Bisa lebih baik'],
            1 => ['Sangat mengecewakan', 'Tidak recommended', 'Kualitas buruk', 'Tidak sesuai gambar'],
        ];

        $reviewCount = 0;
        $deliveredOrders = Order::where('status', 'delivered')->get();

        foreach ($deliveredOrders as $order) {
            // 70% chance customer leaves a review
            if (rand(1, 100) <= 70) {
                foreach ($order->orderItems as $item) {
                    // 50% chance to review each item
                    if (rand(1, 100) <= 50) {
                        $rating = $this->getRealisticRating();
                        $comment = $reviewTexts[$rating][array_rand($reviewTexts[$rating])];
                        
                        Review::create([
                            'user_id' => $order->user_id,
                            'product_id' => $item->productVariant->product_id,
                            'order_item_id' => $item->id,
                            'rating' => $rating,
                            'comment' => $comment,
                            'created_at' => $order->created_at->addDays(rand(1, 5)),
                        ]);
                        
                        $reviewCount++;
                    }
                }
            }
        }

        echo "   ✓ Created $reviewCount reviews\n";
    }

    private function getRealisticRating()
    {
        // Realistic rating distribution (most products get 4-5 stars)
        $rand = rand(1, 100);
        if ($rand <= 40) return 5; // 40% get 5 stars
        if ($rand <= 70) return 4; // 30% get 4 stars
        if ($rand <= 85) return 3; // 15% get 3 stars
        if ($rand <= 95) return 2; // 10% get 2 stars
        return 1; // 5% get 1 star
    }

    private function printSummary()
    {
        echo "\n📊 Database Summary:\n";
        echo "   Users: " . User::count() . "\n";
        echo "   Categories: " . Category::count() . "\n";
        echo "   Products: " . Product::count() . "\n";
        echo "   Product Variants: " . ProductVariant::count() . "\n";
        echo "   Flash Sale Campaigns: " . FlashSaleCampaign::count() . "\n";
        echo "   Flash Sale Items: " . FlashSale::count() . "\n";
        echo "   Orders: " . Order::count() . "\n";
        echo "   Order Items: " . OrderItem::count() . "\n";
        echo "   Reviews: " . Review::count() . "\n";
    }
}
