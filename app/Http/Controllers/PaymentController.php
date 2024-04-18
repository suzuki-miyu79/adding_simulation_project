<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Charge;
use App\Models\Purchase;
use App\Models\Item;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    // 決済ページ
    public function charge(Request $request, $item_id)
    {
        // ユーザーIDを取得
        $userId = auth()->id();

        // 商品の価格を取得
        $item = Item::findOrFail($item_id);

        Stripe::setApiKey(env('STRIPE_SECRET')); //シークレットキー

        try {
            // クレジットカード情報を使用して支払いを処理
            $charge = Charge::create([
                'amount' => $item->price, // 商品の価格で指定
                'currency' => 'jpy',
                'source' => $request->stripeToken, // トークン
            ]);

            // Purchasesテーブルに購入情報を登録
            Purchase::create([
                'item_id' => $item_id,
                'buyer_user_id' => $userId,
            ]);

            return view('thanks');

        } catch (\Exception $e) {
            // エラーメッセージとスタックトレースをログに記録する
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());

            // リクエスト情報をログに記録する
            Log::error('Request: ' . request()->fullUrl());
            Log::error('Request Data: ' . json_encode(request()->all()));

            return back()->with('error', '支払い処理中にエラーが発生しました。もう一度お試しください。');
        }
    }
}
