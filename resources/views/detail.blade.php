@extends('layouts.header-search')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/detail.css') }}">
@endsection

@section('content')
    <div class="detail__content">
        <div class="detail__content-left">
            <div class="detail__img">
                <img src="{{ $item->image }}" alt="商品画像">
            </div>
        </div>
        <div class="detail__content-right">
            <h2 class="detail__item-name">{{ $item->name }}</h2>
            <p class="detail__item-brand">ブランド名</p>
            <p class="detail__item-price">¥(値段)</p>
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
            <p class="detail__item-description--text">{{ $item->description }}</p>
            <p class="detail__item-info">商品の情報</p>
            <div class="detail__group-item-info">
                <label for="">カテゴリー</label>
                <span class="detail__group-item-info--category">{{ $item->childCategory->parentCategory->name }}</span>
                <span class="detail__group-item-info--category">{{ $item->childCategory->name }}</span>
            </div>
            <div class="detail__group-item-info">
                <label for="">商品の状態</label>
                <span>{{ $item->condition->name }}</span>
            </div>
        </div>
    </div>
@endsection
