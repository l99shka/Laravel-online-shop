<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MainController extends Controller
{
    public function main()
    {
        $cart = Cart::where('user_id', Auth::id())->first();

        if ($cart) {
            $products = $cart->products;

            return view('main.index', [
                'categories'  => Category::with('children')->where('parent_id', 0)->get(),
                'products'    => Product::get(),
                'sumQuantity' => $products->where('pivot.user_id', Auth::id())->sum('pivot.quantity')
            ]);
        }

        return view('main.index', [
            'categories'  => Category::with('children')->where('parent_id', 0)->get(),
            'products'    => Product::get(),
            'sumQuantity' => 0
        ]);
    }

    public function catalog()
    {
        $cart = Cart::where('user_id', Auth::id())->first();

        if ($cart) {
            $products = $cart->products;

            return view('main.catalog', [
                'categories'  => Category::with('children')->where('parent_id', 0)->get(),
                'products'    => Product::get(),
                'sumQuantity' => $products->where('pivot.user_id', Auth::id())->sum('pivot.quantity')
            ]);
        }

        return view('main.catalog', [
            'categories'  => Category::with('children')->where('parent_id', 0)->get(),
            'products'    => Product::get(),
            'sumQuantity' => 0
        ]);
    }

    public function category($id)
    {
        $cart = Cart::where('user_id', Auth::id())->first();

        if ($cart) {
            $products = $cart->products;

            return view('main.category', [
                'products'           => Product::where('category_id', $id)->get(),
                'categories'         => Category::with('children')->where('parent_id', 0)->get(),
                'categoriesChildren' => Category::with('children')->where('parent_id', $id)->get(),
                'categoriesParent'   => Category::where('id', $id)->get(),
                'sumQuantity' => $products->where('pivot.user_id', Auth::id())->sum('pivot.quantity')
            ]);
        }

        return view('main.category', [
            'products'           => Product::where('category_id', $id)->get(),
            'categories'         => Category::with('children')->where('parent_id', 0)->get(),
            'categoriesChildren' => Category::with('children')->where('parent_id', $id)->get(),
            'categoriesParent'   => Category::where('id', $id)->get(),
            'sumQuantity' => 0
        ]);
    }
}
