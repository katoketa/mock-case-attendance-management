@extends('layouts.app')

@section('content')
<article class="default-page">
    <h1 class="default-title">{{ $userName }}さんの勤怠</h1>
    @include('components.attendance_date_changer', ['selectInterval' => 'month'])
    @include('components.attendance_list_table')
    <div class="default-button">
        {{-- CSV出力ボタン作成 --}}
    </div>
</article>
@endsection