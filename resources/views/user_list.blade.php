@extends('layouts.default')

<head>
  <link rel="stylesheet" href="/css/reset.css">
  <link rel="stylesheet" href="/css/list.css">
  <link rel="stylesheet" href="/css/user_list.css">


</head>
@section('title', 'ユーザー別勤怠ページ')
@section('content')

<main>
  <div class="user_name">
    <p>{{ $userName }}さんの勤怠記録</p>
  </div>

  <div class="date">
    <form action="/user_page">
      <label for="time">表示月の変更：</label>
      <select name=" month" id="selectMonth">
        <option value="">-</option>
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
        <option value="6">6</option>
        <option value="7">7</option>
        <option value="8">8</option>
        <option value="9">9</option>
        <option value="10">10</option>
        <option value="11">11</option>
        <option value="12">12</option>
      </select>月
    </form>
    {{$attendances}}
  </div>
  <div class="list">
    <table class="attandance_list">
      <tr class="table-title">
        <th>名前</th>
        <th>勤務開始</th>
        <th>勤務終了</th>
        <th>休憩時間</th>
        <th id="attendance_time">勤務時間</th>
      </tr>
      @foreach($attendances as $users)
      <form action="/getAttendance" method="get">
        <tr class="table-value table-value-info">
          @foreach($users as $name)
          <td>{{$name}}</td>
          @endforeach
        </tr>
      </form>
      @endforeach
    </table>
  </div>
  <div class="paginate">
    <form action="/attendance_list/{num}}" method="get">
      <input type="hidden" name="date" value="date">
      {{ $attendances->links() }}
    </form>
  </div>
</main>
@endsection