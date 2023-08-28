<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Авторизация и регистрация</title>
</head>
<body>

<!-- Форма авторизации -->

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
</body>
</html>

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: Montserrat, sans-serif;
    }

    a {
        color: #7c9ab7;
        font-weight: bold;
        text-decoration: none;
    }

    p {
        margin: 10px 0;
    }

    form {
        display: flex;
        flex-direction: column;
        width: 400px;
    }

    input {
        margin: 10px 0;
        padding: 10px;
        border: unset;
        border-bottom: 2px solid #1f0a42;
        outline: none;
    }

    button {
        padding: 10px;
        background: #cbbbb4;
        border: unset;
        cursor: pointer;
    }
</style>
