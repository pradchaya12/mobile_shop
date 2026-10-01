<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "mobile_shop";
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) die("เชื่อมต่อฐานข้อมูลไม่สำเร็จ: " . $conn->connect_error);
$conn->set_charset("utf8mb4");
if (session_status() === PHP_SESSION_NONE) session_start();
