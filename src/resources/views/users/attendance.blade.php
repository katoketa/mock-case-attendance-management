@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/attendance.css') }}">
@endsection

@section('content')
<article class="attendance-page">
    @if (!empty($latestAttendance) && new \Carbon\Carbon($latestAttendance['punch_in_at'])->toDateString() === now()->format('Y-m-d'))
    @if (empty($latestAttendance['punch_out_at']) && empty($latestAttendance['latestBreakTime']['end_break_at']))
    <!-- 休憩中 -->
    休憩中
    @elseif (empty($latestAttendance['punch_out_at']) && !empty($latestAttendance['latestBreakTime']['end_break_at']))
    <!-- 出勤中 -->
    出勤中
    @elseif (!empty($latestAttendance['punch_out_at']))
    <!-- 退勤済 -->
    退勤済
    @endif
    @else
    <!-- 勤務外 -->
    <div class="attendance-state">勤務外</div>
    <div class="attendance__date">{{ now()->format('Y年m月d日(D)') }}</div>
    @endif
</article>
@endsection