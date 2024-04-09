@extends('layouts.header-none')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/address-change.css') }}">
@endsection

@section('content')
    <div class="address-change__content">
        <div class="address-change__heading">
            <h2>住所の変更</h2>
        </div>
        <form method="POST" action="{{ route('address.change', ['item_id' => $item->id]) }}">
            @csrf
            <div class="address-change__form">
                <div class="form__group">
                    <label for="">郵便番号</label>
                    <input id="postcode" type="text" name="postcode">
                    <div class="form__error">
                        @error('postcode')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="form__group">
                    <label for="">住所</label>
                    <input id="address" type="text" name="address">
                    <div class="form__error">
                        @error('address')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="form__group">
                    <label for="">建物名</label>
                    <input id="building_name" type="text" name="building_name">
                    <div class="form__error">
                        @error('building_name')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="a">
                    <p>配送先住所をプロフィールの住所に設定しますか？</p>
                    <label>
                        <input type="radio" name="update_profile_address" value="yes"> はい
                    </label>
                    <label>
                        <input type="radio" name="update_profile_address" value="no" checked> いいえ
                    </label>
                </div>
                <div class="form__button">
                    <button class="form__button-submit">更新する</button>
                </div>
            </div>
        </form>
    </div>
@endsection
