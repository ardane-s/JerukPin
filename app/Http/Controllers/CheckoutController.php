<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ProductVariant;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index()
    {
        $cartItems = $this->getCartItems();
        
        if ($cartItems->count() == 0) {
            return redirect()->route('cart.index')->with('error', 'Keranjang kosong.');
        }
        
        $subtotal = $this->calculateTotal($cartItems);
        $addresses = auth()->check() ? auth()->user()->addresses : collect();
        
        // Calculate shipping cost dynamically
        $shippingCost = \App\Models\Setting::calculateShipping($subtotal);
        $freeShippingThreshold = \App\Models\Setting::getFreeShippingThreshold();
        
        return view('customer.checkout.index', compact('cartItems', 'subtotal', 'addresses', 'shippingCost', 'freeShippingThreshold'));
    }
    
    public function store(Request $request)
    {
        $cartItems = $this->getCartItems();
        
        if ($cartItems->count() == 0) {
            return redirect()->route('cart.index')->with('error', 'Keranjang kosong.');
        }
        
        // Validation
        $rules = [
            'shipping_cost' => 'required|numeric|min:0',
            'payment_method' => 'required|in:bank_transfer,e_wallet,cod',
        ];
        
        if (auth()->check()) {
            // Member must use saved address
            $rules['address_id'] = 'required|exists:addresses,id';
        } else {
            // Guest must provide all info
            $rules['guest_name'] = 'required|string|max:255';
            $rules['guest_email'] = 'required|email';
            $rules['guest_phone'] = 'required|string|max:20';
            $rules['guest_address'] = 'required|string';
        }
        
        $validated = $request->validate($rules);
        
        DB::beginTransaction();
        try {
            // Calculate total
            $subtotal = $this->calculateTotal($cartItems);
            $shippingCost = $validated['shipping_cost'];
            $totalAmount = $subtotal + $shippingCost;
            
            // Create order
            $orderData = [
                'order_number' => 'ORD-' . time() . rand(1000, 9999),
                'subtotal' => $subtotal,
                'shipping_cost' => $shippingCost,
                'total' => $totalAmount,
                'status' => 'pending_payment',
                'payment_method' => $validated['payment_method'],
            ];
            
            if (auth()->check()) {
                $orderData['user_id'] = auth()->id();
                $orderData['address_id'] = $validated['address_id'] ?? null;
            } else {
                $orderData['guest_name'] = $validated['guest_name'];
                $orderData['guest_email'] = $validated['guest_email'];
                $orderData['guest_phone'] = $validated['guest_phone'];
                $orderData['guest_address'] = $validated['guest_address'];
            }
            
            $order = Order::create($orderData);
            
            // Create order items with snapshots
            foreach ($cartItems as $item) {
                $variant = $item->productVariant;
                
                // Check stock again
                if ($variant->stock < $item->quantity) {
                    throw new \Exception("Stok {$variant->product->name} - {$variant->variant_name} tidak mencukupi.");
                }
                
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_variant_id' => $variant->id,
                    'product_name' => $variant->product->name,
                    'variant_name' => $variant->variant_name,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                    'is_flash_sale' => $variant->hasActiveFlashSale(),
                ]);
                
                // Reduce stock
                $variant->decrement('stock', $item->quantity);
            }
            
            // Clear cart
            if (auth()->check()) {
                auth()->user()->cart->items()->delete();
            } else {
                session()->forget('cart');
            }
            
            DB::commit();
            
            // Redirect based on payment method
            if ($order->payment_method === 'cod') {
                // COD orders go directly to order detail
                return redirect()->route('orders.show', $order->order_number)
                    ->with('success', '✅ Pesanan berhasil dibuat! Silakan siapkan uang tunai saat barang tiba.');
            } else {
                // Bank transfer / E-wallet orders go to order detail page for payment upload
                return redirect()->route('orders.show', $order->order_number)
                    ->with('success', '✅ Pesanan berhasil dibuat! Silakan lakukan pembayaran.');
            }
                
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }
    
    private function getCartItems()
    {
        if (auth()->check()) {
            $cart = Cart::with(['items.productVariant.product.images'])
                ->where('user_id', auth()->id())
                ->first();
            
            return $cart ? $cart->items : collect();
        } else {
            $sessionCart = session()->get('cart', []);
            $items = collect();
            
            foreach ($sessionCart as $variantId => $item) {
                $variant = ProductVariant::with('product.images')->find($variantId);
                if ($variant) {
                    $items->push((object)[
                        'id' => $variantId,
                        'productVariant' => $variant,
                        'quantity' => $item['quantity'],
                        'price' => $item['price'],
                    ]);
                }
            }
            
            return $items;
        }
    }
    
    private function calculateTotal($cartItems)
    {
        return $cartItems->sum(function ($item) {
            return $item->price * $item->quantity;
        });
    }
}
