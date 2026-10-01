<?php require_once "config.php";
$q = trim($_GET["q"] ?? "");
$cat = (int)($_GET["category"] ?? 0);
$sql = "SELECT p.*,c.name category_name FROM products p LEFT JOIN categories c ON p.category_id=c.id WHERE 1";
if ($q !== "") {
    $s = $conn->real_escape_string($q);
    $sql .= " AND (p.name LIKE '%$s%' OR p.brand LIKE '%$s%')";
}
if ($cat) $sql .= " AND p.category_id=$cat";
$sql .= " ORDER BY p.id DESC";
$products = $conn->query($sql);
$cats = $conn->query("SELECT * FROM categories ORDER BY name");
include "header.php"; ?>



<div class="container">
    <form class="row g-2 mb-4">
        <div class="col-md-6"><input class="form-control" name="q" value="<?= htmlspecialchars($q) ?>" placeholder="ค้นหาชื่อหรือยี่ห้อ"></div>
        <div class="col-md-4"><select class="form-select" name="category">
                <option value="0">ทุกหมวดหมู่</option><?php while ($c = $cats->fetch_assoc()): ?><option value="<?= $c["id"] ?>"
                        <?= $cat == $c["id"] ? "selected" : "" ?>><?= htmlspecialchars($c["name"]) ?></option><?php endwhile; ?>
            </select></div>
        <div class="col-md-2"><button class="btn btn-success w-100">ค้นหา</button></div>
    </form>
    <div class="row g-4"><?php while ($p = $products->fetch_assoc()): ?><div class="col-md-6 col-lg-4 col-xl-3">
                <div class="card product-card h-100"><?php if ($p["image"]): ?>
                        <img class="card-img-top product-img" src="uploads/products/<?= htmlspecialchars($p["image"]) ?>"><?php else: ?>
                        <div class="placeholder-img"></div><?php endif; ?><div class="card-body d-flex flex-column">
                        <small><?= htmlspecialchars($p["brand"]) ?> · <?= htmlspecialchars($p["category_name"] ?? "") ?></small>
                        <h5><?= htmlspecialchars($p["name"]) ?></h5>
                        <p class="text-muted small"><?= htmlspecialchars($p["description"] ?? "") ?></p>
                        <h4 class="text-primary mt-auto"><?= number_format($p["price"], 2) ?> บาท</h4>
                        <div class="d-flex gap-2"><a class="btn btn-outline-primary flex-fill"
                                href="detail.php?id=<?= $p["id"] ?>">รายละเอียด</a><?php if ($p["qty"] > 0): ?>
                                <a class="btn btn-primary" href="add_cart.php?id=<?= $p["id"] ?>">ซื้อ</a><?php else: ?>
                                <button class="btn btn-secondary" disabled>หมด</button><?php endif; ?>
                        </div>
                    </div>
                </div>
            </div><?php endwhile; ?></div>
</div><?php include "footer.php"; ?>