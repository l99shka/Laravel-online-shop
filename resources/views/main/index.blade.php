@extends('layouts.main-master')
@section('title', 'Главная страница')
@section('content')
    @include('main.products')

    <div class="showmore-bottom" id="showmore-bottom">
        <button id="showmore-button">Показать еще</button>
    </div>
@endsection
