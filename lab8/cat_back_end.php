<?php
include 'db_connect.php';

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $res = $conn->query("SELECT image_url FROM CatBreeds WHERE id = $id");
    $data = $res->fetch_assoc();
    if ($data['image_url'] && file_exists($data['image_url'])) {
        unlink($data['image_url']);
    }
    $conn->query("DELETE FROM CatBreeds WHERE id = $id");
    header("Location: cat_back_end.php");
}

$result = $conn->query("SELECT * FROM CatBreeds");
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>Backend - จัดการข้อมูลแมว</title>
    <style>
        table { width: 100%; border-collapse: collapse; margin-top: 20px; font-family: sans-serif; }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        th { background-color: #f4f4f4; }
        img { width: 80px; border-radius: 5px; }
        .btn { padding: 8px 15px; text-decoration: none; border-radius: 4px; display: inline-block; }
        .btn-add { background: #28a745; color: white; }
        .btn-edit { background: #ffc107; color: black; }
        .btn-delete { background: #dc3545; color: white; }
        .btn-view { background: #17a2b8; color: white; }
    </style>
</head>
<body>
    <h2>จัดการข้อมูลสายพันธุ์แมว (Admin)</h2>
    <a href="cat_form.php" class="btn btn-add">+ เพิ่มแมวใหม่</a>
    <a href="cat_front_end.php" class="btn btn-view">ไปหน้าบ้าน (Front-end)</a>
    
    <table>
        <tr>
            <th>รูป</th>
            <th>ชื่อ (ไทย/อังกฤษ)</th>
            <th>สถานะ</th>
            <th>จัดการ</th>
        </tr>
        <?php while($row = $result->fetch_assoc()): ?>
        <tr>
            <td>
                <?php if($row['image_url']): ?>
                    <img src="<?php echo $row['image_url']; ?>">
                <?php else: ?>
                    ไม่มีรูป
                <?php endif; ?>
            </td>
            <td>
                <strong><?php echo $row['name_th']; ?></strong><br>
                <small><?php echo $row['name_en']; ?></small>
            </td>
            <td><?php echo $row['is_visible'] ? 'แสดง' : 'ซ่อน'; ?></td>
            <td>
                <a href="cat_form.php?id=<?php echo $row['id']; ?>" class="btn btn-edit">แก้ไข</a>
                <a href="cat_back_end.php?delete=<?php echo $row['id']; ?>" 
                   class="btn btn-delete" onclick="return confirm('ลบข้อมูลนี้ใช่ไหม?')">ลบ</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>