<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\FlashSaleController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\AdminFlashSaleController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminReviewController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

// Check and Seed Route (For Railway deployment)
Route::get('/check-and-seed', function() {
    try {
        $result = [
            'status' => 'Starting...',
            'admin' => null,
            'products' => 0,
            'categories' => 0,
            'payment_methods' => 0,
            'settings' => 0,
        ];
        
        // Run migrations first
        Artisan::call('migrate', ['--force' => true]);
        $result['migrations'] = 'Done';
        
        // Run the seeder
        Artisan::call('db:seed', [
            '--class' => 'RealJerukPinSeeder',
            '--force' => true
        ]);
        
        // Check what was created
        $result['admin'] = \App\Models\User::where('email', 'jerukpin@gmail.com')->first();
        $result['products'] = \App\Models\Product::count();
        $result['categories'] = \App\Models\Category::count();
        $result['payment_methods'] = \App\Models\PaymentMethod::count();
        $result['settings'] = \App\Models\Setting::count();
        $result['status'] = 'Success!';
        
        return '<div style="font-family: Arial; padding: 40px; max-width: 800px; margin: 0 auto;">
            <h1 style="color: #FF8A00;">✅ Database Ready!</h1>
            <div style="background: #f0fdf4; border: 2px solid #10b981; padding: 20px; border-radius: 10px; margin: 20px 0;">
                <h2 style="margin-top: 0;">✓ Admin Account</h2>
                <p><strong>Email:</strong> ' . ($result['admin'] ? $result['admin']->email : 'NOT FOUND!') . '</p>
                <p><strong>Password:</strong> Jerukjerukjerukpin!</p>
                <p><strong>Role:</strong> ' . ($result['admin'] ? $result['admin']->role : 'N/A') . '</p>
            </div>
            <div style="background: #eff6ff; border: 2px solid #3b82f6; padding: 20px; border-radius: 10px;">
                <h2 style="margin-top: 0;">📊 Database Summary</h2>
                <ul style="font-size: 16px;">
                    <li>Categories: ' . $result['categories'] . '</li>
                    <li>Products: ' . $result['products'] . '</li>
                    <li>Payment Methods: ' . $result['payment_methods'] . '</li>
                    <li>Settings: ' . $result['settings'] . '</li>
                </ul>
            </div>
            <div style="margin-top: 30px;">
                <a href="/" style="display: inline-block; padding: 12px 24px; background: #FF8A00; color: white; text-decoration: none; border-radius: 8px; margin-right: 10px;">🏠 Homepage</a>
                <a href="/admin" style="display: inline-block; padding: 12px 24px; background: #10b981; color: white; text-decoration: none; border-radius: 8px;">🔐 Admin Panel</a>
            </div>
        </div>';
        
    } catch (\Exception $e) {
        return '<div style="font-family: Arial; padding: 40px; color: red;">
            <h1>❌ Error!</h1>
            <p><strong>Message:</strong> ' . $e->getMessage() . '</p>
            <details>
                <summary style="cursor: pointer; color: blue;">Show Stack Trace</summary>
                <pre style="background: #f3f4f6; padding: 15px; border-radius: 5px; overflow-x: auto;">' . $e->getTraceAsString() . '</pre>
            </details>
            <a href="/check-and-seed" style="display: inline-block; margin-top: 20px; padding: 10px 20px; background: #FF8A00; color: white; text-decoration: none; border-radius: 5px;">🔄 Try Again</a>
        </div>';
    }
});

// Emergency Database Seeder (Public - Remove after use!)
Route::get('/seed-now-emergency', function() {
    try {
        // Run the seeder
        Artisan::call('db:seed', [
            '--class' => 'RealJerukPinSeeder',
            '--force' => true
        ]);
        
        $output = Artisan::output();
        
        // Check admin was created
        $admin = \App\Models\User::where('email', 'jerukpin@gmail.com')->first();
        $productCount = \App\Models\Product::count();
        
        return '<div style="font-family: Arial; padding: 40px; max-width: 600px; margin: 0 auto;">
            <h1 style="color: #FF8A00;">✅ Database Seeded Successfully!</h1>
            <div style="background: #f0fdf4; border: 2px solid #10b981; padding: 20px; border-radius: 10px; margin: 20px 0;">
                <h2 style="margin-top: 0;">Admin Account Created:</h2>
                <p><strong>Email:</strong> ' . ($admin ? $admin->email : 'NOT FOUND!') . '</p>
                <p><strong>Role:</strong> ' . ($admin ? $admin->role : 'N/A') . '</p>
                <p><strong>Products:</strong> ' . $productCount . ' created</p>
            </div>
            <div style="background: #fef2f2; border: 2px solid #ef4444; padding: 20px; border-radius: 10px;">
                <h3 style="margin-top: 0;">⚠️ IMPORTANT</h3>
                <p>Remove this route from <code>routes/web.php</code> after use!</p>
                <p>Delete lines containing <code>/seed-now-emergency</code></p>
            </div>
            <h3>Artisan Output:</h3>
            <pre style="background: #f3f4f6; padding: 15px; border-radius: 5px; overflow-x: auto;">' . htmlspecialchars($output) . '</pre>
            <a href="/" style="display: inline-block; margin-top: 20px; padding: 10px 20px; background: #FF8A00; color: white; text-decoration: none; border-radius: 5px;">Go to Homepage</a>
        </div>';
        
    } catch (\Exception $e) {
        return '<div style="font-family: Arial; padding: 40px; color: red;">
            <h1>❌ Error!</h1>
            <p>' . $e->getMessage() . '</p>
            <pre>' . $e->getTraceAsString() . '</pre>
        </div>';
    }
});

