<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User-define Funcfion</title>
</head>
<body>
    <h1>User-define Function</h1>
    <?php
        echo "ผลบวกของ 10 กับ 20 ".sum(10, 20)."<br>";
        echo "ผลบวกของ 15 กับ 25 ".sum(15, 25)."<br>";
        $a = 30; $b = 45;
        echo "ผลบวกของ $a กับ $b ".sum($a, $b)."<br>";
        echo "<hr>";
        $num = 50;
        echo "ค่า num ก่อนใช้ add_five".$num."<br>";
        add_five($num);
        echo "ค่า num หลังใช้ add_five".$num."<br>";
    ?>

    <h1>function ที่มีพารามิเตอร์หลายตัว</h1>

    <?php
        echo "ผลบวกของตัวเลข 5, 10, 15 คือ ".sumListofNumbers(5, 10, 15)."<br>";
        echo "ผลบวกของตัวเลข 1, 2, 3, 4, 5, 6, 7, 8, 9, 10 คือ ".sumListofNumbers(1, 2, 3, 4, 5, 6, 7, 8, 9, 10)."<br>";
        $a = myFamily("Smith", "John", "Jane", "Peter");
        echo $a;
    ?>

    <h1>function ที่มีพารามิเตอร์ค่าเริ่มต้น</h1>
    <?php
        echo thai_date("2025-12-11")."<br>";
        echo thai_date();
    ?>
</body>
</html>

<?php
    function sum($num1, $num2) {
        $result = $num1 + $num2;
        return $result;
    }

    function add_five($num) {
        $value = $num + 5;
        echo "ค่าภายในฟังก์ชั่น add_five() คือ $value<br>";
    }

    function sumListofNumbers(...$x){
        $n = 0;
        $len = count($x);
        for($i=0; $i<$len; $i++){
            $n += $x[$i];
        }
        return $n;
    }

    function myFamily($lastName, ...$firstName) {
    $txt = "";
    $len = count($firstName);
    for($i = 0; $i < $len; $i++){
        $txt = $txt . "Hi, " . $firstName[$i] . " " . $lastName . ".<br>";
    }
    return $txt;
    }

    function thai_date($strDate="now") {
        $strYear = date("Y", strtotime($strDate)) + 543;
        $strMonth = date("n", strtotime($strDate));
        $strDay = date("j", strtotime($strDate));

        $thaiMonthNames = ["", "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฏาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"];
    
        $strMonthThai = $thaiMonthNames[$strMonth];

        return "$strDay $strMonthThai พ.ศ. $strYear";
    }
?>