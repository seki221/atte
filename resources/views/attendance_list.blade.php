@extends('layouts.default')

<head>
  <link rel="stylesheet" href="/css/reset.css">
  <link rel="stylesheet" href="/css/list.css">
  
</head>
@section('title', '日付一覧')
@section('content')


<main>
  <div class="date">
    <form action="getattendances" method="get">
      <button name="date" id="prev" value="{{ $today }}">
        < </button>
    </form>
    <p class="date__today">{{ $today }}</p>
    <form action="getattendances" method="get">
      <button name="date" id="next" value="{{ $today }}">></button>
    </form>
  </div>

  <div class="date_list">
    <table class="attandance_rest_list">
      <tr>
        <th>名前</th>
        <th>勤務開始</th>
        <th>勤務終了</th>
        <th>休憩時間</th>
        <th>勤務時間</th>
      </tr>
      @foreach($attendances as $attendance)

      @endforeach

    </table>
  </div>
  <!-- <div class="area_navi">
    <div class="prev"><a>＜</a></div>
    <div class="pagenum">
      <ol>
        <li><a>1</a></li>
        <li><a href="">2</a></li>
        <li><a href="">3</a></li>
        <li><a href="">4</a></li>
      </ol>
    </div>
    <div class="next"><a href="">＞</a></div>
  </div> -->
</main>
@endsection