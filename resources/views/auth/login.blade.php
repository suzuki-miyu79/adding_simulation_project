@extends('layouts.header-logo')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection

@section('content')
    <div class="login__content">
        <div class="login__heading">
            <h2>ログイン</h2>
        </div>
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="login-form">
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
                    <button class="form__button-submit">ログインする</button>
                </div>
                <a href="/register" class="register-link">会員登録はこちら</a>
            </div>
        </form>
    </div>
@endsection
