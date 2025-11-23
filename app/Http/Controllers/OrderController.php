<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use App\Models\PaymentProof;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id', auth()->id())
            ->with(['orderItems.productVariant.product', 'payment'])
            ->latest()
            ->paginate(10);
        
        return view('customer.orders.index', compact('orders'));
    }
    
    public function show($orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)
            ->with(['orderItems.productVariant.product', 'payment.paymentProof', 'address'])
            ->firstOrFail();
        
        // Authorization check
        if ($order->user_id && (!auth()->check() || auth()->id() != $order->user_id)) {
            abort(403, 'Unauthorized');
        }
        
        return view('customer.orders.show', compact('order'));
    }
    
    public function track()
    {
        return view('customer.orders.track');
    }
    
    public function trackOrder(Request $request)
    {
        $request->validate([
            'order_number' => 'required|string',
            'email' => 'required|email',
        ]);
        
        $order = Order::where('order_number', $request->order_number)
            ->where('guest_email', $request->email)
            ->first();
        
        if (!$order) {
            return back()->with('error', 'Pesanan tidak ditemukan. Periksa kembali nomor pesanan dan email Anda.');
        }
        
        return redirect()->route('orders.show', $order->order_number);
    }
    
    public function uploadPayment($orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)
            ->with('payment')
            ->firstOrFail();
        
        // Authorization check
        if ($order->user_id && (!auth()->check() || auth()->id() != $order->user_id)) {
            abort(403);
        }
        
        if ($order->status != 'pending_payment') {
            return redirect()->route('orders.show', $orderNumber)
                ->with('error', 'Pembayaran sudah diupload atau pesanan sudah diproses.');
        }
        
        return view('customer.orders.upload-payment', compact('order'));
    }
    
    public function storePayment(Request $request, $orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)->firstOrFail();
        
        // Authorization check
        if ($order->user_id && (!auth()->check() || auth()->id() != $order->user_id)) {
            abort(403);
        }
        
        $request->validate([
            'proof_image' => 'required|image|mimes:jpeg,png,jpg|max:5120',
            'payment_date' => 'required|date',
            'payment_amount' => 'required|numeric|min:0',
            'bank_name' => 'required|string|max:100',
            'account_name' => 'required|string|max:255',
        ]);
        
        // Create payment record
        $payment = Payment::firstOrCreate(
            ['order_id' => $order->id],
            [
                'payment_method' => 'bank_transfer',
                'amount' => $request->payment_amount,
                'status' => 'pending',
            ]
        );
        
        // Upload proof image
        $path = $request->file('proof_image')->store('payment_proofs/' . $order->id, 'public');
        
        // Create payment proof
        PaymentProof::create([
            'payment_id' => $payment->id,
            'proof_image_path' => $path,
            'payment_date' => $request->payment_date,
            'payment_amount' => $request->payment_amount,
            'bank_name' => $request->bank_name,
            'account_name' => $request->account_name,
            'uploaded_at' => now(),
        ]);
        
        // Update order status
        $order->update(['status' => 'payment_uploaded']);
        
        return redirect()->route('orders.show', $orderNumber)
            ->with('success', 'Bukti pembayaran berhasil diupload. Pesanan Anda akan segera diproses.');
    }
    
    public function cancel($orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)->firstOrFail();
        
        // Check if user owns this order (for logged-in users) or allow guest cancellation
        if (auth()->check() && $order->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }
        
        // Only allow cancellation for pending_payment or payment_uploaded status
        if (!in_array($order->status, ['pending_payment', 'payment_uploaded'])) {
            return back()->with('error', 'Pesanan tidak dapat dibatalkan pada status ini.');
        }
        
        // Update status to cancelled
        $order->update(['status' => 'cancelled']);
        
        // Restore stock for cancelled orders
        foreach ($order->orderItems as $item) {
            $item->productVariant->increment('stock', $item->quantity);
        }
        
        return redirect()->route('orders.index')
            ->with('success', '✅ Pesanan berhasil dibatalkan.');
    }
}
