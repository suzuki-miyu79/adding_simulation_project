@extends('layouts.header-search')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
    <script src="https://yubinbango.github.io/yubinbango/yubinbango.js" charset="UTF-8"></script>
@endsection

@section('content')
    <div class="profile__content">
        <div class="profile__heading">
            <h2>プロフィール設定</h2>
        </div>
        <form　 class="h-adr" method="POST" action="{{ route('profile.setting') }}" enctype="multipart/form-data">
            @csrf
            <span class="p-country-name" style="display:none;">Japan</span>
            <div class="user__img">
                <div class="user__img-img">
                    <img id="profile_preview" src="{{ asset($user->image) }}" alt="">
                </div>
                <label>
                    <input type="file" id="profile_image" name="profile_image" onchange="previewImage(event)">画像を選択する
                </label>
            </div>
            <div class="profile-form">
                <div class="form__group">
                    <label for="">ユーザー名</label>
                    <input id="name" type="text" name="name" value="{{ old('name', $user->name) }}" autofocus>
                    <div class="form__error">
                        @error('name')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
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
                <div class="form__button">
                    <button class="form__button-submit">更新する</button>
                </div>
            </div>
        </form>
    </div>

    <script>
        // プロフィール画像のプレビュー表示
        function previewImage(event) {
            var input = event.target;
            var reader = new FileReader();
            reader.onload = function() {
                var dataURL = reader.result;
                var imgElement = document.getElementById('profile_preview');
                imgElement.src = dataURL;
            };
            reader.readAsDataURL(input.files[0]);
        }

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
