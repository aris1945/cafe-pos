<?php

namespace App\Http\Controllers;

use App\Services\PaymentService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Handle the standard Midtrans callback / notification hook.
     */
    public function midtransCallback(Request $request, PaymentService $paymentService)
    {
        try {
            $paymentService->handleCallback();
            return response()->json(['message' => 'Midtrans callback handled successfully']);
        } catch (\Exception $e) {
            \Log::error('Midtrans Callback Error: ' . $e->getMessage());
            return response()->json([
                'message' => 'Error handling midtrans callback', 
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
