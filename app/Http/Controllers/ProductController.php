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
            'id_category' => 'required',
            'description' => 'required',
            'stock' => 'required',
            'type' => 'required',
            'netto' => 'required',
            'price' => 'required',
            'photo' => 'required',
        ];
        $this->validate($request, $rules);

        $product = new Product;
        $product->name = $request->name;
        
        $product->id_category = $request->id_category;
        // $product->photo = $request->file('photo');
        // $tujuan = 'data_gambar';
        // $product->photo->move($tujuan, $product->photo->getClientOriginalName());
        // $foto = $request->photo->store('photo');
        // $extension = $foto->getClientOriginalExtension();
        // $foto->move('/home/vmct8135/public_html/uploads',$foto->getFilename().'.'.$extension);
        // $pathDefault = '/home/vmct8135/public_html/uploads/';
        // $product->photo = $pathDefault.$foto->getFilename().'.'.$extension;
        $product->photo = $request->file('photo')->store(
            '/home/vmct8135/repositories/vmc-backend/public/data_gambar', 'public'
           );
        $product->description = $request->description;
        $product->stock = $request->stock;
        $product->price = $request->price;
        $product->type = $request->type;
        $product->netto = $request->netto;

        $product->save();

        return $this->responseSuccess($product);
    }

    public function getProducts()
    {
        $data = Product::where('type', 'medium')
            ->get();

        return $this->responseSuccess($data);
    }

    public function getProduct($id)
    {
        if (Product::where('id_category', $id)->first()) {
            $hasil = Product::where('id_category', $id)
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

    public function getDetailProduct($id)
    {
        if (Product::where('id', $id)->first()) {
            $hasil = Product::where('id', $id)
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

    public function getReccomProduct($id)
    {
        if (Product::where('id_category', $id)->first()) {
            if ($id == 1) {
                $hasil = Product::where('id_category', 2)
                    ->get();
            }
            else {
                $hasil = Product::where('id_category', 1)
                    ->get();
            }

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
