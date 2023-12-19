<?php

namespace App\Http\Controllers;

use App\Http\Requests\Order\OrderRequest;
use App\Models\Cart;
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
    public function order(): View|Factory|Application|RedirectResponse
    {
        $cart = Cart::where('user_id', Auth::id())->first();
        return $this->service->order($cart);
    }

    public function add(PaymentService $service, OrderRequest $request): JsonResponse
    {
        $cart = Cart::where('user_id', Auth::id())->first();
        $link = $this->service->add($cart, $service, $request);

        return response()->json(['link' => $link]);
    }

    public function callbackPay(PaymentService $service, MessageService $message): void
    {
        $service->callbackPay($message);
    }
}
