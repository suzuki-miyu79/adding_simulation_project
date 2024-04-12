<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Favorite;

class FavoriteController extends Controller
{
    public function toggleFavorite(Request $request, $itemId)
    {
        // 現在のユーザーのIDを取得
        $userId = auth()->id();

        // お気に入りテーブルに該当のレコードが存在するかをチェック
        $existingFavorite = Favorite::where('user_id', $userId)->where('item_id', $itemId)->first();

        // レコードが存在しない場合は新しく追加し、存在する場合は削除する
        if ($existingFavorite) {
            $existingFavorite->delete();
            $message = 'お気に入りから削除しました';
            $isFavorite = false;
        } else {
            Favorite::create([
                'user_id' => $userId,
                'item_id' => $itemId,
            ]);
            $message = 'お気に入りに追加しました';
            $isFavorite = true;
        }

        // お気に入りの数を取得
        $favoriteCount = Favorite::where('item_id', $itemId)->count();

        // お気に入りの状態と件数をJSON形式で返す
        return response()->json(['message' => $message, 'isFavorite' => $isFavorite, 'favoriteCount' => $favoriteCount]);
    }
}
