<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProfileRequest;
use Illuminate\Support\Facades\Auth;

class MypageController extends Controller
{
    public function index()
    {
        // ログインしているユーザーの情報を取得
        $user = Auth::user();
        return view('mypage', compact('user'));
    }

    public function create()
    {
        return view('profile');
    }

    public function store(ProfileRequest $request)
    {
        /** @var \App\Models\User $user **/
        // ログインしているユーザーの情報を取得
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
}
