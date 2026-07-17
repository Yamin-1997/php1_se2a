<?php

// api/update_safety.php

require '../middleware/auth.php';

require '../config/db.php';

require '../utils/response.php';

$data = json_decode(file_get_contents("php://input"), true);

if (empty($data['id'])) {

    error("IDが必要です");
}

$db = (new DB())->connect();

$sql = "UPDATE safety_reports

        SET status = :status,

            injury = :injury,

            can_work = :can_work,

            comment = :comment

        WHERE id = :id AND employee_id = :employee_id";

$stmt = $db->prepare($sql);

$stmt->execute([

    ':status' => $data['status'],

    ':injury' => $data['injury'] ?? '',

    ':can_work' => $data['can_work'] ?? 0,

    ':comment' => $data['comment'] ?? '',

    ':id' => $data['id'],

    ':employee_id' => $_SESSION['user_id']

]);

success("更新しました");
