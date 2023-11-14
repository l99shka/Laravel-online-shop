@extends('layouts.cart-master')
@section('title', 'Корзина')
@section('cart')

        <div class="shopping-cart">
            <!-- Title -->
            <div class="title">
                Ваша корзина
            </div>

            @foreach($sessionCart as $elem)
                <div class="item">
                    <div class="buttons">
                        <span class="delete-btn" data-id="{{ $elem->id }}" onclick="location.reload();"></span>
                    </div>

                    <div class="image">
                        <img src="" alt="" />
                    </div>

                    <div class="description">
                        <span>{{ $elem->name }}</span>
                        <span>Bball High</span>
                        <span>{{ $elem->description }}</span>
                    </div>

                    <div class="quantity">
                        <button class="plus-btn" type="button" name="button" data-id="{{ $elem->id }}" onclick="location.reload();">
                            <img src="https://designmodo.com/demo/shopping-cart/plus.svg" alt="" />
                        </button>
                        <input type="text" name="name" value="{{ $elem->quantity }}">
                        <button class="minus-btn" type="button" name="button" data-id="{{ $elem->id }}" onclick="location.reload();">
                            <img src="https://designmodo.com/demo/shopping-cart/minus.svg" alt="" />
                        </button>
                    </div>

                    <div class="total-price">{{ \Cart::get($elem->id)->getPriceSum() }} руб.</div>
                </div>
            @endforeach
        </div>
        <button class="order-button" type="button" name="button">Оформить заказ <br> На сумму -  руб.</button>

@endsection
