@extends('layouts.header-search')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/sell.css') }}">
@endsection

@section('content')
    <div class="sell__content">

        <div class="sell__heading">
            <h2>商品の出品</h2>
        </div>
        <form method="POST" action="{{ route('sell') }}" enctype="multipart/form-data">
            @csrf
            <div class="sell-form">
                <div class="form__group">
                    <label for="">商品画像</label>
                    <div class="form__group-input--img">
                        <label>
                            <input type="file" id="item_image" name="item_image" required>画像を選択する
                        </label>
                    </div>
                </div>
                <div class="form__group">
                    <p>商品の詳細</p>
                    <div class="line"></div>
                    <div class="form__group-input">
                        <label for="">カテゴリー</label>
                        <select name="parent_category_id" id="parent_category">
                            <option value="">親カテゴリーを選択してください</option>
                            @foreach ($parentCategories as $parentCategory)
                                <option value="{{ $parentCategory->id }}">{{ $parentCategory->name }}</option>
                            @endforeach
                        </select>

                        <select name="child_category_id" id="child_category" disabled>
                            <option value="">子カテゴリーを選択してください</option>
                        </select>
                    </div>
                    <div class="form__group-input">
                        <label for="">商品の状態</label>
                        <input type="text" id="condition" name="condition" required>
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
        // 親カテゴリーが選択されたときの処理
        document.getElementById('parent_category').addEventListener('change', function() {
            var parentCategoryId = this.value;
            var childCategorySelect = document.getElementById('child_category');

            // 子カテゴリーの選択肢を無効にする
            childCategorySelect.disabled = true;
            childCategorySelect.innerHTML = '<option value="">子カテゴリーを選択してください</option>';

            // 選択された親カテゴリーに紐づく子カテゴリーを取得し、選択肢として追加する
            fetch('/api/parent_categories/' + parentCategoryId + '/children')
                .then(response => response.json())
                .then(data => {
                    data.forEach(childCategory => {
                        var option = document.createElement('option');
                        option.value = childCategory.id;
                        option.text = childCategory.name;
                        childCategorySelect.appendChild(option);
                    });
                    // 子カテゴリーの選択肢を有効にする
                    childCategorySelect.disabled = false;
                });
        });
    </script>
@endsection
