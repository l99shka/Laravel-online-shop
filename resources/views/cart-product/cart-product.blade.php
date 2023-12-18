@extends('layouts.cart-product-master')
@section('title', 'Корзина')
@section('cart-product')

    <div class="shopping-cart">
        <div class="title">
            Ваша корзина
        </div>
        @if (count($products))
            @php
                $cartCost = 0;
            @endphp
        @foreach($products as $product)
            @php
                $itemPrice = $product->price;
                $itemQuantity =  $product->pivot->quantity;
                $itemCost = $itemPrice * $itemQuantity;
                $cartCost = $cartCost + $itemCost;
            @endphp
            <div class="item">
                <div class="buttons">
                    <span class="delete-btn" data-id="{{ $product->id }}"></span>
                </div>

                <div class="image">
                    <img src="{{ $product->image }}" width="80px" height="80px" alt=""/>
                </div>

                <div class="description">
                    <span>{{ $product->name }}</span>
                    <span>{{ $product->description }}</span>
                </div>

                <div class="quantity">
                    <button class="plus-btn" type="button" name="button" data-id="{{ $product->id }}">
                        <img src="https://designmodo.com/demo/shopping-cart/plus.svg" alt=""/>
                    </button>
                    <input type="text" name="name" value="{{ $itemQuantity }}">
                    <button class="minus-btn" type="button" name="button" data-id="{{ $product->id }}">
                        <img src="https://designmodo.com/demo/shopping-cart/minus.svg" alt=""/>
                    </button>
                </div>

                <div class="total-price">{{ number_format($itemCost, 2, ',', ' ') }} руб.</div>
            </div>
        @endforeach

        <a href="{{ route('order') }}" class="order-button"> Оформить заказ <br> На сумму - {{ number_format($cartCost, 2, ',', ' ') }} руб.</a>
        @else
            <p>
                Ваша корзина пуста!
            </p>
        @endif
    </div>

@endsection
