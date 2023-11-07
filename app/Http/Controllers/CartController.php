<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Product;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function cart()
    {
        $join = DB::table('products')
            ->join('carts', 'carts.product_id', '=', 'products.id')
            ->select('products.image', 'products.name', 'products.description', 'products.price', 'carts.quantity')
            ->where('carts.user_id', '=', Auth::id())
            ->get();

        return view('cart.cart', [
            'categories' => Category::with('children')->where('parent_id', 0)->get(),
            'cart' => $join
        ]);
    }

    public function addToCart($product_id)
    {
        $product = Product::findOrFail($product_id);

        if($cart = Cart::where(['user_id' => Auth::id(), 'product_id' => $product->id])->first()) {
            $cart->quantity++;
            $cart->save();
        } else {
            Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $product_id,
                'quantity' => 1
            ]);
        }

        return redirect(RouteServiceProvider::HOME);
    }
}
