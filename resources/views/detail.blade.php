@extends('layouts.header-search')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/detail.css') }}">
@endsection

@section('content')
    <div class="detail__content">
        <div class="detail__content-left">
            <div class="detail__img">
                <img src="" alt="商品画像">
            </div>
        </div>
        <div class="detail__content-right">
            <h2 class="detail__item-name"></h2>
            <p class="detail__brand-name"></p>
            <div class="detail__group">
                <div class="detail__group-favorite">
                    <img src="" alt="">
                    <label for=""></label>
                </div>
                <div class="detail__group-comment">
                    <img src="" alt="">
                    <label for=""></label>
                </div>
            </div>
            <div class="detail__button">
                <button class="detail__button-submit">購入する</button>
            </div>
            <p class="detail__item-description">商品説明</p>
            <p class="detail__item-description--text"></p>
            <p class="detail__item-info">商品の情報</p>
            <div class="detail__group-item-info">
                <label for="">カテゴリー</label>
                <span></span>
                <span></span>
            </div>
            <div class="detail__group-item-info">
                <label for="">商品の状態</label>
                <span></span>
            </div>
        </div>
    </div>
@endsection
