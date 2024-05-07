@extends('layouts.admin-header')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/admin/comment-management.css') }}">
@endsection

@section('content')
    <div class="comment-management">
        <div class="comment-management__header">
            <h2>コメント管理</h2>
        </div>
        <div class="comment-management__search">
            <form action="{{ route('comment.search') }}" method="GET" class="search-form">
                <input type="text" name="keyword" placeholder="コメント内容や投稿者を検索">
                <img src="/images/search-icon.svg" alt="">
            </form>
        </div>
        <div class="comment-management__table">
            <table>
                <tr>
                    <th>コメント</th>
                    <th>投稿者</th>
                    <th>日付</th>
                    <th>削除</th>
                </tr>
                @foreach ($comments as $comment)
                    <tr>
                        <td class="comment-cell" data-full-text="{{ $comment->comment }}">
                            {{ Str::limit($comment->comment, 30) }}@if (strlen($comment->comment) > 30)
                            @endif
                        </td>
                        <td class="name-cell">{{ $comment->user->name }}</td>
                        <td class="day-cell">{{ $comment->created_at->format('Y-m-d') }}</td>
                        <td>
                            <form action="{{ route('admin.comments.destroy', $comment->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit">削除</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
        <div class="pagination">
            {{ $comments->links('vendor.pagination.bootstrap-4') }}
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // 各コメントセルにマウスオーバー時のイベントを追加
            document.querySelectorAll('.comment-cell').forEach(function(cell) {
                cell.addEventListener('mouseenter', function() {
                    // ポップアップを作成して全文を表示
                    var popup = document.createElement('div');
                    popup.classList.add('popup');
                    popup.textContent = this.dataset.fullText;
                    // ポップアップをセルの下に挿入
                    this.appendChild(popup);
                });
                cell.addEventListener('mouseleave', function() {
                    // マウスがセルから離れたらポップアップを削除
                    var popup = this.querySelector('.popup');
                    if (popup) {
                        popup.remove();
                    }
                });
            });
        });
    </script>
@endsection
