<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Store a newly created review
     */
    public function store(Request $request)
    {
        $request->validate([
            'order_item_id' => 'required|exists:order_items,id',
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        // Check if user is logged in
        if (!Auth::check()) {
            return back()->with('error', 'Anda harus login terlebih dahulu untuk memberikan ulasan.');
        }

        // Check if already reviewed this order item
        $existingReview = Review::where('order_item_id', $request->order_item_id)
            ->where('user_id', Auth::id())
            ->first();

        if ($existingReview) {
            return back()->with('error', 'Anda sudah pernah memberikan ulasan untuk produk ini.');
        }

        // Create review
        Review::create([
            'user_id' => Auth::id(),
            'order_item_id' => $request->order_item_id,
            'product_id' => $request->product_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'is_approved' => true, // Auto-approve for now, can change to false later
        ]);

        return back()->with('success', 'Terima kasih! Ulasan Anda telah berhasil dikirim.');
    }

    /**
     * Show reviews for a product
     */
    public function index(Product $product)
    {
        $reviews = $product->reviews()
            ->approved()
            ->with(['user'])
            ->latest()
            ->paginate(10);

        $averageRating = $product->reviews()->approved()->avg('rating');
        $totalReviews = $product->reviews()->approved()->count();

        return view('customer.reviews.index', compact('product', 'reviews', 'averageRating', 'totalReviews'));
    }
}
