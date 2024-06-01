<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Breaks;
use Illuminate\Http\Request;

// Auth::user()使用の為、use
use Illuminate\Support\Facades\Auth;

use Carbon\Carbon;
use DateTime;

class AttendanceController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        //$workstart = Attendance::
        // 下記はテスト用
        $status['id'] = 'null';
        //return view('index', compact('user', 'attendance'));
        return view('index', compact('user', 'status'));
    }

    public function workStart(Request $request)
    {
        $user = $request->only('user_id');
        $attendance = [
            'user_id' => $user['user_id'],
            'date' => Carbon::now()->format('Y-m-d'),
            'start_time' => Carbon::now()->format('H:i:s'),
        ];
        Attendance::create($attendance);
        return redirect('/');
    }

    public function workEnd(Request $request)
    {
        $user = $request->only('user_id');
        $date = Carbon::now()->format('Y-m-d');
        $attendance = Attendance::where([
            ['user_id', '=', $user],
            ['date', '=', $date],
        ])->whereNull('end_time')->first();
        $attendanceId = $attendance['id'];
        $end = Carbon::now()->format('H:i:s');
        $start = new Carbon($attendance['start_time']);
        // 時刻差を秒表記で取得
        $diffInSeconds = $start->diffInSeconds($end);
        // 休憩時間取得
        $break = Breaks::where([
            ['attendance_id', '=', $attendanceId],
        ])->whereNotNull('break_end')->get();
        // 休憩時間合計用変数宣言
        $breakdiffInSecondsAll = 0;
        // 休憩回数が複数の場合、合計の休憩時間を求める
        foreach ($break as $breaks) {
            // 休憩開始時間格納
            $breakstart = new Carbon($breaks['break_start']);
            // 休憩終了時間格納
            $breakend = new Carbon($breaks['break_end']);
            // 個別の休憩時間を秒表記で求める
            $breakdiffInSeconds = $breakstart->diffInSeconds($breakend);
            // 合計の休憩時間を格納する
            $breakdiffInSecondsAll += $breakdiffInSeconds;
        }
        // 勤務時間を求めるために合計の休憩時間を減算する
        $diffInSeconds -= $breakdiffInSecondsAll;
        // 時の計算
        $hors = floor($diffInSeconds / 3600);
        // 分の計算
        $minutes = floor(($diffInSeconds % 3600) / 60);
        // 秒の計算
        $seconds = $diffInSeconds % 60;
        // new CarbonするためにY-m-d H:i:s表記にする
        $worktime = $date . ' ' . $hors . ':' . $minutes . ':' . $seconds;
        // 連結した文字列をCarbon表記へ
        $worktime = new Carbon($worktime);
        // 休憩処理完成後に休憩した時間を減算する

        // 時:分:秒のみに変更
        $worktime = $worktime->format('H:i:s');
        // アップデート項目を格納
        $attendance = [
            'end_time' => $end,
            'work_time' => $worktime,
        ];
        //unset($form['_token']);
        Attendance::where([
            ['user_id', '=', $user],
            ['date', '=', $date],
        ])->whereNull('end_time')->update($attendance);
        return redirect('/');
    }
}
