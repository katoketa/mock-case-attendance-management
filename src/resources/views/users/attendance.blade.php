@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/attendance.css') }}">
@endsection

@section('content')
@php
use App\Models\Attendance;
@endphp
<article class="attendance-page">
    <section>
        @if (empty($latestAttendance) || $latestAttendance->getAttendanceState() === Attendance::ATTENDANCE_STATE_BEFORE_WORK)
        <div class="attendance-state">勤務外</div>
        @elseif ($latestAttendance->getAttendanceState() === Attendance::ATTENDANCE_STATE_BREAK_TIME)
        <div class="attendance-state">休憩中</div>
        @elseif ($latestAttendance->getAttendanceState() === Attendance::ATTENDANCE_STATE_FINISH_WORK)
        <div class="attendance-state">退勤済</div>
        @elseif ($latestAttendance->getAttendanceState() === Attendance::ATTENDANCE_STATE_WORKING)
        <div class="attendance-state">出勤中</div>
        @endif
        <div class="attendance__date">{{ now()->isoFormat('Y年M月D日(dd)') }}</div>
        <div class="attendance__time">{{ now()->format('H:i') }}</div>
    </section>
    <section>
        @if (empty($latestAttendance) || $latestAttendance->getAttendanceState() === Attendance::ATTENDANCE_STATE_BEFORE_WORK)
        @elseif ($latestAttendance->getAttendanceState() === Attendance::ATTENDANCE_STATE_BREAK_TIME)
        @elseif ($latestAttendance->getAttendanceState() === Attendance::ATTENDANCE_STATE_FINISH_WORK)
        @elseif ($latestAttendance->getAttendanceState() === Attendance::ATTENDANCE_STATE_WORKING)
        @endif
    </section>
</article>
@endsection