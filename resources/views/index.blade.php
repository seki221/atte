<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Atte</title>
  <link rel="stylesheet" href="/css/reset.css">
  <link rel="stylesheet" href="/css/style.css">
</head>

<body>
  <header class="header">
    <h1 class="header_left">Atte</h1>
    <nav>
      <ul class="header_right">
        <li class="header_list">ホーム</li>
        <li class="header_list">日付一覧</li>
        <li class="header_list">ログアウト</li>
      </ul>
    </nav>
  </header>
  <main>
    <div class="user">
      <h1>さんお疲れ様です！</h1>
    </div>
    <!-- <div class="container">
      <div class="box">
        <p>勤務開始</p>
      </div>
      <div class="box">
        <p>勤務終了</P>
      </div>
    </div>
    <div class="container">
      <div class="box">
        <p>休憩開始</P>
      </div>
      <div class="box">
        <p>休憩終了</p>
      </div>
    </div> -->

    
    <!-- <div class="container"> -->
      <div class="attendance_b">
        <fieldset id="field1">
          <button id="on1" onclick='field2.disabled = false; on1.disabled = true; off1.disabled = false;'>勤務開始</button>
          <button id="off1" disabled="true" onclick='field2.disabled = true; on1.disabled = false; off1.disabled = true;'>勤務終了</button>
        </fieldset>
        <fieldset id="field2" disabled="true">
          <button id="on2" onclick='on2.disabled = true; off2.disabled = false;'>休憩開始</button>
          <button id="off2" disabled="true" onclick='on2.disabled = false; off2.disabled = true;'>休憩終了</button>
        </fieldset>
      </div>
    </div>

    
  </main>
  <footer>
    Atte,inc.
  </footer>
</body>

</html>