<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
class ProductController extends Controller
{
    public function addProduct(Request $request)
    {
        $rules = [
            'name' => 'required',
            'description' => 'required',
            'amount' => 'required',
            'price' => 'required',
            'best' => 'required',
            'photo' => 'required',
        ];
        $this->validate($request, $rules);

        $product = new Product;
        $product->name = $request->name;
        $product->photo = $request->file('photo');
        $tujuan = 'data_gambar';
        $product->photo->move($tujuan, $product->photo->getClientOriginalName());
        $product->description = $request->description;
        $product->amount = $request->amount;
        $product->price = $request->price;
        $product->best = $request->best;

        $product->save();

        return $this->responseSuccess($product);
    }

    public function getProducts()
    {
        $data = Product::whereNull('deleted_at')
        ->get();

        return $this->responseSuccess($data);
    }

    public function getProduct($id)
    {
       $product = Product::find($id);

       return response()
       ->json(['data' => $product], 200);
    }

    public function getBest()
    {
        $hasil = Product::where('best', 1)
            ->get();
    
        return $this->responseSuccess($hasil);
    }
}
