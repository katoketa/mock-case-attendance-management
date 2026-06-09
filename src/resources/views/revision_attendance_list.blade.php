@extends('layouts/app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/revision_attendance_list.css') }}">
@endsection

@section('content')
<article class="default-page">
    <h1 class="default-title">申請一覧</h1>
    <ul class="revision-attendance__ul">
        <li class="revision-attendance__li">承認待ち</li>
        <li class="revision-attendance__li">承認済み</li>
    </ul>
    <table class="default-table">
        <tr class="default-table__tr">
            <th class="default-table__th">状態</th>
            <th class="default-table__th">名前</th>
            <th class="default-table__th">対象日時</th>
            <th class="default-table__th">申請理由</th>
            <th class="default-table__th">申請日時</th>
            <th class="default-table__th">詳細</th>
        </tr>
        @foreach ($revisionAttendances as $revisionAttendance)
        <tr class="default-table__tr">
            <td class="default-table__td">
                @if ($revisionAttendance['is_approval'])
                承認済み
                @else
                承認待ち
                @endif
            </td>
            <td class="default-table__td">
                {{ $revisionAttendance['attendance']['user']['name'] }}
            </td>
            <td class="default-table__td">
                {{ $revisionAttendance['punch_in_at']->format('Y/m/d') }}
            </td>
            <td class="default-table__td">
                {{ $revisionAttendance['remarks'] }}
            </td>
            <td class="default-table__td">
                {{ $revisionAttendance['created_at']->format('Y/m/d') }}
            </td>
            <td class="default-table__td">
                <a href="/stamp_correction_request/approve/{{ $revisionAttendance['id'] }}" class="default-table__a">詳細</a>
            </td>
        </tr>
        @endforeach
    </table>
</article>
@endsection