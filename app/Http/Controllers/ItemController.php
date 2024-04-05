<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;

class ItemController extends Controller
{
    public function showTop()
    {
        $items = Item::all();// Itemsテーブルからすべてのアイテムを取得

        return view('toppage', compact('items'));
    }

    public function showMylist()
    {
        return view('mylist');
    }

    public function index($id)
    {
        $item = Item::findOrFail($id); // IDに対応する商品情報を取得

        return view('detail', compact('item'));
    }
}
