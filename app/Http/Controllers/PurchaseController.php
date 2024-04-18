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

    public function changeAddress(Request $request, $id)
    {
        $item = Item::findOrFail($id); // IDに対応する商品情報を取得

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
        return redirect()->route('purchase.index', ['item_id' => $item->id])->with('success', '配送先住所を更新しました');
    }

    public function thanks()
    {
        return view('thanks');
    }

}
