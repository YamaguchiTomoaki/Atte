@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/attendance.css') }}" />
@endsection

@section('content')
<div class="attendance__content">
    <div class="date__search">
        <form class="datebefore-form" action="/datebefore" method="get">
            <button class="before__button" type="submit">＜</button>
            <input type="hidden" name="date" value="{{ $date }}">
        </form>
        <p class="displaydate">{{ $date }}</p>
        <form class="dateafter-form" action="/dateafter" method="get">
            <button class="after__button" type="submit">＞</button>
            <input type="hidden" name="date" value="{{ $date }}">
        </form>
    </div>
    <div class="content-table">
        <table class="content-table__inner">
            <tr class="content-table__row">
                <th class="content-table__header">
                    名前
                </th>
                <th class="content-table__header">
                    勤務開始
                </th>
                <th class="content-table__header">
                    勤務終了
                </th>
                <th class="content-table__header">
                    休憩時間
                </th>
                <th class="content-table__header">
                    勤務時間
                </th>
            </tr>
            @for ($id = $idcount; $id < $count; $id++) @if ($paginatedData[$id]==null) @break @endif <tr class="content-table__row">
                <td class="content-table__item">
                    {{ $paginatedData[$id]['user']['name'] }}
                </td>
                <td class="content-table__item">
                    {{ $paginatedData[$id]['start_time'] }}
                </td>
                <td class="content-table__item">
                    {{ $paginatedData[$id]['end_time'] }}
                </td>
                <td class="content-table__item">
                    {{ $paginatedData[$id]['break_time'] }}
                </td>
                <td class="content-table__item">
                    {{ $paginatedData[$id]['work_time'] }}
                </td>
                </tr>
                @endfor
        </table>
        {{ $paginatedData->withQueryString()->links() }}

    </div>
</div>
@endsection