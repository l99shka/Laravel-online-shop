@extends('layouts.main-master')
@section('title', 'Каталог')
@section('content')
    <header class="home-cards">
        @foreach($categories as $category)
            <div class="categories">
                <a href="{{ route('category', $category->id) }}">&#10148;{{ $category->name }}</a>
            </div>
        @endforeach
    </header>
@endsection
