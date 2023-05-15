@extends('layouts.default')

<head>
  <link rel="stylesheet" href="/css/reset.css">
  <link rel="stylesheet" href="/css/list.css">

</head>
@section('title', '日付一覧')
@section('content')

<main>
  <div class="date">
    <form action="/attendance?date" method="get">
      @csrf
      <button name="date" id="prev" value="{{ $today }}"> &lt;
      </button>

    </form>
    <p class="date__today">{{ $today }}</p>
    <form action="getattendances" method="get">
      @csrf
      <button name="date" id="next" value="{{ $today }}"> &gt;</button>
    </form>
  </div>

  <div class="list">
    <table class="attandance_list">
      <tr class="table-title">
        <th>名前</th>
        <th>勤務開始</th>
        <th>勤務終了</th>
        <th>休憩時間</th>
        <th>勤務時間</th>
      </tr>
      @foreach($attendances as $values)
      <form action="/getAttendance" method="get">
        <tr class="table-value table-value-info">
          @foreach($values as $sub_value)
          <td>
            {{$sub_value}}
          </td>
          @endforeach
        </tr>
      </form>
      @endforeach
    </table>
  </div>
  <div class="paginate">
    <form action="/attendance_list" method="get">
      <input type="button" name="date" >
      {{ $attendances->links() }}
    </form>
  </div>
</main>
@endsection