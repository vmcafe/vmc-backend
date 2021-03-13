<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;

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
        $cart->save();
        return $this->responseSuccess($cart);
    }

    public function getCart()
    {
        $id = auth()->user()->id;
        if (Cart::where('id_user', $id)->first()) {
            $hasil = Cart::where('id_user', $id)
                ->get();

            return response()
                ->json(['data' => $hasil], 200);
        } else {
            return response()->json([
                'message' => 'data tidak ditemukan',
                'data' => (object) []
            ], 404);
        }
    }
}
