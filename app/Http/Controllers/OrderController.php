<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

use App\Models\Address;
use App\Models\Cart;

class OrderController extends Controller
{
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

    public function putOrder(Request $request)
    {
        try {
           $user = auth()->user()->id;
            $address = Address::where('id_user', $user)
                ->where('selected', 1)
                ->first();
            $order = Order::where('id_user', $user)
                ->whereNull('deleted_at')
                ->update(['id_address' => $address->id]);

                return $this->responseSuccess($order);
        } catch (\Throwable $e) {
            return $this->responseException($e);
        }
        
    }

    public function getOrder()
    {
        $user = auth()->user()->id;
        $order = Order::where('id_user', $user)
            ->get();
        

        return $order;
    }
}
