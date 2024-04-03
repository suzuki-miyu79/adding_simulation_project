@extends('layouts.header-search')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/toppage.css') }}">
@endsection

@section('content')
    <div class="topppage__content">
        <nav class="toppage__nav">
            <ul class="toppage__nav-menu">
                <li class="active"><a href="/">おすすめ</a></li>
                <li><a href="/mylist">マイリスト</a></li>
            </ul>
        </nav>
        <div class="toppage__nav-line"></div>
        <div class="item__list">
            <div class="item-card"></div>
            <div class="item-card"></div>
            <div class="item-card"></div>
            <div class="item-card"></div>
            <div class="item-card"></div>
            <div class="item-card"></div>
            <div class="item-card"></div>
            <div class="item-card"></div>
        </div>
    </div>
@endsection
