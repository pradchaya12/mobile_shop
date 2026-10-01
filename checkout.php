<?php require_once "config.php";
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit;
}
$uid = (int)$_SESSION["user"]["id"];
$error = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST["name"]);
    $phone = trim($_POST["phone"]);
    $address = trim($_POST["address"]);
    $r = $conn->query("SELECT c.*,p.name,p.price,p.qty stock FROM carts c JOIN products p ON p.id=c.product_id WHERE c.user_id=$uid");
    $items = [];
    $total = 0;
    while ($x = $r->fetch_assoc()) {
        $x["subtotal"] = $x["price"] * $x["quantity"];
        $total += $x["subtotal"];
        $items[] = $x;
    }
    if (!$items) $error = "ตะกร้าว่าง";
    else {
        $conn->begin_transaction();
        try {
            $st = $conn->prepare("INSERT INTO orders(user_id,customer_name,phone,address,total) VALUES(?,?,?,?,?)");
            $st->bind_param("isssd", $uid, $name, $phone, $address, $total);
            $st->execute();
            $oid = $conn->insert_id;
            foreach ($items as $x) {
                if ($x["quantity"] > $x["stock"]) throw new Exception();
                $a = $conn->prepare("INSERT INTO order_items(order_id,product_id,product_name,price,quantity,subtotal) VALUES(?,?,?,?,?,?)");
                $a->bind_param("iisdid", $oid, $x["product_id"], $x["name"], $x["price"], $x["quantity"], $x["subtotal"]);
                $a->execute();
                $b = $conn->prepare("UPDATE products SET qty=qty-? WHERE id=?");
                $b->bind_param("ii", $x["quantity"], $x["product_id"]);
                $b->execute();
            }
            $conn->query("DELETE FROM carts WHERE user_id=$uid");
            $conn->commit();
            header("Location: order_success.php?id=$oid");
            exit;
        } catch (Exception $e) {
            $conn->rollback();
            $error = "สินค้าไม่เพียงพอหรือบันทึกไม่สำเร็จ";
        }
    }
}
include "header.php"; ?>
<div class="container py-5">
    <div class="auth-card">
        <h2>ยืนยันการสั่งซื้อ</h2><?php if ($error): ?><div class="alert alert-danger"><?= $error ?></div><?php endif; ?><form method="post"><input class="form-control mb-3" name="name" placeholder="ชื่อผู้รับ" required><input class="form-control mb-3" name="phone" placeholder="เบอร์โทร"><textarea class="form-control mb-3" name="address" rows="4" placeholder="ที่อยู่จัดส่ง" required></textarea><button class="btn btn-primary w-100">ยืนยันการสั่งซื้อ</button></form>
    </div>