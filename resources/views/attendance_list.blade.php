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
        <!-- <?php
        echo date('Y-m-d', strtotime('-1 day')); //昨日
        ?> -->
      </button>

    </form>
    <p class="date__today">{{ $today }}</p>
    <form action="getattendances" method="get">
      @csrf
      <button name="date" id="next" value="{{ $today }}"> &gt;</button>
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
      @foreach ($attendances as $values)
      <tr class="table-value">
        @foreach ($values as $sub_value)
        <td>{{ $sub_value }}</td>
        @endforeach
      </tr>
      @endforeach
    </table>
  </div>
  <div class="paginate">
    <form action="getattendances" method="get">
      <input type="hidden" name="date" value="{{ $today }}">
      {{ $attendances->links() }}
    </form>
  </div>
</main>
@endsection