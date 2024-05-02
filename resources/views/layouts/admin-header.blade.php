<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>coachtechフリマ</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/header.css') }}">
    @yield('css')
    <style>
        
    </style>
</head>

<body>
    <header class="header">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="header__content">
            <a href="/">
                <img src="/images/logo.svg" alt="logo">
            </a>
            <form action="{{ route('search') }}" class="search__form" method="GET">
                <input type="text" name="keyword" placeholder="なにをお探しですか？" class="search__form-input">
            </form>
            <nav class="header__nav">
                @if (Auth::check())
                    {{-- 認証後のナビゲーション --}}
                    <ul class="header__nav-menu">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <li>
                                <a href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                    ログアウト
                                </a>
                            </li>
                        </form>
                        <li><a href="/mypage">マイページ</a></li>
                        @if (auth()->user()->role === 'admin')
                            <li><a href="/admin">管理</a></li>
                        @endif
                    </ul>
                @else
                    {{-- 認証前のナビゲーション --}}
                    <ul class="header__nav-menu">
                        <li><a href="/login">ログイン</a></li>
                        <li><a href="/register">会員登録</a></li>
                    </ul>
                @endif
            </nav>
            <dev class="header__button">
                <a href="/sell">出品</a>
            </dev>
        </div>
    </header>

    <div class="container">
        <div class="sidebar">
            <!-- 左側の固定メニューの内容 -->
            <ul>
                <li><a href="#" class="{{ Request::is('user-management') ? 'active' : '' }}"
                        id="user-management">ユーザー管理</a></li>
                <li><a href="/comment-management" class="{{ Request::is('comment-management') ? 'active' : '' }}"
                        id="comment-management">コメント管理</a></li>
                <li><a href="/mailform" class="{{ Request::is('mailform') ? 'active' : '' }}"
                        id="mailform">メール送信フォーム</a></li>
            </ul>
        </div>
        <main>
            @yield('content')
        </main>
    </div>
</body>

<script>
    // アラートの閉じるボタンがクリックされたときの処理
    document.querySelectorAll('.close').forEach(function(closeButton) {
        closeButton.addEventListener('click', function() {
            this.closest('.alert').style.display = 'none';
        });
    });

    // 選択したメニューの色を変更
    const menuLinks = document.querySelectorAll('.sidebar ul li a');
    menuLinks.forEach(link => {
        link.addEventListener('click', () => {
            // 選択されたメニューにactiveクラスを付与し、他のメニューからactiveクラスを削除する
            menuLinks.forEach(link => link.classList.remove('active'));
            link.classList.add('active');
        });
    });
</script>

</html>
