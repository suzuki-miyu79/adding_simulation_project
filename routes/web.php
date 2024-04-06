<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\MypageController;
use App\Http\Controllers\SellController;

// 商品一覧ページ（おすすめ）
Route::get('/', [ItemController::class, 'showTop'])->name('top');
// 商品詳細ページ
Route::get('/item/{item_id}', [ItemController::class, 'index'])->name('item.index');



Route::middleware('auth')->group(function () {

    // 商品一覧ページ（マイリスト）表示
    Route::get('/mylist', [ItemController::class, 'showMylist']);
    // コメント送信
    Route::post('/item/{item_id}', [ItemController::class, 'comment'])->name('item.comment');
    // 購入ページ
    Route::get('/purchase/{item_id}', [PurchaseController::class, 'index'])->name('purchase.index');
    // 購入処理
    Route::post('/purchase/{item_id}', [PurchaseController::class, 'purchase'])->name('purchase');
    // 住所変更ページ
    Route::get('/purchase/address/{item_id}', [PurchaseController::class, 'showAddress']);
    // 住所変更処理
    Route::post('/purchase/address/{item_id}', [PurchaseController::class, 'updateAddress'])->name('address.update');
    // 決済ページ
    Route::get('/payment', [PaymentController::class, 'index']);
    // 決済処理
    Route::post('/payment', [PaymentController::class, 'payment'])->name('payment');
    // マイページ
    Route::get('/mypage', [MypageController::class, 'index'])->name('mypage');
    // プロフィール設定ページ
    Route::get('/mypage/profile', [MypageController::class, 'create'])->name('profile');
    // プロフィール登録処理
    Route::post('/mypage/profile', [MypageController::class, 'store'])->name('profile.setting');
    // 出品ページ
    Route::get('/sell', [SellController::class, 'index']);
    // 出品処理
    Route::post('/sell', [SellController::class, 'store'])->name('sell');
    // カテゴリー1に関連するカテゴリー2の一覧取得
    Route::get('/sell/parent_categories/{parentCategoryId}/children', [SellController::class, 'getChildCategories']);
});

require __DIR__ . '/auth.php';
