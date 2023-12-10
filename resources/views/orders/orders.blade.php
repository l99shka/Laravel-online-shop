@extends('layouts.orders-master')
@section('title', 'Оформление заказа')
@section('orders')

    <div class="container">
        <div class="title">
            Оформление заказа
        </div>

        <form action="{{ route('add-orders') }}" id="survey-form" method="post">
            @csrf
            @foreach($cartProduct as $elem)
                <div class="item">

                    <div class="image">
                        <img src="{{ $elem->image }}" width="80px" height="80px" alt="" />
                    </div>

                    <div class="description">
                        <span>{{ $elem->name }}</span>
                        <span>{{ $elem->description }}</span>
                    </div>

                    <div class="quantity">
                        <input type="text" name="name" value="{{ $elem->quantity }}">
                    </div>

                    <div class="total-price">{{ number_format($elem->price, 2, ',', ' ') }} руб.</div>
                </div>
            @endforeach

            <div class="label-input">
                <label id="number-label" for="number">Номер телефона</label>
                <input id="number" name="phone" type="tel" placeholder="Введите телефон... " class="form-control">
                <span id="phone_error" style="color: #4b1010">@error('phone') {{ $message }} @enderror</span>

                <label id="number-label" for="email">E-mail</label>
                <input id="email" name="email" type="email" placeholder="Введите E-mail... " class="form-control">
                <span id="email_error" style="color: #4b1010">@error('email') {{ $message }} @enderror</span>
            </div>

            <p> Оставьте коменнатарий к заказу (Необязательно) </p>

            <label for="textarea"></label>
            <textarea maxlength="500" name="message" id="textarea" cols="15" rows="5" placeholder="Введите комметарий..."></textarea>

            <!-- Submit Button -->
            <button id="orderPay-button" type="submit" name="orderPay"> Оплатить: <br> {{ number_format($sumTotalPrice, 2, ',', ' ') }} руб.</button>

        </form>
    </div>

@endsection
