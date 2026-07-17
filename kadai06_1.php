<?php

require_once __DIR__ . "/kadai06_resource.php";
//to show array

$browsed = [];
if (isset($_COOKIE["php1_kadai06"])) {
  $browsed = explode(",", $_COOKIE["php1_kadai06"]);
}
?>


<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- TODO:Bootstrap読み込み -->
  <!-- link -->
  <link href="./css/bootstrap.min.css" rel="stylesheet">

  <title>php1 - kadai06_1</title>
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
      <h2 class="p-5 d-grid gap-2 d-md-flex">取り扱いクッキー</h2>
      <div class="row" style="border-top: 2px solid hotpink;">

        <!-- TODO:kadai06_resourceファイルの情報を読み込み -->
        <?php foreach ($products as $product):  ?>
          <!-- all product to do loop -->
          <div class="col-sm-3 p-3">
            <div class="card h-100 shadow-sm" style="max-width:25rem;">
              <a class="link-secondary" style="text-decoration:none;"
                href="kadai06_2.php?product_id=<?php echo $product["id"]; ?>">

                <img class="img-fluid img-thumbnail h-50" style="width:100%;"
                  src="./asset/images/<?= $product["thumbnail"]["small"] ?>">

                <div class="card-body">
                  <p class="card-text">
                    <?php echo $product["name"]; ?>
                    <!-- to show product name -->
                  </p>
                  <p class="card-text" style="color:hotpink;">
                    ¥<?php echo number_format($product["price"]); ?>
                    <!-- to show product price -->
                  </p>
                </div>
              </a>
            </div>
          </div>
        <?php endforeach; ?>



      </div>

      <div class="row">
        <h2 class="p-5 d-grid gap-2 d-md-flex" style="border-bottom: 2px solid hotpink;">閲覧したクッキー</h2>
        <div class="col m-3" style="display: flex; overflow:auto;">

          <!-- TODO:閲覧したクッキー情報を表示する -->
          <?php

          if (isset($_COOKIE["php1_kadai06"])) {

            // Cookieを配列に変換
            $historyIds = explode(",", $_COOKIE["php1_kadai06"]);

            // 重複削除
            $historyIds = array_unique($historyIds);

            // 履歴ループ
            foreach ($historyIds as $historyId) {

              // 商品検索
              foreach ($products as $product) {

                if ($product["id"] == $historyId) {

          ?>


                  <div class="card m-3" style="max-width:10rem; min-width:10rem;">
                    <a class="link-secondary" style="text-decoration:none;" href="kadai06_2.php?product_id=<?= $product["id"] ?>">

                      <img class="img-fluid img-thumbnail h-50" style="width:100%;"
                        src="./asset/images/<?= $product["thumbnail"]["small"] ?>">
                      <!-- to show image -->
                      <div class="card-body">
                        <p class="card-text"></p>
                        <p class="card-text" style="color:hotpink;">
                          ¥<?php echo number_format($product["price"]); ?></p>
                      </div>
                    </a>
                  </div>
          <?php
                }
              }
            }
          }
          ?>


        </div>

      </div>

    </div>
  </main>
  <!-- ▲▲メイン▲▲----------------------------------- -->
</body>

</html>