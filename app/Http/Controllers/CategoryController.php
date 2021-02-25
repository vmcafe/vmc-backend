<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function addCategory(Request $request)
    {
        $rules = [
            'name' => 'required'
        ];

        $this->validate($request, $rules);

        $category = new Category;
        $category->name = $request->name;
        $category->save();

        return $this->responseSuccess($category);
    }

    public function getCategory()
    {
        $data = Category::get();

        return $this->responseSuccess($data);
    }
}
