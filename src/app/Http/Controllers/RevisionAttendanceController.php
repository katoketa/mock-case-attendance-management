<?php

namespace App\Http\Controllers;

use App\Models\RevisionAttendance;
use App\Models\RevisionBreakTime;
use Illuminate\Http\Request;

class RevisionAttendanceController extends Controller
{
    public function create(Request $request)
    {
        $newRevisionAttendance = $request->only('attendance_id', 'punch_in_at', 'punch_out_at', 'remarks');
        $revisionAttendance = RevisionAttendance::create($newRevisionAttendance);
        $newRevisionBreakTimes = $request->break_times;
        if ($request->new_break_time) {
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
}
