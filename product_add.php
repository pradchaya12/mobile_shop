<?php require_once "auth.php";
$cats = $conn->query("SELECT * FROM categories ORDER BY name");
$error = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST["name"]);
    $brand = trim($_POST["brand"]);
    $cat = (int)$_POST["category_id"];
    $price = (float)$_POST["price"];
    $qty = (int)$_POST["qty"];
    $desc = trim($_POST["description"]);
    $detail = trim($_POST["detail"]);
    $image = "";
    if (!empty($_FILES["image"]["name"])) {
        $ext = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));
        if (in_array($ext, ["jpg", "jpeg", "png", "webp"])) {
            $image = uniqid("phone_") . "." . $ext;
            move_uploaded_file($_FILES["image"]["tmp_name"], __DIR__ . "/../uploads/products/" . $image);
        } else $error = "รองรับ JPG PNG WEBP เท่านั้น";
    }
    if (!$error) {
        $st = $conn->prepare("INSERT INTO products(category_id,name,description,brand,price,qty,detail,image) VALUES(?,?,?,?,?,?,?,?)");
        $st->bind_param("isssdiss", $cat, $name, $desc, $brand, $price, $qty, $detail, $image);
        $st->execute();
        header("Location: products.php");
        exit;
    }
}
include "header.php"; ?><div class="container py-5">
    <h2>เพิ่มสินค้า</h2><?php if ($error): ?><div class="alert alert-danger"><?= $error ?></div><?php endif; ?><form method="post" enctype="multipart/form-data" class="card card-body">
        <div class="row">
            <div class="col-md-6"><input class="form-control mb-3" name="name" placeholder="ชื่อสินค้า" required>
            <input class="form-control mb-3" name="brand" placeholder="ยี่ห้อ"><select class="form-select mb-3" name="category_id"><?php while ($c = $cats->fetch_assoc()): ?>
                <option value="<?= $c["id"] ?>"><?= htmlspecialchars($c["name"]) ?></option><?php endwhile; ?></select><input class="form-control mb-3" type="number" step="0.01" name="price" placeholder="ราคา" required>
                <input class="form-control mb-3" type="number" name="qty" placeholder="จำนวน" required></div>
            <div class="col-md-6"><textarea class="form-control mb-3" name="description" placeholder="คำอธิบาย">
            </textarea><textarea class="form-control mb-3" name="detail" rows="5" placeholder="รายละเอียด">

            </textarea><input class="form-control mb-3" type="file" name="image" accept=".jpg,.jpeg,.png,.webp"></div>
        </div><button class="btn btn-primary">บันทึก</button>
    </form>