@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endsection

@section('content')
<article class="auth-page">
    <h1 class="auth-page__title">ログイン</h1>
    <form action="/login" method="post" class="auth-form">
        <label for="email" class="auth-form__label">メールアドレス</label>
        <input type="email" name="email" id="email" class="auth-form__input">
        <label for="password" class="auth-form__label">パスワード</label>
        <input type="password" name="password" id="password" class="auth-form__input">
        <button type="submit" class="auth-form__button-submit">ログインする</button>
    </form>
    <div class="shift-page__login-register">
        <a href="/register" class="shift-login-register__a">会員登録はこちら</a>
    </div>
</article>
@endsection