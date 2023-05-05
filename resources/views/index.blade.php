@extends('layouts.default')

<head>
  <link rel="stylesheet" href="/css/reset.css">
  <link rel="stylesheet" href="/css/index.css">
</head>

@section('title', '打刻ページ')
@section('content')
<main>
  <div class="main__title">
    @if(Auth::check())
    <p>{{$user->name}}さんお疲れ様です！</p>
    @endif
  </div>

  <div class="main__attendance">
    <div class="attendance__left">
      <!-- 勤務開始 -->
      @if(($isWorkStarted) || ($isWorkEnded))
      <!--  -->
      <form action="/workStart" method="POST" class="timestamp">
        @csrf
        <button disabled style="color:gray">勤務開始</button>
      </form>
      @else
      <!--  -->
      <form action="/workStart" method="POST" class="timestamp">
        @csrf
        <button class="button1">勤務開始</button>
      </form>
      @endif
      <!-- 休憩開始 -->
      @if($isWorkStarted && $isRestStarted)
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
      @if($isWorkStarted)
      <form action="/workEnd" method="POST" class="timestamp">
        @csrf
        <button class="button3">勤務終了</button>
      </form>
      @elseif($isWorkStarted && $isWorkEnded)
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
      @if(($isWorkStarted) && ($isRestStarted))
      <form action="/restEnd" method="POST" class="timestamp">
        @csrf
        <button class="button4">休憩終了</button>
      </form>
      @else
      <form action="/restEnd" method="POST" class="timestamp">
        @csrf
        <button disabled style="color:gray">休憩終了</button>
      </form>
      @endif
    </div>
  </div>

  <div class="main__attendance">
    <div class="attendance__left">
      <fieldset id="field_ws">
        @if(($isWorkStarted) || ($isWorkEnded))
        <form action="/workStart" method="POST" class="timestamp">
          @csrf
          <button id="workstart" onclick='field_ws.disabled = false; workstart.disabled = true; workend.disabled = false;'> 勤務開始 </button>
        </form>
        @else
        <form action="/workStart" method="POST" class="timestamp">
          @csrf
          <button class="button1">勤務開始</button>
        </form>
        @endif
      </fieldset>
      <fieldset id="field_rs">
        <button id="reststart" onclick='field_rs.disabled = true; restend.disabled = false;'>休憩開始</button>
      </fieldset>
    </div>
    <div class="attendance__right">
      <fieldset id="field_we">
        <button id="workend" disabled="true" onclick='field_rs.disabled = true; workstart.disabled = false; workend.disabled = true;'>勤務終了</button>
      </fieldset>
      <fieldset id="field_re">
        <button id="restend" disabled="true" onclick='field_rs.disabled = false; restend.disabled = true;'>休憩終了</button>
      </fieldset>
    </div>
  </div>
</main>
@endsection