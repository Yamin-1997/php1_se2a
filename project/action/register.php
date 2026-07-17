<?php

// api/register_safety.php

require '../middleware/auth.php';

require '../config/db.php';

require '../utils/response.php';

$data = json_decode(file_get_contents("php://input"), true);

if (empty($data['status'])) {

    error("安否状況は必須です");
}

$db = (new DB())->connect();

$sql = "INSERT INTO safety_reports 

(employee_id, status, injury, can_work, comment)

VALUES (:employee_id, :status, :injury, :can_work, :comment)";

$stmt = $db->prepare($sql);

$stmt->execute([

    ':employee_id' => $_SESSION['user_id'],

    ':status' => $data['status'],

    ':injury' => $data['injury'] ?? '',

    ':can_work' => $data['can_work'] ?? 0,

    ':comment' => $data['comment'] ?? ''

]);

success("安否情報を登録しました");
