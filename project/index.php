<?php
session_start();
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <title>安否確認システム</title>
  <link rel="stylesheet" href="src/style.css">
  <script src="src/script.js" defer></script>
</head>

<body>

  <!-- ログイン -->
  <div class="card" id="loginPage">
    <h2>ログイン</h2>

    <!-- エラーメッセージ表示用 -->
    <div class="error" id="errorBox">
      <?php
      //  エラーがある時だけ表示
      if (isset($_SESSION['error'])) {

        //  配列なので1つずつ表示（重要）
        foreach ($_SESSION['error'] as $err) {
          echo "<p>$err</p>";
        }

        //  表示後は削除（しないと残り続ける）
        unset($_SESSION['error']);
      }
      ?>
    </div>

    <form method="POST" action="action/login.php" id="loginForm">
      <input id="employeeId" name="employee_code" placeholder="社員ID" required>
      <input id="password" name="password" type="password" placeholder="パスワード" required>
      <button type="submit">ログイン</button>
    </form>
  </div>

  <!-- errr box エラーがある時だけ表示 -->
  <!-- ※ 上で既に表示しているため、重複防止のためこのブロックはコメントアウトのまま維持 -->

  <!--
  <div class="error" id="errorBox">
    <?php
    // エラーがある時だけ表示
    if (isset($_SESSION['error'])) {

      // 配列なので1つずつ表示
      foreach ($_SESSION['error'] as $err) {
        echo "<p>$err</p>";
      }

      unset($_SESSION['error']); // 一度表示したら消す
    }
    ?>
  </div>
  -->

  <!-- 安否登録画面 -->
  <!-- <div class="card" id="reportPage" style="display:none;">
    <h2>安否登録</h2>
    <p>👤 <span id="userName"></span></p>

    <button class="status green" onclick="selectStatus(event,'無事')">無事</button>
    <button class="status yellow" onclick="selectStatus(event,'要支援')">要支援</button>
    <button class="status red" onclick="selectStatus(event,'緊急')">緊急</button>

    <textarea id="comment" placeholder="コメント"></textarea>

    <button onclick="submitReport()">登録</button>

    <div class="nav">
      <button onclick="showPage('listPage')">一覧</button>
      <button onclick="logout()">ログアウト</button>
    </div>
  </div>

  <!-- 一覧 -->
  <div class="card wide" id="listPage" style="display:none;">
    <h2>安否一覧</h2>

    <button onclick="filterReports('All')">すべて</button>
    <button onclick="filterReports('無事')">無事</button>
    <button onclick="filterReports('要支援')">要支援</button>
    <button onclick="filterReports('緊急')">緊急</button>

    <table id="table"></table>

    <div class="nav">
      <button onclick="showPage('reportPage')">戻る</button>
      <button onclick="logout()">ログアウト</button>
    </div>
  </div> -->

</body>

</html>