@extends('layouts.app')

@section('content')
<article class="default-page">
    <h1 class="default-title">勤怠詳細</h1>
    <form action="{{ route('admin.attendance.update') }}" method="post">
        @csrf
        @include('components.attendance_detail_table')
        @if ($canEdit)
        <div class="default-button">
            <button type="submit" class="default-button__submit">修正</button>
        </div>
        @else
        <div class="pending-approval__message">*承認待ちのため修正はできません。</div>
        @endif
    </form>
</article>
@endsection