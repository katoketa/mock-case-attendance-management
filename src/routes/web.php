<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttendanceController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/attendance', [AttendanceController::class, 'create']);
    Route::post('/attendance/punch_in', [AttendanceController::class, 'punchIn']);
    Route::post('/attendance/punch_out', [AttendanceController::class, 'punchOut']);
    Route::post('/attendance/start_break_time', [AttendanceController::class, 'startBreakTime']);
    Route::post('attendance/end_break_time', [AttendanceController::class, 'endBreakTime']);
    Route::get('/attendance/list', [AttendanceController::class, 'index']);
    Route::get('/attendance/detail/{attendance}', [AttendanceController::class, 'detail']);
});