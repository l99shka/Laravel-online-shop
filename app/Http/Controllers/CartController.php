<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class CartController extends Controller
{
    public function cart(Request $request)
    {
        $cart_id = $request->cookie('cart_id');

        if ($cart_id) {
            $products = Cart::findOrFail($cart_id)->products;

            return view('cart-product.cart-product', [
                'categories' => Category::with('children')->where('parent_id', 0)->get(),
                'products' => $products,
                'sumQuantity' => $products->where('pivot.user_id', Auth::id())->sum('pivot.quantity')
            ]);
        }

        return view('cart-product.cart-product', [
            'categories' => Category::with('children')->where('parent_id', 0)->get(),
            'products' => [],
            'sumQuantity' => 0
        ]);
    }

    public function add(Request $request)
    {
        $cart_id = $request->cookie('cart_id');

        if ($cart_id && Auth::id()) {
            $cart = Cart::findOrFail($cart_id);
            // обновляем поле `updated_at` таблицы `carts`
            $cart->touch();

            if ($cart->products->contains($request->id)) {
                $pivotRow = $cart->products()->where(['user_id' => Auth::id(), 'product_id' => $request->id])->first()->pivot;
                $pivotRow->quantity++;
                $pivotRow->update();
            } else {
                $cart->products()->attach($request->id, ['user_id' => Auth::id()]);
            }

        } else {
            $user = new User();
            $user->save();
            Auth::login($user);

            $cart = Cart::create();
            $cookieCartId = Cookie::forever('cart_id', $cart->id);
            $response = response()->json(['success' => true]);
            $response->headers->setCookie($cookieCartId);

            $cart->products()->attach($request->id, ['user_id' => Auth::id()]);

            return $response;
        }
    }

    public function updateQuantityMinus(Request $request)
    {
        $cart_id = $request->cookie('cart_id');

        $cart = Cart::findOrFail($cart_id);
        // обновляем поле `updated_at` таблицы `carts`
        $cart->touch();

        if ($cart->products->contains($request->id)) {
            $pivotRow = $cart->products()->where(['user_id' => Auth::id(), 'product_id' => $request->id])->first()->pivot;

            if ($pivotRow->quantity > 1) {
                $pivotRow->quantity--;
                $pivotRow->update();
            }
        }
    }

    public static function deleteAll(Request $request)
    {
        $cart_id = $request->cookie('cart_id');

        $cart = Cart::findOrFail($cart_id);
        // обновляем поле `updated_at` таблицы `carts`
        $cart->touch();

        if ($cart->products->contains($request->id)) {
            $cart->products()->where(['user_id' => Auth::id(), 'product_id' => $request->id])->first()->pivot;
            $cart->products()->detach($request->id, ['user_id' => Auth::id()]);
        }
    }
}
