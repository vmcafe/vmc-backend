<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
class midtransCallback extends Controller
{
    public function __construct(){
        \Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        \Midtrans\Config::$isProduction = env('MIDTRANS_ISPRODUCTION');
    }
    public function Callback()
    {
        $notif = new \Midtrans\Notification();
        $transaction = $notif->transaction_status;
        $fraud = $notif->fraud_status;
        $type = $notif->payment_type;
        $order_id   = $notif->order_id;

        $transaksi = Order::where('orderr_id', $order_id)->first();
        if ($transaction == 'capture') {
            if ($type == 'credit_card'){
                if($fraud == 'challenge'){
                    $transaksi->status = "Challenge";
                }else {
                    $transaksi->status = "Lunas";
                }
            }
        }
        else if ($transaction == 'settlement'){
            $transaksi->status = "Berhasil";
        }else if($transaction == 'pending'){
            $transaksi->status = "Diproses";
        }else if ($transaction == 'deny') {
            $transaksi->status = "Gagal";
        }else if ($transaction == 'expire') {
            $transaksi->status = "Gagal";
        }else if ($transaction == 'cancel') {
            $transaksi->status = "Gagal";
        }
        $transaksi->save();
    }
}
