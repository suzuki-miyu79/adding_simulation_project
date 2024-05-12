@extends('layouts.header-none')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/complete.css') }}">
@endsection

@section('content')
    <div class="complete">
        <p class="thanks">ご購入ありがとうございます</p>
        <a href="/">トップページに戻る</a>
    </div>
@endsection
