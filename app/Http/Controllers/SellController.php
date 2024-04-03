<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\SellRequest;
use App\Models\Item;
use App\Models\Parent_category;

class SellController extends Controller
{
    public function index()
    {
        $parentCategories = Parent_category::with('children')->get();

        return view('/sell', compact('parentCategories'));
    }

    public function store(SellRequest $request)
    {
        $item = new Item();
        $item->child_category_id = $request->input('category');
        $item->condition_id = $request->input('condition');
        $item->name = $request->input('name');
        $item->description = $request->input('description');
        $item->price = $request->input('price');
        // 画像のアップロード処理
        if ($request->hasFile('item_image')) {
            // 画像を保存してパスを取得
            $imagePath = $request->file('item_image')->store('item_images', 'public');
            // パスを保存
            $item->image = asset('storage/' . $imagePath);
        }

        $item->save();
    }
}
