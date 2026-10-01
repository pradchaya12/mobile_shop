<?php require_once "config.php";
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit;
}
include "header.php"; ?><div class="container py-5 text-center">
    <div class="card card-body">
        <h1 class="text-success">สั่งซื้อสำเร็จ </h1>
        <p>เลขที่คำสั่งซื้อ #<?= htmlspecialchars($_GET["id"] ?? "") ?></p><a class="btn btn-primary" href="orders.php">ดูคำสั่งซื้อ</a>
    </div>
</div><?php include "footer.php"; ?>