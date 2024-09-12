<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit;
}

// ตรวจสอบสิทธิ์ของผู้ใช้
if ($_SESSION['role'] == 'admin') {
    echo "<h1>Welcome, Admin!</h1>";
    echo "<p>Here are the admin controls and settings.</p>";
} elseif ($_SESSION['role'] == 'member') {
    echo "<h1>Welcome, Member!</h1>";
    echo "<p>Here is your member dashboard.</p>";
} else {
    echo "<h1>Access denied!</h1>";
    exit;
}
?>
