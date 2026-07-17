<?php

// api/get_safety_list.php

require '../middleware/auth.php';

require '../config/db.php';

require '../utils/response.php';

$db = (new DB())->connect();

if ($_SESSION['role'] === 'admin') {

    $sql = "SELECT e.name, s.*

            FROM safety_reports s

            JOIN employees e ON e.id = s.employee_id

            ORDER BY s.created_at DESC";

    $stmt = $db->query($sql);
} else {

    $sql = "SELECT e.name, s.*

            FROM safety_reports s

            JOIN employees e ON e.id = s.employee_id

            WHERE e.department_id = (

                SELECT department_id FROM employees WHERE id = :id

            )

            ORDER BY s.created_at DESC";

    $stmt = $db->prepare($sql);

    $stmt->execute([':id' => $_SESSION['user_id']]);
}

$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

success($data);
