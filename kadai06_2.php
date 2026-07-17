<?php

require_once __DIR__ . "/def.php";
require_once __DIR__ . "/utils.php";
require_once __DIR__ . "/kadai06_resource.php";

$productID = filter_input(
  INPUT_GET,
  "product_id",
  FILTER_VALIDATE_INT
); //to know in 6-1 which product user click 
//get parameter

if (!$productID) {
  header("Location: kadai06_1.php");
  exit;
} // if threr is no produt id go back to 6-1

$item = null; // to search product and save 
//

foreach ($products as $p) {

  if ($p["id"] == $productID) {
    $item = $p;
    break;
  }
}
// if threr is no product go back to 6-1
if (empty($item)) {
  header("Location: kadai06_1.php");
  exit;
}

$browsed = [];
if (isset($_COOKIE["php1_kadai06"])) {
  $browsed = explode(",", $_COOKIE["php1_kadai06"]);
}

$browsed[] = $productID;


// if (!in_array($productID, $browsed)) {
//   $browsed[] = $productID;
// }


// setckookie --> viewed product hostory save broser cookie
setcookie(
  "php1_kadai06",
  implode(",", $browsed),
  time() + 60
);
?>
<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- TODO:Bootstrap読み込み -->
  <!-- link -->
  <link href="./css/bootstrap.min.css" rel="stylesheet">

  <title>php1 - kadai06_2</title>
</head>

<body>
  <!-- ▼▼ヘッダー▼▼--------------------------------- -->
  <header class="bg-info">
    <div class="text-light ms-5 pt-5 pb-3">
      <h1 class="h6">サーバーサイドスクリプト演習１</h1>
      <h2 class="pt-3">クッキー</h2>
    </div><!--/.text-light ms-5 pt-5 pb-3-->
  </header>
  <!-- ▲▲ヘッダー▲▲--------------------------------- -->

  <!-- ▼▼メイン▼▼----------------------------------- -->
  <main>
    <div class="container-field">
      <form action="kadai06_1.php" method="GET" novalidate>
        <h2 class="p-5 d-grid gap-2 d-md-flex border-bottom" style="border-color:deeppink;">取り扱い商品の詳細</h2>
        <div class="p-5 row">
          <div class="col-md-7">
            <!-- 画像 -->
            <figure class="img-fluid"><img class="" style="width:100%;"
                src="./asset/images/<?= $item["thumbnail"]["large"] ?>"></figure>
          </div>

          <div class="col-md-3">
            <div class="row">
              <h3><?= $item["name"] ?></h3>
              <p><?= $item["description"] ?? "商品説明がここに入ります。" ?></p>
              <p style="color:deeppink;">
                ¥<?= number_format($item["price"]) ?>
              </p>

              <a class="mt-5 btn btn-secondary" href="kadai06_1.php">一覧に戻る</a>
            </div>

          </div>
        </div>

    </div>
  </main>
  <!-- ▲▲メイン▲▲----------------------------------- -->
</body>

</html>