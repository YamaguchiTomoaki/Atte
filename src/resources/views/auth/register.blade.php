@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth/register.css') }}" />
@endsection

@section('content')
<div class="register-form__content">
    <h2 class="register-form__heading">会員登録</h2>
    <div class="register-form__inner">
        <form class="register-form" action="/register" method="post">
            @csrf
            <div class="register-form__group">
                <input class="register-form__input" type="text" name="name" placeholder="名前">
                <p class="register-form__error-message">
                    @error('name')
                    {{ $message }}
                    @enderror
                </p>
            </div>
            <div class="register-form__group">
                <input class="register-form__input" type="email" name="email" placeholder="メールアドレス">
                <p class="register-form__error-message">
                    @error('email')
                    {{ $message }}
                    @enderror
                </p>
            </div>
            <div class="register-form__group">
                <input class="register-form__input" type="password" name="password" placeholder="パスワード">
                <p class="register-form__error-message">
                    @error('password')
                    {{ $message }}
                    @enderror
                </p>
            </div>
            <div class="register-form__group">
                <input class="register-form__input" type="password" name="password_confirmation" placeholder="確認用パスワード">
                <p class="register-form__error-message">
                    @error('password_confirmation')
                    {{ $message }}
                    @enderror
                </p>
            </div>
            <button class="register-form__button" type="submit">会員登録</button>
        </form>
        <div class="register-form__footer">
            <p class="register-form__footer-label">アカウントをお持ちの方はこちらから</p>
            <a class="register-form__link-login" href="/login">ログイン</a>
        </div>
    </div>
</div>
@endsection