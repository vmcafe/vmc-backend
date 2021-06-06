<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;

class CartController extends Controller
{
    public function addCart(Request $request)
    {
        $rules = [
            // 'id_user' => 'required',
            'id_product' => 'required',
            'quantity' => 'required'
        ];
        $this->validate($request, $rules);

        $user = auth()->user()->id;
        // $valid = $request->all();
        $cart = new Cart();
        $cart->id_user = $user;
        $cart->id_product = $request->id_product;
        $cart->quantity = $request->quantity;
        $cost = Product::where('id', $cart->id_product)
            ->first();
        $cart->cost = $cost->price * $cart->quantity;
        $cart->save();
        return $this->responseSuccess($cart);
    }

    public function getCart()
    {
        $id = auth()->user()->id;
        $hasil = Cart::with(['products'])
            ->where('Cart.id_user', $id)
            ->get();

            return response()
                ->json(['data' => $hasil], 200);
        
    }
}
