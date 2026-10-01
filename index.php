<?php require_once "auth.php";
$p = $conn->query("SELECT COUNT(*) n FROM products")->fetch_assoc()["n"];
$u = $conn->query("SELECT COUNT(*) n FROM users")->fetch_assoc()["n"];
$o = $conn->query("SELECT COUNT(*) n FROM orders")->fetch_assoc()["n"];
$s = $conn->query("SELECT COALESCE(SUM(total),0) n FROM orders WHERE status<>'ยกเลิก'")->fetch_assoc()["n"];
include "header.php"; ?><div class="container py-5">
    
    <div class="row g-3 mt-2"><?php foreach ([["สินค้า", $p], ["สมาชิก", $u], ["คำสั่งซื้อ", $o], ["ยอดขาย", number_format($s, 2) . " บาท"]] as $a): ?>
        <div class="col-md-3">
                <div class="stat-card">
                    <h6><?= $a[0] ?></h6>
                    <h2><?= $a[1] ?></h2>
                </div>
            </div><?php endforeach; ?></div>
    <div class="mt-4 d-flex gap-2 flex-wrap"><a class="btn btn-primary" href="products.php">จัดการสินค้า</a>
    <a class="btn btn-outline-primary" href="categories.php">หมวดหมู่</a><a class="btn btn-outline-primary" href="orders.php">คำสั่งซื้อ</a>
    <a class="btn btn-outline-primary" href="users.php">สมาชิก</a>
</div>
</div><?php include "footer.php"; ?>