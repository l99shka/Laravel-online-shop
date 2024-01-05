<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class MainController extends Controller
{
    public function main()
    {
        return view('main.index', [
            'products'   => Product::get(),
        ]);
    }

    public function catalog()
    {
        return view('main.catalog', [
            'categories' => Category::whereIsRoot()->get()
        ]);
    }

    public function category($id)
    {
        Category::fixTree();
        $category = Category::find($id);
        $categories = $category->descendants()->pluck('id');
        $categories[] = $category->getKey();

        $products = Product::whereIn('category_id', $categories)->get();

        return view('main.category', [
            'products'           => $products,
            'categoriesChildren' => Category::descendantsOf($id),
            'categoriesParent'   => Category::where('id', $id)->get(),
        ]);
    }
}
