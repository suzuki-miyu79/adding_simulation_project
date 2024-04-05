@extends('layouts.header-search')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/sell.css') }}">
@endsection

@section('content')
    <div class="sell__content">

        <div class="sell__heading">
            <h2>商品の出品</h2>
        </div>
        <form id="sell_form" method="POST" action="{{ route('sell') }}" enctype="multipart/form-data">
            @csrf
            <div class="sell-form">
                <div class="form__group">
                    <label for="">商品画像</label>
                    <div class="form__group-input--img" id="preview-container">
                        <label>
                            <input type="file" id="item_image" name="item_image" required
                                onchange="previewImage(event)">画像を選択する
                        </label>
                    </div>
                </div>
                <div class="form__group">
                    <p>商品の詳細</p>
                    <div class="line"></div>
                    <div class="form__group-input">
                        <label for="">カテゴリー</label>
                        <select name="parent_category" id="parent_category">
                            <option value="">カテゴリー1を選択してください</option>
                            @foreach ($parentCategories as $parentCategory)
                                <option value="{{ $parentCategory->id }}">{{ $parentCategory->name }}</option>
                            @endforeach
                        </select>

                        <select name="child_category" id="child_category" disabled>
                            <option value="">カテゴリー2を選択してください</option>
                        </select>
                    </div>
                    <div class="form__group-input">
                        <label for="condition">商品の状態</label>
                        <select id="condition" name="condition" required>
                            <option value="">選択してください</option>
                            @foreach ($conditions as $condition)
                                <option value="{{ $condition->id }}">{{ $condition->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form__group">
                    <p>商品名と説明</p>
                    <div class="line"></div>
                    <div class="form__group-input">
                        <label for="">商品名</label>
                        <input type="text" id="name" name="name" required>
                    </div>
                    <div class="form__group-input">
                        <label for="">商品の説明</label>
                        <input type="text" id="description" name="description" required>
                    </div>
                </div>
                <div class="form__group">
                    <p>販売価格</p>
                    <div class="line"></div>
                    <div class="form__group-input">
                        <label for="">販売価格</label>
                        <input type="text" id="price" name="price" required>
                    </div>
                </div>
                <div class="form__error">
                    @foreach ($errors->all() as $error)
                        <span class="error">{{ $error }}</span>
                    @endforeach
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

        // カテゴリー1が選択されたときの処理
        document.getElementById('parent_category').addEventListener('change', function() {
            var parentCategoryId = this.value;
            var childCategorySelect = document.getElementById('child_category');

            // カテゴリー2の選択肢を無効にする
            childCategorySelect.disabled = true;
            childCategorySelect.innerHTML = '<option value="">カテゴリー2を選択してください</option>';

            // 選択された親カテゴリーに紐づくカテゴリー2を取得し、選択肢として追加する
            fetch('/sell/parent_categories/' + parentCategoryId + '/children')
                .then(response => response.json())
                .then(data => {
                    data.forEach(childCategory => {
                        var option = document.createElement('option');
                        option.value = childCategory.id;
                        option.text = childCategory.name;
                        childCategorySelect.appendChild(option);
                    });
                    // カテゴリー2の選択肢を有効にする
                    childCategorySelect.disabled = false;
                });
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
