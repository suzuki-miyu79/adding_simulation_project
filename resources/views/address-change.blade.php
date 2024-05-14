@extends('layouts.header-none')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/address-change.css') }}">
    <script src="https://yubinbango.github.io/yubinbango/yubinbango.js" charset="UTF-8"></script>
@endsection

@section('content')
    <div class="address-change__content">
        <div class="address-change__heading">
            <h2>住所の変更</h2>
        </div>
        <form class="h-adr" method="POST" action="{{ route('address.change', ['item_id' => $item->id]) }}">
            @csrf
            <span class="p-country-name" style="display: none;">Japan</span>
            <div class="address-change__form">
                <div class="form__group">
                    <label for="">郵便番号</label>
                    <input class="p-postal-code" id="postcode" type="text" name="postcode"
                        value="{{ old('postcode', $user->postcode) }}">
                    <div class="form__error">
                        @error('postcode')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="form__group">
                    <label for="">住所</label>
                    <input class="p-region p-locality p-street-address p-extended-address" id="address" type="text"
                        name="address" value="{{ old('address', $user->address) }}">
                    <div class="form__error">
                        @error('address')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="form__group">
                    <label for="">建物名</label>
                    <input id="building_name" type="text" name="building_name"
                        value="{{ old('building_name', $user->building_name) }}">
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

    <script>
        // 郵便番号の自動半角変換
        document.addEventListener('DOMContentLoaded', function() {
            var postcodeInput = document.querySelector('input[name="postcode"]');

            // 郵便番号入力フィールドに対してイベントリスナーを追加
            postcodeInput.addEventListener('input', function() {
                // 全角を半角に変換
                var convertedValue = toHalfWidth(this.value);
                // 変換した値をフォームにセット
                this.value = convertedValue;
            });

            // 全角を半角に変換する関数
            function toHalfWidth(value) {
                return value.replace(/[０-９]/g, function(s) {
                    return String.fromCharCode(s.charCodeAt(0) - 0xFEE0);
                });
            }
        });
    </script>
@endsection
