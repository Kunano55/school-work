<?php
function splitThaiName($fullName) {
    $fullName = trim($fullName);
    
    $prefixes = [
        "นาย", "นางสาว", "นาง", "เด็กชาย", "เด็กหญิง",
        "น.ส.", "ด.ช.", "ด.ญ.", "ม.ร.ว.", "ม.ล.", "ดร.", "ผศ.", "รศ.", "ศ.",
        "พล.ต.อ.", "พล.ต.ท.", "พล.ต.ต.", "พ.ต.อ.", "พ.ต.ท.", "พ.ต.ต.", 
        "ร.ต.อ.", "ร.ต.ท.", "ร.ต.ต.", "ด.ต.", "จ.ส.ต.", "ส.ต.ต."
    ];

    $prefix = "";
    $name = "";
    $surname = "";

    foreach ($prefixes as $p) {
        if (mb_substr($fullName, 0, mb_strlen($p)) === $p) {
            $prefix = $p;
            $fullName = trim(mb_substr($fullName, mb_strlen($p)));
            break;
        }
    }

    if ($prefix === "") {
        if (preg_match('/^([^\s]+\.)\s*/u', $fullName, $matches)) {
            $prefix = $matches[1];
            $fullName = trim(str_replace($prefix, '', $fullName));
        }
    }

    $parts = preg_split('/\s+/', $fullName, 2);
    
    $name = isset($parts[0]) ? $parts[0] : "";
    $surname = isset($parts[1]) ? $parts[1] : "";

    return [
        'prefix' => $prefix,
        'name' => $name,
        'surname' => $surname
    ];
}

$result = null;
if (isset($_POST['fullname'])) {
    $result = splitThaiName($_POST['fullname']);
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>PHP Name Splitter</title>
    <style>
        body { font-family: sans-serif; padding: 20px; line-height: 1.6; }
        .container { max-width: 500px; margin: auto; border: 1px solid #ccc; padding: 20px; border-radius: 8px; }
        input[type="text"] { width: 100%; padding: 8px; margin: 10px 0; box-sizing: border-box; }
        button { background: #007bff; color: white; border: none; padding: 10px 15px; cursor: pointer; border-radius: 4px; }
        .result { background: #f4f4f4; padding: 15px; margin-top: 20px; border-left: 5px solid #007bff; }
    </style>
</head>
<body>

<div class="container">
    <h2>โปรแกรมแยกชื่อ-นามสกุล</h2>
    <form method="post">
        <label>กรอกชื่อ-นามสกุลเต็ม:</label>
        <input type="text" name="fullname" placeholder="เช่น ร.ต.ต. สมชาย ณ อยุธยา" required 
               value="<?php echo isset($_POST['fullname']) ? htmlspecialchars($_POST['fullname']) : ''; ?>">
        <button type="submit">แยกข้อมูล</button>
    </form>

    <?php if ($result): ?>
        <div class="result">
            <strong>ผลลัพธ์:</strong><br>
            คำนำหน้า: <?php echo $result['prefix'] ?: "-"; ?><br>
            ชื่อ: <?php echo $result['name']; ?><br>
            นามสกุล: <?php echo $result['surname']; ?>
        </div>
    <?php endif; ?>
</div>

</body>
</html>