// Database Manager (Admin Only - Protected)
Route::get('/admin/database-manager', [App\Http\Controllers\Admin\DatabaseManagerController::class, 'index'])
    ->middleware(['auth'])
    ->name('admin.database.manager');

Route::post('/admin/database-manager/seed', [App\Http\Controllers\Admin\DatabaseManagerController::class, 'seed'])
    ->middleware(['auth'])
    ->name('admin.database.seed');

// Customer Routes (Public)
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/search', [ProductController::class, 'search'])->name('products.search');
Route::get('/category/{slug}', [ProductController::class, 'category'])->name('category.show');
Route::get('/product/{slug}', [ProductController::class, 'show'])->name('product.show');

// Flash Sales
Route::get('/flash-sales', [FlashSaleController::class, 'index'])->name('flash-sales.index');
Route::get('/flash-sale/{id}', [FlashSaleController::class, 'show'])->name('flash-sale.show');

// Static Pages
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::post('/contact', [\App\Http\Controllers\ContactController::class, 'submit'])->name('contact.submit');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/faq', [PageController::class, 'faq'])->name('faq');
Route::get('/privacy', [PageController::class, 'privacy'])->name('privacy');
Route::get('/terms', [PageController::class, 'terms'])->name('terms');
Route::get('/bundle-deals', [PageController::class, 'bundleDeals'])->name('bundle-deals');
Route::get('/diskon-spesial', [PageController::class, 'specialDiscounts'])->name('special-discounts');

