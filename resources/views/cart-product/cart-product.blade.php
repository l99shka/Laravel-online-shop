@extends('layouts.cart-master')
@section('title', 'Корзина')
@section('cart')

    <div class="shopping-cart">
        <!-- Title -->
        <div class="title">
            Ваша корзина
        </div>

        @foreach($cartProduct as $elem)
        <div class="item">
            <div class="buttons">
                <span class="delete-btn" data-id="{{ $elem->id }}"></span>
            </div>

            <div class="image">
                <img src="{{ $elem->image }}" width="80px" height="80px" alt="" />
            </div>

            <div class="description">
                <span>{{ $elem->name }}</span>
                <span>{{ $elem->description }}</span>
            </div>

            <div class="quantity">
                <button class="plus-btn" type="button" name="button" data-id="{{ $elem->id }}">
                    <img src="https://designmodo.com/demo/shopping-cart/plus.svg" alt="" />
                </button>
                    <input type="text" name="name" value="{{ $elem->quantity }}">
                <button class="minus-btn" type="button" name="button" data-id="{{ $elem->id }}">
                    <img src="https://designmodo.com/demo/shopping-cart/minus.svg" alt="" />
                </button>
            </div>

            <div class="total-price">{{ number_format($elem->price, 2, ',', ' ') }} руб.</div>
        </div>
        @endforeach

        <a href="{{ route('orders') }}" class="order-button"> Оформить заказ <br> На сумму - {{ number_format($sumTotalPrice, 2, ',', ' ') }} руб.</a>

    </div>

@endsection
