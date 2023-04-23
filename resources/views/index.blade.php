@extends('layouts.default')

<head>
  <link rel="stylesheet" href="/css/reset.css">
  <link rel="stylesheet" href="css/index.css">
</head>

@section('title', '打刻ページ')
@section('content')
<main>
  <div class="main__title">
    <div class="user">
      @if(Auth::check())
      <p>{{'$user->name'}}さんお疲れ様です！</p>
      @endif
    </div>

    <!-- <div class="container"> -->
    <!-- <div class="attendance_b">
      <fieldset id="field1">
        <button id="on1" onclick='field2.disabled = false; on1.disabled = true; off1.disabled = false;'>勤務開始</button>
        <button id="off1" disabled="true" onclick='field2.disabled = true; on1.disabled = false; off1.disabled = true;'>勤務終了</button>
      </fieldset>
      <fieldset id="field2" disabled="true">
        <button id="on2" onclick='on2.disabled = true; off2.disabled = false;'>休憩開始</button>
        <button id="off2" disabled="true" onclick='on2.disabled = false; off2.disabled = true;'>休憩終了</button>
      </fieldset>
    </div> -->
    <!-- </div> -->

    @if('$isWorkStarted' && '$isRestStarted')
    <p class="status">休憩中</p>
    @elseif($isWorkStarted)
    <p class="status">勤務中</p>
    @else
    <p class="status">退勤済</p>
    @endif
    <div class="main__attendance">
      <div class="attendance__left">
        <!-- 勤務開始 -->
        @if(('$isWorkStarted') || ('$isWorkEnded'))
        <form action="/workStart" method="POST" class="timestamp">
          @csrf
          <button class="button1">勤務開始</button>
        </form>
        @elseif('$isWorkStarted && $isWorkEnded')
        <form action="/workStart" method="POST" class="timestamp">
          @csrf
          <button disabled style="color:gray">勤務開始</button>
        </form>
        @else
        <form action="/workStart" method="POST" class="timestamp">
          @csrf
          <button class="button1">勤務開始</button>
        </form>
        @endif
        <!-- 休憩開始 -->
        @if('$isWorkStarted && $isRestStarted')
        <form action="/restStart" method="POST" class="timestamp">
          @csrf
          <button disabled style="color:gray">休憩開始</button>
        </form>
        @elseif($isWorkStarted)
        <form action="/restStart" method="POST" class="timestamp">
          @csrf
          <button class="button2">休憩開始</button>
        </form>
        @else
        <form action="/restStart" method="POST" class="timestamp">
          @csrf
          <button disabled style="color:gray">休憩開始</button>
        </form>
        @endif
      </div>
      <div class="attendance__right">
        <!-- 勤務終了 -->
        @if('$isWorkStarted')
        <form action="/workEnd" method="POST" class="timestamp">
          @csrf
          <button class="button3">勤務終了</button>
        </form>
        @elseif('$isWorkStarted && $isWorkEnded')
        <form action="/workEnd" method="POST" class="timestamp">
          @csrf
          <button disabled style="color:gray">勤務終了</button>
        </form>
        @else
        <form action="/workEnd" method="POST" class="timestamp">
          @csrf
          <button disabled style="color:gray">勤務終了</button>
        </form>
        @endif
        <!-- 休憩終了 -->
        @if(('$isWorkStarted') && ('$isRestStarted'))
        <form action="/restEnd" method="POST" class="timestamp">
          @csrf
          <button class="button4">休憩終了</button>
        </form>
        @elseif('$isWorkStarted && $isWorkEnded')
        <form action="/workEnd" method="POST" class="timestamp">
          @csrf
          <button disabled style="color:gray">勤務終了</button>
        </form>
        @else
        <form action="/restEnd" method="POST" class="timestamp">
          @csrf
          <button disabled style="color:gray">休憩終了</button>
        </form>
        @endif
</main>
@endsection