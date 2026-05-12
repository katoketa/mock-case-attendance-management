<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Attendance;

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
            'punch_in_at' => Carbon::now(),
        ];
        Attendance::create($newAttendance);

        return redirect('/attendance');
    }

    public function punchOut()
    {
        $punchOutAt = Carbon::now();
        Auth::user()->latestAttendance->update(['punch_out_at' => $punchOutAt]);

        return redirect('/attendance');
    }
}
