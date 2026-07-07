@extends('layouts.app')

@push('css')
<link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endpush

@section('content')
<article class="auth-page">
    <h1 class="auth-page__title">管理者ログイン</h1>
    <form action="{{ route('admin.execute') }}" method="post" class="auth-form" novalidate>
        @csrf
        <label for="email" class="auth-form__label">メールアドレス</label>
        <input type="email" name="email" id="email" class="auth-form__input">
        <label for="password" class="auth-form__label">パスワード</label>
        <input type="password" name="password" id="password" class="auth-form__input">
        <button type="submit" class="auth-form__button-submit">管理者ログインする</button>
    </form>
</article>
@endsection