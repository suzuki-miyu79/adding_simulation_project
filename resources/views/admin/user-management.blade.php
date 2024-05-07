@extends('layouts.admin-header')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/admin/user-management.css') }}">
@endsection

@section('content')
    <div class="user-management">
        <div class="user-management__header">
            <h2>ユーザー管理</h2>
        </div>
        <div class="user-management__search">
            <form id="user-search-form" action="{{ route('admin.user') }}" method="GET" class="search-form">
                <input class="search-name" type="text" name="search" placeholder="ユーザー名またはメールアドレスを検索">
                <img src="/images/search-icon.svg" alt="">
                <input class="search-date" type="date" id="date-input" name="date" placeholder="日付を選択"
                    value="{{ $date ?? '' }}">
            </form>
            <form action="{{ route('admin.user.clearSearch') }}" method="GET">
                <button type="submit">クリア</button>
            </form>
        </div>
        <div class="user-management__table">
            <table>
                <tr>
                    <th>ユーザー名</th>
                    <th>メールアドレス</th>
                    <th>登録日</th>
                    <th>削除</th>
                </tr>
                @foreach ($users as $user)
                    <tr>
                        <td class="name-cell">{{ $user->name }}</td>
                        <td class="email-cell">{{ $user->email }}</td>
                        <td class="day-cell">{{ $user->created_at->format('Y-m-d') }}</td>
                        <td>
                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('本当に削除しますか？')">削除</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
        <div class="pagination">
            {{ $users->links('vendor.pagination.bootstrap-4') }}
        </div>
    </div>

    <script>
        // 日付検索の即時実行
        document.getElementById('date-input').addEventListener('change', function() {
            document.getElementById('user-search-form').submit();
        });
    </script>
@endsection
