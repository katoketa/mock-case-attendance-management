<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\RevisionAttendanceController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/attendance', [AttendanceController::class, 'add'])->name('attendance.add');
    Route::post('/attendance/punch_in', [AttendanceController::class, 'punchIn'])->name('attendance.punch_in');
    Route::post('/attendance/punch_out', [AttendanceController::class, 'punchOut'])->name('attendance.punch_out');
    Route::post('/attendance/start_break_time', [AttendanceController::class, 'startBreakTime'])->name('attendance.start_break_time');
    Route::post('attendance/end_break_time', [AttendanceController::class, 'endBreakTime'])->name('attendance.end_break_time');
    Route::get('/attendance/list', [AttendanceController::class, 'index'])->name('user.attendance.index');
    Route::get('/attendance/detail/{attendance}', [AttendanceController::class, 'show'])->name('user.attendance.show');
    Route::post('/revision_request', [RevisionAttendanceController::class, 'create'])->name('user.revision_attendance.create');
    Route::get('/stamp_correction_request/list', [RevisionAttendanceController::class, 'index'])->name('revision_attendance.index');
    Route::get('/stamp_correction_request/approve/{revisionAttendance}', [RevisionAttendanceController::class, 'show'])->name('revision_attendance.show');
});