@extends('layouts.header-search')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
@endsection

@section('content')
    <div class="mypage__content">
        <div class="mypage__top">
            <img src="{{ asset($user->image) }}" alt="Profile Image">
            <div class="mypage__top-name">
                @if ($user->name)
                    <p>{{ $user->name }}</p>
                @else
                    <p>ユーザー名未設定</p>
                @endif
            </div>
            <a href="/mypage/profile">プロフィールを編集</a>
        </div>
        <nav class="mypage__nav">
            <ul class="mypage__nav-menu">
                <li class="active"><a href="">出品した商品</a></li>
                <li><a href="">購入した商品</a></li>
            </ul>
        </nav>
        <div class="mypage__nav-line"></div>
        <div class="item__list">
            <div class="item-card"></div>
            <div class="item-card"></div>
            <div class="item-card"></div>
            <div class="item-card"></div>
            <div class="item-card"></div>
            <div class="item-card"></div>
            <div class="item-card"></div>
            <div class="item-card"></div>
        </div>

        <script>
            var navLinks = document.querySelectorAll('.mypage__nav-menu li a');

            // リンクにクリックイベントを追加
            navLinks.forEach(function(link) {
                link.addEventListener('click', function(event) {
                    // すべてのリンクからactiveクラスを削除
                    navLinks.forEach(function(link) {
                        link.parentNode.classList.remove('active');
                    });

                    // クリックされたリンクにactiveクラスを追加
                    event.target.parentNode.classList.add('active');
                });
            });
        </script>
    </div>
@endsection
