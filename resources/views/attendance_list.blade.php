@extends('layouts.default')

<head>
  <link rel="stylesheet" href="/css/reset.css">
  <link rel="stylesheet" href="/css/list.css">

</head>
@section('title', '日付一覧')
@section('content')

<main>
  <div class="date">
    <form action="/attendance_list" method="get">
      @csrf
      <button name="date" id="prev" value="{{ $targetDate->subDay()->format('Y-m-d')}}"> &lt;
      </button>
    </form>
    <p class="date__today">{{ $targetDate->format('Y-m-d') }}</p>
    <form action="/attendance_list" method="get">
      @csrf
      <button name="date" id="next" value="{{ $targetDate->tomorrow()->format('Y-m-d') }}"> &gt;</button>
    </form>
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
      <input type="hidden" name="date" value="{{ $targetDate->format('Y-m-d') }}">
      {{ $attendances->links() }}
    </form>
  </div>
</main>
@endsection