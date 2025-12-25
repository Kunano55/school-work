<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ระบบลงทะเบียนอบรม</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .container { max-width: 900px; margin-top: 50px; }
        .card { border: none; border-radius: 15px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        .table-container { background: white; padding: 20px; border-radius: 15px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); margin-top: 30px; }
    </style>
</head>
<body>

<div class="container">
    <div class="card p-4 mb-4">
        <h2 class="text-center mb-4 text-primary">ฟอร์มลงทะเบียนอบรม</h2>
        
        <form method="post">
            <div class="mb-3">
                <label class="form-label">ชื่อ-นามสกุล:</label>
                <input type="text" name="name" class="form-control" placeholder="กรอกชื่อ-นามสกุล" required>
            </div>

            <div class="mb-3">
                <label class="form-label">อีเมล (Email):</label>
                <input type="email" name="email" class="form-control" placeholder="example@mail.com" required>
            </div>

            <div class="mb-3">
                <label class="form-label">หัวข้ออบรม:</label>
                <select name="course" class="form-select" required>
                    <option value="" disabled selected>เลือกหลักสูตร...</option>
                    <option value="PHP">PHP</option>
                    <option value="JavaScript">JavaScript</option>
                    <option value="Python">Python</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label d-block">อาหารที่ต้องการ:</label>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="food[]" value="Normal" id="food1">
                    <label class="form-check-label" for="food1">ปกติ</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="food[]" value="Vegetarian" id="food2">
                    <label class="form-check-label" for="food2">มังสวิรัติ</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="food[]" value="Halal" id="food3">
                    <label class="form-check-label" for="food3">ฮาลาล</label>
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label d-block">รูปแบบการเข้าร่วม:</label>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="attendance" value="Onsite" id="att1" required>
                    <label class="form-check-label" for="att1">เข้าร่วมในสถานที่ (1,500.-)</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="attendance" value="Online" id="att2">
                    <label class="form-check-label" for="att2">เข้าร่วมออนไลน์ (800.-)</label>
                </div>
            </div>

            <button type="submit" name="submit" class="btn btn-primary w-100 btn-lg">ลงทะเบียน</button>
        </form>
    </div>

    <?php
    if (isset($_POST['submit'])) {
        $fullname = htmlspecialchars($_POST['name']);
        $email = htmlspecialchars($_POST['email']);
        $course = $_POST['course'];
        $attendance = $_POST['attendance'];
        $food = isset($_POST['food']) ? implode(", ", $_POST['food']) : "ไม่มี";
        $price = ($attendance == "Onsite") ? 1500 : 800;

        $data = $fullname . "|" . $email . "|" . $course . "|" . $food . "|" . $attendance . "|" . $price;
        file_put_contents("register.txt", $data . "\n", FILE_APPEND);

        echo "<div class='alert alert-success mt-3'>
                <h4>ลงทะเบียนสำเร็จ!</h4>
                <p class='mb-0'>คุณ $fullname ได้ลงทะเบียนหลักสูตร $course เรียบร้อยแล้ว</p>
              </div>";
    }
    ?>

    <div class="table-container mb-5">
        <h4 class="mb-3 text-secondary">รายชื่อผู้ลงทะเบียน</h4>
        <div class="table-responsive">
            <?php
            if (file_exists("register.txt")) {
                $lines = file("register.txt");
                echo "<table class='table table-hover table-striped'>";
                echo "<thead class='table-dark'>
                        <tr>
                            <th>ชื่อ-นามสกุล</th>
                            <th>อีเมล</th>
                            <th>หัวข้อ</th>
                            <th>อาหาร</th>
                            <th>รูปแบบ</th>
                            <th>ราคา</th>
                        </tr>
                      </thead><tbody>";
                foreach ($lines as $line) {
                    $parts = explode("|", trim($line));
                    if(count($parts) == 6) {
                        list($name, $email, $course, $food, $attendance, $price) = $parts;
                        echo "<tr>
                                <td>$name</td>
                                <td>$email</td>
                                <td><span class='badge bg-info text-dark'>$course</span></td>
                                <td>$food</td>
                                <td>$attendance</td>
                                <td class='fw-bold text-primary'>" . number_format($price) . " บาท</td>
                            </tr>";
                    }
                }
                echo "</tbody></table>";
            } else {
                echo "<p class='text-muted'>ยังไม่มีข้อมูลการลงทะเบียน</p>";
            }
            ?>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>