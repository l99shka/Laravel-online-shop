<?php

namespace App\Service\Cart;

use App\Models\Cart;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CartService
{
    public function getCart(): Cart
    {
        $cartName = 'products';

        if (Auth::id()) {
            $cart = Cart::where('user_id', Auth::id())->first();
            if ($cart) {
                return $cart;
            }
            return Cart::create([
                'user_id' => Auth::id(),
                'name'    => $cartName
            ]);
        } else {
            $user = new User();
            $user->save();
            Auth::login($user);

            return Cart::create([
                'user_id' => Auth::id(),
                'name'    => $cartName
            ]);
        }
    }

    public function add(int $productId): void
    {
        $cart = $this->getCart();

        if ($cart->products->contains($productId)) {
            $pivotRow = $cart->products()->where(['user_id' => Auth::id(), 'product_id' => $productId])->first()->pivot;
            $pivotRow->quantity++;
            $pivotRow->update();
        } else {
            $cart->products()->attach($productId, ['user_id' => Auth::id()]);
        }
    }

    public function updateQuantityMinus(int $productId): void
    {
        $cart = $this->getCart();

        if ($cart->products->contains($productId)) {
            $pivotRow = $cart->products()->where(['user_id' => Auth::id(), 'product_id' => $productId])->first()->pivot;

            if ($pivotRow->quantity > 1) {
                $pivotRow->quantity--;
                $pivotRow->update();
            }
        }
    }

    public function deleteAll(int $productId): void
    {
        $cart = $this->getCart();

        if ($cart->products->contains($productId)) {
            $cart->products()->where(['user_id' => Auth::id(), 'product_id' => $productId])->first()->pivot;
            $cart->products()->detach($productId, ['user_id' => Auth::id()]);
        }
    }
}
