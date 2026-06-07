@extends('layouts.app')

@section('content')
<article class="default-page">
    <h1 class="default-title">勤怠一覧</h1>
    <ul class="default-change-date__ul">
        <li class="default-change-date__li">
            <a href="/attendance/list?date={{ $selectDate->subMonth()->format('Y-m') }}" class="default-change-date">
                <img src="{{ asset('image/arrow_back_24dp_B2B2B2_FILL0_wght400_GRAD0_opsz24.svg') }}" alt="←" class="default-change-date__arrow-img">前月
            </a>
        </li>
        <li class="default-change-date__li">
            <img src="{{ asset('image/calendar_month_24dp_4B4B4B.svg') }}" alt="🗓️" class="default-change-date__calendar-img">
            <h2 class="default-change-date__select-date">{{ $selectDate->format('Y/m') }}</h2>
        </li>
        <li class="default-change-date__li">
            <a href=" /attendance/list?date={{ $selectDate->addMonth()->format('Y-m') }}" class="default-change-date">
                翌月<img src="{{ asset('image/arrow_forward_24dp_B2B2B2_FILL0_wght400_GRAD0_opsz24.svg') }}" alt="→" class="default-change-date__arrow-img">
            </a>
        </li>
    </ul>
    <table class="default-table">
        <tr class="default-table__tr">
            <th class="default-table__th align-left">日付</th>
            <th class="default-table__th">出勤</th>
            <th class="default-table__th">退勤</th>
            <th class="default-table__th">休憩</th>
            <th class="default-table__th">合計</th>
            <th class="default-table__th">詳細</th>
        </tr>
        @php $attendance_j = 0; @endphp
        @for ($day_i = 0; $selectDate->addDays($day_i)->format('Y-m') === $selectDate->format('Y-m'); $day_i++)
        @php
        if (!empty($attendances[$attendance_j])) {
            $attendance = $attendances[$attendance_j];
        }
        @endphp
        <tr class="default-table__tr">
            <td class="default-table__td align-left">{{ $selectDate->addDays($day_i)->isoFormat('MM/DD(dd)') }}</td>
            @if (!empty($attendance) && $selectDate->addDays($day_i)->format('Y-m-d') === $attendance['punch_in_at']->format('Y-m-d'))
            <td class=" default-table__td">{{ $attendance['punch_in_at']->format('H:i') }}</td>
            @if (!empty($attendance['punch_out_at']))
            <td class="default-table__td">{{ $attendance['punch_out_at']->format('H:i') }}</td>
            @endif
            @if (!empty($attendance->totalBreakTimeMinute()))
            <td class="default-table__td">{{ sprintf('%d:%02d', (int)$attendance->totalBreakTimeMinute() / 60, $attendance->totalBreakTimeMinute() % 60) }}</td>
            @endif
            @if (!empty($attendance->totalWorkTimeMinute()))
            <td class="default-table__td">{{ sprintf('%d:%02d', (int)$attendance->totalWorkTimeMinute() / 60, $attendance->totalWorkTimeMinute() % 60) }}</td>
            @endif
            <td class="default-table__td">
                <a href="/attendance/detail/{{ $attendance['id'] }}" class="default-table__a">詳細</a>
            </td>
            @php $attendance_j++; @endphp
            @else
            <td class="default-table__td"></td>
            <td class="default-table__td"></td>
            <td class="default-table__td"></td>
            <td class="default-table__td"></td>
            <td class="default-table__td">
                <a href="/attendance/list?date={{ $selectDate->addDays($day_i)->format('Y-m') }}" class="default-table__a">詳細</a>
            </td>
            @endif
        </tr>
        @endfor
    </table>
</article>
@endsection