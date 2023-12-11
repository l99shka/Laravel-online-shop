<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}" charset="UTF-8">
    <title>@yield('title')</title>
    <link href="{{ asset('/css/catalog.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/cart-product.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/orders.css') }}" rel="stylesheet">
</head>
<body>
<nav>
    <a href="{{ route('main') }}" class="logo">Интернет-магазин</a>

    <a class="menu" href="{{ route('main') }}">Главная</a>

    <div class="catalog">
        <ul>
            <li><a href="{{ route('catalog') }}">Каталог &#9660;</a>
                <ul>
                    @foreach ($categories as $category)
                        <li><a href="{{ route('category', $category->id) }}">{{ $category->name }}</a>

                            @if(!empty($category->children))
                                <ul>
                                    @foreach($category->children as $childNode)
                                        @include('main.categories', ['child_node' => $childNode])
                                    @endforeach
                                </ul>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </li>
        </ul>
    </div>

    <a class="menu" href="">О нас</a>
    <a class="menu" href="">Контакты</a>

    <div class="search">
        <form class="search-submit" action="" method="get">
            @csrf
            <label>
                <input type="text" placeholder="Поиск">
            </label>
            <button type="submit">Найти</button>
        </form>
    </div>

    <div class="nav__section">
        <a class="menu" href="{{ route('cartProduct') }}">
            <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M7 2.5V6.5H3V20.5C3 21.0304 3.21071 21.5391 3.58579 21.9142C3.96086 22.2893 4.46957 22.5 5 22.5H19C19.5304 22.5 20.0391 22.2893 20.4142 21.9142C20.7893 21.5391 21 21.0304 21 20.5V6.5H17V2.5H7Z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                <path d="M3 6.5H21" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    <span class="count-style" id="icon">{{ $sumQuantity }}</span>
            </svg>
        </a>

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
@yield('orders')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>
<script src="{{ asset('/js/order.js') }}"></script>
<script src="{{ asset('/js/phone.js') }}"></script>
</body>
</html>
