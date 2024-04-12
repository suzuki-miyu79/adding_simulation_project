<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Favorite;
use App\Models\Comment;

class ItemController extends Controller
{
    public function showTop()
    {
        $items = Item::all();// Itemsテーブルからすべてのアイテム情報を取得

        return view('toppage', compact('items'));
    }

    public function showMylist()
    {
        return view('mylist');
    }

    public function index($id)
    {
        $item = Item::findOrFail($id); // IDに対応する商品情報を取得
        $favoriteCount = Favorite::where('item_id', $item->id)->count(); // お気に入り登録数を取得
        $commentCount = Comment::where('item_id', $item->id)->count(); // コメント数を取得

        $favoriteModel = new Favorite();

        return view('detail', compact('item', 'favoriteCount', 'commentCount', 'favoriteModel'));
    }
}
