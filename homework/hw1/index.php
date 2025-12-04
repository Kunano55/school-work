<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Loop Structures</title>
    <style>
        .loop-container {
            display: flex;
            justify-content: space-around;
            align-items: flex-start;
            padding: 20px;
            gap: 20px;
        }

        .loop-section {
            border: 1px solid black;
            padding: 15px;
            margin: 0;
            width: 30%;
            text-align: left;
            font-family: monospace;
            white-space: pre-wrap;
        }
        
        .info-section {
            text-align: center; 
            margin-top: 50px;
            margin-bottom: 30px;
            padding: 10px;
            border-bottom: 2px solid black;
        }
        
        .loop-header {
            font-weight: bold;
            margin-bottom: 10px;
            display: block;
            text-decoration: underline;
        }
    </style>
</head>
<body>
    
    <div class="info-section">
        <?php
        $unversity = "มหาวิทยาลัยราชภัฏอุดรธานี";
        $faculty = "วิทยาศาสตร์";
        $department = "เทคโนโลยีสารสนเทศ";
        $name = "นายคุณานนท์ สารีมา";
        echo "สวัสดีครับ<br>
            ผมชื่อ $name<br>
            ผมศึกษาอยู่ที่ $unversity<br>
            คณะ $faculty<br>
            สาขา $department";
        ?>
    </div>

    <div class="loop-container">
    
        <div class="loop-section">
            <span class="loop-header">For Loop</span>
            <?php
            echo "<br>";
            for ($i = 1; $i <= 4; $i++) {
                for ($j = 1; $j <= $i; $j++) {
                    echo "*";
                }
                echo "<br>";
            }
            echo "<br>";

            for ($x = 1; $x <= 3; $x++) {
                for ($y = 1; $y <= 4; $y++) {
                    echo "$x ";
                }
                echo "<br>";
            }
            echo "<br>";

            for ($x = 1; $x <= 3; $x++) {
                for ($j = 1; $j <= $x; $j++) {
                    echo "$x ";
                }
                echo "<br>";
            }
            echo "<br>";
            
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
            echo "<br>";

            for ($i = 3; $i >= 1; $i--) {
                for ($j = $i; $j >= 1; $j--) {
                    echo "$i ";
                }
                echo "<br>";
            }
            ?>
        </div>

        <div class="loop-section">
            <span class="loop-header">While Loop</span>
            <?php
            echo "<br>";
            $i = 1;
            while ($i <= 4) {
                $j = 1;
                while ($j <= $i) {
                    echo "*";
                    $j++;
                }
                echo "<br>";
                $i++;
            }
            echo "<br>";

            $x = 1;
            $y = 1; 
            while ($x <= 3){
                while ($y <= 4) {
                    echo "$x ";
                    $y++;
                }
                echo "<br>";
                $y = 1;
                $x++;
            }
            echo "<br>";

            $x = 1; 
            while ($x <= 3) {
                $j = 1;
                while ($j <= $x) {
                    echo "$x ";
                    $j++;
                }
                echo "<br>";
                $x++;
            }
            echo "<br>";

            echo "* * * * * *<br>";
            $i = 1;
            while ($i <= 3) {
                echo "* ";
                $j = 1;
                while ($j <= 4) {
                    echo "$i ";
                    $j++;
                }
                echo "*";
                echo "<br>";
                $i++;
            }
            echo "* * * * * *<br>";
            echo "<br>";

            $i = 3;
            while ($i >= 1) {
                $j = $i;
                while ($j >= 1) {
                    echo "$i ";
                    $j--;
                }
                echo "<br>";
                $i--;
            }
            ?>
        </div>

        <div class="loop-section">
            <span class="loop-header">Do While Loop</span>
            <?php
            echo "<br>";
            $i = 1;
            do {
                $j = 1;
                do {
                    echo "*";
                    $j++;
                } while ($j <= $i);
                
                echo "<br>";
                $i++;
            } while ($i <= 4);
            echo "<br>";

            $x = 1;
            do {
                $y = 1;
                do {
                    echo "$x ";
                    $y++;
                } while ($y <= 4);
                
                echo "<br>";
                $x++;
            } while ($x <= 3);
            echo "<br>";

            $x = 1; 
            do {
                $j = 1;
                do {
                    echo "$x ";
                    $j++;
                } while ($j <= $x);

                echo "<br>";
                $x++;
            } while ($x <= 3);
            echo "<br>";

            echo "* * * * * *<br>";
            $i = 1;
            do {
                echo "* ";
                $j = 1;
                do {
                    echo "$i ";
                    $j++;
                } while ($j <= 4);
                
                echo "*";
                echo "<br>";
                $i++;
            } while ($i <= 3);
            echo "* * * * * *<br>";
            echo "<br>";

            $i = 3;
            do {
                $j = $i;
                do {
                    echo "$i ";
                    $j--;
                } while ($j >= 1);
                
                echo "<br>";
                $i--;
            } while ($i >= 1);
            ?>
        </div>
    </div>

</body>
</html>
