<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Midtrans\Config;
use App\Models\Product;
use App\Models\Order;


class PaymentController extends Controller
{
    public function __construct(){
        \Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        \Midtrans\Config::$isProduction = env('MIDTRANS_ISPRODUCTION');
    }

    public function testPayment(Request $request)
    {
        $request->validate([
            'bank' => 'required',
            'harga_total' => 'required|integer'
        ]);
        $order = Order::find(auth()->user()->id);
    }
}
