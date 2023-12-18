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
        $cart = Cart::where('user_id', Auth::id())->first();

        if ($cart) {
            $products = $cart->products;

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
        $cartName = 'products';

        $cart = Cart::where('user_id', Auth::id())->first();

        if (Auth::id() && $cart) {
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
            if (empty($userId)) {
                $user = new User();
                $user->save();
                Auth::login($user);
            }

            $cart = Cart::create([
                'user_id' => Auth::id(),
                'name'    => $cartName
            ]);

            $cart->products()->attach($request->id, ['user_id' => Auth::id()]);
        }
    }

    public function updateQuantityMinus(Request $request)
    {
        $cart = Cart::where('user_id', Auth::id())->first();
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

    public function deleteAll(Request $request)
    {
        $cart = Cart::where('user_id', Auth::id())->first();
        // обновляем поле `updated_at` таблицы `carts`
        $cart->touch();

        if ($cart->products->contains($request->id)) {
            $cart->products()->where(['user_id' => Auth::id(), 'product_id' => $request->id])->first()->pivot;
            $cart->products()->detach($request->id, ['user_id' => Auth::id()]);
        }
    }
}
