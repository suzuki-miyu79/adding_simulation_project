@extends('layouts.header-none')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/complete.css') }}">
@endsection

@section('content')
    <div class="complete">
        <p class="thanks">ご購入ありがとうございます</p>
        <p class="description">期限までにお支払いください。</p>
        <div class="table">
            <table>
                <tr>
                    <th>支払番号</th>
                    <td><span id="payment-number"></span></td>
                </tr>
                <tr>
                    <th>有効期限</th>
                    <td><span id="expiry-date"></span></td>
                </tr>
            </table>
        </div>
        <a href="/">トップページに戻る</a>
    </div>

    <script>
        // セッションストレージから支払い番号と有効期限を取得して表示する関数
        function displayPaymentInfo() {
            // セッションストレージから支払い番号と有効期限を取得
            var paymentNumber = sessionStorage.getItem('paymentNumber');
            var expiryDate = sessionStorage.getItem('expiryDate');

            // 取得した情報を表示
            document.getElementById('payment-number').textContent = paymentNumber;
            document.getElementById('expiry-date').textContent = expiryDate;
        }

        // ページが読み込まれたときにセッションストレージから情報を表示
        window.onload = displayPaymentInfo;
    </script>
@endsection
