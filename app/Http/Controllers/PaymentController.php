<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use App\Services\MidtransService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    protected $midtransService;

    public function __construct(MidtransService $midtransService)
    {
        $this->midtransService = $midtransService;
    }

    /**
     * Show payment page with Midtrans Snap
     *
     * @param string $orderNumber
     * @return \Illuminate\View\View
     */
    public function show($orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)
            ->with(['orderItems.productVariant.product', 'payment'])
            ->firstOrFail();

        // Authorization check
        if ($order->user_id && (!auth()->check() || auth()->id() != $order->user_id)) {
            abort(403, 'Unauthorized');
        }

        // Check if order is eligible for payment
        if (!in_array($order->status, ['pending_payment', 'payment_uploaded'])) {
            return redirect()->route('orders.show', $orderNumber)
                ->with('error', 'Pesanan ini tidak dapat dibayar.');
        }

        // Get or create payment record
        $payment = Payment::firstOrCreate(
            ['order_id' => $order->id],
            [
                'payment_method' => $order->payment_method,
                'amount' => $order->total,
                'status' => 'pending',
            ]
        );

        // Generate Snap token if not exists or expired
        if (!$payment->snap_token) {
            try {
                $snapToken = $this->midtransService->createSnapToken($order);
                $payment->update(['snap_token' => $snapToken]);
            } catch (\Exception $e) {
                Log::error('Failed to create Snap token: ' . $e->getMessage());
                return redirect()->route('orders.show', $orderNumber)
                    ->with('error', 'Gagal membuat pembayaran. Silakan coba lagi.');
            }
        }

        return view('customer.payments.snap', compact('order', 'payment'));
    }

    /**
     * Handle callback from Midtrans after payment
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function callback(Request $request)
    {
        $orderNumber = $request->input('order_id');
        $transactionStatus = $request->input('transaction_status');

        $order = Order::where('order_number', $orderNumber)->first();

        if (!$order) {
            return redirect()->route('home')->with('error', 'Pesanan tidak ditemukan.');
        }

        // Redirect based on transaction status
        if ($transactionStatus == 'settlement' || $transactionStatus == 'capture') {
            return redirect()->route('orders.show', $orderNumber)
                ->with('success', '✅ Pembayaran berhasil! Pesanan Anda sedang diproses.');
        } elseif ($transactionStatus == 'pending') {
            return redirect()->route('orders.show', $orderNumber)
                ->with('info', '⏳ Pembayaran Anda sedang diproses. Silakan tunggu konfirmasi.');
        } else {
            return redirect()->route('orders.show', $orderNumber)
                ->with('error', '❌ Pembayaran gagal atau dibatalkan.');
        }
    }

    /**
     * Handle notification webhook from Midtrans
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function notification(Request $request)
    {
        try {
            $this->midtransService->handleNotification($request->all());
            
            return response()->json([
                'status' => 'success',
                'message' => 'Notification processed'
            ]);
        } catch (\Exception $e) {
            Log::error('Midtrans notification error: ' . $e->getMessage());
            
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
