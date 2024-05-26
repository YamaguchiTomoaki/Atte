@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth/login.css') }}" />
@endsection

@section('content')
<div class="login-form__content">
    <h2 class="login-form__heading">ログイン</h2>
    <div class="login-form__inner">
        <form class="login-form" action="/login" method="post">
            @csrf
            <div class="login-form__group">
                <input class="login-form__input" type="email" name="email" placeholder="メールアドレス">
                <p class="login-form__error-message">
                    @error('email')
                    {{ $message }}
                    @enderror
                </p>
            </div>
            <div class="login-form__group">
                <input class="login-form__input" type="password" name="password" placeholder="パスワード">
                <p class="login-form__error-message">
                    @error('password')
                    {{ $message }}
                    @enderror
                </p>
            </div>
            <button class="login-form__button" type="submit">ログイン</button>
        </form>
        <div class="login-form__footer">
            <p class="login-form__footer-label">アカウントをお持ちでない方はこちらから</p>
            <a class="login-form__link-register" href="/register">会員登録</a>
        </div>
    </div>
</div>
@endsection