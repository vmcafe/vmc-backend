<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Models\Cart;
class OrderController extends Controller
{
    public function orderProduct()
    {
        $order = new Order();
        // $product = new Product();
        $user = auth()->user()->id;

        $order->id_user = $user;
        $order->save();
        $idOrder = $order->id;


        if (Cart::where('id_user', $user)->first()) {
            $hasil = Cart::where('id_user', $user)
                ->get();


            for ($i = 0; $i < count($hasil); $i++) {
                $orderproduct = new OrderProduct();
                $orderproduct->id_order = $order->id;
                $orderproduct->id_product = $hasil[$i]->id_product;
                $orderproduct->quantity = $hasil[$i]->quantity;
                $orderproduct->cost = $hasil[$i]->sumcost;
                $orderproduct->save();
            };
            $del = Cart::where('id_user', $user)
                ->delete();
        }
    }

    public function putOrder(Request $request)
    {
        $user = auth()->user()->id;
        $order = Order::select('id')
            ->where('id_user', $user)
            ->latest()
            ->first();
        $hasil = Order::find($order->id);
        $hasil->id_user = $user;
        $hasil->status = $request->status;
        $hasil->id_voucher = $request->id_voucher;

        $hasil->sumcost = 

        $hasil->save();
    }

    public function getOrder()
    {
        $user = auth()->user()->id;
        $order = Order::select('id')
            ->where('id_user', $user)
            ->latest()
            ->first();
        $join = Order::join('ordersproducts', 'orders.id', '=', 'ordersproducts.id_order')
            ->select(
                'ordersproducts.id_product',
                'ordersproducts.quantity',
                'ordersproducts.cost',
                'orders.status',
                'orders.sumcost',
                'orders.payment'
            )
            ->where('ordersproducts.id_order', $order->id)
            ->get();

        return $join;
    }
    
}
