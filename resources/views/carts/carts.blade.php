@extends('layouts.cart-master')
@section('title', 'Корзина')
@section('cart')
    <div class="shopping-cart">
        <!-- Title -->
        <div class="title">
            Ваша корзина
        </div>

        <div class="item">
            <div class="buttons">
                <span class="delete-btn"></span>
            </div>

            <div class="image">
                <img src="https://designmodo.com/demo/shopping-cart/item-1.png" alt="" />
            </div>

            <div class="description">
                <span>Common Projects</span>
                <span>Bball High</span>
                <span>White</span>
            </div>

            <div class="quantity">
                <button class="plus-btn" type="button" name="button">
                    <img src="https://designmodo.com/demo/shopping-cart/plus.svg" alt="" />
                </button>
                    <input type="text" name="name" value="1">
                <button class="minus-btn" type="button" name="button">
                    <img src="https://designmodo.com/demo/shopping-cart/minus.svg" alt="" />
                </button>
            </div>

            <div class="total-price">$549</div>
        </div>
    </div>
@endsection
