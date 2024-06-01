<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Breaks;
use Illuminate\Http\Request;
use Carbon\Carbon;
use GuzzleHttp\Promise\Create;

class BreakController extends Controller
{
    public function breakStart(Request $request)
    {
        $user = $request->only('user_id');
        $date = Carbon::now()->format('Y-m-d');
        $attendance = Attendance::where([
            ['user_id', '=', $user],
            ['date', '=', $date],
        ])->whereNotNull('start_time')->whereNull('end_time')->first();
        $break = [
            'attendance_id' => $attendance['id'],
            'break_start' => Carbon::now()->format('H:i:s'),
        ];
        Breaks::create($break);

        return redirect('/');
    }

    public function breakEnd(Request $request)
    {
        $user = $request->only('user_id');
        $date = Carbon::now()->format('Y-m-d');
        $attendance = Attendance::where([
            ['user_id', '=', $user],
            ['date', '=', $date],
        ])->whereNotNull('start_time')->whereNull('end_time')->first();

        $break = [
            'break_end' => Carbon::now()->format('H:i:s'),
        ];
        Breaks::where([
            ['attendance_id', '=', $attendance['id']],
        ])->whereNotNull('break_start')->whereNull('break_end')->update($break);

        return redirect('/');
    }
}
