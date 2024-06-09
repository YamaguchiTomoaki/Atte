<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\BreakController;
use App\Http\Controllers\DateviewController;
use App\Models\Attendance;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware('auth')->group(function () {
    Route::get('/', [AttendanceController::class, 'index']);
    Route::post('/workstart', [AttendanceController::class, 'workStart']);
    Route::post('/workend', [AttendanceController::class, 'workEnd']);
    Route::post('/breakstart', [BreakController::class, 'breakStart']);
    Route::post('/breakend', [BreakController::class, 'breakEnd']);
    Route::get('/attendance', [DateviewController::class, 'DateView']);
    Route::get('/datebefore', [DateviewController::class, 'DateBefore']);
    Route::get('/dateafter', [DateviewController::class, 'DateAfter']);
});
