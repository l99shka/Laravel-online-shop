<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use function Termwind\style;

class MainController extends Controller
{
    public function main()
    {
        return view('main.index', [
            'categories' => Category::with('children')->where('parent_id', 0)->get(),
            'products' => Product::get()
        ]);

    }

    public function catalog()
    {
        return view('main.catalog', [
            'categories' => Category::with('children')->where('parent_id', 0)->get(),
            'products' => Product::get()
        ]);
    }

    public function category($id)
    {
        return view('main.category', [
            'products' => Product::where('category_id', $id)->get(),
            'categories' => Category::with('children')->where('parent_id', 0)->get(),
            'categoriesChildren' => Category::with('children')->where('parent_id', $id)->get(),
            'categoriesParent' => Category::where('id', $id)->get(),
        ]);
    }
}
