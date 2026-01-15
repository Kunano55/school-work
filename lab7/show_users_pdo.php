<?php
require_once 'db_connect_pdo.php';

// --- Logic: ลบข้อมูล ---
if (isset($_GET['delete_id'])) {
    $stmt = $pdo->prepare("DELETE FROM user_data WHERE id = ?");
    $stmt->execute([$_GET['delete_id']]);
    header("Location: show_users_pdo.php");
    exit;
}

// --- Logic: บันทึกข้อมูล (เพิ่ม & แก้ไข) ---
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'] ?? '';
    $name = $_POST['name'];
    $sex = $_POST['sex'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $birthday = $_POST['birthday'];

    if (!empty($id)) {
        // Update
        $sql = "UPDATE user_data SET name=?, sex=?, phone=?, email=?, birthday=? WHERE id=?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$name, $sex, $phone, $email, $birthday, $id]);
    } else {
        // Insert
        $sql = "INSERT INTO user_data (name, sex, phone, email, birthday) VALUES (?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$name, $sex, $phone, $email, $birthday]);
    }
    header("Location: show_users_pdo.php");
    exit;
}

$users = $pdo->query("SELECT * FROM user_data ORDER BY id DESC")->fetchAll();
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>จัดการสมาชิก - Pop-up Edition</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body { background-color: #f0f2f5; font-family: 'Sarabun', sans-serif; }
        .card { border: none; border-radius: 15px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
        .table thead { background-color: #0d6efd; color: white; }
        .btn-action { padding: 5px 10px; border-radius: 8px; }
    </style>
</head>
<body>

<div class="container py-5">
    <div class="card p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="m-0 text-primary"><i class="bi bi-people-fill"></i> จัดการข้อมูลสมาชิก</h2>
            <button class="btn btn-success" onclick="openAddModal()">
                <i class="bi bi-person-plus-fill"></i> เพิ่มสมาชิกใหม่
            </button>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>ชื่อ-นามสกุล</th>
                        <th>เพศ</th>
                        <th>เบอร์โทร</th>
                        <th>อีเมล</th>
                        <th>วันเกิด</th>
                        <th class="text-center">จัดการ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $u): ?>
                    <tr>
                        <td><?= $u['id'] ?></td>
                        <td><strong><?= htmlspecialchars($u['name']) ?></strong></td>
                        <td><?= htmlspecialchars($u['sex']) ?></td>
                        <td><?= htmlspecialchars($u['phone']) ?></td>
                        <td><?= htmlspecialchars($u['email']) ?></td>
                        <td><?= htmlspecialchars($u['birthday']) ?></td>
                        <td class="text-center">
                            <button class="btn btn-warning btn-sm btn-action" 
                                    onclick='openEditModal(<?= json_encode($u) ?>)'>
                                <i class="bi bi-pencil-square"></i> แก้ไข
                            </button>
                            <a href="?delete_id=<?= $u['id'] ?>" class="btn btn-danger btn-sm btn-action" 
                               onclick="return confirm('ยืนยันการลบข้อมูลนี้?')">
                                <i class="bi bi-trash"></i> ลบ
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="userModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius: 15px;">
            <div class="modal-header bg-primary text-white" style="border-top-left-radius: 15px; border-top-right-radius: 15px;">
                <h5 class="modal-title" id="modalTitle">จัดการข้อมูล</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST">
                <div class="modal-body">
                    <input type="hidden" name="id" id="user_id">
                    <div class="mb-3">
                        <label class="form-label">ชื่อ-นามสกุล</label>
                        <input type="text" name="name" id="user_name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">เพศ</label>
                        <select name="sex" id="user_sex" class="form-select">
                            <option value="ชาย">ชาย</option>
                            <option value="หญิง">หญิง</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">เบอร์โทรศัพท์</label>
                        <input type="text" name="phone" id="user_phone" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">อีเมล</label>
                        <input type="email" name="email" id="user_email" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">วันเกิด</label>
                        <input type="date" name="birthday" id="user_birthday" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-primary">บันทึกข้อมูล</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    const userModal = new bootstrap.Modal(document.getElementById('userModal'));

    // ฟังก์ชันสำหรับเปิด Pop-up เพิ่มข้อมูลใหม่
    function openAddModal() {
        document.getElementById('modalTitle').innerText = "เพิ่มสมาชิกใหม่";
        document.getElementById('user_id').value = "";
        document.getElementById('user_name').value = "";
        document.getElementById('user_sex').value = "ชาย";
        document.getElementById('user_phone').value = "";
        document.getElementById('user_email').value = "";
        document.getElementById('user_birthday').value = "";
        userModal.show();
    }

    // ฟังก์ชันสำหรับเปิด Pop-up แก้ไขข้อมูล (รับค่าจาก Object u)
    function openEditModal(u) {
        document.getElementById('modalTitle').innerText = "แก้ไขข้อมูลสมาชิก";
        document.getElementById('user_id').value = u.id;
        document.getElementById('user_name').value = u.name;
        document.getElementById('user_sex').value = u.sex;
        document.getElementById('user_phone').value = u.phone;
        document.getElementById('user_email').value = u.email;
        document.getElementById('user_birthday').value = u.birthday;
        userModal.show();
    }
</script>

</body>
</html>