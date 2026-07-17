<?php
$fruits = [
    "apple" => 220,
    "banana" => 110,
    "strawberrt" => 490,
    "grape" => 550,
    "kiwi" => 160,
];

echo "<pre>";
var_dump($fruits);
echo "</pre>";

$vegetables = [
    "cabbage" => 130,
    "carrot" => 80,
    "greenPapper" => 120,
    "eggplaint" => 160,
    "punpkin" => 240,
];

echo "<pre>";
var_dump($vegetables);
echo "</pre>";
echo "<hr>"; // လိုင်းတားပြီး ခွဲခြားပြသခြင်း

$food = [
    "fruits" => $fruits,
    "vege" => $vegetables
];

echo "<pre>";
var_dump($food);
echo "</pre>";
echo "<hr>"; // လိုင်းတားပြီး ခွဲခြားပြသခြင်း

foreach ($fruits as $name => $price) {
    echo "{$name}: {$price}円<br>";
}

echo "---<br>";

foreach ($food as $type => $data) {

    echo "■種別: {$type}<br>";

    foreach ($data as $name => $price) {

        echo "商品名: {$name} / 価格: {$price}円<br>";
    }

    echo "---<br>";
}
