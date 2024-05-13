@extends('layouts.header-search')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/purchase.css') }}">
    <script></script>
@endsection

@section('content')
    <div class="purchase__content">
        <div class="purchase__content-left">
            <div class="purchase__item">
                <div id="item" data-item-id="{{ $item->id }}"></div>
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
                        <option value="credit_card" selected>クレジットカード</option>
                        <option value="bank_transfer">銀行振り込み</option>
                        <option value="convenience_store">コンビニ支払い</option>
                    </select>
                    <p>選択中の支払方法: <span id="selected-payment"></span></p>
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
                    @elseif ($user->postcode && $user->address && $user->building_name)
                        {{-- ユーザーの情報が空でない場合の表示 --}}
                        <p class="postcode">{{ $user->postcode }}</p>
                        <p class="address">{{ $user->address }}</p>
                        <p class="building-name">{{ $user->building_name }}</p>
                    @else
                        {{-- 配送先が設定されていない場合の表示 --}}
                        <p class="attention">配送先を設定してください</p>
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
            <div class="pay-info" id="credit-card-info">
                <p class="info-title">クレジットカード情報の入力</p>
                <form action="{{ route('charge', ['item_id' => $item->id]) }}" method="POST" id="stripe-payment-form">
                    @csrf
                    <dl class="form__dl">
                        <dt class="form__dt">カード番号</dt>
                        <dd class="form__dd">
                            <div id="card-number"></div>
                        </dd>
                    </dl>
                    <dl class="form__dl">
                        <dt class="form__dt">有効期限</dt>
                        <dd class="form__dd">
                            <div id="card-expiry"></div>
                        </dd>
                    </dl>
                    <dl class="form__dl">
                        <dt class="form__dt">セキュリティコード</dt>
                        <dd class="form__dd flex flex-wrap items-center">
                            <div class="w-full sm:w-2/12">
                                <div id="card-cvc"></div>
                            </div>
                            <div class="p-2 w-full sm:w-9/12">※カード背面の4桁または3桁の番号</div>
                        </dd>
                    </dl>
                    <div class="purchase__button">
                        <button class="purchase__button-submit" id="credit-card-info-button">購入する</button>
                    </div>
                </form>
            </div>
            <div class="pay-info" id="bank-transfer-info" style="display: none;">
                <form action="{{ route('purchase.bank', ['item_id' => $item->id]) }}" method="POST">
                    @csrf
                    <p class="info-title">銀行振り込み情報</p>
                    <p>銀行名: すいか銀行</p>
                    <p>口座番号: 301-405809-7929</p>
                    <div class="purchase__button">
                        <button class="purchase__button-submit">購入する</button>
                    </div>
                </form>
            </div>
            <div class="pay-info" id="convenience-store-info" style="display: none;">
                <form action="{{ route('purchase.convenienceStore', ['item_id' => $item->id]) }}" method="POST">
                    @csrf
                    <p class="info-title">コンビニ支払情報</p>
                    <p>支払番号: <span id="payment-number"></span></p>
                    <p>有効期限: <span id="expiry-date"></span></p>
                    <div class="purchase__button">
                        <button class="purchase__button-submit">購入する</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://js.stripe.com/v3/"></script>
    <script>
        // ページが読み込まれたときの処理
        document.addEventListener('DOMContentLoaded', function() {
            // Stripeオブジェクトを初期化
            var stripe = Stripe('{{ env('STRIPE_PUBLIC') }}');

            // 支払いフォームを初期化
            initializePaymentForm(stripe);

            // デフォルトで選択された支払い方法を表示
            var defaultPaymentText = document.querySelector('#payment-method option:checked').textContent;
            updateSelectedPayment(defaultPaymentText);
        });

        // 支払いフォームを初期化する関数
        function initializePaymentForm(stripe) {
            // Stripe Elementsを取得
            var elements = stripe.elements();

            // カード情報の入力要素を作成
            var cardNumberElement = elements.create('cardNumber');
            var cardExpiryElement = elements.create('cardExpiry');
            var cardCvcElement = elements.create('cardCvc');

            // カード情報の入力要素をHTMLにマウント
            cardNumberElement.mount('#card-number');
            cardExpiryElement.mount('#card-expiry');
            cardCvcElement.mount('#card-cvc');

            // 変更するリンクがクリックされたときの処理
            document.getElementById('change-payment').addEventListener('click', function(e) {
                e.preventDefault(); // リンクのデフォルト動作をキャンセル

                // 選択肢を表示する
                document.getElementById('payment-method').style.display = 'block';
            });

            // 支払い方法が選択されたときの処理
            document.getElementById('payment-method').addEventListener('change', function() {
                var selectedPaymentMethod = this.value;

                // 支払い情報の表示を切り替える
                togglePaymentMethodFields(selectedPaymentMethod);

                // 選択された支払い方法を表示
                updateSelectedPayment(this.options[this.selectedIndex].text);

                // 選択肢を非表示にする
                this.style.display = 'none';
            });

            // 購入ボタンがクリックされたときの処理を設定
            document.getElementById('credit-card-info-button').addEventListener('click', function(event) {
                event.preventDefault();
                // 支払いの処理を実行
                handlePaymentSubmission(stripe, cardNumberElement);
            });
        }

        // 選択された支払い方法を表示する
        function updateSelectedPayment(text) {
            document.getElementById('selected-payment').textContent = text;
            document.getElementById('selected-payment-2').textContent = text;
        }

        // 支払いの処理を行う関数
        function handlePaymentSubmission(stripe, cardNumberElement) {
            stripe.createToken(cardNumberElement).then(function(result) {
                if (result.error) {
                    // エラーメッセージを表示
                    displayError(result.error.message);
                } else {
                    // トークンをサーバーに送信
                    submitTokenToServer(result.token.id);
                }
            });
        }

        // 支払い方法の表示を切り替える関数
        function togglePaymentMethodFields(selectedPaymentMethod) {
            // 支払い方法ごとの要素の表示を切り替える
            var methods = {
                'credit_card': 'credit-card-info',
                'bank_transfer': 'bank-transfer-info',
                'convenience_store': 'convenience-store-info'
            };

            for (var method in methods) {
                var element = document.getElementById(methods[method]);
                // 選択された支払い方法に応じて表示を切り替える
                element.style.display = (method === selectedPaymentMethod) ? 'block' : 'none';
            }
        }

        // エラーメッセージを表示する関数
        function displayError(message) {
            var errorElement = document.getElementById('card-errors');
            errorElement.textContent = message;
        }

        // サーバーにトークンを送信する関数
        function submitTokenToServer(token) {
            var form = document.getElementById('stripe-payment-form');
            var hiddenInput = document.createElement('input');
            hiddenInput.setAttribute('type', 'hidden');
            hiddenInput.setAttribute('name', 'stripeToken');
            hiddenInput.setAttribute('value', token);
            form.appendChild(hiddenInput);
            form.submit();
        }

        // ランダムな12桁の数字を生成する関数
        function generateRandomNumber() {
            // 12桁のランダムな数字を生成
            var randomNumber = Math.floor(100000000000 + Math.random() * 900000000000).toString();
            // ハイフンを挿入する位置を計算
            var formattedNumber = randomNumber.substring(0, 4) + '-' + randomNumber.substring(4, 8) + '-' + randomNumber
                .substring(8);
            // 生成したフォーマット済みの数字を表示
            document.getElementById('payment-number').textContent = formattedNumber;
            // セッションストレージに支払い番号を保存
            sessionStorage.setItem('paymentNumber', formattedNumber);
        }

        // 今日から一週間後の日付を計算する関数
        function calculateExpiryDate() {
            // 今日の日付を取得
            var today = new Date();
            // 一週間後の日付を計算
            var expiryDate = new Date(today.getFullYear(), today.getMonth(), today.getDate() + 7);
            // 年、月、日を取得
            var year = expiryDate.getFullYear();
            var month = ('0' + (expiryDate.getMonth() + 1)).slice(-2);
            var day = ('0' + expiryDate.getDate()).slice(-2);
            // 有効期限を表示
            var formattedExpiryDate = year + '/' + month + '/' + day;
            document.getElementById('expiry-date').textContent = formattedExpiryDate;
            // セッションストレージに有効期限を保存
            sessionStorage.setItem('expiryDate', formattedExpiryDate);
        }

        // ページが読み込まれたときに両方の関数を実行
        window.onload = function() {
            generateRandomNumber();
            calculateExpiryDate();
        };
    </script>
@endsection
