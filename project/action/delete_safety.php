<?php

// api/delete_safety.php

require '../middleware/auth.php';

require '../config/db.php';

require '../utils/response.php';

if ($_SESSION['role'] !== 'admin') {

    error("削除権限がありません");
}

$data = json_decode(file_get_contents("php://input"), true);

if (empty($data['id'])) {

    error("IDが必要です");
}

$db = (new DB())->connect();

$stmt = $db->prepare("DELETE FROM safety_reports WHERE id = :id");

$stmt->execute([':id' => $data['id']]);

success("削除しました");
