<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");

include_once "../config/database.php";
$method = $_SERVER['REQUEST_METHOD'];

$base_storage_path = "../"; 

switch ($method) {

    case 'GET':
        $sql = "SELECT * FROM CatBreeds2";
        $result = $conn->query($sql);
        $breeds = [];
        while ($row = $result->fetch_assoc()) {
            if (!empty($row['image_url'])) {
                $row['image_url'] = "api/" . $base_storage_path . $row['image_url'];
            }
            $breeds[] = $row;
        }
        echo json_encode($breeds);
        break;

    case 'POST':
        $id = $_POST['id'] ?? null; 
        $name_th = $_POST['name_th'] ?? '';
        $name_en = $_POST['name_en'] ?? '';
        $description = $_POST['description'] ?? '';
        $characteristics = $_POST['characteristics'] ?? '';
        $care_instructions = $_POST['care_instructions'] ?? '';
        $is_visible = $_POST['is_visible'] ?? 1;
        
        // ค่ารูปเดิมจาก Hidden Input
        $image_db_path = $_POST['image_url'] ?? ''; 

        // 1. ถ้ามีการอัปโหลดไฟล์ภาพใหม่เข้ามา
        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $folder_name = "uploads/";
            
            // --- ส่วนที่เพิ่ม: ลบรูปภาพเดิมถ้าเป็นการแก้ไข (Update) ---
            if (!empty($id)) {
                $res = $conn->query("SELECT image_url FROM CatBreeds2 WHERE id = $id");
                if ($row = $res->fetch_assoc()) {
                    $old_file = $base_storage_path . $row['image_url'];
                    if (!empty($row['image_url']) && file_exists($old_file)) {
                        unlink($old_file); // ลบไฟล์เก่าทิ้ง
                    }
                }
            }
            // --------------------------------------------------

            $file_name = time() . "_" . basename($_FILES["image"]["name"]);
            $full_upload_path = $base_storage_path . $folder_name . $file_name;

            if (move_uploaded_file($_FILES["image"]["tmp_name"], $full_upload_path)) {
                $image_db_path = $folder_name . $file_name;
            }
        }

        if (!empty($id)) {
            $sql = "UPDATE CatBreeds2 SET 
                    name_th = '$name_th', 
                    name_en = '$name_en', 
                    description = '$description', 
                    characteristics = '$characteristics', 
                    care_instructions = '$care_instructions', 
                    image_url = '$image_db_path', 
                    is_visible = '$is_visible' 
                    WHERE id = $id";
            $message = "Updated successfully";
        } else {
            $sql = "INSERT INTO CatBreeds2 (name_th, name_en, description, characteristics, care_instructions, image_url, is_visible) 
                    VALUES ('$name_th', '$name_en', '$description', '$characteristics', '$care_instructions', '$image_db_path', '$is_visible')";
            $message = "Created successfully";
        }

        if ($conn->query($sql)) {
            echo json_encode(["status" => 200, "message" => $message]);
        } else {
            echo json_encode(["status" => 500, "message" => "Database error"]);
        }
        break;

    case 'DELETE':
        $data = json_decode(file_get_contents("php://input"));
        $id = $data->id;

        // ลบไฟล์รูปภาพออกจาก Server ก่อนลบข้อมูลใน DB
        $res = $conn->query("SELECT image_url FROM CatBreeds2 WHERE id = $id");
        if ($row = $res->fetch_assoc()) {
            $file_to_delete = $base_storage_path . $row['image_url'];
            if (!empty($row['image_url']) && file_exists($file_to_delete)) {
                unlink($file_to_delete); // ลบไฟล์
            }
        }

        $sql = "DELETE FROM CatBreeds2 WHERE id = $id";
        if ($conn->query($sql)) {
            echo json_encode(["status" => 200, "message" => "Deleted successfully"]);
        }
        break;
}
?>