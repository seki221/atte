@extends('layouts.default')

<head>
  <link rel="stylesheet" href="/css/reset.css">
  <link rel="stylesheet" href="/css/list.css">
</head>
@section('title', '日付一覧')
@section('content')


<main>
  <div class="date">
    <form action="getAttendances" method="get">
      <p class="date__today">{{ $today }}</p>
    </form>
  </div>

  <div class="date_list">
    <table class="attandance_rest_list">
      <thead class="atte_tag">
        <tr>
          <th>名前</th>
          <th>勤務開始</th>
          <th>勤務終了</th>
          <th>休憩時間</th>
          <th>勤務時間</th>
        </tr>
      </thead>
      <tbody>
        @foreach($users as $array)
        <tr>
          <td>
            {{ $user->name }}
          </td>
          
        @endforeach
      </tbody>
    </table>
  </div>
  <div class="area_navi">
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
  </div>
</main>
@endsection