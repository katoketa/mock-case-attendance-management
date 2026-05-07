@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/attendance.css') }}">
@endsection

@section('content')
@php
use App\Models\Attendance;
@endphp
<article class="attendance-page">
    <section class="attendance-page__content">
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
    <section class="attendance-page__forms">
        @if (empty($latestAttendance) || $latestAttendance->getAttendanceState() === Attendance::ATTENDANCE_STATE_BEFORE_WORK)
        <form action="/attendance/punch_in" method="post" class="attendance-form">
            @csrf

        </form>
        <div class="attendance__button">出勤</div>
        @elseif ($latestAttendance->getAttendanceState() === Attendance::ATTENDANCE_STATE_BREAK_TIME)
        <div class="break-time__button">休憩戻</div>
        @elseif ($latestAttendance->getAttendanceState() === Attendance::ATTENDANCE_STATE_FINISH_WORK)
        <div class="finish-work-message">お疲れ様でした。</div>
        @elseif ($latestAttendance->getAttendanceState() === Attendance::ATTENDANCE_STATE_WORKING)
        <div class="attendance__button">退勤</div>
        <div class="break-time__button">休憩入</div>
        @endif
    </section>
</article>
@endsection