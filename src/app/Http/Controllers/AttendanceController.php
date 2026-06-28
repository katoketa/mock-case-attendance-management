<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\CarbonImmutable;
use App\Models\Attendance;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        if (!empty($request->date)) {
            $selectDate = new CarbonImmutable($request->date);
        } else {
            $selectDate = CarbonImmutable::now()->startOfMonth();
        }
        $attendances = Auth::user()->attendances()->where('punch_in_at', 'like', $selectDate->format('Y-m') . '%')->orderBy('punch_in_at', 'asc')->get();
        $attendances->load('breakTimes');
        return view('users.attendance_list', compact('selectDate', 'attendances'));
    }

    public function show(Attendance $attendance)
    {
        if (empty($attendance)) {
            redirect()->route('attendance.index');
        }

        // 出勤飲み押した状態でloadするとbreakTimesが存在しないのでエラーが発生する
        // $attendance->load('latestAttendance', 'breakTimes');
        $user = Auth::user();
        $canEdit = $attendance->latestRevisionAttendance['is_approval'] ?? true;
        if ($canEdit) {
            $showData = $attendance;
            $breakTimes = $attendance['breakTimes'];
        } else {
            $showData = $attendance['latestRevisionAttendance'];
            $breakTimes = $showData['revisionBreakTimes'];
        }
        return view('users.attendance_detail', compact('user', 'showData', 'breakTimes', 'canEdit'));
    }
}
