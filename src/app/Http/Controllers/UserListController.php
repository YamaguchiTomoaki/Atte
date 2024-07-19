<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;



class UserListController extends Controller
{
    public function userList()
    {
        $users = User::Paginate(5);

        return view('userlist', compact('users'));
    }

    public function userPage(Request $request)
    {
        // 勤怠一覧ボタン処理よりuser_idを取得
        $user = $request->only('user_id');
        // user_idから対象のユーザー名を取得
        $name = User::UseridSearch($user)->get();
        // ユーザー名のみ格納
        $name = $name[0]['name'];

        // 勤怠情報取得(勤務日で整列)
        $attendances = Attendance::UserSearch($user)->orderBy('date', 'asc')->get();
        // toArrayで配列に変換
        $attendanceArray = $attendances->toArray();
        // 配列の要素数取得
        $count = count($attendanceArray);
        for ($id = 0; $id < $count; $id++) {
            $starttime = $attendanceArray[$id]['date'] . ' ' . $attendanceArray[$id]['start_time'];
            // diffInSecondsを行うためにCarbonの形式へ変換(勤務開始時刻)
            $starttime = new Carbon($starttime);
            $endtime = $attendanceArray[$id]['date'] . ' ' . $attendanceArray[$id]['end_time'];
            // diffInSecondsを行うためにCarbonの形式へ変換(勤務終了時刻)
            $endtime = new Carbon($endtime);
            $worktime = $attendanceArray[$id]['date'] . ' ' . $attendanceArray[$id]['work_time'];
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
        return view('userpage', compact('paginatedData', 'count', 'name', 'idcount'));
    }
}
