<?php

$lecture = "PHP";
$time = "3/4時間目";
$feedback = " 興味があります。";



?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>

<body>
    <header class="bg-dark">
        <div class="text-light ms-5 pt-5 pb-3">
            <h1 class="h6">サーバーサイドスクリプト演習１</h1>
            <h2 class="pt-3">bootstrap読み込み試作</h2>
        </div><!--/.container-->
    </header>


    <h1>20.4.2026 monday :<?= $time ?></h1>
    <h2>セーバーサイドスクリプトI ：<?= $lecture ?></h2>
    <p><?= $feedback ?></p>
</body>

</html>