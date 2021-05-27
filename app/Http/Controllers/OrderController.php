<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

use App\Models\Address;
use App\Models\Cart;

class OrderController extends Controller
{
    public function __construct(){
        \Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        \Midtrans\Config::$isProduction = env('MIDTRANS_ISPRODUCTION');
    }
    public function orderProduct()
    {
        try {
            $order = new Order();
            // $product = new Product();
            $user = auth()->user()->id;

            if (Cart::where('id_user', $user)->first()) {
                $hasil = Cart::where('id_user', $user)
                    ->get();


                for ($i = 0; $i < count($hasil); $i++) {
                    $order = new Order();
                    $order->id_user = $user;
                    $order->id_product = $hasil[$i]->id_product;
                    $order->orderr_id = "Pembayaran-".time();
                    $order->invoice = rand(11111111, 99999999);
                    $order->status = 1;
                    $order->quantity = $hasil[$i]->quantity;
                    $order->cost = $hasil[$i]->cost;
                    $hasil[$i]->delete();
                    $order->save();
                };
                return $this->responseSuccess($hasil);
            }
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
        try {
            $user = auth()->user()->id;
            $order = Order::where('orders.id_user', $user)
                ->join('address', 'orders.id_address', '=', 'address.id')
                ->join('products', 'orders.id_product', '=', 'products.id')
                ->join('users', 'address.id_user', '=', 'users.id')
                ->select('orders.*', 'address.phone', 'address.street', 
                'address.district', 'address.city',
                'products.name', 'users.name')
                ->get();
    
    
            return $this->responseSuccess($order);
        } catch (\Throwable $e) {
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
            'gross_amount'  => $order->cost
        );
        
        $items = array(
            array(
                'price'    => $order->cost,
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
