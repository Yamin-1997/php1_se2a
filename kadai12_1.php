<?php
require "./lib/vendor/autoload.php";
$zipcode = $_GET["zipcode"] ?? '';
$url = "https://zipcloud.ibsnet.co.jp/api/search?zipcode=" . $zipcode;
$json = file_get_contents($url);
$response = json_decode($json, true);

$cli = new GuzzleHttp\Client([
    //instance of GuzzleHttp\Client
    'base_uri' => 'https://zipcloud.ibsnet.co.jp/api/', //外部apiのURL
]);

$res = $cli->request(
    'get',
    '/api/search',
    [
        'query' => [
            'zipcode' => $zipcode,
        ],
        "verify" => false, //開発用環境なので、証明書の検証をオフにする（
    ]
);

$response = json_decode($res->getBody(), true); ////JSONデータを連想配列に変換

// echo "<pre>";
// print_r($response);
// echo "<pre>";
//todo 表示用の文字列を編集
$address = '';
if ($response["message"] !== null) {
    $address = $response["message"];
} elseif ($response["results"] == null) {
    $address = "該当する住所がありません";
} else {
    $address =
        $response["results"][0]["address1"] .
        $response["results"][0]["address2"] .
        $response["results"][0]["address3"];
}
?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>kadai12_1 JSONデータ</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <!-- ▼▼ヘッダー▼▼--------------------------------- -->
    <header class="bg-info">
        <div class="text-light ms-5 pt-5 pb-3">
            <h1 class="h6">サーバーサイドスクリプト演習１</h1>
            <h2 class="pt-3">外部APIからJSONデータを取得する</h2>
        </div><!--/.text-light ms-5 pt-5 pb-3-->
    </header>
    <!-- ▲▲ヘッダー▲▲--------------------------------- -->

    <!-- ▼▼メイン▼▼----------------------------------- -->
    <main>
        <div class="form-control">

            <div class="p-5 row">
                <div class="col-md-5">
                    <form action="" method="" class="">

                        <!-- 検索 -->
                        <div class="input-group mb-3">
                            <span class="input-group-text">郵便番号</span>
                            <input type="text" class="form-control" name="zipcode" id="zipcode" value="<?= htmlspecialchars($zipcode) ?>">

                        </div>
                        <div class="input-group mb-3">
                            <!-- 住所 -->
                            <div class="col">
                                <p class="text-danger">
                                    住所：<?= htmlspecialchars($address) ?>

                                </p>
                            </div><!-- .col -->
                        </div>

                        <div class="row">
                            <div class="pt-5 px-0 d-grid gap-2 d-md-flex justify-content-md-end">
                                <input class="btn btn-primary btn-lg" type="submit" value="検索">
                            </div><!-- .p-5 d-grid gap-2 d-md-flex justify-content-md-end -->
                        </div><!-- .row -->

                    </form>

                </div><!-- .col-md-5 -->

            </div><!-- .p-5 row -->
        </div><!--/.form-control-->
    </main>
    <!-- ▲▲メイン▲▲------------------------------------ -->

</body>

</html>