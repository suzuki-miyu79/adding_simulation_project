@extends('layouts.header-none')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/search-results.css') }}">
@endsection

@section('content')
    <div class="search-results">
        <h1>{{ $keyword }} の検索結果</h1>
        <a href="/" class="back-button">トップページへ戻る</a>
        <div class="item__list">
            @if ($items->isEmpty())
                <p>該当するアイテムは見つかりませんでした。</p>
            @else
                @foreach ($items as $item)
                    <div class="item-card">
                        <a href="{{ route('item.index', ['item_id' => $item->id]) }}">
                            <img src="{{ $item->image }}" alt="{{ $item->name }}">
                        </a>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
@endsection
