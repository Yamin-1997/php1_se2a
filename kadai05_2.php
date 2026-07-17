<?php

require_once __DIR__ . "/def.php";
require_once __DIR__ . "/utils.php";

/*POSTでデータが送信されていなかったら、kadai05_1.phpへ戻る */
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
  header("Location: kadai05_1.php");
  exit;
}

/* 結果格納用の連想配列 */
// to save result if there is message or file this file are null
$result = [
  "status"  => true,
  "message" => null,
  "file"    => null,
];

/* 送信されたファイルデータを変数に格納 */
//to save upload file
$upfile = $_FILES["upfile"] ?? null;

/*ファイルエラー処理 */
//file error check
if ($upfile === null) {
  $result["status"]  = false;
  $result["message"] = "ファイルが送信されていません。";
} elseif ($upfile["error"] !== UPLOAD_ERR_OK) {
  $result["status"] = false;
  switch ($upfile["error"]) {
    case UPLOAD_ERR_INI_SIZE:
    case UPLOAD_ERR_FORM_SIZE:
      $result["message"] = "ファイルのサイズが⼤きすぎます";
      break;
    case UPLOAD_ERR_PARTIAL:
      $result["message"] = "通信環境が良くなってからもう一度お試しください。";
      break;
    case UPLOAD_ERR_NO_FILE:
      $result["message"] = "ファイルがありません。";
      break;
    default:
      $result["message"] = "システムの復旧後に再度アップロードしてください。";
      break;
  }
} else {
  /*アップロード処理 */
  $upload_dir = __DIR__ . "/upload/";
  if (!file_exists($upload_dir)) {
    mkdir($upload_dir, 0777, true);
  }

  $filename = basename($upfile["name"]);
  $save_path = $upload_dir . $filename;

  $tmp_path = $upfile["tmp_name"];
  $image_info = @getimagesize($tmp_path); // 画像の場合は配列、非画像なら false
  if ($image_info === false) {
    $result["status"]  = false;
    $result["message"] = "画像ファイルではありません。";
  } else {
    // move_uploaded_fileで移動
    if (move_uploaded_file($upfile["tmp_name"], $save_path)) {
      $result["status"]  = true;
      $result["message"] = "ファイルのアップロードに成功しました。";
      $result["file"]    = "upload/" . $filename;
    } else {
      $result["status"]  = false;
      $result["message"] = "ファイルのアップロードに失敗しました。";
    }
  }
}

?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <title>php1 - kadai05_2</title>
  <link href="css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
  <div class="w-100">
    <header class="bg-info text-light ms-3 pt-4 pb-3">
      <h1 class="h6">サーバーサイドスクリプト演習１</h1>
      <h2 class="pt-3">画像のアップロード結果</h2>
    </header>

    <main>
      <div class="form-control">
        <h3 class="border-bottom border-3 border-info mb-4 mt-2 pb-2">アップロード結果</h3>

        <div id="frame" class="p-5 border-info rounded" style="border:1px dashed;">
          <div class="text-center">
            <?php if ($result["status"] === true && !empty($result["file"])) : ?>
              <figure class="d-inline-block me-1 mt-1 mb-5">
                <img src="<?= ($result["file"]) ?>" class="img-thumbnail" style="max-height:200px;">
              </figure>
              <p class="text-success"><?= ($result["message"]) ?></p>
            <?php else : ?>
              <p class="text-danger"><?= ($result["message"]) ?></p>
            <?php endif; ?>
          </div>
        </div>

        <div class="text-center mt-4">
          <a class="btn btn-secondary btn-lg" href="kadai05_1.php">戻る</a>
        </div>
      </div>
    </main>
  </div>
</body>

</html>