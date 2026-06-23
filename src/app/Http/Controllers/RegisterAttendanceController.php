<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\BreakTime;
use App\Models\Attendance;

class RegisterAttendanceController extends Controller
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

        return redirect()->route('attendance.create');
    }

    public function punchOut()
    {
        $punchOutAt = Carbon::now()->startOfMinute();
        Auth::user()->latestAttendance->update(['punch_out_at' => $punchOutAt]);

        return redirect()->route('attendance.create');
    }

    public function startBreakTime()
    {
        $newBreakTime = [
            'attendance_id' => Auth::user()->latestAttendance['id'],
            'start_break_at' => Carbon::now()->startOfMinute(),
        ];
        BreakTime::create($newBreakTime);

        return redirect()->route('attendance.create');
    }

    public function endBreakTime()
    {
        $endBreakAt = Carbon::now()->startOfMinute();
        Auth::user()->latestAttendance->latestBreakTime->update(['end_break_at' => $endBreakAt]);

        return redirect()->route('attendance.create');
    }
}
