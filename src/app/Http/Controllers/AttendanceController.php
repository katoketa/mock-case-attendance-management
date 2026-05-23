<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use App\Models\Attendance;
use App\Models\BreakTime;

class AttendanceController extends Controller
{
    public function create()
    {
        $user = Auth::user();
        $latestAttendance = $user->latestAttendance;
        return view('users.attendance', compact('latestAttendance'));
    }

    public function punchIn()
    {
        $newAttendance = [
            'user_id' => Auth::id(),
            'punch_in_at' => Carbon::now()->startOfMinute(),
        ];
        Attendance::create($newAttendance);

        return redirect('/attendance');
    }

    public function punchOut()
    {
        $punchOutAt = Carbon::now()->startOfMinute();
        Auth::user()->latestAttendance->update(['punch_out_at' => $punchOutAt]);

        return redirect('/attendance');
    }

    public function startBreakTime()
    {
        $newBreakTime = [
            'attendance_id' => Auth::user()->latestAttendance['id'],
            'start_break_at' => Carbon::now()->startOfMinute(),
        ];
        BreakTime::create($newBreakTime);

        return redirect('/attendance');
    }

    public function endBreakTime()
    {
        $endBreakAt = Carbon::now()->startOfMinute();
        Auth::user()->latestAttendance->latestBreakTime->update(['end_break_at' => $endBreakAt]);

        return redirect('/attendance');
    }

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
}
