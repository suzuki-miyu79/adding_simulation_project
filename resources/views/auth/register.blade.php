@extends('layouts.header-logo')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endsection

@section('content')
    <div class="register__content">
        <div class="register__heading">
            <h2>会員登録</h2>
        </div>
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="register-form">
                <div class="form__group">
                    <label for="">メールアドレス</label>
                    <input id="email" class="block mt-1 w-full" type="email" name="email" value="{{ old('email') }}"
                        required autofocus>
                </div>
                <div class="form__group">
                    <label for="">パスワード</label>
                    <input id="password" class="block mt-1 w-full" type="password" name="password" required
                        autocomplete="current-password" />
                </div>
                <div class="form__error">
                    @foreach ($errors->all() as $error)
                        <span class="error">{{ $error }}</span>
                    @endforeach
                </div>
                <div class="form__button">
                    <button class="form__button-submit">登録する</button>
                </div>
                <a href="/login" class="login-link">ログインはこちら</a>
            </div>
        </form>
    </div>
@endsection
