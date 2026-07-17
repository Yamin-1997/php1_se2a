<?php

// utils/response.php
//success() → အောင်မြင်တဲ့အခါ return ပြန်ပေးတယ်
function success($data = [])
{

    echo json_encode([

        "status" => "success",

        "data" => $data

    ]);
}

function error($message)
{

    echo json_encode([

        "status" => "error",

        "message" => $message

    ]);

    exit;
}
