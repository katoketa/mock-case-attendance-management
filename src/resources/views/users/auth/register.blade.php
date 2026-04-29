@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endsection

@section('content')
<article class="auth-page">
    <h1 class="auth-page__title">会員登録</h1>
    <form action="/register" method="post" class="auth-form" novalidate>
        @csrf
        <label for="name" class="auth-form__label">名前</label>
        <input type="text" name="name" id="name" class="auth-form__input">
        <label for="email" class="auth-form__label">メールアドレス</label>
        <input type="email" name="email" id="email" class="auth-form__input">
        <label for="password" class="auth-form__label">パスワード</label>
        <input type="password" name="password" id="password" class="auth-form__input">
        <label for="password_confirmation" class="auth-form__label">パスワード確認</label>
        <input type="password" name="password_confirmation" id="password_confirmation" class="auth-form__input">
        <button type="submit" class="auth-form__button-submit">登録する</button>
        <div class="shift-page__login-register">
            <a href="/login" class="shift-login-register__a">ログインはこちら</a>
        </div>
    </form>
</article>
@endsection