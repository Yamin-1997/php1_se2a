<?php

$fruits = ['りんご', 'バナナ', 'イチゴ', 'ふどう', 'キウイ'];
$vegetables = ['キャンペーン', '人参', 'ピーマン', 'なつ', 'かぼうちゃ'];

echo "<pre>";
var_dump($fruits);
var_dump($vegetables);
echo "</pre>";
echo "<hr>"; // လိုင်းတားပြီး ခွဲခြားပြသခြင်း



$food = [$fruits, $vegetables];

echo "<pre>";
var_dump($food);
echo "</pre>";



echo '$food 2行3列目は、' . $food[1][2] . 'です';



?>




<!-- foreach ($fruits as $name => $price) {

echo " {$name}:{$price};円<br>";

} -->