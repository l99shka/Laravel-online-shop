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
                            <a href="{{ route('category', $category->id) }}" class="children">&#10148;{{ $category->name }}</a>
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

@endsection
