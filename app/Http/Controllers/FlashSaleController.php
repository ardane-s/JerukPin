<?php

namespace App\Http\Controllers;

use App\Models\FlashSale;
use App\Models\FlashSaleCampaign;
use App\Models\Product;
use App\Services\FlashSaleCampaignService;
use Illuminate\Http\Request;

class FlashSaleController extends Controller
{
    public function index()
    {
        // Get active campaign with products
        $activeCampaign = FlashSaleCampaignService::getActiveCampaign();
        
        // Get upcoming campaign (teaser)
        $upcomingCampaign = FlashSaleCampaignService::getUpcomingCampaign();
        
        return view('customer.flash-sales.index', compact('activeCampaign', 'upcomingCampaign'));
    }
    
    public function show($id)
    {
        $flashSale = FlashSale::with(['productVariant.product.images', 'productVariant.product.category', 'campaign'])
            ->findOrFail($id);
        
        // Get related products from same category
        $relatedProducts = Product::with(['variants', 'images'])
            ->where('category_id', $flashSale->productVariant->product->category_id)
            ->where('id', '!=', $flashSale->productVariant->product_id)
            ->active()
            ->take(4)
            ->get();
        
        return view('customer.flash-sales.show', compact('flashSale', 'relatedProducts'));
    }
}
