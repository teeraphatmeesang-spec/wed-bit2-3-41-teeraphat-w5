<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // สำหรับทดสอบกำหนด admin / 1234
    if ($username === 'admin' && $password === '1234') {
        $_SESSION['user'] = $username;
        header("Location: index.php");
        exit();
    } else {
        echo "<script>
                alert('ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง!');
                window.location.href = 'login.php';
              </script>";
        exit();
    }
}
?>