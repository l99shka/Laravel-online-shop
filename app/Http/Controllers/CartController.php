<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Service\Cart\CartService;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CartController extends Controller
{
    private CartService $service;

    public function __construct(CartService $service)
    {
        $this->service = $service;
    }

    public function cart(): View
    {
        $cart = Cart::where('user_id', Auth::id())->first();
        return $this->service->cart($cart);
    }

    public function add(): void
    {
        $cartName = 'products';
        $cart = Cart::where('user_id', Auth::id())->first();
        $this->service->add($cart, $cartName);
    }

    public function updateQuantityMinus(): void
    {
        $cart = Cart::where('user_id', Auth::id())->first();
        $this->service->updateQuantityMinus($cart);
    }

    public function deleteAll(): void
    {
        $cart = Cart::where('user_id', Auth::id())->first();
        $this->service->deletAll($cart);
    }
}
