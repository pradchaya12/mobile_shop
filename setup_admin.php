<?php
require_once "config.php";
$name = "ผู้ดูแลระบบ";
$email = "admin@mobileshop.com";
$password = password_hash("admin123", PASSWORD_DEFAULT);
$role = "admin";
$st = $conn->prepare("INSERT INTO users(name,email,password,role) VALUES(?,?,?,?) ON DUPLICATE KEY UPDATE password=VALUES(password),role='admin',name=VALUES(name)");
$st->bind_param("ssss", $name, $email, $password, $role);
$st->execute();
echo "สร้าง/อัปเดต Admin สำเร็จ<br>Email: admin@mobileshop.com<br>Password: admin123<br><br>ลบไฟล์ setup_admin.php หลังใช้งานเพื่อความปลอดภัย";
