@extends('layouts.header-search')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/detail.css') }}">
@endsection

@section('content')
    <div class="detail__content">
        <div class="detail__content-left">
            <div class="detail__img">
                <img src="{{ $item->image }}" alt="商品画像">
            </div>
        </div>
        <div class="detail__content-right">
            <h2 class="detail__item-name">{{ $item->name }}</h2>
            <p class="detail__item-brand">{{ $item->brand }}</p>
            <p class="detail__item-price">¥{{ number_format($item->price) }}(値段)</p>
            <div class="detail__group">
                <div class="detail__group-inner">
                    @if (auth()->check())
                        @php
                            $isFavorite = auth()
                                ->user()
                                ->favorites()
                                ->where('item_id', $item->id)
                                ->exists();
                        @endphp

                        @if ($isFavorite)
                            {{-- お気に入り登録されている場合 --}}
                            <img id="favorite-icon" class="favorite-icon" src="/images/favorite-icon-yellow.svg"
                                alt="" onclick="toggleFavorite({{ $item->id }})">
                        @else
                            {{-- お気に入り登録されていない場合 --}}
                            <img id="favorite-icon" class="favorite-icon" src="/images/favorite-icon.svg" alt=""
                                onclick="toggleFavorite({{ $item->id }})">
                        @endif
                    @else
                        {{-- 未ログインの場合 --}}
                        <a href="{{ route('login') }}">
                            <img id="favorite-icon" class="favorite-icon" src="/images/favorite-icon.svg" alt="">
                        </a>
                    @endif
                    <p id="favorite-count" class="count">{{ $favoriteCount }}</p>
                </div>
                <div class="detail__group-inner">
                    <img class="comment-icon" id="comment-icon" src="/images/comment-icon.svg" alt="">
                    <p class="count">{{ $commentCount }}</p>
                </div>
            </div>

            {{-- 商品情報 --}}
            <div id="item-info-section">
                <div class="detail__button">
                    <a href="{{ route('purchase.index', ['item_id' => $item->id]) }}">購入する</a>
                </div>
                <p class="detail__item-description">商品説明</p>
                <p class="detail__item-description--text">{{ $item->description }}</p>
                <p class="detail__item-info">商品の情報</p>
                <div class="detail__group-item-info">
                    <p for="">カテゴリー</p>
                    <span class="detail__group-item-info--category">{{ $item->childCategory->parentCategory->name }}</span>
                    <span class="detail__group-item-info--category">{{ $item->childCategory->name }}</span>
                </div>
                <div class="detail__group-item-info">
                    <p>商品の状態</p>
                    <span>{{ $item->condition->name }}</span>
                </div>
            </div>

            {{-- コメント --}}
            <div class="comment" id="comment-section" style="display: none;">
                @foreach ($comments as $comment)
                    <div class="comment__inner {{ $comment->user_id === auth()->id() ? 'my-post' : 'other-post' }}">
                        {{-- ログインユーザーとその他ユーザーの表示切替 --}}
                        @if ($comment->user_id === auth()->id())
                            <div class="comment-user">
                                <span>{{ $comment->user->name }}</span>
                                <div class="comment-img">
                                    <img src="{{ $comment->user->image }}" alt="{{ $comment->user->name }}のアイコン"
                                        class="icon-right">
                                </div>
                            </div>
                        @else
                            <div class="comment-user">
                                <div class="comment-img">
                                    <img src="{{ $comment->user->image }}" alt="{{ $comment->user->name }}のアイコン"
                                        class="icon-left">
                                </div>
                                <span>{{ $comment->user->name }}</span>
                            </div>
                        @endif
                        <p class="comment-text">{{ $comment->comment }}</p>
                    </div>
                @endforeach
                <form action="{{ route('item.comment', ['item_id' => $item->id]) }}" class="comment__form" method="post">
                    @csrf
                    <div class="comment__form">
                        @if (auth()->check())
                            <input type="hidden" name="item_id" value="{{ $item->id }}"> {{-- 商品IDを送信 --}}
                            <p>商品へのコメント</p>
                            <textarea name="comment"></textarea>
                            <button type="submit">コメントを送信する</button>
                        @else
                            <a href="{{ route('login') }}">ログインしてコメントする</a>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        function toggleFavorite(itemId) {
            axios.post(`/favorite/${itemId}`, {
                    _token: '{{ csrf_token() }}',
                    item_id: itemId,
                })
                .then(response => {
                    console.log(response.data); // レスポンスをログに出力
                    // アイコンの表示を更新する処理（isFavoriteフラグを受け取ってアイコンの状態を更新）
                    const favoriteIcon = document.getElementById('favorite-icon');
                    if (favoriteIcon) {
                        if (response.data.isFavorite) {
                            favoriteIcon.src = "/images/favorite-icon-yellow.svg";
                        } else {
                            favoriteIcon.src = "/images/favorite-icon.svg";
                        }
                    }

                    // お気に入りの件数を更新する処理
                    const favoriteCountElement = document.getElementById('favorite-count');
                    if (favoriteCountElement) {
                        favoriteCountElement.textContent = response.data.favoriteCount;
                    }
                })
                .catch(error => {
                    console.error('Error Message:', error);
                });
        }
    </script>
    <script>
        document.getElementById('comment-icon').addEventListener('click', function() {
            // コメント表示エリアを表示
            document.getElementById('comment-section').style.display = 'block';
            // 商品情報エリアを非表示
            document.getElementById('item-info-section').style.display = 'none';
        });
    </script>
@endsection
