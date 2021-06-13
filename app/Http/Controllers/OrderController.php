<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Address;
use App\Models\Cart;
use App\Models\CartProduct;

class OrderController extends Controller
{
    public function __construct()
    {
        \Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        \Midtrans\Config::$isProduction = env('MIDTRANS_ISPRODUCTION');
    }
    public function orderProduct()
    {
        try {
            $order = new Order();
            $user = auth()->user()->id;
            // $product = new Product();
            // $address = Address::where('id_user', $user)
            //     ->where('selected', 1)
            //     ->first();
            // $order->id_address = $address->id;
            $order->id_user = $user;
            $order->orderr_id = "Pembayaran-" . time();
            $order->invoice = rand(11111111, 99999999);
            $order->status = 1;
            $order->save();

            $data = Cart::where('id_user', $user)->first();
            $hasil = CartProduct::where('id_cart', $data->id)
                ->get();
            for ($i = 0; $i < count($hasil); $i++) {
                $orderproduct = new OrderProduct();
                $order = Order::where('id_user', $user)
                    ->orderby('created_at', 'desc')
                    ->first();
                $orderproduct->id_order = $order->id;
                $orderproduct->id_product = $hasil[$i]->id_product;
                $orderproduct->quantity = $hasil[$i]->quantity;
                $orderproduct->cost = $hasil[$i]->cost;
                $hasil[$i]->delete();
                $orderproduct->save();
            };
            $data->delete();
            $total = OrderProduct::where('id_order', $order->id)
                ->sum('cost');
            $order->total = $total;
            $order->save();
            return $this->responseSuccess($hasil);
        } catch (\Exception $e) {
            return $this->responseException($e);
        }
    }

    public function putOrder()
    {
        try {
            $user = auth()->user()->id;
            $address = Address::where('id_user', $user)
                ->where('selected', 1)
                ->first();
            $order = Order::where('id_user', $user)
                ->whereNull('id_address')
                ->update(['id_address' => $address->id]);

            return $this->responseSuccess($order);
        } catch (\Throwable $e) {
            return $this->responseException($e);
        }
    }

    public function getOrder()
    {
        $id = auth()->user()->id;
        try {
            $order = Order::where('id_user', $id)
                ->first();
            $s = OrderProduct::with(['products'])
                ->where('id_order', $order->id)
                ->get();


            return $this->responseSuccess($s);
        } catch (\Exception $e) {
            return $this->responseException($e);
        }
        // try {
        //     $user = auth()->user()->id;
        //     $order = Order::with(['address', 'products'])
        //         ->where('orders.id_user', $user)
        //     ->join('address', 'orders.id_address', '=', 'address.id')
        //     ->join('products', 'orders.id_product', '=', 'products.id')
        //     ->join('users', 'users.id', '=', 'address.id_user')
        //     ->select('orders.*', 'address.phone', 'address.street', 
        //     'address.district')
        // ->get();


        //     return response()
        //         ->json(['data' => $order], 200);
        // } catch (\Throwable $e) {
        //     return $this->responseException($e);
        // }
    }

    public function getTotal()
    {
        $id = auth()->user()->id;
        try {
            if (Order::where('id_user', $id)->first()) {
                $order = Order::where('id_user', $id)
                    ->orderby('created_at', 'desc')
                    ->first();
                return $this->responseSuccess($order);
            }
        } catch (\Exception $e) {
            return $this->responseException($e);
        }
    }
    public function pembayaran(Request $request, $id)
    {
        $rules = [
            'bank' => 'required',
        ];
        $this->validate($request, $rules);
        $order = Order::find($id);

        $order_id = $order->orderr_id;
        $transaction_details = array(
            'order_id'    => $order_id,
            'gross_amount'  => $order->total
        );

        $items = array(
            array(
                'price'    => $order->total,
                'quantity' => 1,
                'name'     => 'Pembayaran booking wisata'
            )
        );

        if($request->bank == "mandiri"){
            $payment_type = 'echannel';
            $bank_transfer = 'echannel';
            $bank_transfer_value = array(
                "bill_info1" => "Pembayaran",
                "bill_info2" => "booking"
            );
        }else{
            $payment_type = 'bank_transfer';
            $bank_transfer = 'bank_transfer';
            $bank_transfer_value = array(
                "bank"  => $request->bank
            );
        }


        $transaction_data = array(
            'payment_type'        => $payment_type,
            'transaction_details' => $transaction_details,
            'item_details'        => $items,
            'bank_transfer'        => $bank_transfer_value,
            'echannel'            => $bank_transfer_value
        );

        $response = \Midtrans\CoreApi::charge($transaction_data);
        // if($response->status_code == "201"){
        //     $order->bank = $request->bank;
        //     if($request->bank == "mandiri"){
        //         $order->nomor_virtual = $response->biller_code." ".$response->bill_key;
        //     }else{
        //         $order->nomor_virtual = $response->va_numbers[0]->va_number;
        //     }
        //     $order->status = "Pending";
        //     $order->save();
        return $this->responseSuccess($response);
        // }else{
        //     return $this->responseException($e);
        // }
    }
}
