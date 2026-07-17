<?php

// api/login.php

require '../config/db.php';

require '../utils/response.php';

$data = json_decode(file_get_contents("php://input"), true);

if (empty($data['email']) || empty($data['password'])) {

    error("メールアドレスとパスワードを入力してください");
}

$db = (new DB())->connect();

$stmt = $db->prepare("SELECT * FROM employees WHERE email = :email");

$stmt->execute([':email' => $data['email']]);

$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user || !password_verify($data['password'], $user['password'])) {

    error("ログイン失敗");
}

session_start();

$_SESSION['user_id'] = $user['id'];

$_SESSION['role'] = $user['role'];

success([

    "message" => "ログイン成功",

    "user" => [

        "id" => $user['id'],

        "name" => $user['name'],

        "role" => $user['role']

    ]

]);
