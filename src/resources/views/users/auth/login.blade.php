@extends('layouts.app')

@push('css')
<link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endpush

@section('content')
<article class="auth-page">
    <h1 class="auth-page__title">ログイン</h1>
    <form action="/login" method="post" novalidate>
        @csrf
        <label for="email" class="auth-form__label">メールアドレス</label>
        <input type="email" name="email" id="email" class="auth-form__input" value="{{ old('email') }}">
        @error('email')
        <div class="default-error-message">{{ $message }}</div>
        @enderror
        <label for="password" class="auth-form__label">パスワード</label>
        <input type="password" name="password" id="password" class="auth-form__input">
        @error('password')
        <div class="default-error-message">{{ $message }}</div>
        @enderror
        <button type="submit" class="auth-form__button-submit">ログインする</button>
    </form>
    <div class="shift-page__login-register">
        <a href="/register" class="shift-login-register__a">会員登録はこちら</a>
    </div>
</article>
@endsection