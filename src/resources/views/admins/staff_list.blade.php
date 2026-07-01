@extends('layouts.app')

@section('content')
<article class="default-page">
    <h1 class="default-title">スタッフ一覧</h1>
    <table class="default-table">
        <tr class="default-table__tr">
            <th class="default-table__th">名前</th>
            <th class="default-table__th">メールアドレス</th>
            <th class="default-table__th">月次勤怠</th>
        </tr>
        @foreach ($users as $user)
        <tr class="default-table__tr">
            <td class="default-table__td">{{ $user['name'] }}</td>
            <td class="default-table__td">{{ $user['email'] }}</td>
            <td class="default-table__td">
                <a href="{{ route('admin.staff.show" class="default-table__a">詳細</a>
            </td>
        </tr>
        @endforeach
    </table>
</article>
@endsection