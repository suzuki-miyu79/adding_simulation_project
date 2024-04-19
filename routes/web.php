<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\MypageController;
use App\Http\Controllers\SellController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\AdminController;
use App\Http\Middleware\AdminMiddleware;

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
    // 購入完了ページ
    Route::get('/purchase/{item_id}/thanks', [PurchaseController::class, 'thanks'])->name('purchase.thanks');
    // 住所変更ページ
    Route::get('/purchase/address/{item_id}', [PurchaseController::class, 'showAddress'])->name('address');
    // 住所変更処理
    Route::post('/purchase/address/{item_id}', [PurchaseController::class, 'changeAddress'])->name('address.change');
    // 決済処理
    Route::post('/charge/{item_id}', [PaymentController::class, 'charge'])->name('charge');
    // サンクスページ
    Route::get('/thanks', [PurchaseController::class, 'thanks']);
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
    // お気に入り登録
    Route::post('/favorite/{item_id}', [FavoriteController::class, 'toggleFavorite'])->name('favorite.toggle');
    // 検索
    Route::get('/search', [ItemController::class, 'search'])->name('search');
    // 管理ページの表示
    Route::get('/admin', [AdminController::class, 'showAdminPage'])->name('admin.show')->middleware(AdminMiddleware::class)->middleware('auth');
    // メール送信フォームの表示
    Route::get('/mailform', [AdminController::class, 'showMailForm'])->name('mailform.show');
    // メール送信
    Route::post('/send-mail', [AdminController::class, 'sendMail'])->name('send.mail');
});

require __DIR__ . '/auth.php';
