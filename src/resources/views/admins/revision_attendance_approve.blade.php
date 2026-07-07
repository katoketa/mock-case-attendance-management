@extends('layouts.app')

@section('content')
<article class="default-page">
    <h1 class="default-title">勤怠詳細</h1>
    @include('components.attendance_detail_table', ['canEdit' => false])
    <div class="default-button">
        <button type="submit" class="default-button__submit">承認</button>
    </div>
</article>
@endsection