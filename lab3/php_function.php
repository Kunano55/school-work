<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Function</title>
</head>
<body>
    <h1>PHP Built-In Functions Test</h1>

    <h2>Function Date</h2>

    <?php
        echo "Today is ".date("Y/m/d")."<br>";
        echo "Today is ".date("Y.M.D")."<br>";
        echo "Current time ".date("H-i-sa")."<br>";
        echo "Today is ".date("l")."<br>";
    ?>

    <h2>date_diff function</h2>
    <?php
        $date1 = date_create("2004-03-04");
        $date2 = date_create($datetime='now');
        $diff = date_diff($date1, $date2);
        echo "Number of days between 2004-03-04 and ".date("Y-m-d")." is ".$diff->days."<br>";
        echo "or ".$diff->y. " years, ".$diff->m." months, ".$diff->d." days<br>";
    ?>

    <h2>Math function</h2>
    <?php
        $num1 = 10.3;
        $num2 = 15.7;
        $pi = 3.14159;
        echo "ปัด num1 ขึ้น ".ceil($num1)."<br>";
        echo "ปัด num2 ลง ".floor($num2)."<br>";
        echo "ค่า Pi ทศนิยม 2 ตำแหน่ง ".round($pi, 2)."<br>";
        echo "ค่ายกกำลัง 3 ของ 5 คือ ".pow(5,3)."<br>";
        echo "ค่ารากที่สองของ 144 คือ ".sqrt(144)."<br>";
        echo "สุ่มระหว่าง 1-100 ".rand(1,100)."<br>";
        echo "สุ่มระหว่าง 50-150 ".mt_rand(50,150)."<br>";
        echo "ค่าสุ่ม ".rand()."<br>";
        $arr=array(10,20,30,40,50);
        echo "ค้าสูงสุดในอาเรย์ ".max($arr)."<br>";
        echo "ค้าต่ำสุดในอาเรย์ ".min($arr)."<br>";
    ?>

    <h2>strings function</h2>
    <?php
        $str = "Hello World PHP Functions Test";
        echo "ความยาวของสตริง ".strlen($str)."<br>";
        echo "ตัดสตริง ".substr($str,6,5)."<br>";
        echo "ค้นหาตำแหน่งของคำว่า 'PHP' ".strpos($str,"PHP")."<br>";
        echo "เปลี่ยนเป็นตัวพิมพ์ใหญ่ ".strtoupper($str)."<br>";
        echo "เปลี่ยนเป็นตัวพิมพ์เล็ก ".strtolower($str)."<br>";
        echo "แทนที่คำว่า 'World' ด้วย 'Everyone' ".str_replace("World","Everyone",$str)."<br>";
        $substr = "PHP";
        echo "ตำแหน่งของคำว่า substr ใน str ".strpos($str, $substr)."<br>";
        $str2 = "         PHP    Functions    with    Spaces   ";
        echo "ก่อนลบช่องว่างใน str '".$str2."'<br>";
        echo "หลังลบช่องว่างใน str '".trim($str2)."'<br>"; 
    ?>

    <?php myFooter("Khunanon Sareema");?>
</body>
</html>
<?php
    function myFooter($myName){
        echo "<footer><hr>";
        echo "<p>PHP Built-In Function Example &copy; 2024</p>";
        echo "<p>สร้างโดย: $myName</p>";
        echo "</footer>";
    }
?>