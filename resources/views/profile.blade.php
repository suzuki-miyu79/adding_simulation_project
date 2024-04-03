@extends('layouts.header-search')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endsection

@section('content')
    <div class="profile__content">
        <div class="profile__heading">
            <h2>プロフィール設定</h2>
        </div>
        <form method="POST" action="{{ route('profile.setting') }}" enctype="multipart/form-data">
            @csrf
            <div class="user_img">
                <img id="profile_preview" src="" alt="">
                <label>
                    <input type="file" id="profile_image" name="profile_image" onchange="previewImage(event)">画像を選択する
                </label>
            </div>
            <div class="profile-form">
                <div class="form__group">
                    <label for="">ユーザー名</label>
                    <input id="name" type="text" name="name" :value="old('name')" autofocus>
                    <div class="form__error">
                        @error('name')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
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
                <div class="form__button">
                    <button class="form__button-submit">更新する</button>
                </div>
            </div>
        </form>
    </div>

    {{-- プロフィール画像のプレビュー表示 --}}
    <script>
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
    </script>
@endsection
