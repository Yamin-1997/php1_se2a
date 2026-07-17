<?php
session_start();
// require __DIR__ . '/../../config/dbconnect.php';
// require __DIR__ . '/../utils/functions.php';
var_dump(file_exists(__DIR__ . '/../config/dbconnect.php'));
exit;

// エラー・デバッグメッセージ用
$response = [];

// フォームから社員IDとパスワードのバリデーション
if (!$userId = filter_input(INPUT_POST, "employee_code")) {
    // 🔴 FIX: typo (`くだ`さい → ください)
    $response[] = "正しい社員IDを入力してください。";
}
if (!$password = filter_input(INPUT_POST, "password")) {
    $response[] = "パスワードを入力してください。";
}

// 🔴 入力エラーがあればここで戻す
if (count($response) > 0) {
    $_SESSION['error'] = $response; // ← arrayで保存（OK）
    header('Location: ../index.php?error=login');
    exit;
}

$arr = [];
$arr[] = $userId;

$sql = "SELECT * FROM users WHERE employee_code = ?";
$stmt = connect()->prepare($sql); // ⚠️ connect() がPDO返してるか確認
$stmt->execute($arr);

$user = $stmt->fetch();

//  FIX: $user がないのに password_verify するとFatal error
if (!$user) {
    $response[] = "社員IDが間違いました。もう一度やり直してください。";
} else {
    //  userがある場合だけ実行（重要）
    if (!password_verify($password, $user['password'])) {
        $response[] = "パスワードが間違いました。もう一度やり直してください。";
    }
}

//  認証エラーがあれば戻す
if (count($response) > 0) {
    $_SESSION['error'] = $response;
    header('Location: ../index.php?error=login');
    exit;
}

// セキュリティー対策
session_regenerate_id(true);
unset($user['password']);

$_SESSION['employee_code'] = $user['employee_code'];
$_SESSION['role_id'] = $user['role_id'];

header('Location: ../reports.php');
exit;

?>


// デバッグ用
// success([
// "message" => "ログイン成功",
// "user" => [
// "id" => $user['employee_code'],
// "name" => $user['uname'],
// "role_id" => $user['role_id']
// ]
// ]);