<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['variants', 'images', 'category'])
            ->active();
        
        // Filter by category
        if ($request->has('category')) {
            $query->where('category_id', $request->category);
        }
        
        // Search
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }
        
        // Sort
        $sort = $request->get('sort', 'latest');
        switch ($sort) {
            case 'popular':
                $query->orderBy('total_sold_count', 'desc');
                break;
            case 'price_low':
                $query->withMin('variants', 'price')->orderBy('variants_min_price', 'asc');
                break;
            case 'price_high':
                $query->withMax('variants', 'price')->orderBy('variants_max_price', 'desc');
                break;
            default:
                $query->latest();
        }
        
        $products = $query->paginate(12);
        $categories = Category::active()->get();
        $categories = \App\Models\Category::where('is_active', true)->get();

        return view('customer.products.index', compact('products', 'categories'));
    }
    
    public function category($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        
        $products = Product::with(['variants', 'images'])
            ->where('category_id', $category->id)
            ->active()
            ->latest()
            ->paginate(12);
        
        return view('customer.products.category', compact('category', 'products'));
    }
    
    public function show($slug)
    {
        $product = Product::with([
            'variants' => function($query) {
                $query->active()->orderBy('sort_order');
            },
            'images' => function($query) {
                $query->orderBy('sort_order');
            },
            'category',
            'reviews' => function($query) {
                $query->approved()->latest();
            }
        ])->where('slug', $slug)->firstOrFail();
        
        // Related products from same category
        $relatedProducts = Product::with(['variants', 'images'])
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->active()
            ->take(4)
            ->get();
        
        return view('customer.products.show', compact('product', 'relatedProducts'));
    }
    
    public function search(Request $request)
    {
        $search = $request->get('q');
        
        $products = Product::with(['variants', 'images', 'category'])
            ->where(function($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%");
            })
            ->active()
            ->paginate(12);
        
        return view('customer.products.search', compact('products', 'search'));
    }
}
