@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}" />
@endsection

@section('content')
<div class="index__content">
    <h2 class="user-name">{{ Auth::user()->name }}さんお疲れ様です！</h2>
    <div class="attendance__content">
        <div class="work__start">
            <form class="work__start-form" action="/start" method="post">
                <button class="start__button" type="submit">勤務開始</button>
            </form>
        </div>
        <div class="work__end">
            <form class="work__end-form" action="/end" method="post">
                <button class="end__button" type="submit">勤務終了</button>
            </form>
        </div>
        <div class="break__start">
            <form class="break__start-form" action="/breakstart" method="post">
                <button class="breakstart__button" type="submit">休憩開始</button>
            </form>
        </div>
        <div class="break__end">
            <form class="break__end-form" action="/breakend" method="post">
                <button class="breakend__button" type="submit">休憩終了</button>
            </form>
        </div>
    </div>
</div>
@endsection