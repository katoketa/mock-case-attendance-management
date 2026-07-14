@extends('layouts.app')

@push('css')
<link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endpush

@section('content')
@php
if (!empty($error)) {
dd($error);
}
@endphp
<article class="auth-page">
    <h1 class="auth-page__title">管理者ログイン</h1>
    <form action="{{ route('admin.execute') }}" method="post" class="auth-form" novalidate>
        @csrf
        <label for="email" class="auth-form__label">メールアドレス</label>
        <input type="email" name="email" id="email" class="auth-form__input" value="{{ old('email') }}">
        @error('email')
        <div class="default-error-message">{{ $message }}</div>
        @enderror
        @if (!empty(session('login_failed_message')))
        <div class="default-error-message">{{ session('login_failed_message') }}</div>
        @endif
        <label for="password" class="auth-form__label">パスワード</label>
        <input type="password" name="password" id="password" class="auth-form__input">
        @error('password')
        <div class="default-error-message">{{ $message }}</div>
        @enderror
        <button type="submit" class="auth-form__button-submit">管理者ログインする</button>
    </form>
</article>
@endsection