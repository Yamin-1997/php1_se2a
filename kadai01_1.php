
<?php

$total;		// 合計額の格納用の変数
$price = 1200;	// 価格を格納した変数
$tax = '1.1';// 消費税を格納した変数　
// ※ただし、シングルコーテーションで囲んでいるので文字列


echo gettype($tax).'<br>';
$total = $price * $tax;	// 価格×消費税を変数$totalに格納

echo $total;		// 画面出力 echo
?>