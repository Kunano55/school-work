<?php
$fullname  = $_POST['fullname'];
$birthdate = $_POST['birthdate'];
$weight    = $_POST['weight'];
$height    = $_POST['height'];

$today = new DateTime();
$birth = new DateTime($birthdate);
$age = $today->diff($birth)->y; 

$height_m = $height / 100;
$bmi = $weight / ($height_m * $height_m);
$bmi = round($bmi, 2);

if ($bmi < 18.5) {
    $result_text = "น้ำหนักน้อยกว่ามาตรฐาน (ผอม)";
    $advice = "ควรรับประทานอาหารที่มีประโยชน์ให้ครบ 5 หมู่ และเพิ่มปริมาณพลังงาน";
} elseif ($bmi < 23) {
    $result_text = "น้ำหนักปกติ (สุขภาพดี)";
    $advice = "ยินดีด้วย! คุณมีน้ำหนักอยู่ในเกณฑ์ดี ควรออกกำลังกายสม่ำเสมอ";
} elseif ($bmi < 25) {
    $result_text = "น้ำหนักเกิน (ท้วม)";
    $advice = "ควรระมัดระวังเรื่องอาหารที่มีไขมันและน้ำตาลสูง";
} elseif ($bmi < 30) {
    $result_text = "โรคอ้วนระดับ 1";
    $advice = "ควรควบคุมอาหารและเริ่มออกกำลังกายอย่างจริงจัง";
} else {
    $result_text = "โรคอ้วนระดับ 2 (อันตราย)";
    $advice = "ควรปรึกษาแพทย์หรือผู้เชี่ยวชาญเพื่อวางแผนลดน้ำหนัก";
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>ผลการคำนวณ</title>
</head>
<body>
    <h2>ข้อมูลและผลการทดสอบ</h2>
    
    <table border="0">
        <tr><td><b>ชื่อ-นามสกุล:</b></td><td><?php echo $fullname; ?></td></tr>
        <tr><td><b>วันเกิด:</b></td><td><?php echo $birthdate; ?></td></tr>
        <tr><td><b>อายุ:</b></td><td><?php echo $age; ?> ปี</td></tr>
        <tr><td><b>น้ำหนัก:</b></td><td><?php echo $weight; ?> กก.</td></tr>
        <tr><td><b>ส่วนสูง:</b></td><td><?php echo $height; ?> ซม.</td></tr>
    </table>

    <hr>

    <h3>ค่า BMI ของคุณคือ: <?php echo $bmi; ?></h3>
    <p><b>แปลผล:</b> <?php echo $result_text; ?></p>
    <p><b>คำแนะนำ:</b> <?php echo $advice; ?></p>

    <br>
    <a href="main.php">
        <button type="button">กลับหน้าหลัก</button>
    </a>
</body>
</html>