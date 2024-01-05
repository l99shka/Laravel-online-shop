@extends('layouts.main-master')
@section('title', 'Оформление заказа')
@section('content')
    <div class="container">
        <div class="title">
            Оформление заказа
        </div>
        <form action="{{ route('addOrder') }}" id="survey-form" method="post">
            @csrf
            @php
                $cartCost = 0;
            @endphp
            @foreach($products as $product)
                @php
                    $itemPrice    = $product->price;
                    $itemQuantity =  $product->pivot->quantity;
                    $itemCost     = $itemPrice * $itemQuantity;
                    $cartCost     = $cartCost + $itemCost;
                @endphp
                <div class="item">

                    <div class="image">
                        <img src="{{ $product->image }}" width="80px" height="80px" alt=""/>
                    </div>

                    <div class="description">
                        <span>{{ $product->name }}</span>
                        <span>{{ $product->description }}</span>
                    </div>

                    <div class="quantity">
                        <input type="text" name="name" value="{{ $itemQuantity }}">
                    </div>

                    <div class="total-price">{{ number_format($itemCost, 2, ',', ' ') }} руб.</div>
                </div>
            @endforeach

            <div class="label-input">
                <label id="number-label" for="number">Номер телефона</label>
                <input id="number" name="phone" type="tel" placeholder="Введите номер телефона..."
                       class="form-control art-stranger">
                <span id="phone_error" style="color: #4b1010">@error('phone') {{ $message }} @enderror</span>
                @can('user', auth()->user())
                    <input style="pointer-events: none; background: #d3f1cf;" tabindex="-1" id="email" name="email"
                           type="email" hidden="hidden" class="form-control" value="{{ auth()->user()->email }}"
                           readonly>
                @endcan
                @can('guest', auth()->user())
                    <label id="number-label" for="email">E-mail</label>
                    <input id="email" name="email" type="email" placeholder="Введите E-mail... " class="form-control">
                @endcan
                <span id="email_error" style="color: #4b1010">@error('email') {{ $message }} @enderror</span>
            </div>

            <p> Оставьте коменнатарий к заказу (Необязательно) </p>

            <textarea maxlength="500" name="message" id="textarea" cols="15" rows="5"
                      placeholder="Введите комметарий..."></textarea>

            <!-- Submit Button -->
            <button id="orderPay-button" type="submit" name="orderPay"> Оплатить:
                <br> {{ number_format($cartCost, 2, ',', ' ') }} руб.
            </button>
        </form>
    </div>
@endsection
