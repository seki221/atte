@extends('layouts.default')

<head>
  <link rel="stylesheet" href="/css/reset.css">
  <link rel="stylesheet" href="css/list.css">
</head>
@section('title', '日付一覧')
@section('list')

<div class="container">

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
        </tr>
      </thead>
    </table>
  </div>
</div>