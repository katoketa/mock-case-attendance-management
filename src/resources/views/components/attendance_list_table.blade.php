{{-- 必要なデータ $selectDate(CarbonImmutable型), $attendances(selectDateと同じ月の勤怠データ)--}}
@if (!empty($alert))
<div class="default-table__alert">{{ $alert }}</div>
@endif
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
        @else
        <td class="default-table__td"></td>
        @endif
        @if (!empty($attendance->totalBreakTimeMinute()))
        <td class="default-table__td">{{ sprintf('%d:%02d', (int)$attendance->totalBreakTimeMinute() / 60, $attendance->totalBreakTimeMinute() % 60) }}</td>
        @else
        <td class="default-table__td"></td>
        @endif
        @if (!empty($attendance->totalWorkTimeMinute()))
        <td class="default-table__td">{{ sprintf('%d:%02d', (int)$attendance->totalWorkTimeMinute() / 60, $attendance->totalWorkTimeMinute() % 60) }}</td>
        @else
        <td class="default-table__td"></td>
        @endif
        <td class="default-table__td">
            @if (Auth::guard('web')->check())
            <a href="{{ route('attendance.show', ['attendance' => $attendance['id']]) }}" class="default-table__a">詳細</a>
            @elseif (Auth::guard('admin')->check())
            <a href="{{ route('admin.attendance.show', ['attendance' => $attendance['id']]) }}" class="default-table__a">詳細</a>
            @endif
        </td>
        @php $attendance_j++; @endphp
        @else
        <td class="default-table__td"></td>
        <td class="default-table__td"></td>
        <td class="default-table__td"></td>
        <td class="default-table__td"></td>
        <td class="default-table__td">
            <a href="{{ url()->current() . '?date=' . $selectDate->format('Y-m') . '&alert=' . $selectDate->addDays($day_i)->format('n月j日') . 'の勤怠データが存在しません。' }}" class="default-table__a">詳細</a>
        </td>
        @endif
    </tr>
    @endfor
</table>