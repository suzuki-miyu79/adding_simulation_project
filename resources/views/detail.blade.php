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
            <p class="detail__item-brand">ブランド名</p>
            <p class="detail__item-price">¥{{ $item->price }}(値段)</p>
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
                    <p id="favorite-count">{{ $favoriteCount }}</p>
                </div>
                <div class="detail__group-inner">
                    <img class="comment-icon" id="comment-icon" src="/images/comment-icon.svg" alt="">
                    <p>{{ $commentCount }}</p>
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
                <div class="comment__inner">
                    <div class="comment__user">
                        <img src="" alt="">
                        <span>名前</span>
                    </div>
                    <p>コメント</p>
                </div>
                <form action="" class="comment__form">
                    <p>商品へのコメント</p>
                    <textarea name="" id="" cols="30" rows="10"></textarea>
                    <button>コメントを送信する</button>
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
