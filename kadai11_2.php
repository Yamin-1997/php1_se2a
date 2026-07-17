<?php

//必要ファイルがあれば、読み込むこと
require_once __DIR__ . "/def.php";
require_once __DIR__ . "/utils.php";

// リクエストがPOST形式でなければ、kadai08_1に戻って、処理終了

if (empty($product_no)) {
  header("Location: kadai08_1.php");
  exit;
}

// エラーメッセージ配列
$errMsg = [];

// POSTデータ取得
$postData = filter_input_array(INPUT_POST);
$postData["product_no"] = filter_input(INPUT_POST, "product_no");
$postData["pname"]      = filter_input(INPUT_POST, "pname");
$postData["price"]      = filter_input(INPUT_POST, "price", FILTER_VALIDATE_INT);
$postData["category"]   = filter_input(INPUT_POST, "category");

// 入力データのtrim処理
foreach ($postData as $key => $value) {
  if (is_string($value)) {
    $postData[$key] = trim($value);
  }
}

// 入力データチェック
if (empty($postData["pname"])) {
  $errMsg[] = "商品名が入力されていません。";
}
if (empty($postData["price"])) {
  $errMsg[] = "価格が入力されていません。";
}
// エラーがなければDB更新
if (count($errMsg) == 0) {

  try {

    $dsn = "mysql:host=" . DB_HOST .
      ";dbname=" . DB_NAME .
      ";charset=" . DB_CHARSET;

    $db = new PDO($dsn, DB_USER, DB_PASS);

    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

    // 
    $sql = "UPDATE " . TBL_PRODCUT . "
        SET pname = :pname,
            price = :price,
            category = :category
        WHERE product_no = :product_no";

    $stmt = $db->prepare($sql);

    $stmt->bindValue(":pname", $postData["pname"], PDO::PARAM_STR);
    $stmt->bindValue(":price", $postData["price"], PDO::PARAM_INT);
    $stmt->bindValue(":category", $postData["category"], PDO::PARAM_STR);
    $stmt->bindValue(":product_no", $postData["product_no"], PDO::PARAM_INT);



    $result = $stmt->execute();
    // トランザクション確定
    // $db->commit();

    $stmt = null;
    $db = null;
  } catch (PDOException $e) {
    if ($db->inTransaction()) {
      $db->rollBack();
    }
    exit("DBエラー：" . $e->getMessage());
  }
}


?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>kadai11_2 更新結果</title>
  <link href="css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
  <!-- ▼▼ヘッダー▼▼--------------------------------- -->
  <header class="bg-info">
    <div class="text-light ms-5 pt-5 pb-3">
      <h1 class="h6">サーバーサイドスクリプト演習１</h1>
      <h2 class="pt-3">データベース更新結果</h2>
    </div><!--/.text-light ms-5 pt-5 pb-3-->
  </header>
  <!-- ▲▲ヘッダー▲▲--------------------------------- -->

  <!-- ▼▼メイン▼▼----------------------------------- -->
  <main>
    <div class="form-control">

      <div class="p-5 row">
        <div class="col-md-5">
          <!-- エラーメッセージ -->
          <div class="col">
            <p class="text-danger">
              <?php if (!empty($errMsg)) : ?>

            <div class="alert alert-danger">
              <?php foreach ($errMsg as $msg) : ?>
                <?= h($msg) ?><br>
              <?php endforeach; ?>
            </div>

          <?php elseif (isset($result) && $result) : ?>

            <div class="alert alert-success">
              更新しました。
            </div>

          <?php endif; ?>
          </p>
          </div><!-- .col -->

          <!-- 戻るボタン（入力画面に戻る） -->
          <div class="p-5 d-grid gap-2 d-md-flex justify-content-md-start">
            <a class="btn btn-secondary btn-lg" href="kadai08_1.php">戻る</a>
          </div><!-- .p-5 d-grid gap-2 d-md-flex justify-content-md-end -->

        </div><!-- .col-md-5 -->

      </div><!-- .p-5 row -->
    </div><!--/.form-control-->
  </main>
  <!-- ▲▲メイン▲▲------------------------------------ -->

</body>

</html>