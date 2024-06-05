@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/attendance.css') }}" />
@endsection

@section('content')
<div class="attendance__content">
    <!--ページネーション記載-->
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
            @for ($id = 0; $id < $count; $id++) <tr class="content-table__row">
                <td class="content-table__item">
                    {{ $attendanceArray[$id]['user']['name'] }}
                </td>
                <td class="content-table__item">
                    {{ $attendanceArray[$id]['start_time'] }}
                </td>
                <td class="content-table__item">
                    {{ $attendanceArray[$id]['end_time'] }}
                </td>
                <td class="content-table__item">
                    {{ $attendanceArray[$id]['break_time'] }}
                </td>
                <td class="content-table__item">
                    {{ $attendanceArray[$id]['work_time'] }}
                </td>
                </tr>
                @endfor
        </table>
        <!--ページネーション-->
    </div>
</div>
@endsection