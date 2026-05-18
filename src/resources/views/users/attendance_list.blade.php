@extends('layouts.app')

@section('content')
@php
use Carbon\Carbon;

$selectMonth = new Carbon($selectDate)->format('m');
$i = 0;
@endphp
<article class="default-page">
    <h1 class="default-title">勤怠一覧</h1>
    <ul class="default-change-date__ul">
        <li>
            <a href="/attendance/list?date={{ new Carbon($selectDate)->addDay()->format('Y-m') }}" class="default-change-date__before">前月</a>
        </li>
        <li>
            <h2 class="default-change-date__select-date">{{ new Carbon($selectDate)->format('Y-m') }}</h2>
        </li>
        <li>
            <a href="/attendance/list?date={{ new Carbon($selectDate)->subDay()->format('Y-m') }}" class="default-change-date__after">翌月</a>
        </li>
    </ul>
    <table class="default-table">
        <tr class="default-table__tr">
            <th class="default-table__th">日付</th>
            <th class="default-table__th">出勤</th>
            <th class="default-table__th">退勤</th>
            <th class="default-table__th">休憩</th>
            <th class="default-table__th">合計</th>
            <th class="default-table__th">詳細</th>
        </tr>
        @foreach ($attendances as $attendance)
        @while ($i <= 30)
        <tr class="default-table__tr">
            <td class="default-table__td">{{ new Carbon($selectDate)->addDays($i)->isoFormat('Y年M月D日(dd)') }}</td>
            @if (new Carbon($selectDate)->addDays($i)->format('Y-m-d') === new Carbon($attendance['punch_in_at'])->format('Y-m-d'))
            <td class="default-table__td">{{ $attendance['punch_in_at']->format('Y-m-d') }}</td>
            <td class="default-table__td">{{ $attendance['punch_out_at']->format('Y-m-d') }}</td>
            <td class="default-table__td">{{ $attendance->totalBreakTime()->format('H:i') }}</td>
            <td class="default-table__td">{{ $attendance->totalWorkTime()->format('H:i') }}</td>
            <td class="default-table__td">
                <a href="/attendance/detail/{{ $attendance['id'] }}" class="default-table__a">詳細</a>
            </td>
            @break
            @else
            <td class="default-table__td">
                <a href="/attendance/detail" class="default-table__a">詳細</a>
            </td>
            @php
            $i++;
            @endphp
            @endif
        </tr>
        @endwhile
        @php
        $i++;
        @endphp
        @endforeach
    </table>
</article>
@endsection
