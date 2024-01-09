<?php

namespace App\Http\Controllers;

use App\Service\Cart\CartService;
use Illuminate\Http\Request;
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
        $cart = $this->service->getCart();

        return view('cart-product.cart-product', [
            'products'   => $cart->products,
        ]);
    }

    public function add(Request $request): void
    {
        $this->service->add($request->id);
    }

    public function updateQuantityMinus(Request $request): void
    {
        $this->service->updateQuantityMinus($request->id);
    }

    public function deleteAll(Request $request): void
    {
        $this->service->deleteAll($request->id);
    }
}
