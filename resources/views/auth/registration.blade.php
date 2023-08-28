<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Авторизация и регистрация</title>
</head>
<body>

<!-- Форма регистрации -->

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
    <input type="tel" name="phone" placeholder="Введите телефон">
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

