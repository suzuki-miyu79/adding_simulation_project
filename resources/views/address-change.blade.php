@extends('layouts.header-none')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/address-change.css') }}">
@endsection

@section('content')
    <div class="address-change__content">
        <div class="address-change__heading">
            <h2>住所の変更</h2>
        </div>
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="address-change__form">
                <div class="form__group">
                    <label for="">郵便番号</label>
                    <input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                        required autofocus autocomplete="username" />
                </div>
                <div class="form__group">
                    <label for="">住所</label>
                    <input id="password" class="block mt-1 w-full" type="password" name="password" required
                        autocomplete="current-password" />
                </div>
                <div class="form__group">
                    <label for="">建物名</label>
                    <input id="password" class="block mt-1 w-full" type="password" name="password" required
                        autocomplete="current-password" />
                </div>
                <div class="form__error">
                    @foreach ($errors->all() as $error)
                        <span class="error">{{ $error }}</span>
                    @endforeach
                </div>
                <div class="form__button">
                    <button class="form__button-submit">更新する</button>
                </div>
            </div>
        </form>
    </div>
@endsection
