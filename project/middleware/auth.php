<?php
// middleware/auth.php

session_start();

if (!isset($_SESSION['user_id'])) {
    echo json_encode([
        "status" => "error",
        "message" => "認証エラー"
    ]);
    exit;
}
