<?php require_once "config.php";
if (isset($_SESSION["user"])) {
    header("Location: shop.php");
    exit;
}
$error = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST["email"] ?? "");
    $pw = $_POST["password"] ?? "";
    $st = $conn->prepare("SELECT * FROM users WHERE email=? LIMIT 1");
    $st->bind_param("s", $email);
    $st->execute();
    $u = $st->get_result()->fetch_assoc();
    if ($u && password_verify($pw, $u["password"])) {
        $_SESSION["user"] = $u;
        header("Location: shop.php");
        exit;
    }
    $error = "อีเมลหรือรหัสผ่านไม่ถูกต้อง";
}
include "header.php"; ?>
<div class="container py-5">
    <div class="auth-card">
        <h2>เข้าสู่ระบบ</h2><?php if ($error): ?><div class="alert alert-danger"><?= $error ?></div>
            <?php endif; ?>
            <form method="post"><input class="form-control mb-3" type="email" name="email" placeholder="อีเมล" required>
            <input class="form-control mb-3" type="password" name="password" placeholder="รหัสผ่าน" required>
            <button class="btn btn-primary w-100">เข้าสู่ระบบ</button></form>
    </div>
</div><?php include "footer.php"; ?>