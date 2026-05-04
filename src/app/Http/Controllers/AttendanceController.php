<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function create()
    {
        $user = Auth::user();
        $latestAttendance = $user->latestAttendance;
        return view('users.attendance', compact('latestAttendance'));
    }
}
