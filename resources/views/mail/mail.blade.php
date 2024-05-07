@extends('layouts.admin-header')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/mail.css') }}">
@endsection

@section('content')
    <div class="mail__content">
        <h2 class="mail__content-title">メール送信フォーム</h2>
        <div class="mail__content-form">
            <form action="{{ route('send.mail') }}" method="POST" class="mail__content__form">
                @csrf
                <div class="mail__content__form-recipient">
                    <div class="select">
                        <label for="recipient">宛先:</label>
                        <div class="select-all"> {{-- 全件付け外し機能 --}}
                            <button type="button" id="toggle-selection-button">全件選択</button>
                        </div>
                    </div>
                    <div class="individual-selection">
                        @foreach ($users as $user)
                            <div class="mail__content__form-recipient-item">
                                <input type="checkbox" id="recipient_{{ $user->id }}" name="recipients[]"
                                    value="{{ $user->email }}">
                                <label for="recipient_{{ $user->id }}">{{ $user->name }}</label>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="mail__content__form-text">
                    <label for="message">本文:</label>
                    <textarea id="message" name="message" rows="15" required></textarea>
                </div>
                <div class="mail__content__form-button">
                    <button class="mail__content__form-button-submit">送信</button>
                </div>
            </form>
        </div>
    </div>

    {{-- 全件付け外し機能 --}}
    <script>
        var toggleSelectionButton = document.getElementById('toggle-selection-button');

        toggleSelectionButton.addEventListener('click', function() {
            var checkboxes = document.querySelectorAll(
                '.mail__content__form-recipient-item input[type="checkbox"]');
            var allUnchecked = true;

            checkboxes.forEach(function(checkbox) {
                if (checkbox.checked) {
                    allUnchecked = false;
                }
            });

            if (allUnchecked) {
                checkboxes.forEach(function(checkbox) {
                    checkbox.checked = true;
                });
                toggleSelectionButton.textContent = '全件解除';
            } else {
                checkboxes.forEach(function(checkbox) {
                    checkbox.checked = false;
                });
                toggleSelectionButton.textContent = '全件選択';
            }
        });
    </script>
@endsection
