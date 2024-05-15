@extends('layouts.header-search')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/sell.css') }}">
@endsection

@section('content')
    <div class="sell__content">

        <div class="sell__heading">
            <h1>商品の出品</h1>
        </div>
        <form id="sell_form" method="POST" action="{{ route('sell') }}" enctype="multipart/form-data">
            @csrf
            <div class="sell-form">
                <div class="form__group">
                    <label for="">商品画像</label>
                    <div class="form__group-input--img" id="preview-container">
                        <label>
                            <input type="file" id="item_image" name="item_image" onchange="previewImage(event)">画像を選択する
                        </label>
                    </div>
                    @if ($errors->has('item_image'))
                        <div class="error">
                            {{ $errors->first('item_image') }}
                        </div>
                    @endif
                </div>
                <div class="form__group">
                    <p>商品の詳細</p>
                    <div class="line"></div>
                    <div class="form__group-input">
                        <label for="parent_category">カテゴリー</label>
                        <select name="parent_category" id="parent_category" required>
                            <option value="">カテゴリー1を選択してください</option>
                            @foreach ($parentCategories as $parentCategory)
                                <option value="{{ $parentCategory->id }}"
                                    {{ old('parent_category') == $parentCategory->id ? 'selected' : '' }}>
                                    {{ $parentCategory->name }}
                                </option>
                            @endforeach
                        </select>
                        <select name="child_category" id="child_category" disabled>
                            <option value="">カテゴリー2を選択してください</option>
                            @if (old('parent_category'))
                                @foreach ($childCategories as $childCategory)
                                    <option value="{{ $childCategory->id }}"
                                        {{ old('child_category') == $childCategory->id ? 'selected' : '' }}>
                                        {{ $childCategory->name }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>
                <div class="form__group">
                    <p>商品名と説明</p>
                    <div class="line"></div>
                    <div class="form__group-input">
                        <label for="">商品名</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" required>
                    </div>
                    <div class="form__group-input">
                        <label for="">商品の説明</label>
                        <input type="text" id="description" name="description" value="{{ old('description') }}"
                            required>
                    </div>
                    <div class="form__group-input">
                        <label for="">ブランド名（任意）</label>
                        <input type="text" id="brand" name="brand" value="{{ old('brand') }}">
                    </div>
                </div>
                <div class="form__group">
                    <p>販売価格</p>
                    <div class="line"></div>
                    <div class="form__group-input">
                        <label for="">販売価格</label>
                        <div class="price">
                            <span>&yen;</span>
                            <input type="text" id="price" name="price" value="{{ old('price') }}" required>
                        </div>
                    </div>
                </div>
                <div class="form__button">
                    <button class="form__button-submit">出品する</button>
                </div>
            </div>
        </form>
    </div>

    <script>
        // 商品画像の表示
        function previewImage(event) {
            const input = event.target;
            const reader = new FileReader();

            reader.onload = function() {
                const previewContainer = document.getElementById('preview-container');
                previewContainer.style.backgroundImage = `url('${reader.result}')`;
            };

            if (input.files && input.files[0]) {
                reader.readAsDataURL(input.files[0]);
            }
        }

        // ページのDOMが完全に読み込まれた後に実行される
        document.addEventListener('DOMContentLoaded', function() {
            var parentCategorySelect = document.getElementById('parent_category');
            var childCategorySelect = document.getElementById('child_category');

            // ページ再表示時、親カテゴリーが選択されている場合は子カテゴリーの選択肢をロードする
            if (!parentCategorySelect.value) {
                // 親カテゴリーが選択されていない場合、子カテゴリーを無効にする
                childCategorySelect.disabled = true;
            } else {
                // 親カテゴリーが選択されている場合、子カテゴリーをロードして無効化を解除する
                loadChildCategories(parentCategorySelect.value, '{{ old('child_category') }}');
            }

            // 親カテゴリーが変更されたときに実行される処理
            parentCategorySelect.addEventListener('change', function() {
                var parentCategoryId = this.value;
                // 新しく選択された親カテゴリーに基づいて子カテゴリーをロードする
                loadChildCategories(parentCategoryId);
            });

            /**
             * 選択された親カテゴリーに基づいて子カテゴリーをロードする関数
             * @param {string} parentCategoryId - 親カテゴリーのID
             * @param {string|null} selectedChildCategoryId - 選択された子カテゴリーのID（再表示時の保持用）
             */
            function loadChildCategories(parentCategoryId, selectedChildCategoryId = null) {
                // 子カテゴリーのセレクトボックスを無効にして初期化
                childCategorySelect.disabled = true; // 選択を無効にする
                childCategorySelect.innerHTML = '<option value="">カテゴリー2を選択してください</option>';

                // 親カテゴリーが選択されていない場合は処理を終了
                if (!parentCategoryId) {
                    return;
                }

                // サーバーから選択された親カテゴリーに対応する子カテゴリーを取得し、セレクトボックスに追加する
                fetch('/sell/parent_categories/' + parentCategoryId + '/children')
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(childCategory => {
                            var option = document.createElement('option');
                            option.value = childCategory.id;
                            option.text = childCategory.name;
                            // 再表示時に選択された子カテゴリーを保持する
                            if (selectedChildCategoryId && option.value == selectedChildCategoryId) {
                                option.selected = true;
                            }
                            childCategorySelect.appendChild(option);
                        });
                        // 子カテゴリーの選択肢が追加された後、セレクトボックスを有効にする
                        childCategorySelect.disabled = false;
                    });
            }
        });

        document.getElementById('child_category').addEventListener('change', function() {
            var childCategoryId = this.value;

            // カテゴリー2のIDをフォームに追加する
            var hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'child_category';
            hiddenInput.value = childCategoryId;
            var form = document.getElementById('sell_form');
            form.appendChild(hiddenInput);
        });
    </script>
@endsection
