<?php
session_start();

if(!isset($_SESSION['username'])){
    echo "กรุณาเข้าสู่ระบบ";
} echo {
    echo "ยินดีต้อนรับ ".$_SESSION['username'];
}
?>