@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}" />
@endsection

@section('content')
<div class="index__content">
    <h2 class="user-name">{{ $user['name'] }}さんお疲れ様です！</h2>
    <div class="attendance__content">
        <div class="work__start">
            <form class="work__start-form" action="/workstart" method="post">
                @csrf
                <button class="start__button" type="submit" {{ $work['start_time'] != 'null' ? 'disabled' : '' }}>勤務開始</button>
                <input type="hidden" name="user_id" value="{{ $user['id'] }}">
            </form>
        </div>
        <div class="work__end">
            <form class="work__end-form" action="/workend" method="post">
                @csrf
                <button class="end__button" type="submit" {{ $work['start_time'] == 'null' ? 'disabled' : '' }}>勤務終了</button>
                <input type="hidden" name="user_id" value="{{ $user['id'] }}">
            </form>
        </div>
        <div class="break__start">
            <form class="break__start-form" action="/breakstart" method="post">
                @csrf
                <button class="breakstart__button" type="submit" {{ $breakstartstatus == 1 ? 'disabled' : '' }}>休憩開始</button>
                <input type="hidden" name="user_id" value="{{ $user['id'] }}">
            </form>
        </div>
        <div class="break__end">
            <form class="break__end-form" action="/breakend" method="post">
                @csrf
                <button class="breakend__button" type="submit" {{ $breakendstatus == 1 ? 'disabled' : '' }}>休憩終了</button>
                <input type="hidden" name="user_id" value="{{ $user['id'] }}">
            </form>
        </div>
    </div>
</div>
@endsection