<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>แบบฟอร์มบันทึกข้อมูล</title>
</head>
<body>
    <h2>กรอกข้อมูลส่วนตัว</h2>
    <form action="result.php" method="POST">
        <label>ชื่อ-นามสกุล:</label><br>
        <input type="text" name="fullname" required><br><br>

        <label>วันเกิด:</label><br>
        <input type="date" name="birthdate" required><br><br>

        <label>น้ำหนัก (กก.):</label><br>
        <input type="number" name="weight" step="0.1" required><br><br>

        <label>ส่วนสูง (ซม.):</label><br>
        <input type="number" name="height" required><br><br>

        <button type="submit">Submit</button>
        <button type="reset">Clear</button>
    </form>
</body>
</html>