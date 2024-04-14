@extends('layouts.header-none')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/toppage.css') }}">
@endsection

@section('content')
    <h1>{{ $keyword }} の検索結果</h1>
    <a href="/">トップページへ戻る</a>

    @if ($items->isEmpty())
        <p>該当するアイテムは見つかりませんでした。</p>
    @else
        <ul>
            @foreach ($items as $item)
                <div class="item-card">
                    <a href="{{ route('item.index', ['item_id' => $item->id]) }}">
                        <img src="{{ $item->image }}" alt="{{ $item->name }}">
                    </a>
                </div>
            @endforeach
        </ul>
    @endif
@endsection
