@extends('layouts.auth-master')
@section('title', 'Логин')
@section('content')
    <form action="{{ route('login-user') }}" method="post">
        @csrf
        <label>Логин</label>
        <label style="color: #4b1010">@error('email') {{ $message }} @enderror</label>
        <input type="text" name="email" value="{{ old('email') }}" placeholder="Введите свой E-mail">
        <label>Пароль</label>
        <label style="color: #4b1010">@error('password') {{ $message }} @enderror</label>
        <input type="password" name="password" placeholder="Введите пароль">
        <input type="hidden" name="auth">
        <label style="color: #4b1010">@error('auth') {{ $message }} @enderror</label>
        <button type="submit" class="login-btn">Войти</button>
        <p>
            У вас нет аккаунта? - <a href="{{ route('register-user') }}">зарегистрируйтесь</a>!
        </p>
    </form>
@endsection
