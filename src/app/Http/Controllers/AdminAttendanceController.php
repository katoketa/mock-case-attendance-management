<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\CarbonImmutable;
use App\Models\Attendance;
use App\Models\BreakTime;
use App\Models\User;

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

    public function update(Request $request)
    {
        $newAttendance = $request->only('punch_in_at', 'punch_out_at', 'remarks');
        $newAttendance['punch_in_at'] = $request->date . $newAttendance['punch_in_at'];
        $newAttendance['punch_out_at'] = $request->date . $newAttendance['punch_out_at'];
        $attendance = Attendance::find($request->attendance_id);
        $attendance->update($newAttendance);
        $breakTimes = $attendance->breakTimes;
        foreach ($breakTimes as $key => $breakTime) {
            $newBreakTime = $request->break_times[$key];
            $newBreakTime['start_break_at'] = $request->date . $newBreakTime['start_break_at'];
            $newBreakTime['end_break_at'] = $request->date . $newBreakTime['end_break_at'];
            $breakTime->update($newBreakTime);
        }
        if ($request->new_break_time['start_break_at'] && $request->new_break_time['end_break_at']) {
            $newBreakTime = $request->new_break_time;
            $newBreakTime['start_break_at'] = $request->date . $newBreakTime['start_break_at'];
            $newBreakTime['end_break_at'] = $request->date . $newBreakTime['end_break_at'];
            $newBreakTime['attendance_id'] = $request->attendance_id;
            BreakTime::create($newBreakTime);
        }

        return redirect()->route('admin.attendance.show', ['attendance' => $request->attendance_id]);
    }

    public function staffIndex()
    {
        $users = User::all();
        return view('admins.staff_list', compact('users'));
    }

    public function staffShow(User $user, Request $request)
    {
        if (!empty($request->date)) {
            $selectDate = new CarbonImmutable($request->date);
        } else {
            $selectDate = CarbonImmutable::now()->startOfMonth();
        }
        $attendances = $user->attendances()->where('punch_in_at', 'like', $selectDate->format('Y-m') . '%')->orderBy('punch_in_at', 'asc')->get();
        $attendances->load('breakTimes');
        $userName = $user['name'];
        $alert = $request->alert;
        return view('/admins/staff_attendance', compact('selectDate', 'attendances', 'userName', 'alert'));
    }
}
