<?php
include 'db_connect.php';

$id = $_GET['id'] ?? '';
$cat = ['name_th'=>'','name_en'=>'','description'=>'','characteristics'=>'','care_instructions'=>'','is_visible'=>1,'image_url'=>''];

// ดึงข้อมูลกรณี "แก้ไข"
if ($id) {
    $stmt = $conn->prepare("SELECT * FROM CatBreeds WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $cat = $stmt->get_result()->fetch_assoc();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name_th = $_POST['name_th'];
    $name_en = $_POST['name_en'];
    $description = $_POST['description'];
    $characteristics = $_POST['characteristics'];
    $care_instructions = $_POST['care_instructions'];
    $is_visible = $_POST['is_visible'];
    $image_url = $cat['image_url'];

    // จัดการการอัปโหลดรูปภาพ
    if (isset($_FILES['image_file']) && $_FILES['image_file']['error'] == 0) {
        $folder = 'uploads/';
        if (!file_exists($folder)) {
            mkdir($folder, 0777, true); // สร้างโฟลเดอร์อัตโนมัติถ้ายังไม่มี
        }

        $extension = pathinfo($_FILES['image_file']['name'], PATHINFO_EXTENSION);
        $file_name = uniqid('cat_') . '.' . $extension; // สุ่มชื่อไฟล์ป้องกันซ้ำ
        $target_path = $folder . $file_name;

        if (move_uploaded_file($_FILES['image_file']['tmp_name'], $target_path)) {
            // ลบรูปเก่าทิ้ง (ถ้ามี)
            if ($image_url && file_exists($image_url)) {
                unlink($image_url);
            }
            $image_url = $target_path;
        }
    }

    if ($id) {
        // SQL สำหรับ UPDATE
        $sql = "UPDATE CatBreeds SET name_th=?, name_en=?, description=?, characteristics=?, care_instructions=?, image_url=?, is_visible=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssii", $name_th, $name_en, $description, $characteristics, $care_instructions, $image_url, $is_visible, $id);
    } else {
        // SQL สำหรับ INSERT
        $sql = "INSERT INTO CatBreeds (name_th, name_en, description, characteristics, care_instructions, image_url, is_visible) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssi", $name_th, $name_en, $description, $characteristics, $care_instructions, $image_url, $is_visible);
    }

    if ($stmt->execute()) {
        header("Location: cat_back_end.php");
    } else {
        echo "เกิดข้อผิดพลาด: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title><?php echo $id ? 'แก้ไขข้อมูลแมว' : 'เพิ่มข้อมูลแมว'; ?></title>
    <style>
        .container { width: 50%; margin: auto; font-family: sans-serif; }
        input[type="text"], textarea, select { width: 100%; padding: 8px; margin: 5px 0 15px; box-sizing: border-box; }
        button { background: #007bff; color: white; padding: 10px 20px; border: none; cursor: pointer; }
    </style>
</head>
<body>
<div class="container">
    <h2><?php echo $id ? 'แก้ไขข้อมูลแมว' : 'เพิ่มแมวสายพันธุ์ใหม่'; ?></h2>
    <form method="post" enctype="multipart/form-data">
        <label>ชื่อภาษาไทย (name_th):</label>
        <input type="text" name="name_th" value="<?php echo $cat['name_th']; ?>" required>

        <label>ชื่อภาษาอังกฤษ (name_en):</label>
        <input type="text" name="name_en" value="<?php echo $cat['name_en']; ?>" required>

        <label>รายละเอียด (description):</label>
        <textarea name="description" rows="4"><?php echo $cat['description']; ?></textarea>

        <label>ลักษณะเด่น (characteristics):</label>
        <textarea name="characteristics" rows="3"><?php echo $cat['characteristics']; ?></textarea>

        <label>วิธีดูแล (care_instructions):</label>
        <textarea name="care_instructions" rows="3"><?php echo $cat['care_instructions']; ?></textarea>

        <label>รูปภาพ:</label><br>
        <input type="file" name="image_file" accept="image/*"><br>
        <?php if($cat['image_url']): ?>
            <img src="<?php echo $cat['image_url']; ?>" width="150" style="margin: 10px 0;"><br>
        <?php endif; ?>

        <label>สถานะการแสดงผล:</label>
        <select name="is_visible">
            <option value="1" <?php echo $cat['is_visible']==1 ? 'selected' : ''; ?>>แสดงผล (Visible)</option>
            <option value="0" <?php echo $cat['is_visible']==0 ? 'selected' : ''; ?>>ซ่อน (Hidden)</option>
        </select>

        <button type="submit">บันทึกข้อมูล</button>
        <a href="cat_back_end.php">กลับหน้าหลัก</a>
    </form>
</div>
</body>
</html>