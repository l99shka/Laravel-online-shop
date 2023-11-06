<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;

class CartController extends Controller
{
    public function cart()
    {
        return view('carts.carts', [
            'categories' => Category::with('children')->where('parent_id', 0)->get()
        ]);
    }

    public function addToCart()
    {

    }
}
