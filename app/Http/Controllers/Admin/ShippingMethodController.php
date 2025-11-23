<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ShippingMethod;
use Illuminate\Http\Request;

class ShippingMethodController extends Controller
{
    public function index()
    {
        $shippingMethods = ShippingMethod::ordered()->get();
        
        return view('admin.settings.shipping.index', compact('shippingMethods'));
    }

    public function create()
    {
        return view('admin.settings.shipping.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:shipping_methods,code',
            'description' => 'nullable|string',
            'base_cost' => 'required|numeric|min:0',
            'icon' => 'nullable|string|max:10',
            'estimated_days' => 'required|integer|min:0|max:30',
            'is_active' => 'boolean',
            'order' => 'nullable|integer',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['order'] = $validated['order'] ?? ShippingMethod::max('order') + 1;

        ShippingMethod::create($validated);

        return redirect()->route('admin.shipping-methods.index')
            ->with('success', 'Metode pengiriman berhasil ditambahkan!');
    }

    public function edit(ShippingMethod $shippingMethod)
    {
        return view('admin.settings.shipping.edit', compact('shippingMethod'));
    }

    public function update(Request $request, ShippingMethod $shippingMethod)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:shipping_methods,code,' . $shippingMethod->id,
            'description' => 'nullable|string',
            'base_cost' => 'required|numeric|min:0',
            'icon' => 'nullable|string|max:10',
            'estimated_days' => 'required|integer|min:0|max:30',
            'is_active' => 'boolean',
            'order' => 'nullable|integer',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $shippingMethod->update($validated);

        return redirect()->route('admin.shipping-methods.index')
            ->with('success', 'Metode pengiriman berhasil diperbarui!');
    }

    public function destroy(ShippingMethod $shippingMethod)
    {
        // Check if any orders are using this method
        if ($shippingMethod->orders()->count() > 0) {
            return back()->with('error', 'Tidak dapat menghapus metode pengiriman yang sedang digunakan.');
        }

        $shippingMethod->delete();

        return redirect()->route('admin.shipping-methods.index')
            ->with('success', 'Metode pengiriman berhasil dihapus!');
    }
}
