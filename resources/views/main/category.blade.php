@extends('layouts.main-master')
@section('title', 'Категории')
@section('content')
    <header class="home-cards">
        @foreach($categoriesParent as $category)
            <h1>{{ $category->name }}</h1>
        @endforeach

        @foreach($categoriesChildren as $category)

            <tr>
                <td>
                    <ul>
                        <li>
                            <a href="{{ route('category', $category->id) }}"
                               class="children">&#10148;{{ $category->name }}</a>
                        </li>
                    </ul>
                    @if(!empty($category->children))
                        <div>
                            <p>
                                @foreach($category->children as $childNode)
                                    {{ $childNode->name }}<br>
                                @endforeach
                            </p>
                        </div>
                    @endif
                </td>
            </tr>
        @endforeach
    </header>
    <div class="product-card">
        @foreach($products as $product)
            <div class="product-item">
                <img src="{{ $product->image }}">
                <div class="product-list">
                    <h3>{{ $product->name }}</h3>
                    <h4>{{ $product->description }}</h4>
                    <span class="price">{{ number_format($product->price , 2, ',', ' ') }} руб.</span>
                    <button type="submit" class="add-button" name="button" data-id="{{ $product->id }}">В корзину</button>
                </div>
            </div>
        @endforeach
    </div>
@endsection
