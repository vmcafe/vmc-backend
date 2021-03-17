<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wishlist;

class WishlistController extends Controller
{
    public function addWishlist(Request $request)
    {
        $rules = [
            // 'id_user' => 'required',
            'id_product' => 'required',
        ];
        $this->validate($request, $rules);

        $user = auth()->user()->id;
        // $valid = $request->all();
        $wishlist = new Wishlist();
        $wishlist->id_user = $user;
        $wishlist->id_product = $request->id_product;
        $wishlist->save();
        return $this->responseSuccess($wishlist);
    }

    public function getWishlist()
    {
        $id = auth()->user()->id;
        if (Wishlist::where('id_user', $id)->first()) {
            $hasil = Wishlist::where('id_user', $id)
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

    public function delWishlist(Request $request)
    {
        $rules = [
            'id_product' => 'required'
        ];
        $this->validate($request, $rules);

        $wishlist = $request->id_product;
        $id = auth()->user()->id;
        if (Wishlist::where('id_user', $id)->first()) {
            $hasil = Wishlist::where('id_product', $wishlist)
                ->delete();

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