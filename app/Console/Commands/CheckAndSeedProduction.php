<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\PaymentMethod;
use App\Models\ShippingMethod;

class CheckAndSeedProduction extends Command
{
    protected $signature = 'db:check-and-seed {--force : Force without confirmation}';
    protected $description = 'Clean test data, then ensure products/categories/admin exist (FOR RAILWAY)';

    public function handle()
    {
        $this->info('🔍 Railway Production Database Check & Seed');
        $this->newLine();
        
        // Step 1: Clean test data
        $this->info('STEP 1: Cleaning test data...');
        if (!$this->option('force')) {
            if (!$this->confirm('Delete all orders, customers, reviews, etc.?')) {
                $this->info('Cancelled.');
                return 0;
            }
        }
        
        try {
            // Disable foreign key checks
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            
            // Delete test data (keep structure)
            User::where('role', '!=', 'admin')->delete();
            DB::table('payment_proofs')->truncate();
            DB::table('payments')->truncate();
            DB::table('order_items')->truncate();
            DB::table('orders')->truncate();
            DB::table('reviews')->truncate();
            DB::table('carts')->truncate();
            DB::table('wishlists')->truncate();
            DB::table('addresses')->truncate();
            DB::table('notifications')->truncate();
            
            // Re-enable foreign key checks
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            
            $this->info('✓ Test data cleaned');
            
            // Step 2: Check and seed essential data
            $this->newLine();
            $this->info('STEP 2: Checking essential data...');
            
            // Check admin
            $adminUser = User::where('email', 'jerukpin@gmail.com')->first();
            if (!$adminUser) {
                $this->warn('⚠️  Admin (jerukpin@gmail.com) not found! Creating...');
                User::create([
                    'name' => 'Admin JerukPin',
                    'email' => 'jerukpin@gmail.com',
                    'password' => bcrypt('Jerukjerukjerukpin!'),
                    'role' => 'admin',
                    'phone' => '081234567890',
                    'email_verified_at' => now(),
                ]);
                $this->info('✓ Admin created (email: jerukpin@gmail.com)');
            } else {
                // Update password for existing admin to ensure it matches
                $adminUser->update([
                    'password' => bcrypt('Jerukjerukjerukpin!')
                ]);
                $this->info("✓ Admin exists & password updated (jerukpin@gmail.com)");
            }
            
            // Check categories
            $categoryCount = Category::count();
            if ($categoryCount === 0) {
                $this->warn('⚠️  No categories found! Running seeder...');
                Artisan::call('db:seed', ['--class' => 'RealJerukPinSeeder']);
                $this->info('✓ Categories and products seeded');
            } else {
                $this->info("✓ Categories exist ({$categoryCount} categories)");
            }
            
            // Check products
            $productCount = Product::count();
            if ($productCount === 0) {
                $this->warn('⚠️  No products found! Running seeder...');
                Artisan::call('db:seed', ['--class' => 'RealJerukPinSeeder']);
                $this->info('✓ Products seeded');
            } else {
                $this->info("✓ Products exist ({$productCount} products)");
            }
            
            // Check payment methods
            $paymentMethodCount = PaymentMethod::count();
            if ($paymentMethodCount === 0) {
                $this->warn('⚠️  No payment methods found! Creating defaults...');
                PaymentMethod::create([
                    'name' => 'Transfer Bank',
                    'type' => 'bank_transfer',
                    'account_number' => '1234567890',
                    'account_name' => 'JerukPin',
                    'bank_name' => 'BCA',
                    'is_active' => true,
                ]);
                $this->info('✓ Payment method created');
            } else {
                $this->info("✓ Payment methods exist ({$paymentMethodCount} methods)");
            }
            
            // Check shipping methods  
            $shippingMethodCount = ShippingMethod::count();
            if ($shippingMethodCount === 0) {
                $this->warn('⚠️  No shipping methods found! Creating defaults...');
                ShippingMethod::create([
                    'name' => 'JNT',
                    'code' => 'jnt',
                    'icon' => '📦',
                    'base_cost' => 10000,
                    'estimated_days' => '2-3 hari',
                    'is_active' => true,
                ]);
                $this->info('✓ Shipping method created');
            } else {
                $this->info("✓ Shipping methods exist ({$shippingMethodCount} methods)");
            }
            
            // Summary
            $this->newLine();
            $this->info('✅ Railway database ready!');
            $this->newLine();
            $this->table(
                ['Item', 'Status'],
                [
                    ['Admin Account', User::where('role', 'admin')->count() . ' admin(s)'],
                    ['Categories', Category::count()],
                    ['Products', Product::count()],
                    ['Payment Methods', PaymentMethod::count()],
                    ['Shipping Methods', ShippingMethod::count()],
                    ['Customers', '0 (cleaned)'],
                    ['Orders', '0 (cleaned)'],
                    ['Reviews', '0 (cleaned)'],
                ]
            );
            
            return 0;
            
        } catch (\Exception $e) {
            $this->error('❌ Error: ' . $e->getMessage());
            return 1;
        }
    }
}
