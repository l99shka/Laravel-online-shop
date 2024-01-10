<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function main()
    {
        return view('main.index', [
            'products'   => Product::paginate(5),
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

        $products = Product::whereIn('category_id', $categories)->paginate(2);

        return view('main.category', [
            'categoriesParent'   => Category::where('id', $id)->get(),
            'categoriesChildren' => Category::descendantsOf($id),
            'products'           => $products,
        ]);
    }

    public function loadMoreProducts(Request $request)
    {
        $nextProducts = Product::paginate(5, ['*'], 'page', $request->page);

        return response()->json($nextProducts);
    }
}
