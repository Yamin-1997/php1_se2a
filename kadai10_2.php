<?php

require_once __DIR__ . "/def.php";

// TODO:各入力値チェック用配列-------------------
$result = [
  "status"  => true,
  "message" => null,
  "result"  => null,
];


//商品名の空白文字を置き換え
$pname = trim($_POST["pname"] ?? '');
$price = $_POST["price"] ?? '';
$category = $_POST["category"] ?? '';




//商品名が空かどうかのチェック
if (empty($pname)) {
  $result["status"]  = false;
  $result["message"] = "商品名が入力されていません。<br>";
}

//価格が空かどうかのチェック
if (empty($price)) {
  $result["status"]  = false;
  $result["message"] = $result["message"] . "価格が入力されていません。";
}

//エラーがなかったとき（条件つける）

if ($result["status"] === true) {
  //DB接続
  //   $db = dbConnect();
  // }


  //カテゴリのコードからカテゴリ名に置き換え
  if ($category == "1") {
    $category = "ピザ";
  } elseif ($category == "2") {
    $category = "ドリンク";
  }

  try {

    //DB登録処理ここから開始
    $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
    $db = new PDO($dsn, DB_USER, DB_PASS);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // トランザクション開始
    $db->beginTransaction();
    $sql = "INSERT INTO " . TBL_PRODCUT . " (pname, price, category) VALUES (:pname, :price, :category)";
    $stmt = $db->prepare($sql);

    $stmt->bindValue(":pname", $pname, PDO::PARAM_STR);
    $stmt->bindValue(":price", $price, PDO::PARAM_INT);
    $stmt->bindValue(":category", $category, PDO::PARAM_STR);

    //executeの結果は$result配列に格納
    $result["result"] = $stmt->execute();

    // トランザクション確定
    $db->commit();

    if ($result["result"] === true) {
      $result["message"] = "登録が完了しました。";
    }

    //登録完了の場合、完了メッセージを格納。
  } catch (PDOException $poe) {
    // トランザクション取り消し
    $db->rollBack();
    $result["status"]  = false;
    $result["message"] = "データベース登録に失敗しました。";
    exit("DBエラー：" . $poe->getMessage());
  }
}
//DB切断
$db = null;

?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>php1 - kadai10_2</title>
  <link href="css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
  <div class="w-100">

    <!-- ▼▼ヘッダー▼▼--------------------------------- -->
    <header class="bg-info">
      <div class="text-light ms-3 pt-4 pb-3">
        <h1 class="h6">サーバーサイドスクリプト演習１</h1>
        <h2 class="pt-3">データベース登録結果</h2>
      </div><!--/.container-->
    </header>
    <!-- ▲▲ヘッダー▲▲--------------------------------- -->

    <!-- ▼▼メイン▼▼----------------------------------- -->
    <main>

      <div class="form-control">

        <h3 class="border-bottom border-3 border-info mb-4 mt-2 pb-2">データベース登録結果</h3>

        <div id="frame" class="p-5 border-info rounded" style="border:1px dashed;">

          <!-- 処理結果表示 -->
          <div class="text-center">


            <p class="text-danger"><?php echo $result["message"]; ?></p>
          </div>
        </div>

        <div class="p-5 d-grid gap-2 d-md-flex justify-content-md-end">
          <a class="btn btn-secondary btn-lg" href="kadai10_1.php">戻る</a>
        </div>

      </div>
    </main>

  </div><!--/.w100-->

</body>

</html>