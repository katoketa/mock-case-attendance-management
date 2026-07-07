@extends('layouts/app')

@push('css')
<link rel="stylesheet" href="{{ asset('css/revision_attendance_list.css') }}">
@endpush

@section('content')
<article class="default-page">
    <h1 class="default-title">申請一覧</h1>
    <ul class="revision-attendance__ul">
        @if ($select === "approved")
        <li class="revision-attendance__li">
            <a href="{{ route('revision_attendance.index', ['select' => 'pending_approval']) }}" class="revision-attendance__li-a">承認待ち</a>
        </li>
        <li class="revision-attendance__li revision-attendance__li--select">
            <a href="{{ route('revision_attendance.index', ['select' => 'approved']) }}" class="revision-attendance__li-a">承認済み</a>
        </li>
        @else
        <li class="revision-attendance__li revision-attendance__li--select">
            <a href="{{ route('revision_attendance.index', ['select' => 'pending_approval']) }}" class="revision-attendance__li-a">承認待ち</a>
        </li>
        <li class="revision-attendance__li">
            <a href="{{ route('revision_attendance.index', ['select' => 'approved']) }}" class="revision-attendance__li-a">承認済み</a>
        </li>
        @endif
    </ul>
    <table class="default-table">
        <tr class="default-table__tr">
            <th class="default-table__th">状態</th>
            <th class="default-table__th align-left">名前</th>
            <th class="default-table__th align-left">対象日時</th>
            <th class="default-table__th align-left">申請理由</th>
            <th class="default-table__th align-left">申請日時</th>
            <th class="default-table__th align-left">詳細</th>
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
            <td class="default-table__td align-left">
                {{ $revisionAttendance['attendance']['user']['name'] }}
            </td>
            <td class="default-table__td align-left">
                {{ $revisionAttendance['punch_in_at']->format('Y/m/d') }}
            </td>
            <td class="default-table__td align-left">
                <div class="revision-attendance__remarks">
                    {{ $revisionAttendance['remarks'] }}
                </div>
            </td>
            <td class="default-table__td align-left">
                {{ $revisionAttendance['created_at']->format('Y/m/d') }}
            </td>
            <td class="default-table__td align-left">
                @if (Auth::guard('web')->check())
                <a href="{{ route('revision_attendance.show', ['revisionAttendance' => $revisionAttendance['id']]) }}" class="default-table__a">詳細</a>
                @elseif (Auth::guard('admin')->check())
                <a href="{{ route('admin.revision_attendance.edit', ['revisionAttendance' => $revisionAttendance['id']]) }}" class="default-table__a">詳細</a>
                @endif
            </td>
        </tr>
        @endforeach
    </table>
</article>
@endsection