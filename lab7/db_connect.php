<?php
    $host = 'localhost';
    $db = 'it67040233141';
    $pass = 'K3D2H5I4';
    $dbname = 'it67040233141';

    $conn = new mysqli($host, $db, $pass, $dbname);
    mysqli_set_charset($conn, 'utf8');

    if(!$conn){
        die("เชื่อมต่อไม่สำเร็จ: " . $mysqli_connect_error());
    }
?>