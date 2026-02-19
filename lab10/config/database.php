<?php
$host = "localhost";
$username = "it67040233141";
$password = "K3D2H5I4";
$db = "it67040233141";

$conn = new mysqli($host, $username, $password, $db);
if ($conn->connect_error) {
die(json_encode([
"status" => 500,
"message" => "Database connection failed"
]));
}
?>