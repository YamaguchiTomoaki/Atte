<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Breaks;

use Illuminate\Http\Request;

// Auth::user()使用の為、use
use Illuminate\Support\Facades\Auth;

use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $date = Carbon::now()->format('Y-m-d');
        // 勤務開始ボタンステータスチェック用
        $work = Attendance::where([
            ['user_id', '=', $user['id']],
            ['date', '=', $date],
        ])->first();
        // 該当のレコードが無い場合エラーになる為、nullを代入
        if ($work == null) {
            $work['id'] = 'null';
            $work['start_time'] = 'null';
        }
        $break = Breaks::where([
            ['attendance_id', '=', $work['id']],
        ])->whereNull('break_end')->first();

        // Breaksテーブルに該当のレコードが無い場合
        if ($break == null) {
            $break['break_end'] = 'null';
        }

        // 勤務開始が無いとき or 勤務終了があるとき or 休憩終了が無いとき
        if ($work['start_time'] == 'null' || $work['end_time'] != null || $break['break_end'] == null) {
            // 休憩開始ボタン不可
            $breakstartstatus = 1;
        } else {
            // 休憩開始ボタン可
            $breakstartstatus = 0;
        }

        if ($breakstartstatus == 0 || $work['start_time'] == 'null' || $work['end_time'] != null) {
            // 休憩終了ボタン不可
            $breakendstatus  = 1;
        } else {
            // 休憩開始ボタン可
            $breakendstatus = 0;
        }

        if ($work['start_time'] == 'null' || $breakendstatus == 0 || $work['end_time'] != null) {
            $workendstatus = 1;
        } else {
            $workendstatus = 0;
        }

        return view('index', compact('user', 'work', 'breakstartstatus', 'breakendstatus', 'workendstatus'));
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
