@extends('layouts.cart-master')
@section('title', 'Корзина')
@section('cart')

    <div class="shopping-cart">
        <!-- Title -->
        <div class="title">
            Ваша корзина
        </div>
        @foreach($cart as $elem)
        <div class="item">
            <div class="buttons">
                <span class="delete-btn"></span>
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
                <button class="plus-btn" type="button" name="button">
                    <img src="https://designmodo.com/demo/shopping-cart/plus.svg" alt="" />
                </button>
                    <input type="text" name="name" value="{{ $elem->quantity }}">
                <button class="minus-btn" type="button" name="button">
                    <img src="https://designmodo.com/demo/shopping-cart/minus.svg" alt="" />
                </button>
            </div>

            <div class="total-price">{{ $elem->price }} руб.</div>
        </div>
        @endforeach
    </div>

@endsection
