@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/attendance_date_changer.css') }}">
@endsection

@section('content')
<article class="default-page">
    <h1 class="default-title">{{ $selectDate->format('Y年m月d日') }}の勤怠</h1>
    @include('components.attendance_date_changer', ['selectInterval' => 'day'])
    <table class="default-table">
        <tr class="default-table__tr">
            <th class="default-table__th">名前</th>
            <th class="default-table__th">出勤</th>
            <th class="default-table__th">退勤</th>
            <th class="default-table__th">休憩</th>
            <th class="default-table__th">合計</th>
            <th class="default-table__th">詳細</th>
        </tr>
        @foreach ($attendances as $attendance)
        <tr class="default-table__tr">
            <td class="default-table__td">{{ $attendance['user']['name'] }}</td>
            <td class="default-table__td">{{ $attendance['punch_in_at']->format('H:i') }}</td>
            <td class="default-table__td">{{ !empty($attendance['punch_out_at']) ? $attendance['punch_out_at']->format('H:i') : '' }}</td>
            <td class="default-table__td">{{ sprintf('%d:%02d', (int)$attendance->totalBreakTimeMinute() / 60, $attendance->totalBreakTimeMinute() % 60) }}</td>
            <td class="default-table__td">{{ sprintf('%d:%02d', (int)$attendance->totalWorkTimeMinute() / 60, $attendance->totalWorkTimeMinute() % 60) }}</td>
            <td class="default-table__td">
                <a href="{{ route('admin.attendance.show', ['attendance' => $attendance['id']]) }}" class="default-table__a">詳細</a>
            </td>
        </tr>
        @endforeach
    </table>
</article>
@endsection