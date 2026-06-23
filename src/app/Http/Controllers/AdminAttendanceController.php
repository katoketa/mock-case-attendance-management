<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\CarbonImmutable;
use App\Models\Attendance;

class AdminAttendanceController extends Controller
{
    public function index(Request $request)
    {
        if (!empty($request->date)) {
            $selectDate = new CarbonImmutable($request->date);
        } else {
            $selectDate = CarbonImmutable::now();
        }
        $attendances = Attendance::with('breakTimes', 'user')->where('punch_in_at', 'like', $selectDate->format('Y-m-d') . '%')->orderBy('punch_in_at', 'asc')->get();
        return view('admins.attendance_list', compact('selectDate', 'attendances'));
    }

    public function show(Attendance $attendance)
    {
        if (empty($attendance)) {
            return redirect()->route('admin.attendance.index');
        }

        $attendance->load('user', 'latestRevisionAttendance', 'breakTimes');
        $user = $attendance['user'];
        $canEdit = $attendance->latestRevisionAttendance['is_approval'] ?? true;
        if ($canEdit) {
            $showData = $attendance;
            $breakTimes = $attendance['breakTimes'];
        } else {
            $showData = $attendance['latestRevisionAttendance'];
            $breakTimes = $showData['revisionBreakTimes'];
        }
        return view('/admins/attendance_detail', compact('user', 'showData', 'breakTimes', 'canEdit'));
    }
}
