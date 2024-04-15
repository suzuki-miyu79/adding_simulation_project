@extends('layouts.header-search')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/toppage.css') }}">
@endsection

@section('content')
    <div class="topppage__content">
        <nav class="toppage__nav">
            <ul class="toppage__nav-menu">
                <li><a href="/">おすすめ</a></li>
                <li class="active"><a href="/mylist">マイリスト</a></li>
            </ul>
        </nav>
        <div class="toppage__nav-line"></div>
        <div class="item__list">
            @foreach ($favorites as $favorite)
                <div class="item-card">
                    <a href="{{ route('item.index', ['item_id' => $favorite->item_id]) }}">
                        <img src="{{ $favorite->item->image }}" alt="{{ $favorite->item->name }}">
                    </a>
                </div>
            @endforeach
        </div>
    </div>
@endsection
