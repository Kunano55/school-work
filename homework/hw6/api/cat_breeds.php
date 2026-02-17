<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");

include_once "../config/database.php";
$method = $_SERVER['REQUEST_METHOD'];

$base_storage_path = "../"; 

switch ($method) {

    // ==========================================
    // GET: ดึงข้อมูลจาก CatBreeds2
    // ==========================================
    case 'GET':
        $sql = "SELECT * FROM CatBreeds2"; // เปลี่ยนชื่อตาราง
        $result = $conn->query($sql);

        $breeds = [];
        while ($row = $result->fetch_assoc()) {
            // เติม Path รูปภาพให้ Frontend เรียกใช้ได้
            if (!empty($row['image_url'])) {
                // ส่ง Path ที่ Frontend นำไปใส่ src ได้เลย
                $row['image_url'] = "api/" . $base_storage_path . $row['image_url'];
            }
            $breeds[] = $row;
        }

        echo json_encode($breeds);
        break;

    // ==========================================
    // POST: เพิ่มและแก้ไขข้อมูล (CatBreeds2)
    // ==========================================
    case 'POST':
        $id = $_POST['id'] ?? null; 
        $name_th = $_POST['name_th'] ?? '';
        $name_en = $_POST['name_en'] ?? '';
        $description = $_POST['description'] ?? '';
        $characteristics = $_POST['characteristics'] ?? '';
        $care_instructions = $_POST['care_instructions'] ?? '';
        $is_visible = $_POST['is_visible'] ?? 1;
        
        $image_db_path = $_POST['image_url'] ?? ''; 

        // --- ส่วนจัดการอัปโหลดไฟล์ ---
        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $folder_name = "uploads/";
            
            // สร้างโฟลเดอร์ uploads ถ้ายังไม่มี
            if (!file_exists($base_storage_path . $folder_name)) {
                mkdir($base_storage_path . $folder_name, 0777, true);
            }

            $file_name = time() . "_" . basename($_FILES["image"]["name"]);
            $full_upload_path = $base_storage_path . $folder_name . $file_name;

            if (move_uploaded_file($_FILES["image"]["tmp_name"], $full_upload_path)) {
                $image_db_path = $folder_name . $file_name;
            }
        }

        if (!empty($id)) {
            // UPDATE: CatBreeds2
            $sql = "UPDATE CatBreeds2 SET 
                    name_th = '$name_th', 
                    name_en = '$name_en', 
                    description = '$description', 
                    characteristics = '$characteristics', 
                    care_instructions = '$care_instructions', 
                    image_url = '$image_db_path', 
                    is_visible = '$is_visible' 
                    WHERE id = $id";
            $message = "Product updated successfully";
        } else {
            // INSERT: CatBreeds2
            $sql = "INSERT INTO CatBreeds2 (name_th, name_en, description, characteristics, care_instructions, image_url, is_visible) 
                    VALUES ('$name_th', '$name_en', '$description', '$characteristics', '$care_instructions', '$image_db_path', '$is_visible')";
            $message = "Product created successfully";
        }

        if ($conn->query($sql)) {
            echo json_encode(["status" => 200, "message" => $message]);
        } else {
            echo json_encode(["status" => 500, "message" => "Database error: " . $conn->error]);
        }
        break;

    // ==========================================
    // DELETE: ลบข้อมูลจาก CatBreeds2
    // ==========================================
    case 'DELETE':
        $data = json_decode(file_get_contents("php://input"));
        $id = $data->id;

        // ลบไฟล์รูปก่อน
        $res = $conn->query("SELECT image_url FROM CatBreeds2 WHERE id = $id"); // เปลี่ยนชื่อตาราง
        if ($row = $res->fetch_assoc()) {
            $file_to_delete = $base_storage_path . $row['image_url'];
            if (!empty($row['image_url']) && file_exists($file_to_delete)) {
                unlink($file_to_delete);
            }
        }

        // ลบข้อมูลในฐานข้อมูล
        $sql = "DELETE FROM CatBreeds2 WHERE id = $id"; // เปลี่ยนชื่อตาราง
        if ($conn->query($sql)) {
            echo json_encode(["status" => 200, "message" => "Product deleted successfully"]);
        }
        break;

    default:
        echo json_encode(["status" => 400, "message" => "Invalid request"]);
        break;
}
?>