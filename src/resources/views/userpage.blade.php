@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/userpage.css') }}" />
@endsection

@section('content')
<div class="userpage__content">
    <h2 class="userpage__title">ユーザーページ</br>
        {{ $name }}さんの勤怠一覧
    </h2>
    <div class="userpage-table">
        <table class="userpage-table__inner">
            <tr class="userpage-table__row">
                <th class="userpage-table__header">
                    勤務日
                </th>
                <th class="userpage-table__header">
                    勤務開始
                </th>
                <th class="userpage-table__header">
                    勤務終了
                </th>
                <th class="userpage-table__header">
                    休憩時間
                </th>
                <th class="userpage-table__header">
                    勤務時間
                </th>
            </tr>
            @for ($id = $idcount; $id < $count; $id++) @if ($paginatedData[$id]==null) @break @endif <tr class="userpage-table__row">
                <td class="userpage-table__item">
                    {{ $paginatedData[$id]['date'] }}
                </td>
                <td class="userpage-table__item">
                    {{ $paginatedData[$id]['start_time'] }}
                </td>
                <td class="userpage-table__item">
                    {{ $paginatedData[$id]['end_time'] }}
                </td>
                <td class="userpage-table__item">
                    {{ $paginatedData[$id]['break_time'] }}
                </td>
                <td class="userpage-table__item">
                    {{ $paginatedData[$id]['work_time'] }}
                </td>
                </tr>
                @endfor
        </table>
        {{ $paginatedData->withQueryString()->links() }}
    </div>
</div>
@endsection