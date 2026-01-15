<?php
include 'db_connect.php'; // เชื่อมต่อฐานข้อมูล

// --- ส่วนที่ 1: การประมวลผลข้อมูล (Logic) ---

// 1. บันทึกข้อมูล (Add / Update)
if (isset($_POST['save'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $sex = $_POST['sex'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $birthday = $_POST['birthday'];

    if ($id) {
        $sql = "UPDATE user_data SET name='$name', sex='$sex', phone='$phone', email='$email', birthday='$birthday' WHERE id=$id";
    } else {
        $sql = "INSERT INTO user_data (name, sex, phone, email, birthday) VALUES ('$name', '$sex', '$phone', '$email', '$birthday')";
    }
    mysqli_query($conn, $sql);
    header("Location: show_users.php"); // ทำเสร็จแล้วกลับมาหน้าหลัก
    exit;
}

// 2. ลบข้อมูล (Delete)
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM user_data WHERE id=$id");
    header("Location: show_users.php");
    exit;
}

// --- ส่วนที่ 2: การเตรียมข้อมูลสำหรับแสดงผล ---

$action = $_GET['action'] ?? 'list'; // ดูว่าตอนนี้ผู้ใช้กำลังจะทำอะไร (list หรือ form)
$id = $_GET['id'] ?? null;
$user = ['name'=>'', 'sex'=>'', 'phone'=>'', 'email'=>'', 'birthday'=>''];

if ($id && $action == 'edit') {
    $res = mysqli_query($conn, "SELECT * FROM user_data WHERE id = $id");
    $user = mysqli_fetch_assoc($res);
}

$all_users = mysqli_query($conn, "SELECT * FROM user_data");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>User Management System</title>
</head>
<body class="bg-light">

<div class="container mt-5">
    
    <?php if ($action == 'add' || $action == 'edit'): ?>
    <div class="card p-4 shadow mx-auto" style="max-width: 600px;">
        <h3><?= $id ? 'แก้ไขข้อมูล' : 'เพิ่มข้อมูลใหม่' ?></h3>
        <form action="manage.php" method="POST">
            <input type="hidden" name="id" value="<?= $id ?>">
            <div class="mb-3">
                <label class="form-label">ชื่อ-นามสกุล</label>
                <input type="text" name="name" class="form-control" value="<?= $user['name'] ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">เพศ</label>
                <select name="sex" class="form-select">
                    <option value="ชาย" <?= $user['sex'] == 'ชาย' ? 'selected' : '' ?>>ชาย</option>
                    <option value="หญิง" <?= $user['sex'] == 'หญิง' ? 'selected' : '' ?>>หญิง</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">เบอร์โทรศัพท์</label>
                <input type="text" name="phone" class="form-control" value="<?= $user['phone'] ?>">
            </div>
            <div class="mb-3">
                <label class="form-label">อีเมล</label>
                <input type="email" name="email" class="form-control" value="<?= $user['email'] ?>">
            </div>
            <div class="mb-3">
                <label class="form-label">วันเกิด</label>
                <input type="date" name="birthday" class="form-control" value="<?= $user['birthday'] ?>">
            </div>
            <button type="submit" name="save" class="btn btn-primary w-100">บันทึกข้อมูล</button>
            <a href="manage.php" class="btn btn-link w-100 mt-2 text-decoration-none text-muted">ยกเลิก</a>
        </form>
    </div>

    <?php else: ?>
    <div class="d-flex justify-content-between mb-3 align-items-center">
        <h2>รายชื่อสมาชิก (user_data)</h2>
        <a href="manage.php?action=add" class="btn btn-success">+ เพิ่มข้อมูล</a>
    </div>
    
    <div class="table-responsive">
        <table class="table table-bordered bg-white shadow-sm">
            <thead class="table-dark text-center">
                <tr>
                    <th>ID</th><th>ชื่อ-นามสกุล</th><th>เพศ</th><th>โทรศัพท์</th><th>อีเมล</th><th>วันเกิด</th><th>จัดการ</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = mysqli_fetch_assoc($all_users)): ?>
                <tr>
                    <td class="text-center"><?= $row['id'] ?></td>
                    <td><?= $row['name'] ?></td>
                    <td class="text-center"><?= $row['sex'] ?></td>
                    <td><?= $row['phone'] ?></td>
                    <td><?= $row['email'] ?></td>
                    <td><?= $row['birthday'] ?></td>
                    <td class="text-center">
                        <a href="manage.php?action=edit&id=<?= $row['id'] ?>" class="btn btn-sm btn-warning">แก้ไข</a>
                        <a href="manage.php?delete=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('ยืนยันการลบข้อมูล?')">ลบ</a>
                    </td>
                </tr>
                <?php endwhile; ?>
                <?php if(mysqli_num_rows($all_users) == 0): ?>
                    <tr><td colspan="7" class="text-center">ไม่มีข้อมูล</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php endif; ?>

</div>

</body>
</html>