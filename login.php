<?php
session_start();
require_once 'config.php';  // เชื่อมต่อฐานข้อมูล

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST[''];
    $password = $_POST[''];

    // ตรวจสอบข้อมูลในฐานข้อมูล
    $stmt = $conn->prepare("SELECT id, password, role FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 1) {
        $stmt->bind_result($id, $hashed_password, $role);
        $stmt->fetch();

        // ตรวจสอบรหัสผ่าน
        if (hash('sha256', $password) === $hashed_password) {
            // เก็บข้อมูลลงใน session
            $_SESSION['user_id'] = $id;
            $_SESSION['role'] = $role;
            
            // นำผู้ใช้ไปยังแดชบอร์ด
            header("Location: dashboard.php");
            exit;
        } else {
            // รหัสผ่านไม่ถูกต้อง
            header("Location: login.html?error=1");
            exit;
        }
    } else {
        // ชื่อผู้ใช้ไม่ถูกต้อง
        header("Location: login.html?error=1");
        exit;
    }
}
?>
