<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\SellRequest;
use App\Models\Item;
use App\Models\ParentCategory;
use App\Models\Condition;
use Illuminate\Support\Facades\Auth;

class SellController extends Controller
{
    public function index()
    {
        // カテゴリーを取得
        $parentCategories = ParentCategory::with('childCategories')->get();
        // 商品の状態を取得
        $conditions = Condition::all();

        return view('/sell', compact('parentCategories', 'conditions'));
    }

    // カテゴリー1のIDを受け取り、関連するカテゴリー2を取得する
    public function getChildCategories($parentCategoryId)
    {
        $parentCategory = ParentCategory::find($parentCategoryId);
        if (!$parentCategory) {
            return response()->json(['error' => 'Parent category not found'], 404);
        }

        $childCategories = $parentCategory->childCategories;

        return response()->json($childCategories);
    }

    public function store(SellRequest $request)
    {
        // ログインしているユーザーのIDを取得
        $sellerUserId = Auth::id();

        $item = new Item();
        $item->child_category_id = $request->input('child_category');
        $item->condition_id = $request->input('condition');
        $item->name = $request->input('name');
        $item->description = $request->input('description');
        $item->brand = $request->input('brand');
        $item->price = $request->input('price');
        $item->seller_user_id = $sellerUserId;
        // 画像のアップロード処理
        if ($request->hasFile('item_image')) {
            // 画像を保存してパスを取得
            $imagePath = $request->file('item_image')->store('item_images', 'public');
            // パスを保存
            $item->image = asset('storage/' . $imagePath);
        }

        $item->save();

        // 出品処理完了後に出品完了ページへリダイレクト
        return redirect()->route('sell.complete');
    }

    public function showSellComplete()
    {
        return view('sell-complete');
    }
}
