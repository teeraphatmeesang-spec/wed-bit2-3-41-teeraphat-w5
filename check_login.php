<?php
session_start();

// รับค่าจากฟอร์ม
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

// กำหนดเงื่อนไขสมมติ (หรือยอมให้ทุก Username/Password ผ่าน)
if (!empty($username) && !empty($password)) {
    $_SESSION['username'] = $username;
    header("Location: index.php");
    exit();
} else {
    echo "<script>alert('กรุณากรอกข้อมูลให้ครบถ้วน'); window.location.href='login.html';</script>";
}
?>