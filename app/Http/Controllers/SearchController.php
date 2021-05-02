<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class SearchController extends Controller
{
    public function get(Request $request)
    {
        try {
            $search = $request->search;
            $product = Product::where('name', 'LIKE', "%{$search}%")
                ->get();
            if (count($product) == 0) {
                return response()->json([
                    'message' => 'data tidak ditemukan',
                    'data' => (object) []
                ], 404);
            } else{
                return $this->responseSuccess($product);
            }
        } catch (\Exception $e) {
            return $this->responseException($e);
        }
    }
}
