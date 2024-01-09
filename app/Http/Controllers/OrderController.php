<?php

namespace App\Http\Controllers;

use App\Http\Requests\Order\OrderRequest;
use App\Models\Cart;
use App\Service\Cart\CartService;
use App\Service\Message\MessageService;
use App\Service\Order\OrderService;
use App\Service\Payment\PaymentService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;


class OrderController extends Controller
{
    private OrderService $service;

    public function __construct(OrderService $service)
    {
        $this->service = $service;
    }

    public function order(CartService $cartService): View|Factory|Application|RedirectResponse
    {
        $cart = $cartService->getCart();

        if (count($cart->products)) {
            return view('order.order', [
                'products'   => $cart->products
            ]);
        }
        return redirect()->back();
    }

    public function add(CartService $cartService, PaymentService $paymentService, OrderRequest $request): JsonResponse
    {
        $cart = $cartService->getCart();
        $link = $this->service->add($cart, $paymentService, $request);

        return response()->json(['link' => $link]);
    }

    public function callbackPay(PaymentService $service, MessageService $message): void
    {
        $service->callbackPay($message);
    }
}
