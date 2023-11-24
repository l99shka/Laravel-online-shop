<?php

namespace App\Http\Controllers;

use App\Models\CartProduct;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartProductController extends Controller
{
    public function cartProduct()
    {
        $cartProduct = DB::table('products')
            ->join('cart_products', 'cart_products.product_id', '=', 'products.id')
            ->select('cart_products.id', 'products.image', 'products.name', 'products.description', 'cart_products.quantity', DB::raw('products.price*cart_products.quantity as price'))
            ->where('cart_products.user_id', '=', Auth::id())
            ->get();

        $sumTotalPrice = $cartProduct->sum('price');

        return view('cart-product.cart-product', [
            'categories' => Category::with('children')->where('parent_id', 0)->get(),
            'cartProduct' => $cartProduct,
            'sumQuantity' => CartProduct::where('user_id', Auth::id())->sum('quantity'),
            'sumTotalPrice' => $sumTotalPrice
        ]);
    }

    public function addToCartProduct(Request $request)
    {
        if (empty(Auth::id()))
        {
            $user = new User();
            $user->save();

            Auth::login($user);

            CartProduct::create([
                'user_id' => Auth::id(),
                'product_id' => $request->id,
                'quantity' => 1
            ]);

        } else {
            $product = Product::findOrFail($request->id);

            if ($cart = CartProduct::where(['user_id' => Auth::id(), 'product_id' => $product->id])->first()) {
                $cart->quantity++;
                $cart->save();
            } else {
                CartProduct::create([
                    'user_id' => Auth::id(),
                    'product_id' => $request->id,
                    'quantity' => 1
                ]);
            }
        }
    }

    public function updateQuantityPlus(Request $request)
    {
        if ($cart = CartProduct::where('id', $request->id)->first()) {
            $cart->increment('quantity', 1);
        }
    }

    public function updateQuantityMinus(Request $request)
    {
        if ($cart = CartProduct::where('id', $request->id)->first()) {
            if ($cart->quantity > 1) {
                $cart->decrement('quantity', 1);
            }
        }
    }

    public function deleteToCartProduct(Request $request)
    {
        if ($cart = CartProduct::where('id', $request->id)->first()) {
            $cart->delete();
        }
    }
}
