<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");

include_once "../config/database.php";
$method = $_SERVER['REQUEST_METHOD'];
switch ($method) {

// ======================
// GET (อ่านข้อมูลทั้งหมด)
// ======================
case 'GET':

$sql = "SELECT * FROM products";
$result = $conn->query($sql);

$products = [];
while ($row = $result->fetch_assoc()) {
$products[] = $row;
}

echo json_encode($products);
break;

// ======================
// POST (เพิ่มข้อมูล)
// ======================
case 'POST':

$data = json_decode(file_get_contents("php://input"));

$sql = "INSERT INTO products (product_name, price)
VALUES ('$data->product_name', '$data->price')";
if ($conn->query($sql)) {
echo json_encode([
"status" => 201,
"message" => "Product created successfully"
]);
}

break;

// ======================
// PUT (แก้ไขข้อมูล)
// ======================
case 'PUT':

$data = json_decode(file_get_contents("php://input"));
$sql = "UPDATE products
SET product_name='$data->product_name',
price='$data->price'
WHERE id=$data->id";

if ($conn->query($sql)) {
echo json_encode([
"status" => 200,
"message" => "Product updated successfully"
]);
}

break;

// ======================
// DELETE (ลบข้อมูล)
// ======================
case 'DELETE':

$data = json_decode(file_get_contents("php://input"));
$sql = "DELETE FROM products WHERE id=$data->id";

if ($conn->query($sql)) {
echo json_encode([
"status" => 200,
"message" => "Product deleted successfully"
]);
}

break;

default:
echo json_encode([
"status" => 400,
"message" => "Invalid request"
]);
}
?>