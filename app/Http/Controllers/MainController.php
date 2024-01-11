<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function main(Request $request)
    {
        $products = Product::paginate(5);

        if ($request->ajax()) {
            $view = view('main.products', [
                'products'        => $products,
                'hasMoreProducts' => $products->hasMorePages() // Проверка на наличие следующей страницы
            ])->render();

            return response()->json(['html' => $view]);
        }

        return view('main.index', [
            'products'        => $products,
            'hasMoreProducts' => $products->hasMorePages() // Проверка на наличие следующей страницы
        ]);
    }

    public function catalog()
    {
        return view('main.catalog', [
            'categories' => Category::whereIsRoot()->get()
        ]);
    }

    public function category(int $id, Request $request)
    {
        Category::fixTree();
        $category = Category::find($id);
        $categories = $category->descendants()->pluck('id');
        $categories[] = $category->getKey();

        $products = Product::whereIn('category_id', $categories)->paginate(5);

        if ($request->ajax()) {
            $view = view('main.products', [
                'categoriesParent'   => Category::where('id', $id)->get(),
                'categoriesChildren' => Category::descendantsOf($id),
                'products'           => $products,
                'currentCategoryId'  => $id,
                'hasMoreProducts'    => $products->hasMorePages() // Проверка на наличие следующей страницы
            ])->render();

            return response()->json(['html' => $view]);
        }

        return view('main.category', [
            'categoriesParent'   => Category::where('id', $id)->get(),
            'categoriesChildren' => Category::descendantsOf($id),
            'products'           => $products,
            'currentCategoryId'  => $id,
            'hasMoreProducts'    => $products->hasMorePages() // Проверка на наличие следующей страницы
        ]);
    }
}
