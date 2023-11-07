<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Product;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function cart()
    {
        $sessionId = Session::getId();
        \Cart::session($sessionId);
        $cart = \Cart::getContent();

        $join = DB::table('products')
            ->join('carts', 'carts.product_id', '=', 'products.id')
            ->select('products.image', 'products.name', 'products.description', 'products.price', 'carts.quantity')
            ->where('carts.user_id', '=', Auth::id())
            ->get();

        return view('cart.cart', [
            'categories' => Category::with('children')->where('parent_id', 0)->get(),
            'cart' => $join,
            'sessionCart' => $cart
        ]);
    }

    public function addToCart($product_id)
    {

        if (!empty(Auth::id())) {
            $product = Product::findOrFail($product_id);

            if ($cart = Cart::where(['user_id' => Auth::id(), 'product_id' => $product->id])->first()) {
                $cart->quantity++;
                $cart->save();

            } else {
                Cart::create([
                    'user_id'    => Auth::id(),
                    'product_id' => $product_id,
                    'quantity'   => 1
                ]);
            }
            return redirect()->back();

        } else {
            $product = Product::query()->where(['id' => $product_id])->first();
            $sessionId = Session::getId();

            \Cart::session($sessionId)->add([
                'id'         => $product->id,
                'name'       => $product->name,
                'price'      => $product->price,
                'quantity'   => 1,
                'attributes' => ([
                    'image'  => $product->image
                ])
            ]);

            \Cart::getContent();

            return redirect()->back();
        }
    }
}
