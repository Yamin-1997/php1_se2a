<?php

require_once __DIR__ . "/def.php";
require_once __DIR__ . "/utils.php";

//課題８ではoldProductから全件表示

//課題９でPRICEもしくはCATEGORYの条件を追加して検索

?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>kadai08_1 商品検索</title>
  <link href="css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
  <!-- ▼▼ヘッダー▼▼--------------------------------- -->
  <header class="bg-info">
    <div class="text-light ms-5 pt-5 pb-3">
      <h1 class="h6">サーバーサイドスクリプト演習１</h1>
      <h2 class="pt-3">データベース検索</h2>
    </div><!--/.container-->
  </header>
  <!-- ▲▲ヘッダー▲▲--------------------------------- -->

  <div class="container-field">
    <div class="row">
      <div class=" p-3 d-grid gap-2 d-md-flex justify-content-md-end">
        <a class="btn btn-danger btn-lg me-md-5" href="kadai10_1.php">新規登録</a>
      </div>
    </div>
    <div class="row border h-75">
      <div class="col-3 border">
        <form action="kadai08_1.php" method="GET" class="mt-5 m-3">

          <!-- 検索 -->
          <div class="form-check form-check-inline mb-3">
            <input class="form-check-input" type="radio" name="searchType" id="searchRadio1" value="1" onclick="typeCheck();">
            <label class=" form-check-label" for="searchRadio1">価格検索</label>
          </div>
          <div class="form-check form-check-inline mb-3">
            <input class="form-check-input" type="radio" name="searchType" id="searchRadio2" value="2" onclick="typeCheck();">
            <label class="form-check-label" for="searchRadio2">カテゴリ検索</label>
          </div>
          <div class="form-check form-check-inline mb-3">
            <input class="form-check-input" type="radio" name="searchType" id="searchRadio3" value="3" onclick="typeCheck();">
            <label class=" form-check-label" for="searchRadio3">商品名検索</label>
          </div>

          <div class="input-group mb-3">
            <span class="input-group-text">価格</span>
            <input type="text" class="form-control" name="price" id="price" value="">
            <span class="input-group-text">円以上</span>
          </div>

          <div class="input-group mb-3">
            <label class="input-group-text mb-3" for="category">カテゴリ</label>
            <select class="form-select mb-3" name="category" id="category">
              <option value="1">全ての商品</option>
              <option value="2">ピザ</option>
              <option value="3">ドリンク</option>
            </select>
          </div>

          <div class="input-group mb-3">
            <span class="input-group-text">商品名</span>
            <input type="text" class="form-control" name="pname" id="pname" value="">
            <span class="input-group-text">を含む</span>
          </div>

          <div class="row">
            <div class="pt-5 px-0 d-grid gap-2 d-md-flex justify-content-md-end">
              <input class="btn btn-primary btn-lg" type="submit" value="検索">
            </div><!-- .p-5 d-grid gap-2 d-md-flex justify-content-md-end -->
          </div><!-- .row -->

        </form>
      </div><!-- .col-3 border -->

      <div class="col-9 border">

        <table class="table table-hover mt-5 form-control-lg">
          <thead class="table-light text-secondary">
            <tr>
              <th>商品番号</th>
              <th>商品名</th>
              <th>カテゴリ</th>
              <th>価格</th>
              <th>編集</th>
              <th>削除</th>
            </tr>
          </thead>
          <tbody>

            <tr>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <!-- TODO:「編集」「削除」各リンク先は課題10以降で追加。 -->
              <td><a class="btn btn-primary" href="">編集</a></td>
              <td><a class="btn btn-secondary" href="">削除</a></td>
            </tr>

          </tbody>
        </table>

      </div><!-- .col-9 border -->
    </div><!-- .row border h-75 -->
  </div><!-- .container-field -->

  <script>
    /* 本来は別ファイルに分けた方が良い */
    window.onload = (event) => {
      /* TODO:配布ファイル用　処理（ラジオボックスの値保持前のために実装） */
      // TODO:値保持の実装をしたらコメントアウト可。（このままでも支障なし）
      const chkBox = document.getElementsByName('searchType');
      if (chkBox[0].checked == false && chkBox[1].checked == false && chkBox[2].checked == false)
        chkBox[0].checked = true;
      /* TODO:ここまで */
      typeCheck();
    }

    function typeCheck() {
      const chk = document.querySelector("input[name='searchType']:checked").value;
      console.log(chk);
      const priceBox = document.getElementById("price");
      const categoryBox = document.getElementById("category");
      const pnameBox = document.getElementById("pname");

      if (chk == 1) {
        priceBox.disabled = false;
        categoryBox.disabled = true;
        categoryBox.value = 1;
        pnameBox.disabled = true;
        pnameBox.value = "";
      } else if (chk == 2) {
        categoryBox.disabled = false;
        priceBox.disabled = true;
        priceBox.value = "";
        pnameBox.disabled = true;
        pnameBox.value = "";
      } else if (chk == 3) {
        pnameBox.disabled = false;
        priceBox.disabled = true;
        priceBox.value = "";
        categoryBox.disabled = true;
        categoryBox.value = 1;
      }
    }
  </script>

</body>

</html>