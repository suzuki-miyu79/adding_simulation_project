@extends('layouts.header-none')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/complete.css') }}">
@endsection

@section('content')
    <div class="complete">
        <p class="thanks">ご購入ありがとうございます</p>
        <p class="description">指定の銀行口座へのお振込みをお願いいたします。</p>
        <div class="table">
            <table>
                <tr>
                    <th>銀行名</th>
                    <td>すいか銀行</td>
                </tr>
                <tr>
                    <th>口座番号</th>
                    <td>301-405809-7929</td>
                </tr>
            </table>
        </div>
        <a href="/">トップページに戻る</a>
    </div>
@endsection
