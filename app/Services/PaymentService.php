<?php

// app/Services/PaymentService.php
namespace App\Services;

use App\Models\Order;
use App\Models\Payment;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Notification;

class PaymentService
{
    public function __construct()
    {
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$clientKey = config('services.midtrans.client_key');
        Config::$isProduction = config('services.midtrans.is_production', false);
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    public function createSnapToken(Order $order): array
    {
        $params = [
            'transaction_details' => [
                'order_id' => $order->order_number,
                'gross_amount' => (int) $order->total,
            ],
            'customer_details' => [
                'first_name' => $order->customer_name ?? 'Guest',
            ],
            'item_details' => $order->items->map(function ($item) {
                return [
                    'id' => (string) $item->menu_id,
                    'price' => (int) $item->price,
                    'quantity' => $item->quantity,
                    'name' => $item->menu->name,
                ];
            })->toArray(),
        ];

        $snapToken = Snap::getSnapToken($params);

        // Simpan payment record
        Payment::updateOrCreate(
            ['order_id' => $order->id],
            [
                'method' => 'midtrans',
                'amount' => $order->total,
                'status' => 'pending',
            ]
        );

        return [
            'token' => $snapToken,
            'client_key' => Config::$clientKey,
        ];
    }

    public function processCash(Order $order, float $amountPaid): Payment
    {
        $payment = Payment::updateOrCreate(
            ['order_id' => $order->id],
            [
                'transaction_id' => 'CASH-' . strtoupper(uniqid()),
                'method' => 'cash',
                'amount' => $order->total,
                'status' => 'success',
                'paid_at' => now(),
            ]
        );

        $order->update(['status' => 'paid']);

        return $payment;
    }

    public function handleCallback(): void
    {
        $notification = new Notification();
        $order = Order::where('order_number', $notification->order_id)->firstOrFail();
        $payment = $order->payment;

        $status = match ($notification->transaction_status) {
            'capture', 'settlement' => 'success',
            'deny', 'cancel', 'expire', 'failure' => 'failed',
            default => 'pending',
        };

        $payment->update([
            'transaction_id' => $notification->transaction_id,
            'status' => $status,
            'midtrans_response' => $notification->getResponse(),
            'paid_at' => $status === 'success' ? now() : null,
        ]);

        if ($status === 'success') {
            $order->update(['status' => 'paid']);
        } elseif ($status === 'failed') {
            $order->update(['status' => 'cancelled']);
        }
    }
}