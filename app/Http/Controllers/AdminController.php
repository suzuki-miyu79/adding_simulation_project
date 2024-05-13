<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\AdminMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\Comment;

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

        // 日付検索
        if ($request->has('date')) {
            $date = $request->input('date');
            $users->whereDate('created_at', $date);

            // 選択された日付をセッションに保存
            $request->session()->put('selected_date', $date);
        } else {
            // セッションから日付を取得
            $date = $request->session()->get('selected_date');
        }

        $users = $users->paginate(10); // 1ページに10件ずつユーザーを取得

        return view('admin.user-management', compact('users', 'date'));
    }

    // ユーザー管理の検索結果クリア
    public function clearSearchUser(Request $request)
    {
        $request->session()->forget('selected_date'); // 日付検索のセッションを削除

        return redirect()->route('admin.user');
    }

    // ユーザー削除
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.user')->with('success', 'ユーザーを削除しました。');
    }

    // コメント管理ページ表示
    public function showCommentManagement(Request $request)
    {
        // 検索キーワードを取得
        $keyword = $request->input('keyword');

        // コメント内容・投稿者名で部分一致検索を行うクエリを作成
        $comments = Comment::query();

        if ($keyword) {
            $comments->where('comment', 'like', "%$keyword%")
                ->orWhereHas('user', function ($query) use ($keyword) {
                    $query->where('name', 'like', "%$keyword%");
                });
        }

        // 日付検索
        if ($request->has('date')) {
            $date = $request->input('date');
            $comments->whereDate('created_at', $date);

            // 選択された日付をセッションに保存
            $request->session()->put('selected_date', $date);
        } else {
            // セッションから日付を取得
            $date = $request->session()->get('selected_date');
        }

        // ページネーションを適用
        $comments = $comments->paginate(10);

        return view('admin.comment-management', compact('comments', 'date'));
    }

    // コメント管理の検索結果クリア
    public function clearSearchComment(Request $request)
    {
        $request->session()->forget('selected_date'); // 日付検索のセッションを削除

        return redirect()->route('admin.comment');
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

