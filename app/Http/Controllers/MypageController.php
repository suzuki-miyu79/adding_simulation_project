<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Purchase;
use App\Http\Requests\ProfileRequest;
use Illuminate\Support\Facades\Auth;

class MypageController extends Controller
{
    // マイページの表示
    public function index()
    {
        // ログインしているユーザーの情報を取得
        $user = Auth::user();
        $userId = $user->id;
        $items = Item::where('seller_user_id', $userId)->get();
        return view('mypage', compact('user', 'items'));
    }

    // プロフィール設定ページの表示
    public function create()
    {
        $user = Auth::user();
        return view('profile', compact('user'));
    }

    // プロフィール登録処理
    public function store(ProfileRequest $request)
    {
        // ログインしているユーザーの情報を取得
        /** @var \App\Models\User $user **/
        $user = Auth::user();

        // ユーザー情報を更新
        if ($request->filled('name')) {
            $user->name = $request->input('name');
        }
        if ($request->filled('postcode')) {
            $user->postcode = $request->input('postcode');
        }
        if ($request->filled('address')) {
            $user->address = $request->input('address');
        }
        if ($request->filled('building_name')) {
            $user->building_name = $request->input('building_name');
        }

        // 画像のアップロード処理
        if ($request->hasFile('profile_image')) {
            // 画像を保存してパスを取得
            $imagePath = $request->file('profile_image')->store('profile_images', 'public');
            // パスを保存
            $user->image = asset('storage/' . $imagePath);
        }

        // ユーザー情報を保存
        $user->save();

        // リダイレクト
        return redirect()->route('mypage')->with('success', 'プロフィールを更新しました');
    }

    // 購入した商品ページの表示
    public function showPurchaseProduct()
    {
        // ログインしているユーザーの情報を取得
        $user = Auth::user();
        $userId = $user->id;
        $purchases = Purchase::where('buyer_user_id', $userId)->get();

        // 商品情報を格納する配列を初期化
        $itemsData = [];

        // 購入した商品ごとに商品情報を取得し、配列に追加
        foreach ($purchases as $purchase) {
            $item = Item::find($purchase->item_id);
            if ($item) {
                $itemsData[] = [
                    'image' => $item->image,
                    'name' => $item->name,
                ];
            }
        }

        return view('purchase-product', compact('user', 'itemsData'));
    }
}