// Newsletter
Route::post('/newsletter/subscribe', [\App\Http\Controllers\NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');

// Cart (Public)
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::put('/cart/{item}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/{item}', [CartController::class, 'remove'])->name('cart.remove');
Route::delete('/cart', [CartController::class, 'clear'])->name('cart.clear');

// Checkout (Public)
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');

// Orders (Public & Protected)
Route::get('/orders/track', [OrderController::class, 'track'])->name('orders.track');
Route::post('/orders/track', [OrderController::class, 'trackOrder'])->name('orders.track.submit');
Route::get('/orders/{orderNumber}', [OrderController::class, 'show'])->name('orders.show');
Route::get('/orders/{orderNumber}/invoice', [InvoiceController::class, 'show'])->name('orders.invoice');
Route::get('/orders/{orderNumber}/payment', [OrderController::class, 'uploadPayment'])->name('orders.payment');
Route::post('/orders/{orderNumber}/payment', [OrderController::class, 'storePayment'])->name('orders.payment.store');
Route::post('/orders/{orderNumber}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');


Route::middleware('auth')->group(function () {
    Route::get('/my-orders', [OrderController::class, 'index'])->name('orders.index');
    
    // Reviews (authenticated customers only)
    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    Route::get('/products/{product}/reviews', [ReviewController::class, 'index'])->name('reviews.index');
    
    // Wishlist (authenticated customers only)
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist', [WishlistController::class, 'store'])->name('wishlist.store');
    Route::delete('/wishlist/{product}', [WishlistController::class, 'destroy'])->name('wishlist.destroy');

    // Profile & Settings
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/settings', [\App\Http\Controllers\SettingsController::class, 'index'])->name('settings.index');

    // Addresses
    Route::resource('addresses', \App\Http\Controllers\AddressController::class);
    Route::get('/wishlist/check/{product}', [WishlistController::class, 'check'])->name('wishlist.check');
    
    // Payment routes (authenticated customers only)
    Route::get('/payment/{orderNumber}', [App\Http\Controllers\PaymentController::class, 'show'])->name('payment.show');
});

// Payment callback and notification (accessible to all)
Route::get('/payment/callback', [App\Http\Controllers\PaymentController::class, 'callback'])->name('payment.callback');
Route::post('/payment/notification', [App\Http\Controllers\PaymentController::class, 'notification'])->name('payment.notification');


// Admin Routes (Protected by auth + super_admin middleware)
Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // Categories
    Route::resource('categories', AdminCategoryController::class);
    
    // Products
    Route::resource('products', AdminProductController::class);
    Route::post('products/{product}/images', [AdminProductController::class, 'uploadImages'])->name('products.images.upload');
    Route::delete('products/images/{image}', [AdminProductController::class, 'deleteImage'])->name('products.images.delete');
    Route::post('products/images/{image}/primary', [AdminProductController::class, 'setPrimaryImage'])->name('products.images.primary');
    Route::post('products/{product}/variants', [AdminProductController::class, 'addVariant'])->name('products.variants.add');
    Route::put('products/variants/{variant}', [AdminProductController::class, 'updateVariant'])->name('products.variants.update');
    Route::delete('products/variants/{variant}', [AdminProductController::class, 'deleteVariant'])->name('products.variants.delete');
    
    
    // Flash Sale Campaigns (New System)
    Route::get('flash-sale-campaigns', [App\Http\Controllers\Admin\FlashSaleCampaignController::class, 'index'])->name('flash-sale-campaigns.index');
    Route::get('flash-sale-campaigns/create', [App\Http\Controllers\Admin\FlashSaleCampaignController::class, 'create'])->name('flash-sale-campaigns.create');
    Route::post('flash-sale-campaigns', [App\Http\Controllers\Admin\FlashSaleCampaignController::class, 'store'])->name('flash-sale-campaigns.store');
    Route::get('flash-sale-campaigns/{campaign}/edit', [App\Http\Controllers\Admin\FlashSaleCampaignController::class, 'edit'])->name('flash-sale-campaigns.edit');
    Route::put('flash-sale-campaigns/{campaign}', [App\Http\Controllers\Admin\FlashSaleCampaignController::class, 'update'])->name('flash-sale-campaigns.update');
    Route::delete('flash-sale-campaigns/{campaign}', [App\Http\Controllers\Admin\FlashSaleCampaignController::class, 'destroy'])->name('flash-sale-campaigns.destroy');
    Route::get('flash-sale-campaigns/{campaign}/products', [App\Http\Controllers\Admin\FlashSaleCampaignController::class, 'products'])->name('flash-sale-campaigns.products');
    Route::post('flash-sale-campaigns/{campaign}/products', [App\Http\Controllers\Admin\FlashSaleCampaignController::class, 'addProduct'])->name('flash-sale-campaigns.add-product');
    Route::delete('flash-sale-campaigns/{campaign}/products/{flashSale}', [App\Http\Controllers\Admin\FlashSaleCampaignController::class, 'removeProduct'])->name('flash-sale-campaigns.remove-product');
    
    // Flash Sales (Old System - Keep for backward compatibility)
    Route::resource('flash-sales', AdminFlashSaleController::class);
    Route::post('flash-sales/{flashSale}/deactivate', [AdminFlashSaleController::class, 'deactivate'])->name('flash-sales.deactivate');

    
    // Orders
    Route::get('orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::put('orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.status');
    Route::post('orders/{order}/verify-payment', [AdminOrderController::class, 'verifyPayment'])->name('orders.verify');
    Route::post('orders/{order}/reject-payment', [AdminOrderController::class, 'rejectPayment'])->name('orders.reject');
    
    
    // Reviews
    Route::get('reviews', [AdminReviewController::class, 'index'])->name('reviews.index');
    Route::get('reviews/{review}', [AdminReviewController::class, 'show'])->name('reviews.show');
    Route::post('reviews/{review}/approve', [AdminReviewController::class, 'approve'])->name('reviews.approve');
    Route::delete('reviews/{review}', [AdminReviewController::class, 'destroy'])->name('reviews.destroy');
    
    // Payment Methods
    Route::resource('payment-methods', App\Http\Controllers\Admin\PaymentMethodController::class);
    Route::post('payment-methods/{paymentMethod}/toggle', [App\Http\Controllers\Admin\PaymentMethodController::class, 'toggleActive'])->name('payment-methods.toggle');
    
    // Settings
    Route::get('settings/shipping', [App\Http\Controllers\Admin\SettingController::class, 'shipping'])->name('settings.shipping');
    Route::put('settings/shipping', [App\Http\Controllers\Admin\SettingController::class, 'updateShipping'])->name('settings.shipping.update');
});

// Breeze Default Routes
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
