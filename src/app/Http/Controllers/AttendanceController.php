<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function create()
    {
        $testDate = \Carbon\Carbon::now()->toString();
        return view('users.attendance', compact('testDate'));
    }
}
