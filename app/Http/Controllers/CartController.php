<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;

use App\Models\CartProduct;

class CartController extends Controller
{
    public function addCart(Request $request)
    {
        try {
            $user = auth()->user()->id;
            $rules = [
                // 'id_user' => 'required',
                'id_product' => 'required',
                'quantity' => 'required'
            ];
            $this->validate($request, $rules);

            if (Cart::where('id_user', $user)->first()) {
                $cartproduct = new CartProduct();
                $cart = Cart::where('id_user', $user)->first();
                $cartproduct->id_cart = $cart->id;
                $cartproduct->id_product = $request->id_product;
                $cartproduct->quantity = $request->quantity;
                $cost = Product::where('id', $cartproduct->id_product)
                    ->first();
                $cartproduct->cost = $cost->price * $cartproduct->quantity;
                $cartproduct->save();
                $total = CartProduct::where('id_cart', $cart->id)
                    ->sum('cost');
                $cart->total = $total;
                $cart->save();
                return $this->responseSuccess($cartproduct);
            } else {
                $cart = new Cart();
                $cart->id_user = $user;
                $cart->save();
                $cartproduct = new CartProduct();
                $cartproduct->id_cart = $cart->id;
                $cartproduct->id_product = $request->id_product;
                $cartproduct->quantity = $request->quantity;
                $cost = Product::where('id', $cartproduct->id_product)
                    ->first();
                $cartproduct->cost = $cost->price * $cartproduct->quantity;
                $cartproduct->save();
                $total = CartProduct::where('id_cart', $cart->id)
                    ->sum('cost');
                $cart->total = $total;
                $cart->save();
                return $this->responseSuccess($cartproduct);
            }
        } catch (\Exception $e) {
            return $this->responseException($e);
        }
    }

    public function getCart()
    {
        $id = auth()->user()->id;
        try {
            $cart = Cart::where('id_user', $id)
                ->first();
            $s = CartProduct::with(['products'])
                ->where('id_cart', $cart->id)
                ->get();

            
                    return $this->responseSuccess($s);
                
            
        } catch (\Exception $e) {
            return $this->responseException($e);
        }
        // if (Cart::where('id_user', $id)->first()) {
        //     $hasil = Cart::where('carts.id_user', $id)

        //         ->leftJoin('cartsproducts', 'carts.id', '=', 'cartsproducts.id_cart')
        //         ->leftJoin('products', 'cartsproducts.id_product', '=', 'products.id')
        //         ->leftJoin('users', 'users.id', '=', 'carts.id_user')
        //         ->get();


        // } else {
        //     return response()->json([
        //         'message' => 'data tidak ditemukan',
        //         'data' => (object) []
        //     ], 404);
        // }
    }

    public function getTotal()
    {
        $id = auth()->user()->id;
        try {
            if (Cart::where('id_user', $id)->first()) {
                $cart = Cart::where('id_user', $id)
                    ->get();
                return response()
                    ->json(['data' => $cart], 200);
            }
        } catch (\Exception $e) {
            return $this->responseException($e);
        }
    }
}
