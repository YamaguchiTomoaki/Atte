<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Attendance;
use App\Models\Breaks;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

class DateviewController extends Controller
{
    public function dateView(Request $request)
    {
        // デフォルトの日付取得処理
        $date = Carbon::now()->format('Y-m-d');
        // Attendancesテーブルと主テーブルのUsersのnameを取得
        $attendances = Attendance::with('user:id,name')->DateSearch($date)->get();
        // toArrayで配列に変換
        $attendanceArray = $attendances->toArray();
        // 配列の要素数取得
        $count = count($attendanceArray);
        // 勤務開始時刻と勤務終了時刻のdiffを勤務時間で減算し休憩時間の合計を求める
        for ($id = 0; $id < $count; $id++) {
            $starttime = $attendanceArray[$id]['start_time'];
            // diffInSecondsを行うためにCarbonの形式へ変換(勤務開始時刻)
            $starttime = new Carbon($starttime);
            $endtime = $attendanceArray[$id]['end_time'];
            // diffInSecondsを行うためにCarbonの形式へ変換(勤務終了時刻)
            $endtime = new Carbon($endtime);
            $worktime = $attendanceArray[$id]['work_time'];
            // 時:分:秒それぞれの値を秒に変更し加算する為にCarbon形式に変換
            $worktime = new Carbon($worktime);
            // 時を秒へ変換
            $workhour = $worktime->format('H') * 3600;
            // 分を秒へ変換
            $workminutes = $worktime->format('i') * 60;
            // 秒はそのまま
            $worksecond = $worktime->format('s');
            // 時：分：秒を加算し勤務時間の秒数を求める
            $workingtime = $workhour + $workminutes + $worksecond;
            // 勤務開始時間と勤務終了時間のdiffを秒で求める
            $diffInSeconds = $starttime->diffInSeconds($endtime);
            // 休憩時間の秒数を求める
            $breaksecond = $diffInSeconds - $workingtime;
            // 時：分：秒で表示する為にCarbon形式へ変換
            $breaksecond = new Carbon($breaksecond);
            $attendanceArray[$id]['break_time'] = $breaksecond->format('H:i:s');
        }
        $attendancecollection = collect($attendanceArray);
        $perPage = 5;
        $page = Paginator::resolveCurrentPage('page');
        $options = [
            'path' => Paginator::resolveCurrentPath(),
            'pageName' => 'page'
        ];
        // view内ループ処理終了カウント
        $count = $page * 5;
        // view内ループ処理開始カウント
        $idcount = $count - 5;

        $paginatedData = new LengthAwarePaginator($attendancecollection->forPage($request->page, 5), count($attendancecollection), 5, $request->page, array('path' => $request->url()));

        /* [表示するコレクション] = new LengthAwarePaginator(
            [表示するコレクション]->forPage([現在のページ番号],[1ページ当たりの表示数]),
            [コレクションの大きさ],
            [1ページ当たりの表示数],
            [現在のページ番号],
            [オプション(ここでは"ページの遷移先パス")]
        );*/

        // $attendanceArrayの要素数をviewファイルでも使用したいのでついでにcountも送っている
        return view('attendance', compact('paginatedData', 'count', 'date', 'idcount'));
    }

