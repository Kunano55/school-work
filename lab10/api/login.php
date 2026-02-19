<?php
session_start();
header("Content-Type: application/json");
include_once "../config/database.php";

// Handle logout
if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    session_destroy();
    echo json_encode(["status" => 200, "message" => "ออกจากระบบสำเร็จ"]);
    exit;
}

// Handle login
$data = json_decode(file_get_contents("php://input"));
$username = $conn->real_escape_string($data->username);
$password = $data->password;

$sql = "SELECT * FROM Users WHERE username = '$username'";
$result = $conn->query($sql);

if ($row = $result->fetch_assoc()) {
    // ตรวจสอบรหัสผ่านที่ Hash ไว้ใน DB
    if (password_verify($password, $row['password'])) {
        $_SESSION['admin_id'] = $row['id'];
        $_SESSION['admin_user'] = $row['username'];
        echo json_encode(["status" => 200, "message" => "สำเร็จ"]);
        exit;
    }
}
echo json_encode(["status" => 401, "message" => "Username หรือ Password ไม่ถูกต้อง"]);
?>