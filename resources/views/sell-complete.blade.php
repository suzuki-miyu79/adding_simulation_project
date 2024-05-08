@extends('layouts.header-none')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/complete.css') }}">
@endsection

@section('content')
    <div class="complete">
        <p>出品が完了しました。</p>
        <a href="/">トップページに戻る</a>
    </div>
@endsection
