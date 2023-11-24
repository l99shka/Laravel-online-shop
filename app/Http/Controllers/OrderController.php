<?php

namespace App\Http\Controllers;

use App\Http\Requests\Orders\OrderRequest;
use App\Models\CartProduct;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderPosition;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


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

    public function addOrders(OrderRequest $request)
    {
        DB::beginTransaction();

        try {

            $order = Order::create([
                'user_id'    => Auth::id(),
                'comment' => $request->message,
                'contact_phone'   => $request->phone
            ]);

            $products = DB::table('products')
                ->join('cart_products', 'cart_products.product_id', '=', 'products.id')
                ->select(DB::raw('products.price*cart_products.quantity as price'), 'cart_products.product_id', 'cart_products.quantity')
                ->where('cart_products.user_id', '=', Auth::id())
                ->get();

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
    }

    public function pay()
    {
        return view('orders.pay');
    }
}
