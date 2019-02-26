<?php

namespace Laravel\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Category;

class CategoryController extends Controller
{
    public function search($category_name)
    {
        $category = Category::where('name',$category_name)->first();
        $products="test";
        $products = $category->products()->get();
        return view('category.search')->with(compact('category','products'));
    }
}
