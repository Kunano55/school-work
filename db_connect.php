<?php
    $host = 'localhost';
    $db = 'it67040233141';
    $pass = 'K3D2H5I4';
    $dbname = 'it67040233141';

    $conn = new mysqli($host, $db, $pass, $dbname);

    if ($conn->connect_error) {
        die("เชื่อมต่อไม่สำเร็จ: " . $conn->connect_error);
    }

    $conn->set_charset("utf8");
?>