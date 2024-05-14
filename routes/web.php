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

// 認証済みユーザーがアクセス可能
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
    Route::get('/purchase/address/{item_id}', [PurchaseController::class, 'showAddress'])->name('address');
    // 住所変更処理
    Route::post('/purchase/address/{item_id}', [PurchaseController::class, 'changeAddress'])->name('address.change');
    // 決済処理
    Route::post('/charge/{item_id}', [PaymentController::class, 'charge'])->name('charge');
    // 購入完了ページ
    Route::get('/complete/{item_id}', [PurchaseController::class, 'complete'])->name('complete');
    // 銀行振込購入処理
    Route::post('/purchase/bank/{item_id}', [PaymentController::class, 'bankPaymentPurchase'])->name('purchase.bank');
    // 購入完了ページ
    Route::get('/complete-b/{item_id}', [PurchaseController::class, 'completeBank'])->name('complete.bank');
    // コンビニ支払購入処理
    Route::post('/purchase/convenience-store/{item_id}', [PaymentController::class, 'convenienceStorePaymentPurchase'])->name('purchase.convenienceStore');
    // 購入完了ページ
    Route::get('/complete-c/{item_id}', [PurchaseController::class, 'completeConvenienceStore'])->name('complete.convenienceStore');
    // マイページ(出品した商品)
    Route::get('/mypage', [MypageController::class, 'index'])->name('mypage');
    // マイページ(購入した商品)
    Route::get('/mypage/purchase-product', [MypageController::class, 'showPurchaseProduct']);
    // プロフィール設定ページ
    Route::get('/mypage/profile', [MypageController::class, 'create'])->name('profile');
    // プロフィール登録処理
    Route::post('/mypage/profile', [MypageController::class, 'store'])->name('profile.setting');
    // 出品ページ
    Route::get('/sell', [SellController::class, 'index']);
    // 出品処理
    Route::post('/sell', [SellController::class, 'store'])->name('sell');
    // 出品完了ページ
    Route::get('/sell/complete', [SellController::class, 'showSellComplete'])->name('sell.complete');
    // カテゴリー1に関連するカテゴリー2の一覧取得
    Route::get('/sell/parent_categories/{parentCategoryId}/children', [SellController::class, 'getChildCategories']);
    // お気に入り登録
    Route::post('/favorite/{item_id}', [FavoriteController::class, 'toggleFavorite'])->name('favorite.toggle');
    // 検索
    Route::get('/search', [ItemController::class, 'search'])->name('search');
    // 管理ページの表示
    Route::get('/admin', [AdminController::class, 'showAdminPage'])->name('admin.show')->middleware(AdminMiddleware::class)->middleware('auth');
    // ユーザー管理表示
    Route::get('/user-management', [AdminController::class, 'showUserManagement'])->name('admin.user')->middleware(AdminMiddleware::class)->middleware('auth');
    // ユーザー削除
    Route::delete('/user-management/{user}', [AdminController::class, 'destroy'])->name('admin.users.destroy')->middleware(AdminMiddleware::class)->middleware('auth');
    // ユーザー検索結果クリア
    Route::get('/user-management/clear-search', [AdminController::class, 'clearSearchUser'])->name('admin.user.clearSearch')->middleware(AdminMiddleware::class)->middleware('auth');
    // コメント管理表示
    Route::get('/comment-management', [AdminController::class, 'showCommentManagement'])->name('admin.comment')->middleware(AdminMiddleware::class)->middleware('auth');
    // コメント削除
    Route::delete('/comment-management/{comment}', [ItemController::class, 'destroy'])->name('admin.comments.destroy')->middleware(AdminMiddleware::class)->middleware('auth');
    // コメント検索結果クリア
    Route::get('/comment-management/clear-search', [AdminController::class, 'clearSearchComment'])->name('admin.comment.clearSearch')->middleware(AdminMiddleware::class)->middleware('auth');
    // メール送信フォームの表示
    Route::get('/mailform', [AdminController::class, 'showMailForm'])->name('mailform.show')->middleware(AdminMiddleware::class)->middleware('auth');
    // メール送信
    Route::post('/send-mail', [AdminController::class, 'sendMail'])->name('send.mail')->middleware(AdminMiddleware::class)->middleware('auth');
});

require __DIR__ . '/auth.php';
