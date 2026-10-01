<?php require_once "config.php";
$id = (int)($_GET["id"] ?? 0);
$st = $conn->prepare("SELECT p.*,c.name category_name FROM products p LEFT JOIN categories c ON p.category_id=c.id WHERE p.id=?");
$st->bind_param("i", $id);
$st->execute();
$p = $st->get_result()->fetch_assoc();
if (!$p) {
    header("Location: shop.php");
    exit;
}
include "header.php"; ?>
<div class="container py-5">
    <div class="row g-5">
        <div class="col-md-5"><?php if ($p["image"]): ?><img class="img-fluid rounded" src="uploads/products/<?= htmlspecialchars($p["image"]) ?>"><?php else: ?><div class="placeholder-img detail-img">📱</div><?php endif; ?></div>
        <div class="col-md-7"><span class="badge bg-secondary"><?= htmlspecialchars($p["category_name"] ?? "") ?></span>
            <h1><?= htmlspecialchars($p["name"]) ?></h1>
            <p><?= htmlspecialchars($p["brand"]) ?></p>
            <h2 class="text-primary"><?= number_format($p["price"], 2) ?> บาท</h2>
            <p><?= nl2br(htmlspecialchars($p["description"] ?? "")) ?></p>
            <div class="border rounded p-3 mb-3"><?= nl2br(htmlspecialchars($p["detail"] ?? "-")) ?></div>
            <p>คงเหลือ <b><?= $p["qty"] ?></b> เครื่อง</p><?php if ($p["qty"]): ?><a class="btn btn-primary btn-lg" href="add_cart.php?id=<?= $p["id"] ?>">เพิ่มลงตะกร้า</a><?php endif; ?>
        </div>
    </div>