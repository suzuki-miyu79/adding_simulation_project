<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Favorite;
use App\Models\Comment;

class ItemController extends Controller
{
    // トップページ表示
    public function showTop()
    {
        $items = Item::all();// Itemsテーブルからすべてのアイテム情報を取得

        return view('toppage', compact('items'));
    }

    // マイリスト表示
    public function showMylist()
    {
        $favorites = Favorite::where('user_id', auth()->id())->get(); // お気に入り登録しているアイテムを取得

        return view('mylist', compact('favorites'));
    }

    // 商品詳細ページ表示
    public function index($id)
    {
        $item = Item::findOrFail($id); // IDに対応する商品情報を取得
        $comments = Comment::where('item_id', $item->id)->get(); // 商品に紐づくコメントを取得
        $favoriteCount = Favorite::where('item_id', $item->id)->count(); // お気に入り登録数を取得
        $commentCount = Comment::where('item_id', $item->id)->count(); // コメント数を取得

        $favoriteModel = new Favorite();

        return view('detail', compact('item', 'comments', 'favoriteCount', 'commentCount', 'favoriteModel'));
    }

    // 検索機能
    public function search(Request $request)
    {
        $keyword = $request->input('keyword');

        // キーワードに部分一致するアイテムを検索
        $items = Item::where('name', 'like', '%' . $keyword . '%')
            ->orWhere('brand', 'like', '%' . $keyword . '%')
            ->orWhereHas('childCategory', function ($query) use ($keyword) {
                $query->where('name', 'like', '%' . $keyword . '%');
            })
            ->get();

        return view('search-results', compact('items', 'keyword'));
    }

    // コメント機能
    public function comment(Request $request): RedirectResponse
    {
        $comment = new Comment();
        $comment->item_id = $request->item_id;
        $comment->user_id = auth()->id();
        $comment->comment = $request->comment;
        $comment->save();

        // 成功メッセージをセットしてリダイレクト
        return redirect()->back()->with('success', 'コメントを投稿しました。');
    }

    // コメント削除機能
    public function destroy(Comment $comment)
    {
        $comment->delete();
        return redirect()->back()->with('success', 'コメントを削除しました。');
    }
}
