@extends('layouts.header-search')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/purchase.css') }}">
@endsection

@section('content')
    <div class="purchase__content">
        <div class="purchase__content-left">
            <div class="purchase__item">
                <div class="purchase__img">
                    <img src={{ $item->image }} alt="商品画像">
                </div>
                <div class="purchase__item-info">
                    <p class="item__name">{{ $item->name }}</p>
                    <p class="price">\{{ $item->price }}</p>
                </div>
            </div>
            <div class="payment">
                <div class="payment-top">
                    <p>支払い方法</p>
                    <a href="#" id="change-payment">変更する</a>
                </div>
                <div class="payment-bottom">
                    <select id="payment-method" style="display: none;">
                        <option value="credit_card">クレジットカード</option>
                        <option value="bank_transfer">銀行振り込み</option>
                        <option value="convenience_store">コンビニ支払い</option>
                    </select>
                    <p>選択された支払方法: <span id="selected-payment"></span></p>
                </div>
            </div>
            <div class="delivery">
                <div class="delivery-top">
                    <p>配送先</p>
                    <a href="{{ route('address', ['item_id' => $item->id]) }}">変更する</a>
                </div>
                <div class="delivery-bottom">
                    @if (session()->has('delivery_address'))
                        {{-- 配送先を変更した場合の表示 --}}
                        <p class="postcode">{{ session('delivery_address.postcode') }}</p>
                        <p class="address">{{ session('delivery_address.address') }}</p>
                        <p class="building-name">{{ session('delivery_address.building_name') }}</p>
                    @else
                        {{-- 配送先未変更の場合の表示 --}}
                        <p class="postcode">{{ $user->postcode }}</p>
                        <p class="address">{{ $user->address }}</p>
                        <p class="building-name">{{ $user->building_name }}</p>
                    @endif
                </div>
            </div>
        </div>
        <div class="purchase__content-right">
            <div class="purchase__content-right-content">
                <div class="purchase__content-right-inner product-price">
                    <p>商品代金</p>
                    <span>\{{ $item->price }}</span>
                </div>
                <div class="purchase__content-right-inner pay-amount">
                    <p>支払い金額</p>
                    <span>\{{ $item->price }}</span>
                </div>
                <div class="purchase__content-right-inner payment-methods">
                    <p>支払い方法</p>
                    <span id="selected-payment-2"></span>
                </div>
            </div>
            <div class="purchase__button">
                <button class="purchase__button-submit">購入する</button>
            </div>
        </div>
    </div>

    <script>
        // 変更するリンクがクリックされたときの処理
        document.getElementById('change-payment').addEventListener('click', function(e) {
            e.preventDefault(); // リンクのデフォルト動作をキャンセル

            // 選択肢を表示する
            document.getElementById('payment-method').style.display = 'block';
        });

        // 支払い方法が選択されたときの処理
        document.getElementById('payment-method').addEventListener('change', function() {
            var selectedOption = this.value; // 選択された支払い方法を取得
            var selectedText = this.options[this.selectedIndex].text; // 選択された支払い方法を取得

            // 選択された支払い方法を表示
            document.getElementById('selected-payment').textContent = selectedText;
            document.getElementById('selected-payment-2').textContent = selectedText;

            // 選択肢を非表示にする
            this.style.display = 'none';
        });

        // 購入ボタンがクリックされたときの処理
        document.querySelector('.purchase__button-submit').addEventListener('click', function() {
            var selectedPaymentMethod = document.getElementById('payment-method').value;

            // 選択された支払い方法に応じてルートを変更する
            switch (selectedPaymentMethod) {
                case 'credit_card':
                    // クレジットカードの支払い処理を行うルートにリダイレクト
                    window.location.href = '/stripe/credit-card-payment';
                    break;
                case 'bank_transfer':
                    // 銀行振り込みの支払い処理を行うルートにリダイレクト
                    window.location.href = '/bank-transfer-payment';
                    break;
                case 'convenience_store':
                    // コンビニ支払いの支払い処理を行うルートにリダイレクト
                    window.location.href = '/convenience-store-payment';
                    break;
                default:
                    // デフォルトの処理を行うか、エラーメッセージを表示
                    console.error('Unsupported payment method selected');
                    break;
            }
        });
    </script>
@endsection
