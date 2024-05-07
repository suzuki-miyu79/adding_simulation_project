<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\AdminMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class AdminController extends Controller
{
    // 管理者ページ表示
    public function showAdminPage()
    {
        return view('admin.admin-page');
    }

    // ユーザー管理ページ表示
    public function showUserManagement(Request $request)
    {
        $users = User::query();

        // 検索
        if ($request->has('search')) {
            $search = $request->input('search');
            $users->where('name', 'like', "%$search%")
                ->orWhere('email', 'like', "%$search%");
        }

        $users = $users->paginate(10); // 1ページに10件ずつユーザーを取得

        return view('admin.user-management', compact('users'));
    }

    // ユーザー削除
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.user')->with('success', 'ユーザーを削除しました。');
    }

    // コメント管理ページ表示
    public function showCommentManagement()
    {
        $comments = Comment::paginate(10); // 1ページに10件ずつコメントを取得

        return view('admin.comment-management', compact('comments'));
    }

    // コメント検索機能
    public function searchComment(Request $request)
    {
        // 検索キーワードを取得
        $keyword = $request->input('keyword');

        // コメント内容・投稿者名・日付で部分一致検索を行うクエリを作成
        $comments = Comment::query()
            ->where('comment', 'like', "%$keyword%")
            ->orWhereHas('user', function ($query) use ($keyword) {
                $query->where('name', 'like', "%$keyword%");
            })
            ->orWhereDate('created_at', 'like', "%$keyword%")

            ->paginate(10);

        return view('admin.comment-management', compact('comments'));
    }

    // 登録完了ページ表示
    public function showRegistered()
    {
        return view('registered');
    }

    // メール送信フォーム表示
    public function showMailForm()
    {
        // ユーザーのリストを取得
        $users = User::all();

        return view('mail.mail', compact('users'));
    }

    // メール送信機能
    public function sendMail(Request $request)
    {
        // フォームから送信された、選択されたユーザーのメールアドレスと名前を取得
        $selectedRecipients = $request->input('recipients');
        $users = User::whereIn('email', $selectedRecipients)->select('name', 'email')->get();

        // フォームから送信されたデータを取得
        $message = nl2br($request->input('message'));

        foreach ($users as $user) {
            try {
                // メール送信処理
                Mail::to($user->email)->send(new AdminMail($user->name, $message));
            } catch (\Exception $e) {
                // メール送信失敗時にログを記録する
                Log::error('メールの送信中にエラーが発生しました。', ['exception' => $e]);
                // メール送信失敗時の処理
                return redirect()->back()->with('error', 'メールの送信中にエラーが発生しました。');
            }
        }

        // メール送信成功時の処理
        return redirect()->back()->with('success', 'メールが送信されました。');
    }
}

