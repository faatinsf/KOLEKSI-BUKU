<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MidtransWebhookController extends Controller
{
   public function handle(Request $request)
{
    try {
        Log::info('WEBHOOK MASUK', $request->all());

        $serverKey   = config('midtrans.server_key');
        $payload     = $request->all();

        $orderId     = $payload['order_id'] ?? null;
        $statusCode  = $payload['status_code'] ?? null;
        $grossAmount = $payload['gross_amount'] ?? null;
        $signKey     = $payload['signature_key'] ?? null;

        // ❗ VALIDASI DATA DULU (BIAR GA CRASH)
        if (!$orderId || !$statusCode || !$grossAmount || !$signKey) {
            Log::error('Payload tidak lengkap', $payload);
            return response()->json(['message' => 'Invalid payload'], 400);
        }

        // ❗ VALIDASI SIGNATURE
        $expectedSignature = hash('sha512', $orderId . $statusCode . $grossAmount . $serverKey);

        if ($signKey !== $expectedSignature) {
            Log::warning('Signature tidak valid', ['order_id' => $orderId]);
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        // ❗ AMANKAN EXPLODE
        $parts = explode('-', $orderId);
        if (count($parts) < 2) {
            Log::error('Format order_id salah', ['order_id' => $orderId]);
            return response()->json(['message' => 'Invalid order_id'], 400);
        }

        $realId = $parts[1];

        $order   = Order::find($realId);
        $payment = Payment::where('order_id', $realId)->first();

        if (!$order || !$payment) {
            Log::error('Order tidak ditemukan', ['order_id' => $realId]);
            return response()->json(['message' => 'Order tidak ditemukan'], 404);
        }

        $transactionStatus = $payload['transaction_status'] ?? '';
        $paymentType       = $payload['payment_type'] ?? '';
        $transactionId     = $payload['transaction_id'] ?? '';

        // Update payment
        $payment->update([
            'transaction_id' => $transactionId,
            'payment_type'   => $paymentType,
            'status'         => $transactionStatus,
        ]);

        // Update order
        if (in_array($transactionStatus, ['settlement', 'capture'])) {
            $order->update(['status_pembayaran' => 'lunas']);
        } elseif (in_array($transactionStatus, ['cancel', 'expire', 'deny'])) {
            $order->update(['status_pembayaran' => 'pending']);
        }

        Log::info('Midtrans webhook OK', [
            'order_id' => $realId,
            'status'   => $transactionStatus,
        ]);

        return response()->json(['message' => 'OK']);

    } catch (\Exception $e) {
        Log::error('WEBHOOK ERROR: ' . $e->getMessage());
        return response()->json(['error' => $e->getMessage()], 500);
    }
}
}
