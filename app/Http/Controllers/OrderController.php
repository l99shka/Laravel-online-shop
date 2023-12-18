<?php

namespace App\Http\Controllers;

use App\Http\Requests\Orders\OrderRequest;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderPosition;
use App\Service\MessageService;
use App\Service\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use YooKassa\Model\Notification\NotificationEventType;
use YooKassa\Model\Notification\NotificationSucceeded;
use YooKassa\Model\Notification\NotificationWaitingForCapture;


class OrderController extends Controller
{
    public function order(Request $request)
    {
        $cart_id = $request->cookie('cart_id');

        if ($cart_id && count($products = Cart::findOrFail($cart_id)->products)) {

            return view('order.order', [
                'categories' => Category::with('children')->where('parent_id', 0)->get(),
                'products' => $products,
                'sumQuantity' => $products->where('pivot.user_id', Auth::id())->sum('pivot.quantity')
            ]);
        }
        return redirect()->back();
    }

    public function add(OrderRequest $request, PaymentService $service)
    {
        $cartCost = 0;

        DB::beginTransaction();
        try {
            $order = Order::create([
                'user_id'         => Auth::id(),
                'comment'         => $request->message,
                'contact_phone'   => $request->phone,
                'email'           => $request->email
            ]);

            $cart_id = $request->cookie('cart_id');

            if ($cart_id && count($products = Cart::findOrFail($cart_id)->products)) {

                foreach ($products as $product) {
                    $itemPrice = $product->price;
                    $itemQuantity =  $product->pivot->quantity;
                    $itemCost = $itemPrice * $itemQuantity;
                    $cartCost = $cartCost + $itemCost;

                    $orderPosition = new OrderPosition();

                    $orderPosition->product_id = $product->pivot->product_id;
                    $orderPosition->quantity = $itemQuantity;
                    $orderPosition->total_price = $itemCost;
                    $orderPosition->order_id = $order->id;

                    $orderPosition->save();
                }
            }

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json(['alert' => 'Повторите попытку']);
        }

        $link = $service->createPayment($cartCost, [
            'order_id' => $order->id,
            'user_id'  => Auth::id(),
            'email'    => $order->email
        ]);

        return response()->json(['link' => $link]);
    }

    public function callbackPay(PaymentService $service, MessageService $message)
    {
        $source = file_get_contents('php://input');
        $requestBody = json_decode($source, true);
        $notification = ($requestBody['event'] && $requestBody['event'] === NotificationEventType::PAYMENT_SUCCEEDED)
              ? new NotificationSucceeded($requestBody)
              : new NotificationWaitingForCapture($requestBody);
        $payment = $notification->getObject();

        if (isset($payment->status) && $payment->status === 'waiting_for_capture') {
            $service->getClient()->capturePayment([
                'amount' => $payment->amount
            ], $payment->id, uniqid('', true));
        }

        if (isset($payment->status) && $payment->status === 'succeeded') {
            $metadata = $payment->metadata;

            if(isset($metadata->user_id)) {

//                $userId = $metadata->user_id;
                Cookie::forget('cart_id');

            }
            if ($payment->paid === true) {

                if(isset($metadata->order_id)) {

                    $orderId = $metadata->order_id;
                    $order = Order::find($orderId);
                    $order->status = Order::PAID;
                    $order->save();
                }

                if(isset($metadata->email)) {

                    $email = $metadata->email;
                    $queue = 'OrderMessage';
                    $data = [
                        'email' => $email
                    ];
                    $message->publish($queue, $data);
                }
            }
        }
    }
}
