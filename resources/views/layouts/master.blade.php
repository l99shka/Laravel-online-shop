<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>
    <link href="{{ asset('/css/catalog.css') }}" rel="stylesheet">
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
        @guest
    <a class="menu" href="{{ route('register-user') }}">Регистрация</a>
    <a class="menu" href="{{ route('login-user') }}">Вход</a>
        @endguest

            @auth
            <a class="menu" href="">Личный кабинет</a>

                <form method="post" class="logout" action="{{ route('logout') }}">
                    @csrf
            <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="menu">Выход</a>
                </form>
            @endauth
    </div>
</nav>

    @yield('content')

<div class="product-card">
    @foreach($products as $product)
        <div class="product-item">
            <img src="{{ $product->image }}">
            <div class="product-list">
                <h3>{{ $product->name }}</h3>
                <h4>{{ $product->description }}</h4>
                <span class="price">{{ $product->price }} руб.</span>
                <a href="{{ route('add-to-cart') }}" class="button">В корзину</a>
            </div>
        </div>
    @endforeach
</div>

</body>
</html>
