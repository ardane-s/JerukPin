<?php

namespace App\Services;

use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Transaction;
use Midtrans\Notification;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Support\Facades\Log;

class MidtransService
{
    public function __construct()
    {
        // Set Midtrans configuration
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');
    }

    /**
     * Create Snap token for payment
     *
     * @param Order $order
     * @return string Snap token
     */
    public function createSnapToken(Order $order)
    {
        $params = [
            'transaction_details' => [
                'order_id' => $order->order_number,
                'gross_amount' => (int) $order->total,
            ],
            'customer_details' => $this->getCustomerDetails($order),
            'item_details' => $this->getItemDetails($order),
            'enabled_payments' => $this->getEnabledPayments($order->payment_method),
        ];

        try {
            $snapToken = Snap::getSnapToken($params);
            return $snapToken;
        } catch (\Exception $e) {
            Log::error('Midtrans Snap Token Error: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Get customer details for Midtrans
     *
     * @param Order $order
     * @return array
     */
    private function getCustomerDetails(Order $order)
    {
        if ($order->user_id) {
            // Registered user
            $address = $order->address;
            return [
                'first_name' => $order->user->name,
                'email' => $order->user->email,
                'phone' => $order->user->phone ?? '08123456789',
                'billing_address' => [
                    'address' => $address ? $address->full_address : 'N/A',
                    'city' => $address ? $address->city : 'N/A',
                    'postal_code' => $address ? $address->postal_code : '00000',
                ],
                'shipping_address' => [
                    'address' => $address ? $address->full_address : 'N/A',
                    'city' => $address ? $address->city : 'N/A',
                    'postal_code' => $address ? $address->postal_code : '00000',
                ],
            ];
        } else {
            // Guest user
            return [
                'first_name' => $order->guest_name,
                'email' => $order->guest_email,
                'phone' => $order->guest_phone,
                'billing_address' => [
                    'address' => $order->guest_address,
                    'city' => 'N/A',
                    'postal_code' => '00000',
                ],
                'shipping_address' => [
                    'address' => $order->guest_address,
                    'city' => 'N/A',
                    'postal_code' => '00000',
                ],
            ];
        }
    }

    /**
     * Get item details for Midtrans
     *
     * @param Order $order
     * @return array
     */
    private function getItemDetails(Order $order)
    {
        $items = [];

        foreach ($order->orderItems as $item) {
            $items[] = [
                'id' => $item->product_variant_id,
                'price' => (int) $item->price,
                'quantity' => $item->quantity,
                'name' => $item->product_name . ' - ' . $item->variant_name,
            ];
        }

        // Add shipping cost as item
        if ($order->shipping_cost > 0) {
            $items[] = [
                'id' => 'SHIPPING',
                'price' => (int) $order->shipping_cost,
                'quantity' => 1,
                'name' => 'Ongkos Kirim',
            ];
        }

        return $items;
    }

    /**
     * Get enabled payment methods based on order payment method
     *
     * @param string $paymentMethod
     * @return array
     */
    private function getEnabledPayments($paymentMethod)
    {
        if ($paymentMethod === 'bank_transfer') {
            return ['bank_transfer', 'echannel'];
        } elseif ($paymentMethod === 'e_wallet') {
            return ['gopay', 'shopeepay', 'qris'];
        }

        // Default: all payment methods
        return [
            'credit_card',
            'bank_transfer',
            'echannel',
            'gopay',
            'shopeepay',
            'qris',
        ];
    }

    /**
     * Handle payment notification from Midtrans
     *
     * @param array $notificationData
     * @return void
     */
    public function handleNotification($notificationData)
    {
        try {
            $notification = new Notification();

            $orderNumber = $notification->order_id;
            $transactionStatus = $notification->transaction_status;
            $fraudStatus = $notification->fraud_status;
            $paymentType = $notification->payment_type;

            Log::info('Midtrans Notification', [
                'order_number' => $orderNumber,
                'transaction_status' => $transactionStatus,
                'fraud_status' => $fraudStatus,
                'payment_type' => $paymentType,
            ]);

            $order = Order::where('order_number', $orderNumber)->first();

            if (!$order) {
                Log::error('Order not found: ' . $orderNumber);
                return;
            }

            // Get or create payment record
            $payment = Payment::firstOrCreate(
                ['order_id' => $order->id],
                [
                    'payment_method' => $order->payment_method,
                    'amount' => $order->total,
                ]
            );

            // Update payment with Midtrans data
            $payment->update([
                'transaction_id' => $notification->transaction_id,
                'payment_type' => $paymentType,
                'transaction_status' => $transactionStatus,
                'transaction_time' => now(),
            ]);

            // Update order status based on transaction status
            if ($transactionStatus == 'capture') {
                if ($fraudStatus == 'accept') {
                    $order->update(['status' => 'payment_verified']);
                }
            } elseif ($transactionStatus == 'settlement') {
                $order->update(['status' => 'payment_verified']);
            } elseif ($transactionStatus == 'pending') {
                $order->update(['status' => 'pending_payment']);
            } elseif (in_array($transactionStatus, ['deny', 'expire', 'cancel'])) {
                $order->update(['status' => 'cancelled']);
            }

        } catch (\Exception $e) {
            Log::error('Midtrans Notification Error: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Get transaction status from Midtrans
     *
     * @param string $orderNumber
     * @return object
     */
    public function getTransactionStatus($orderNumber)
    {
        try {
            $status = Transaction::status($orderNumber);
            return $status;
        } catch (\Exception $e) {
            Log::error('Midtrans Get Status Error: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Cancel transaction
     *
     * @param string $orderNumber
     * @return object
     */
    public function cancelTransaction($orderNumber)
    {
        try {
            $cancel = Transaction::cancel($orderNumber);
            return $cancel;
        } catch (\Exception $e) {
            Log::error('Midtrans Cancel Error: ' . $e->getMessage());
            throw $e;
        }
    }
}
