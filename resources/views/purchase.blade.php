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
                    <p class="item__name">{{ $item->name }}</p>
                    <p class="price">\{{ $item->price }}</p>
                </div>
            </div>
            <div class="payment">
                <div class="payment-top">
                    <p>支払い方法</p>
                    <a href="">変更する</a>
                </div>
                <div class="payment-bottom">
                    <p></p>
                </div>
            </div>
            <div class="delivery">
                <div class="delivery-top">
                    <p>配送先</p>
                    <a href="{{ route('address', ['item_id' => $item->id]) }}">変更する</a>
                </div>
                <div class="delivery-bottom">
                    @if (session()->has('delivery_address'))
                        {{-- 配送先を変更した場合の表示 --}}
                        <p class="postcode">{{ session('delivery_address.postcode') }}</p>
                        <p class="address">{{ session('delivery_address.address') }}</p>
                        <p class="building-name">{{ session('delivery_address.building_name') }}</p>
                    @else
                        {{-- 配送先未変更の場合の表示 --}}
                        <p class="postcode">{{ $user->postcode }}</p>
                        <p class="address">{{ $user->address }}</p>
                        <p class="building-name">{{ $user->building_name }}</p>
                    @endif
                </div>
            </div>
        </div>
        <div class="purchase__content-right">
            <div class="purchase__content-right-content">
                <div class="purchase__content-right-inner product-price">
                    <p>商品代金</p>
                    <span>\{{ $item->price }}</span>
                </div>
                <div class="purchase__content-right-inner pay-amount">
                    <p>支払い金額</p>
                    <span>\{{ $item->price }}</span>
                </div>
                <div class="purchase__content-right-inner payment-methods">
                    <p>支払い方法</p>
                    <span></span>
                </div>
            </div>
            <div class="purchase__button">
                <button class="purchase__button-submit">購入する</button>
            </div>
        </div>
    </div>
@endsection
