@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/attendance.css') }}">
@endsection

@section('content')
<article class="attendance-page">
    @if (new \Carbon\Carbon($latestAttendance['punch_in_at'])->toDateString() === now()->format('Y-m-d'))
    @endif
</article>
@endsection