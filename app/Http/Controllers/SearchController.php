<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
class SearchController extends Controller
{
    public function get(Request $request)
    {
        $search = $request->search;
        $product = Product::where('name', 'LIKE', "%{$search}%")
        ->get();
        return $product;
    }
}
