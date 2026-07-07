<?php

namespace App\Http\Controllers;

use App\Models\RevisionAttendance;
use App\Models\RevisionBreakTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RevisionAttendanceController extends Controller
{
    public function store(Request $request)
    {
        $newRevisionAttendance = $request->only('attendance_id', 'punch_in_at', 'punch_out_at', 'remarks');
        $newRevisionAttendance['punch_in_at'] = $request->date . $newRevisionAttendance['punch_in_at'];
        $newRevisionAttendance['punch_out_at'] = $request->date . $newRevisionAttendance['punch_out_at'];
        $revisionAttendance = RevisionAttendance::create($newRevisionAttendance);
        $newRevisionBreakTimes = $request->break_times;
        if ($request->new_break_time['start_break_at'] && $request->new_break_time['end_break_at']) {
            $newRevisionBreakTimes[] = $request->new_break_time;
        }
        if ($newRevisionBreakTimes) {
            foreach ($newRevisionBreakTimes as $newRevisionBreakTime) {
                $newRevisionBreakTime['revision_attendance_id'] = $revisionAttendance['id'];
                $newRevisionBreakTime['start_break_at'] = $request->date . $newRevisionBreakTime['start_break_at'];
                $newRevisionBreakTime['end_break_at'] = $request->date . $newRevisionBreakTime['end_break_at'];
                RevisionBreakTime::create($newRevisionBreakTime);
            }
        }
        return redirect()->route('attendance.show', ['attendance' => $request->attendance_id]);
    }

    public function index(Request $request)
    {
        if (Auth::guard('web')->check()) {
            $user = Auth::user();
            if ($request->select === "approved") {
                $revisionAttendances = $user->revisionAttendances()->where('is_approval', true)->get();
            } else {
                $revisionAttendances = $user->revisionAttendances()->where('is_approval', false)->get();
            }
        } elseif (Auth::guard('admin')->check()) {
            if ($request->select === "approved") {
                $revisionAttendances = RevisionAttendance::where('is_approval', true)->get();
            } else {
                $revisionAttendances = RevisionAttendance::where('is_approval', false)->get();
            }
        }
                    $select = $request->select;
        return view('revision_attendance_list', compact('revisionAttendances', 'select'));
    }

    public function show(RevisionAttendance $revisionAttendance)
    {
        $attendance = $revisionAttendance->attendance;
        return redirect()->route('attendance.show', ['attendance' => $attendance['id']]);
    }

    public function edit(RevisionAttendance $revisionAttendance)
    {
        $showData = $revisionAttendance;
        $user = $revisionAttendance['attendance']['user'];
        $breakTimes = $revisionAttendance['revisionBreakTimes'];
        return view('/admins/revision_attendance_approve', compact('user', 'showData', 'breakTimes'));
    }
}
