<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;

class PurchaseController extends Controller
{
    public function index($id)
    {
        $item = Item::findOrFail($id); // IDに対応する商品情報を取得

        return view('purchase', compact('item'));
    }
}
