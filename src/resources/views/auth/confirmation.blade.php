@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth/confirmation.css') }}" />
@endsection

@section('content')
<div class="confirmation__content">
    <h2 class="confitmation__message">認証メールを送信しました<br />
        メールを確認してください</h2>
    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
        @csrf
        <p>メールが届いていない場合は下記のボタンをクリックしてください<br />再度認証メールを送信します</p>
        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('再送する') }}</button>
    </form>

</div>
@endsection