<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use Midtrans\Config;
use Midtrans\Snap;

class MidtransController extends Controller
{
    public function notificationHandler(Request $request)
    {
    // Tangkap data notif dari Midtrans
    $notification = new \Midtrans\Notification();

    $transactionStatus = $notification->transaction_status;
    $orderId = $notification->order_id;

    // Cari booking / payment berdasarkan order_id
    $payment = Payment::where('order_id', $orderId)->first();

    if (!$payment) {
        return response()->json(['message' => 'Payment not found'], 404);
    }

    // Update status payment sesuai status Midtrans
    if ($transactionStatus == 'settlement') {
        if ($payment->status === 'menunggu pembayaran') {
        $payment->status = 'menunggu konfirmasi';
        } else {
        $payment->status = 'konfirmasi'; // fallback kalau status awal bukan 'menunggu'
        }
        } elseif ($transactionStatus == 'pending') {
        $payment->status = 'menunggu pembayaran';
        } elseif (in_array($transactionStatus, ['deny', 'cancel', 'expire'])) {
        $payment->status = 'pembayaran ditolak';
        }

    $payment->save();

    return response()->json(['message' => 'Status updated']);
}

}
