<?php

namespace App\Http\Controllers;

use App\Models\RevisionAttendance;
use App\Models\RevisionBreakTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RevisionAttendanceController extends Controller
{
    public function create(Request $request)
    {
        $newRevisionAttendance = $request->only('attendance_id', 'punch_in_at', 'punch_out_at', 'remarks');
        $revisionAttendance = RevisionAttendance::create($newRevisionAttendance);
        $newRevisionBreakTimes = $request->break_times;
        if ($request->new_break_time['start_break_at'] && $request->new_break_time['end_break_at']) {
            $newRevisionBreakTimes[] = $request->new_break_time;
        }
        if ($newRevisionBreakTimes) {
            foreach ($newRevisionBreakTimes as $newRevisionBreakTime) {
                $newRevisionBreakTime['revision_attendance_id'] = $revisionAttendance['id'];
                RevisionBreakTime::create($newRevisionBreakTime);
            }
        }
        return redirect('/attendance/detail/' . $request->attendance_id);
    }

    public function index(Request $request)
    {
        $user = Auth::user();
        if ($request->select === "approved") {
            $revisionAttendances = $user->revisionAttendances()->where('is_approval', true)->get();
        } else {
            $revisionAttendances = $user->revisionAttendances()->where('is_approval', false)->get();
        }
        $select = $request->select;
        return view('revision_attendance_list', compact('revisionAttendances', 'select'));
    }
}
