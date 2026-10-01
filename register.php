<?php require_once "config.php";
$error = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $pw = $_POST["password"];
    if (strlen($pw) < 6) $error = "รหัสผ่านต้องมีอย่างน้อย 6 ตัวอักษร";
    else {
        $h = password_hash($pw, PASSWORD_DEFAULT);
        $st = $conn->prepare("INSERT INTO users(name,email,password) VALUES(?,?,?)");
        $st->bind_param("sss", $name, $email, $h);
        if ($st->execute()) {
            header("Location: login.php");
            exit;
        } else $error = "อีเมลนี้ถูกใช้งานแล้ว";
    }
}
include "header.php"; ?><div class="container py-5">
    <div class="auth-card">
        <h2>สมัครสมาชิก</h2><?php if ($error): ?><div class="alert alert-danger"><?= $error ?></div><?php endif; ?><form method="post"><input class="form-control mb-3" name="name" placeholder="ชื่อ" required><input class="form-control mb-3" type="email" name="email" placeholder="อีเมล" required><input class="form-control mb-3" type="password" name="password" placeholder="รหัสผ่านอย่างน้อย 6 ตัว" required><button class="btn btn-primary w-100">สมัครสมาชิก</button></form>
    </div>
</div><?php include "footer.php"; ?>