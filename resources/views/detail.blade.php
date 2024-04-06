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
            <p class="detail__item-price">¥(値段)</p>
            <div class="detail__group">
                <div class="detail__group-inner">
                    <img src="/images/favorite-icon.svg" alt="">
                    <p for="">{{ $favoriteCount }}</p>
                </div>
                <div class="detail__group-inner">
                    <img id="comment-icon" src="/images/comment-icon.svg" alt="">
                    <p for="">{{ $commentCount }}</p>
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
                    <label for="">カテゴリー</label>
                    <span class="detail__group-item-info--category">{{ $item->childCategory->parentCategory->name }}</span>
                    <span class="detail__group-item-info--category">{{ $item->childCategory->name }}</span>
                </div>
                <div class="detail__group-item-info">
                    <label for="">商品の状態</label>
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
                    <label for="">商品へのコメント</label>
                    <textarea name="" id="" cols="30" rows="10"></textarea>
                    <button>コメントを送信する</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('comment-icon').addEventListener('click', function() {
            // コメント表示エリアを表示
            document.getElementById('comment-section').style.display = 'block';
            // 商品情報エリアを非表示
            document.getElementById('item-info-section').style.display = 'none';
        });
    </script>
@endsection
