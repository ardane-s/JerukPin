<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function contact()
    {
        return view('pages.contact');
    }
    
    public function about()
    {
        return view('pages.about');
    }
    
    public function faq()
    {
        return view('pages.faq');
    }

    public function privacy()
    {
        return view('pages.privacy');
    }

    public function terms()
    {
        return view('pages.terms');
    }

    public function bundleDeals()
    {
        return view('pages.bundle-deals');
    }

    public function specialDiscounts()
    {
        return view('pages.special-discounts');
    }
}
