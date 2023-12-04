<?php

namespace App\Http\Controllers;

use App\Http\Requests\Orders\OrderRequest;
use App\Models\CartProduct;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderPosition;
use App\Service\PaymentService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use YooKassa\Model\Notification\NotificationEventType;
use YooKassa\Model\Notification\NotificationSucceeded;
use YooKassa\Model\Notification\NotificationWaitingForCapture;


class OrderController extends Controller
{
    public function order()
    {
        $cartProduct = DB::table('products')
            ->join('cart_products', 'cart_products.product_id', '=', 'products.id')
            ->select('cart_products.id', 'products.image', 'products.name', 'products.description', 'cart_products.quantity', DB::raw('products.price*cart_products.quantity as price'))
            ->where('cart_products.user_id', '=', Auth::id())
            ->get();

        $sumTotalPrice = $cartProduct->sum('price');

        return view('orders.orders', [
            'categories' => Category::with('children')->where('parent_id', 0)->get(),
            'cartProduct' => $cartProduct,
            'sumQuantity' => CartProduct::where('user_id', Auth::id())->sum('quantity'),
            'sumTotalPrice' => $sumTotalPrice
        ]);
    }

    public function addOrders(OrderRequest $request, PaymentService $service)
    {
        $products = DB::table('products')
            ->join('cart_products', 'cart_products.product_id', '=', 'products.id')
            ->select(DB::raw('products.price*cart_products.quantity as price'), 'cart_products.product_id', 'cart_products.quantity')
            ->where('cart_products.user_id', '=', Auth::id())
            ->get();

        $amount = $products->sum('price');

        DB::beginTransaction();
        try {
            $order = Order::create([
                'user_id'         => Auth::id(),
                'comment'         => $request->message,
                'contact_phone'   => $request->phone
            ]);

            foreach ($products as $item) {

                $orderPosition = new OrderPosition();

                $orderPosition->product_id = $item->product_id;
                $orderPosition->quantity = $item->quantity;
                $orderPosition->total_price = $item->price;
                $orderPosition->order_id = $order->id;

                $orderPosition->save();
            }

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json(['alert' => 'Повторите попытку']);
        }

        $link = $service->createPayment($amount, [
            'order_id' => $order->id,
            'user_id'  => Auth::id()
        ]);

        return response()->json(['link' => $link]);
    }

    public function callbackPay(PaymentService $service)
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

                $userId = $metadata->user_id;
                CartProduct::where('user_id', $userId)->delete();
            }
            if ($payment->paid === true) {

                if(isset($metadata->order_id)) {

                    $orderId = $metadata->order_id;
                    $order = Order::find($orderId);
                    $order->status = Order::PAID;
                    $order->save();
                }
            }
        }
    }
}
