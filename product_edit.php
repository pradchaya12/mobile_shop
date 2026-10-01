<?php require_once "auth.php";
$id = (int)($_GET["id"] ?? 0);
$st = $conn->prepare("SELECT * FROM products WHERE id=?");
$st->bind_param("i", $id);
$st->execute();
$p = $st->get_result()->fetch_assoc();
if (!$p) {
    header("Location: products.php");
    exit;
}
$cats = $conn->query("SELECT * FROM categories ORDER BY name");
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST["name"]);
    $brand = trim($_POST["brand"]);
    $cat = (int)$_POST["category_id"];
    $price = (float)$_POST["price"];
    $qty = (int)$_POST["qty"];
    $desc = trim($_POST["description"]);
    $detail = trim($_POST["detail"]);
    $image = $p["image"];
    if (!empty($_FILES["image"]["name"])) {
        $ext = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));
        if (in_array($ext, ["jpg", "jpeg", "png", "webp"])) {
            $image = uniqid("phone_") . "." . $ext;
            move_uploaded_file($_FILES["image"]["tmp_name"], __DIR__ . "/../uploads/products/" . $image);
        }
    }
    $st = $conn->prepare("UPDATE products SET category_id=?,name=?,description=?,brand=?,price=?,qty=?,detail=?,image=? WHERE id=?");
    $st->bind_param("isssdissi", $cat, $name, $desc, $brand, $price, $qty, $detail, $image, $id);
    $st->execute();
    header("Location: products.php");
    exit;
}
include "header.php"; ?><div class="container py-5">
    <h2>แก้ไขสินค้า</h2>
    <form method="post" enctype="multipart/form-data" class="card card-body">
        <div class="row">
            <div class="col-md-6"><input class="form-control mb-3" name="name" value="<?= htmlspecialchars($p["name"]) ?>" required><input class="form-control mb-3" name="brand" value="<?= htmlspecialchars($p["brand"]) ?>"><select class="form-select mb-3" name="category_id"><?php while ($c = $cats->fetch_assoc()): ?><option value="<?= $c["id"] ?>" <?= $p["category_id"] == $c["id"] ? "selected" : "" ?>><?= htmlspecialchars($c["name"]) ?></option><?php endwhile; ?></select><input class="form-control mb-3" type="number" step="0.01" name="price" value="<?= $p["price"] ?>" required><input class="form-control mb-3" type="number" name="qty" value="<?= $p["qty"] ?>" required></div>
            <div class="col-md-6"><textarea class="form-control mb-3" name="description" rows="4"><?= htmlspecialchars($p["description"]) ?></textarea><textarea class="form-control mb-3" name="detail" rows="5"><?= htmlspecialchars($p["detail"]) ?></textarea><input class="form-control mb-3" type="file" name="image"></div>
        </div><button class="btn btn-primary">บันทึกการแก้ไข</button>
    </form>