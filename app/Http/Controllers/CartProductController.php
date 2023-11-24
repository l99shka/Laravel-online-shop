<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function cart()
    {
        $cart = DB::table('products')
            ->join('carts', 'carts.product_id', '=', 'products.id')
            ->select('carts.id', 'products.image', 'products.name', 'products.description', 'carts.quantity', DB::raw('products.price*carts.quantity as price'))
            ->where('carts.user_id', '=', Auth::id())
            ->get();

        $sumTotalPrice = $cart->sum('price');

        return view('cart.cart', [
            'categories' => Category::with('children')->where('parent_id', 0)->get(),
            'cart' => $cart,
            'sumQuantity' => Cart::where('user_id', Auth::id())->sum('quantity'),
            'sumTotalPrice' => $sumTotalPrice
        ]);
    }

    public function addToCart(Request $request)
    {
        if (empty(Auth::id()))
        {
            $user = new User();
            $user->save();

            Auth::login($user);
//            cartProduct
            Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $request->id,
                'quantity' => 1
            ]);

        } else {
            $product = Product::findOrFail($request->id);

            if ($cart = Cart::where(['user_id' => Auth::id(), 'product_id' => $product->id])->first()) {
                $cart->quantity++;
                $cart->save();
            } else {
                Cart::create([
                    'user_id' => Auth::id(),
                    'product_id' => $request->id,
                    'quantity' => 1
                ]);
            }
            return response()->json(['status' => true]);
        }
    }

    public function updateQuantityPlus(Request $request)
    {
        if ($cart = Cart::where('id', $request->id)->first()) {
            $cart->increment('quantity', 1);
        }
    }

    public function updateQuantityMinus(Request $request)
    {
        if ($cart = Cart::where('id', $request->id)->first()) {
            if ($cart->quantity > 1) {
                $cart->decrement('quantity', 1);
            }
        }
    }

    public function deleteProduct(Request $request)
    {
        if ($cart = Cart::where('id', $request->id)->first()) {
            $cart->delete();
        }
    }
}
