<?php
    $host = 'localhost';
    $dbname = 'it67040233141';
    $username = 'it67040233141';
    $password = 'K3D2H5I4';
    $charset = 'utf8';

    // กำหนด Data Source Name (DSN)
    $dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";
    
    // การตั้งค่า Options สำหรับ PDO
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // ให้แจ้งเตือนเป็น Exception เมื่อเกิด Error
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // ให้ดึงข้อมูลแบบ Array Key ตามชื่อคอลัมน์
        PDO::ATTR_EMULATE_PREPARES   => false,                  // ปิดการเลียนแบบ Prepared Statements เพื่อความปลอดภัย
    ];

    try {
        // สร้างการเชื่อมต่อ
        $pdo = new PDO($dsn, $username, $password, $options);
        // echo "เชื่อมต่อสำเร็จ"; 
    } catch (PDOException $e) {
        // หากเชื่อมต่อไม่สำเร็จจะหยุดการทำงานและแสดง Error
        die("เชื่อมต่อไม่สำเร็จ: " . $e->getMessage());
    }
?>