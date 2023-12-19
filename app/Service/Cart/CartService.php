<?php

namespace App\Service\Cart;

use App\Models\Cart;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CartService
{
    private Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    public function cart($cart): View
    {
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

    public function add($cart, string $cartName): void
    {
        if (Auth::id() && $cart) {
            // обновляем поле `updated_at` таблицы `carts`
            $cart->touch();

            if ($cart->products->contains($this->request->id)) {
                $pivotRow = $cart->products()->where(['user_id' => Auth::id(), 'product_id' => $this->request->id])->first()->pivot;
                $pivotRow->quantity++;
                $pivotRow->update();
            } else {
                $cart->products()->attach($this->request->id, ['user_id' => Auth::id()]);
            }

        } else {
            if (empty(Auth::id())) {
                $user = new User();
                $user->save();
                Auth::login($user);
            }

            $cart = Cart::create([
                'user_id' => Auth::id(),
                'name'    => $cartName
            ]);

            $cart->products()->attach($this->request->id, ['user_id' => Auth::id()]);
        }
    }

    public function updateQuantityMinus($cart): void
    {
        // обновляем поле `updated_at` таблицы `carts`
        $cart->touch();

        if ($cart->products->contains($this->request->id)) {
            $pivotRow = $cart->products()->where(['user_id' => Auth::id(), 'product_id' => $this->request->id])->first()->pivot;

            if ($pivotRow->quantity > 1) {
                $pivotRow->quantity--;
                $pivotRow->update();
            }
        }
    }

    public function deletAll($cart): void
    {
        // обновляем поле `updated_at` таблицы `carts`
        $cart->touch();

        if ($cart->products->contains($this->request->id)) {
            $cart->products()->where(['user_id' => Auth::id(), 'product_id' => $this->request->id])->first()->pivot;
            $cart->products()->detach($this->request->id, ['user_id' => Auth::id()]);
        }
    }
}
