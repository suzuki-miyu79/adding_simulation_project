@extends('layouts.header-search')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/purchase.css') }}">
@endsection

@section('content')
    <div class="purchase__content">
        <div class="purchase__content-left">
            <div class="purchase__item">
                <div class="purchase__img">
                    <img src={{ $item->image }} alt="商品画像">
                </div>
                <div class="purchase__item-info">
                    <p class="item__name">商品名</p>
                    <p class="price">\</p>
                </div>
            </div>
            <div class="payment">
                <div class="payment-top">
                    <p>支払方法</p>
                    <a href=""></a>
                </div>
                <div class="payment-bottom">
                    <p></p>
                </div>
            </div>
            <div class="delivery">
                <div class="delivery-top">
                    <p>配送先</p>
                    <a href=""></a>
                </div>
                <div class="delivery-bottom">
                    <p class="postcode"></p>
                    <p class="address"></p>
                    <p class="building-name"></p>
                </div>
            </div>
        </div>
        <div class="purchase__content-right">
            <div class="product-price">
                <p>商品代金</p>
                <span></span>
            </div>
            <div class="pay-amount">
                <p>支払い金額</p>
                <span></span>
            </div>
            <div class="payment-methods">
                <p>支払い方法</p>
                <span></span>
            </div>
            <div class="purchase__button">
                <button class="purchase__button-submit">購入する</button>
            </div>
        </div>
    </div>
@endsection
