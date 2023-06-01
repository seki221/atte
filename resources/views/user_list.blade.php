@extends('layouts.default')

<head>
  <link rel="stylesheet" href="/css/reset.css">
  <link rel="stylesheet" href="/css/user_list.css">
  <link rel="stylesheet" href="/css/list.css">


</head>
@section('title', 'ユーザー別勤怠ページ')
@section('content')

<main>
  <div class="user__name">
    <p>{{ $userName }}さんの勤怠記録</p>
  </div>
  <div class="date">
    <form action="/attendance_list" method="get">
      @csrf
      <button name="date_n" id="prev__n" value=""> &lt;
      </button>
    </form>
    <p class="date__n">
      {{ $today->format('Y-m-d') }}
    </p>
    <form action="/attendance_list" method="get">
      @csrf
      <button name="date_n" id="next__n" value=""> &gt;
      </button>
    </form>
  </div>

  <div class="month_chenge">
    <form action="/user_list" method="get">
      <label for="time">月の変更：</label>
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
      <input type="submit" value="変更">
    </form>
  </div>
  <div class="list">
    <table class="attandance_list">
      <tr class="table-title">
        <th>日付</th>
        <th>勤務開始</th>
        <th>勤務終了</th>
        <th>休憩時間</th>
        <th>勤務時間</th>
        <th>勤務時間</th>
      </tr>


      <!-- <form action="/user_list" method="get"> -->
      @foreach($attendances as $values)
      <tr class="table-value table-value-info">
        @foreach( $values as $sub_value )
        <td>{{ $sub_value }}</td>
        @endforeach
      </tr>
      @endforeach
      <!-- </form> -->


    </table>
    <div class="paginate">
      <form action="/attendance_list/{num}}" method="get">
        <input type="hidden" name="date" value="date">
        {{ $attendances->links() }}
      </form>
    </div>
  </div>
</main>
@endsection