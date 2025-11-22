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
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/faq', [PageController::class, 'faq'])->name('faq');

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
});

// Breeze Default Routes
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
