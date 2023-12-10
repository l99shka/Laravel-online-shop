<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}" charset="UTF-8">
    <title>Подтверждение E-mail</title>
    <link href="{{ asset('/css/catalog.css') }}" rel="stylesheet">
</head>
<body>
<nav>
    <a href="{{ route('main') }}" class="logo">Интернет-магазин</a>
    <div class="nav__section">
        @guest()
            <a class="menu" href="{{ route('register-user') }}">Регистрация</a>
            <a class="menu" href="{{ route('login-user') }}">Вход</a>
        @endguest

        @can('guest', auth()->user())
            <a class="menu" href="{{ route('register-user') }}">Регистрация</a>
            <a class="menu" href="{{ route('login-user') }}">Вход</a>
        @endcan

        @can('user', auth()->user())
            <a class="menu" href="">Личный кабинет</a>
            <form method="post" class="logout" action="{{ route('logout') }}">
                @csrf
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="menu">Выход</a>
            </form>
        @endcan
    </div>
</nav>

<header class="email">
        <div class="children">
            <h1>Необходимо подтверждение E-mail</h1>
            @if(session('message'))
                    <a class="email-verify">
                        <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="30" height="30" viewBox="0 0 50 50">
                            <path d="M25,2C12.318,2,2,12.318,2,25c0,12.683,10.318,23,23,23c12.683,0,23-10.317,23-23C48,12.318,37.683,2,25,2z M35.827,16.562	L24.316,33.525l-8.997-8.349c-0.405-0.375-0.429-1.008-0.053-1.413c0.375-0.406,1.009-0.428,1.413-0.053l7.29,6.764l10.203-15.036	c0.311-0.457,0.933-0.575,1.389-0.266C36.019,15.482,36.138,16.104,35.827,16.562z"></path>
                        </svg>
                        {{ session('message') }}
                    </a>
            @endif
            <form action="{{ route('verification.send') }}" method="post">
                @csrf
                <button type="submit" class="verify-button" name="button" >Отправить повторно</button>
            </form>
        </div>
</header>
</body>
</html>
