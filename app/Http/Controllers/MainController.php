<?php

namespace App\Http\Controllers;

use App\Models\CartProduct;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class MainController extends Controller
{
    public function main()
    {
        return view('main.index', [
            'categories'  => Category::with('children')->where('parent_id', 0)->get(),
            'products'    => Product::get(),
            'sumQuantity' => CartProduct::where('user_id', Auth::id())->sum('quantity')
        ]);

    }

    public function catalog()
    {
        return view('main.catalog', [
            'categories'  => Category::with('children')->where('parent_id', 0)->get(),
            'products'    => Product::get(),
            'sumQuantity' => CartProduct::where('user_id', Auth::id())->sum('quantity')
        ]);
    }

    public function category($id)
    {
        return view('main.category', [
            'products'           => Product::where('category_id', $id)->get(),
            'categories'         => Category::with('children')->where('parent_id', 0)->get(),
            'categoriesChildren' => Category::with('children')->where('parent_id', $id)->get(),
            'categoriesParent'   => Category::where('id', $id)->get(),
            'sumQuantity'        => CartProduct::where('user_id', Auth::id())->sum('quantity')
        ]);
    }
}
