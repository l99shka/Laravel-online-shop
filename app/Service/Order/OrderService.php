<?php

namespace App\Service\Order;

use App\Http\Requests\Order\OrderRequest;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderPosition;
use App\Service\Payment\PaymentService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderService
{
    public function order($cart): View|Factory|Application|RedirectResponse
    {
        if ($cart && count($cart->products)) {
            return view('order.order', [
                'products'   => $cart->products
            ]);
        }
        return redirect()->back();
    }

    public function add($cart, PaymentService $service, OrderRequest $request): JsonResponse|string
    {
        $products = $cart->products;
        $cartCost = 0;

        DB::beginTransaction();
        try {
            $order = Order::create([
                'user_id'       => Auth::id(),
                'comment'       => $request->message,
                'contact_phone' => $request->phone,
                'email'         => $request->email
            ]);


            if ($cart && count($products)) {

                foreach ($products as $product) {
                    $itemPrice    = $product->price;
                    $itemQuantity = $product->pivot->quantity;
                    $itemCost     = $itemPrice * $itemQuantity;
                    $cartCost     = $cartCost + $itemCost;

                    $orderPosition = new OrderPosition();

                    $orderPosition->product_id  = $product->pivot->product_id;
                    $orderPosition->quantity    = $itemQuantity;
                    $orderPosition->total_price = $itemCost;
                    $orderPosition->order_id    = $order->id;

                    $orderPosition->save();
                }
            }

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json(['alert' => 'Повторите попытку']);
        }
        return $service->createPayment($cartCost, [
            'order_id' => $order->id,
            'user_id'  => Auth::id(),
            'email'    => $order->email
        ]);
    }
}
