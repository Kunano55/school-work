<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Globals vars</title>
</head>
<body>
    <h1>Function</h1>
    <?php
    $x = 75;
    $y = 25;

    function addition() {
        $GLOBALS['z'] = $GLOBALS['x'] + $GLOBALS['y'];
    }

    addition();
    echo $z;
    ?>
    <h1>Sever</h1>
    <?php
        echo $_SERVER['PHP_SELF']."<br>\n";
        echo $_SERVER['SERVER_NAME']."<br>\n";
        echo $_SERVER['HTTP_HOST']."<br>\n";
        echo $_SERVER['HTTP_USER_AGENT']."<br>\n";
        echo $_SERVER['SCRIPT_NAME']."<br>\n";
    ?>
</body>
</html>