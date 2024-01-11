@extends('layouts.main-master')
@section('title', 'Главная страница')
@section('content')
    @include('main.products')

    <div class="showmore-bottom" id="showmore-bottom">
        @if (!$hasMoreProducts)
            <button id="showmore-button" style="display: none;">Показать еще</button>
        @else
            <button id="showmore-button">Показать еще</button>
        @endif
    </div>
@endsection
