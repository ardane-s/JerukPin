<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class CleanProductionData extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'db:clean-production {--force : Force the operation without confirmation}';

    /**
     * The console command description.
     */
    protected $description = 'Clean all data except products, categories, and admin account (FOR RAILWAY DEPLOYMENT)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Safety check - only run in production or with --force flag
        if (!app()->environment('production') && !$this->option('force')) {
            $this->error('⚠️  This command should only be run in production!');
            $this->info('Use --force flag to run in non-production environment');
            return 1;
        }

        // Confirmation
        if (!$this->option('force')) {
            if (!$this->confirm('🚨 This will DELETE all orders, users (except admin), reviews, carts, etc. Continue?')) {
                $this->info('Operation cancelled.');
                return 0;
            }
        }

        $this->info('🧹 Starting database cleanup...');
        
        try {
            DB::beginTransaction();
            
            // 1. Delete all non-admin users (customers)
            $deletedUsers = User::where('role', '!=', 'admin')->delete();
            $this->info("✓ Deleted {$deletedUsers} customer accounts");
            
            // 2. Clear orders and related data
            DB::table('payment_proofs')->truncate();
            $this->info('✓ Cleared payment proofs');
            
            DB::table('payments')->truncate();
            $this->info('✓ Cleared payments');
            
            DB::table('order_items')->truncate();
            $this->info('✓ Cleared order items');
            
            DB::table('orders')->truncate();
            $this->info('✓ Cleared orders');
            
            // 3. Clear reviews
            DB::table('reviews')->truncate();
            $this->info('✓ Cleared reviews');
            
            // 4. Clear carts
            DB::table('carts')->truncate();
            $this->info('✓ Cleared carts');
            
            // 5. Clear wishlists
            DB::table('wishlists')->truncate();
            $this->info('✓ Cleared wishlists');
            
            // 6. Clear addresses
            DB::table('addresses')->truncate();
            $this->info('✓ Cleared addresses');
            
            // 7. Clear notifications
            DB::table('notifications')->truncate();
            $this->info('✓ Cleared notifications');
            
            // 8. Keep: products, categories, product_images, product_variants, payment_methods, shipping_methods, admin users
            
            DB::commit();
            
            $this->newLine();
            $this->info('✅ Database cleaned successfully!');
            $this->newLine();
            $this->info('📦 KEPT:');
            $this->line('  - All products');
            $this->line('  - All categories');
            $this->line('  - Product images & variants');
            $this->line('  - Payment methods');
            $this->line('  - Shipping methods');
            $this->line('  - Admin account(s)');
            $this->newLine();
            $this->info('🗑️  DELETED:');
            $this->line('  - All customer accounts');
            $this->line('  - All orders & payments');
            $this->line('  - All reviews');
            $this->line('  - All carts & wishlists');
            $this->line('  - All addresses');
            $this->line('  - All notifications');
            
            return 0;
            
        } catch (\Exception $e) {
            DB::rollBack();
            $this->error('❌ Error during cleanup: ' . $e->getMessage());
            return 1;
        }
    }
}
