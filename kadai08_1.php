<?php
require_once __DIR__ . "/def.php";
require_once __DIR__ . "/utils.php";

// DB接続文字列
$dsn = "mysql:host=" . DB_HOST .
  ";dbname=" . DB_NAME .
  ";charset=" . DB_CHARSET;

// GETデータ取得
$searchType = $_GET["searchType"] ?? "";
$price = $_GET["price"] ?? "";
$category = $_GET["category"] ?? "1";

try {
  // DB接続
  $db = new PDO($dsn, DB_USER, DB_PASS);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
  // 基本SQL
  $sql = "SELECT
            PRODUCT_NO AS product_no,
            PNAME AS pname,
            CATEGORY AS category,
            PRICE AS price
          FROM " . TBL_PRODCUT;

  $params = [];

  // 検索ボタンを押した場合だけ条件を追加
  if ($searchType === "1") {
    // 価格検索：空なら0円以上
    if ($price === "") {
      $price = 0;
    }

    $sql .= " WHERE PRICE >= :price";
    $params[":price"] = $price;
  } elseif ($searchType === "2") {
    // カテゴリ検索
    if ($category === "2") {
      $sql .= " WHERE CATEGORY = :category";
      $params[":category"] = "ピザ";
    } elseif ($category === "3") {
      $sql .= " WHERE CATEGORY = :category";
      $params[":category"] = "ドリンク";
    }
    // category が 1 の場合は全件表示
  }

  // SQL準備
  $stmt = $db->prepare($sql);

  // プレースホルダに値を入れる
  foreach ($params as $key => $value) {
    $stmt->bindValue($key, $value);
  }

  // SQL実行
  $stmt->execute();
  $db->commit();

  // 結果を配列に入れる
  $result = [];
  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $result[] = $row;
  }

  $stmt = null;
  $db = null;
} catch (PDOException $poe) {
  exit("DBエラー：" . $poe->getMessage());
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <title>kadai08_1 商品検索</title>
  <link href="css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
  <header class="bg-info">
    <div class="text-light ms-5 pt-5 pb-3">
      <h1 class="h6">サーバーサイドスクリプト演習１</h1>
      <h2 class="pt-3">データベース検索</h2>
    </div>
  </header>

  <div class="container-field">
    <div class="row">
      <div class="p-3 d-grid gap-2 d-md-flex justify-content-md-end">
        <a class="btn btn-danger btn-lg me-md-5" href="kadai10_1.php">新規登録</a>
      </div>
    </div>

    <div class="row border h-75">
      <div class="col-3 border">
        <form action="kadai08_1.php" method="GET" class="mt-5 m-3">

          <div class="form-check form-check-inline mb-3">

            <input class="form-check-input" type="radio" name="searchType" id="searchRadio1"
              value="1" onclick="typeCheck();"

              <?= ($searchType === "" || $searchType === "1") ? "checked" : "" ?>>

            <label class="form-check-label" for="searchRadio1">価格検索</label>
          </div>

          <div class="form-check form-check-inline mb-3">
            <input class="form-check-input" type="radio" name="searchType" id="searchRadio2"
              value="2" onclick="typeCheck();"

              <?= ($searchType === "2") ? "checked" : "" ?>

              <label class="form-check-label" for="searchRadio2">カテゴリ検索</label>
          </div>

          <div class="input-group mb-3">
            <span class="input-group-text">価格</span>
            <input type="text" class="form-control" name="price" id="price"
              value="<?= htmlspecialchars($price, ENT_QUOTES, 'UTF-8') ?>">
            <span class="input-group-text">円以上</span>
          </div>

          <div class="input-group mb-3">
            <label class="input-group-text mb-3" for="category">カテゴリ</label>
            <select class="form-select mb-3" name="category" id="category">
              <option value="1" <?= ($category === "1") ? "selected" : "" ?>>全ての商品</option>
              <option value="2" <?= ($category === "2") ? "selected" : "" ?>>ピザ</option>
              <option value="3" <?= ($category === "3") ? "selected" : "" ?>>ドリンク</option>
              <!-- <option value="1">全ての商品</option>
              <option value="2">ピザ</option>
              <option value="3">ドリンク</option> -->
            </select>
          </div>

          <div class="pt-5 px-0 d-grid gap-2 d-md-flex justify-content-md-end">
            <input class="btn btn-primary btn-lg" type="submit" value="検索">
          </div>

        </form>
      </div>

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
            <?php foreach ($result as $row) { ?>
              <tr>
                <td><?= htmlspecialchars($row["product_no"], ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($row["pname"], ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($row["category"], ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($row["price"], ENT_QUOTES, 'UTF-8') ?></td>
                <td><a class="btn btn-primary"
                    href="kadai11_1.php?product_no=<?= $row["product_no"] ?>">編集</a></td>
                <td>
                  <a class="btn btn-secondary"
                    href="kadai11_3.php?product_no=<?= htmlspecialchars($row["product_no"], ENT_QUOTES, 'UTF-8') ?>">
                    削除</a>
                </td>
                <!-- <td><a class="btn btn-secondary" href="">削除</a></td> -->
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>


  <script>
    /* 本来は別ファイルに分けた方が良い */
    window.onload = (event) => {
      /* TODO:配布ファイル用　処理（ラジオボックスの値保持前のために実装） */
      // TODO:値保持の実装をしたらコメントアウト可。（このままでも支障なし）
      const chkBox = document.getElementsByName('searchType');
      if (chkBox[0].checked == false && chkBox[1].checked == false)
        chkBox[0].checked = true;
      /* TODO:ここまで */
      typeCheck();
    }

    function typeCheck() {
      const chk = document.querySelector("input[name='searchType']:checked").value;
      console.log(chk);
      const priceBox = document.getElementById("price");
      const categoryBox = document.getElementById("category");

      if (chk == 1) {
        categoryBox.disabled = true;
        priceBox.disabled = false;
        categoryBox.value = 1;
      } else if (chk == 2) {
        categoryBox.disabled = false;
        priceBox.disabled = true;
        priceBox.value = "";
      }
    }
  </script>