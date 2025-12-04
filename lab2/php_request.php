<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Request</title>
</head>
<body>
    <h1>Form</h1>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
        Name: <input type="text" name="fname">
        Last Name: <input type="text" name="lname">
        <input type="submit" value="Submit">
    </form>

    <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $name = $_REQUEST['fname'];
            $lname = $_REQUEST['lname'];
            if (empty($name)) {
                echo "Name is empty";
            } else {
                echo $name." ".$lname;
            }
        }
    ?>
</body>
</html>