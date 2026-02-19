<?php
session_start();
header("Content-Type: application/json");

if (isset($_SESSION['admin_id'])) {
    echo json_encode([
        "status" => 200, 
        "username" => $_SESSION['admin_user']
    ]);
} else {
    http_response_code(401);
    echo json_encode(["status" => 401, "message" => "Unauthorized"]);
}
?>