<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div style="text-align: center; margin-top: 50px;">
        <?php
        $unversity = "มหาวิทยาลัยราชภัฏอุดรธานี";
        $faculty = "วิทยาศาสตร์";
        $department = "เทคโนโลยีสารสนเทศ";
        $name = "นายคุณานนท์ สารีมา";
        echo "สวัสดีครับ<br>
                ผมชื่อ $name<br>
                ผมศึกษาอยู่ที่ $unversity<br>
                คณะ $faculty<br>
                สาขา $department
                ";
        ?>
    </div>

    <div style="margin: 50px;">
        <?php
        $x = 1;
        $y = 1;

        echo "ใช้ for<br>";

        for ($i = 1; $i <= 4; $i++) {
            for ($j = 1; $j <= $i; $j++) {
                echo "*";
            }
            echo "<br>";
        }

        echo "<br>ใช้ while<br>";

        while ($x <= 3){
                while ($y <= 4) {
                    echo "$x ";
                    $y++;
                }
            echo "<br>";
            $y = 1;
            $x++;
        }

        echo "<br>ใช้ do while + for<br>";

        $x = 1;

        do {
            for ($j = 1; $j <= $x; $j++) {
                echo "$x ";
            }
            echo "<br>";
            $x++;
        } while ($x <= 3);

        echo "<br>ใช้ for<br>";
        
        echo "* * * * * *<br>";

        for ($i = 1; $i <= 3; $i++) {
            echo "* ";
                for ($j = 1; $j <= 4; $j++) {
                    echo "$i ";
                }
            echo "*";
            echo "<br>";
        }

        echo "* * * * * *<br>";

        echo "<br>ใช้ for<br>";

        for ($i = 3; $i >= 1; $i--) {
            for ($j = $i; $j >= 1; $j--) {
                echo "$i ";
            }
            echo "<br>";
        }
        ?>
    </div>
</body>
</html>