    public function dateBefore(Request $request)
    {
        $date = $request->only('date');
        $date = new Carbon($date['date']);
        $date = $date->subDay()->format('Y-m-d');

        // Attendancesテーブルと主テーブルのUsersのnameを取得
        $attendances = Attendance::with('user:id,name')->DateSearch($date)->get();
        // toArrayで配列に変換
        $attendanceArray = $attendances->toArray();
        // 配列の要素数取得
        $count = count($attendanceArray);
        // 勤務開始時刻と勤務終了時刻のdiffを勤務時間で減算し休憩時間の合計を求める
        for ($id = 0; $id < $count; $id++) {
            $starttime = $attendanceArray[$id]['start_time'];
            // diffInSecondsを行うためにCarbonの形式へ変換(勤務開始時刻)
            $starttime = new Carbon($starttime);
            $endtime = $attendanceArray[$id]['end_time'];
            // diffInSecondsを行うためにCarbonの形式へ変換(勤務終了時刻)
            $endtime = new Carbon($endtime);
            $worktime = $attendanceArray[$id]['work_time'];
            // 時:分:秒それぞれの値を秒に変更し加算する為にCarbon形式に変換
            $worktime = new Carbon($worktime);
            // 時を秒へ変換
            $workhour = $worktime->format('H') * 3600;
            // 分を秒へ変換
            $workminutes = $worktime->format('i') * 60;
            // 秒はそのまま
            $worksecond = $worktime->format('s');
            // 時：分：秒を加算し勤務時間の秒数を求める
            $workingtime = $workhour + $workminutes + $worksecond;
            // 勤務開始時間と勤務終了時間のdiffを秒で求める
            $diffInSeconds = $starttime->diffInSeconds($endtime);
            // 休憩時間の秒数を求める
            $breaksecond = $diffInSeconds - $workingtime;
            // 時：分：秒で表示する為にCarbon形式へ変換
            $breaksecond = new Carbon($breaksecond);
            $attendanceArray[$id]['break_time'] = $breaksecond->format('H:i:s');
        }

        $attendancecollection = collect($attendanceArray);
        $perPage = 5;
        $page = Paginator::resolveCurrentPage('page');
        //$pageData = $attendancecollection->slice(($page - 1) * $perPage);
        $options = [
            'path' => Paginator::resolveCurrentPath(),
            'pageName' => 'page'
        ];
        // view内ループ処理終了カウント
        $count = $page * 5;
        // view内ループ処理開始カウント
        $idcount = $count - 5;

        $paginatedData = new LengthAwarePaginator($attendancecollection->forPage($request->page, 5), count($attendancecollection), 5, $request->page, array('path' => $request->url()));


        // $attendanceArrayの要素数をviewファイルでも使用したいのでついでにcountも送っている
        return view('attendance', compact(
            'paginatedData',
            'count',
            'date',
            'idcount'
        ));
    }

    public function dateAfter(Request $request)
    {
        $date = $request->only('date');
        $date = new Carbon($date['date']);
        $date = $date->addDay()->format('Y-m-d');

        // Attendancesテーブルと主テーブルのUsersのnameを取得
        $attendances = Attendance::with('user:id,name')->DateSearch($date)->get();
        // toArrayで配列に変換
        $attendanceArray = $attendances->toArray();
        // 配列の要素数取得
        $count = count($attendanceArray);
        // 勤務開始時刻と勤務終了時刻のdiffを勤務時間で減算し休憩時間の合計を求める
        for ($id = 0; $id < $count; $id++) {
            $starttime = $attendanceArray[$id]['start_time'];
            // diffInSecondsを行うためにCarbonの形式へ変換(勤務開始時刻)
            $starttime = new Carbon($starttime);
            $endtime = $attendanceArray[$id]['end_time'];
            // diffInSecondsを行うためにCarbonの形式へ変換(勤務終了時刻)
            $endtime = new Carbon($endtime);
            $worktime = $attendanceArray[$id]['work_time'];
            // 時:分:秒それぞれの値を秒に変更し加算する為にCarbon形式に変換
            $worktime = new Carbon($worktime);
            // 時を秒へ変換
            $workhour = $worktime->format('H') * 3600;
            // 分を秒へ変換
            $workminutes = $worktime->format('i') * 60;
            // 秒はそのまま
            $worksecond = $worktime->format('s');
            // 時：分：秒を加算し勤務時間の秒数を求める
            $workingtime = $workhour + $workminutes + $worksecond;
            // 勤務開始時間と勤務終了時間のdiffを秒で求める
            $diffInSeconds = $starttime->diffInSeconds($endtime);
            // 休憩時間の秒数を求める
            $breaksecond = $diffInSeconds - $workingtime;
            // 時：分：秒で表示する為にCarbon形式へ変換
            $breaksecond = new Carbon($breaksecond);
            $attendanceArray[$id]['break_time'] = $breaksecond->format('H:i:s');
        }

        $attendancecollection = collect($attendanceArray);
        $perPage = 5;
        $page = Paginator::resolveCurrentPage('page');
        //$pageData = $attendancecollection->slice(($page - 1) * $perPage);
        $options = [
            'path' => Paginator::resolveCurrentPath(),
            'pageName' => 'page'
        ];
        // view内ループ処理終了カウント
        $count = $page * 5;
        // view内ループ処理開始カウント
        $idcount = $count - 5;

        $paginatedData = new LengthAwarePaginator($attendancecollection->forPage($request->page, 5), count($attendancecollection), 5, $request->page, array('path' => $request->url()));


        // $attendanceArrayの要素数をviewファイルでも使用したいのでついでにcountも送っている
        return view('attendance', compact(
            'paginatedData',
            'count',
            'date',
            'idcount'
        ));
    }
}
