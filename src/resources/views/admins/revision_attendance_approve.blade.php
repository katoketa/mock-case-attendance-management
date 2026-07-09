@extends('layouts.app')

@section('content')
<article class="default-page">
    <h1 class="default-title">勤怠詳細</h1>
    @include('components.attendance_detail_table', ['canEdit' => false])
    <form action="{{ route('admin.revision_attendance.update', ['revisionAttendance' => $showData['id']]) }}" method="post">
        @csrf
        <div class="default-button">
            @if ($showData['is_approval'])
            <button type="submit" class="default-button__submit" disabled>承認済み</button>
            @else
            <button type="submit" class="default-button__submit">承認</button>
            @endif
        </div>
    </form>
</article>
@endsection