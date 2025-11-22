<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function shipping()
    {
        $shippingCost = Setting::getShippingCost();
        $freeShippingThreshold = Setting::getFreeShippingThreshold();
        
        return view('admin.settings.shipping', compact('shippingCost', 'freeShippingThreshold'));
    }

    public function updateShipping(Request $request)
    {
        $request->validate([
            'shipping_cost' => 'required|numeric|min:0',
            'free_shipping_threshold' => 'required|numeric|min:0',
        ]);

        Setting::set('shipping_cost', $request->shipping_cost);
        Setting::set('free_shipping_threshold', $request->free_shipping_threshold);

        return back()->with('success', 'Pengaturan ongkir berhasil diperbarui!');
    }
}
