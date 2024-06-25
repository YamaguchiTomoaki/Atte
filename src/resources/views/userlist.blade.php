@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/userlist.css') }}" />
@endsection

@section('content')
<div class="userlist__content">
    <h2 class="userlist__title">ユーザー一覧</h2>
    <table class="userlist-table__inner">
        <tr class="userlist-table__row">
            <th class="userlist-table__title">名前</th>
            <th class="userlist-table__title">勤怠一覧ボタン</th>
        </tr>
        @foreach ($users as $user)
        <tr class="userlist-table__row">
            <td class="userlist-table__item--name">
                {{ $user['name'] }}
            </td>
            <td class="userlist-table__item--button">
                <form class="userlist-form" action="/userpage" method="get">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ $user['id'] }}">
                    <button class="userlist__button" type="submit">勤怠一覧</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
    {{ $users->links() }}
</div>
@endsection