@extends('layouts.auth-master')
@section('title', 'Регистрация')
@section('content')
    <form action="{{ route('register-user') }}" method="post">
        @csrf
        <label>ФИО</label>
        <label style="color: #4b1010">@error('full_name') {{ $message }} @enderror</label>
        <input type="text" name="full_name" value="{{ old('full_name') }}" placeholder="Введите ФИО">
        <label>E-mail</label>
        <label style="color: #4b1010">@error('email') {{ $message }} @enderror</label>
        <input type="email" name="email" value="{{ old('email') }}" placeholder="Введите E-mail">
        <label>Телефон</label>
        <label style="color: #4b1010">@error('phone') {{ $message }} @enderror</label>
        <input id="number" class="art-stranger" type="tel" name="phone" placeholder="Введите номер телефона">
        <label>Пароль</label>
        <label style="color: #4b1010">@error('password') {{ $message }} @enderror</label>
        <input type="password" name="password" placeholder="Придумайте пароль">
        <label>Подтверждение пароля</label>
        <label style="color: #4b1010">@error('password_confirmation') {{ $message }} @enderror</label>
        <input type="password" name="password_confirmation" placeholder="Повторите пароль">
        <button type="submit" class="register-btn">Зарегистрироваться</button>
        <p>
            У вас уже есть аккаунт? - <a href="{{ route('login-user') }}">Авторизируйтесь</a>!
        </p>
    </form>
@endsection
