<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\RevisionAttendanceController;
use App\Http\Controllers\AdminAuthController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth:web')->group(function () {
    Route::get('/attendance', [AttendanceController::class, 'create'])->name('attendance.create');
    Route::post('/attendance/punch_in', [AttendanceController::class, 'punchIn'])->name('attendance.punch_in');
    Route::post('/attendance/punch_out', [AttendanceController::class, 'punchOut'])->name('attendance.punch_out');
    Route::post('/attendance/start_break_time', [AttendanceController::class, 'startBreakTime'])->name('attendance.start_break_time');
    Route::post('/attendance/end_break_time', [AttendanceController::class, 'endBreakTime'])->name('attendance.end_break_time');
    Route::get('/attendance/list', [AttendanceController::class, 'index'])->name('attendance.index');
    Route::get('/attendance/detail/{attendance}', [AttendanceController::class, 'show'])->name('attendance.show');
    Route::post('attendance/revision_request', [RevisionAttendanceController::class, 'store'])->name('revision_attendance.store');
    Route::get('/stamp_correction_request/list', [RevisionAttendanceController::class, 'index'])->name('revision_attendance.index');
    Route::get('/stamp_correction_request/approve/{revisionAttendance}', [RevisionAttendanceController::class, 'show'])->name('revision_attendance.show');
});

Route::name('admin.')->group(function () {
    Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('login');
    Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('execute');

    Route::middleware('auth:admin')->group(function () {
        Route::get('/admin/index', [AdminAuthController::class, 'index'])->name('index');
        Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('logout');
        Route::get('/admin/attendance/list', [AttendanceController::class, 'adminIndex'])->name('attendance.index');
    });
});