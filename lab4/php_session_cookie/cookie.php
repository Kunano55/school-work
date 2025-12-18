<?php
if(isset($_POST["submit"])){
    $username = $_POST["username"];

    setcookie("user", $username, time()+3600,"/");
}

if(isset($_COOKIE["user"])){
    $welcome_massage = "Welcome back, ".$_COOKIE["user"]."!";
} else {
    $welcome_massage = "Welcome, Guest!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1><?php echo $welcome_massage; ?></h1>

    <form method="post" action="">
        <label for="username">Enter your name:</label>
        <input type="text" id="username" name="username">
        <button type="submit" name="submit">Submit</button>
    </form>
</body>
</html>