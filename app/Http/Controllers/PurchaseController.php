<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Purchase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Stripe\Stripe;
use Stripe\PaymentIntent;

class PurchaseController extends Controller
{
    public function index($id)
    {
        $user = Auth::user(); // ログインしているユーザーの情報を取得
        $item = Item::findOrFail($id); // IDに対応する商品情報を取得

        return view('purchase', compact('user', 'item'));
    }

    public function showAddress($id)
    {
        $item = Item::findOrFail($id); // IDに対応する商品情報を取得

        return view('address-change', compact('item'));
    }

    public function changeAddress(Request $request)
    {
        // 送信された住所情報をセッションに保存
        Session::put('delivery_address', [
            'postcode' => $request->input('postcode'),
            'address' => $request->input('address'),
            'building_name' => $request->input('building_name'),
        ]);

        // 「はい」が選択された場合、プロフィールの住所を更新
        if ($request->input('update_profile_address') == 'yes') {
            /** @var \App\Models\User $user **/
            $user = Auth::user();
            $user->postcode = $request->input('postcode');
            $user->address = $request->input('address');
            $user->building_name = $request->input('building_name');
            $user->save();
        }

        // ページにリダイレクト
        return redirect()->route('purchase.show')->with('success', '配送先住所を更新しました');
    }

    public function purchase(Request $request, $itemId)
    {
        // StripeのAPIキーを設定
        Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

        // 商品の金額を取得
        $itemPrice = $request->input('item_price');

        try {
            // StripeのPaymentIntentを作成
            $paymentIntent = PaymentIntent::create([
                'amount' => $itemPrice * 100, // 金額をセント単位に変換
                'currency' => 'JPY',
            ]);

            // purchasesテーブルに情報を登録
            Purchase::create([
                'item_id' => $itemId,
                'buyer_user_id' => auth()->id(),
            ]);

            // 成功レスポンスを返す
            return response()->json(['success' => true, 'client_secret' => $paymentIntent->client_secret]);
        } catch (\Exception $e) {
            // エラーレスポンスを返す
            return response()->json(['error' => $e->getMessage()]);
        }
    }

}
