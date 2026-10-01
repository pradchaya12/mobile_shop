<?php require_once "config.php";
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit;
}
$uid = (int)$_SESSION["user"]["id"];
if (isset($_POST["update"])) foreach ($_POST["qty"] as $id => $q) {
    $id = (int)$id;
    $q = max(1, (int)$q);
    $st = $conn->prepare("UPDATE carts c JOIN products p ON p.id=c.product_id SET c.quantity=LEAST(?,p.qty) WHERE c.id=? AND c.user_id=?");
    $st->bind_param("iii", $q, $id, $uid);
    $st->execute();
}
$r = $conn->query("SELECT c.*,p.name,p.price,p.qty stock FROM carts c JOIN products p ON p.id=c.product_id WHERE c.user_id=$uid");
$total = 0;
include "header.php"; ?>
<div class="container py-5">
    <h2>ตะกร้าสินค้า</h2>
    <form method="post"><input type="hidden" name="update" value="1">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>สินค้า</th>
                        <th>ราคา</th>
                        <th>จำนวน</th>
                        <th>รวม</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody><?php while ($x = $r->fetch_assoc()): $sub = $x["price"] * $x["quantity"];
                            $total += $sub; ?><tr>
                            <td><?= htmlspecialchars($x["name"]) ?></td>
                            <td><?= number_format($x["price"], 2) ?></td>
                            <td><input class="form-control" style="max-width:100px" type="number" min="1" max="<?= $x["stock"] ?>" name="qty[<?= $x["id"] ?>]" value="<?= $x["quantity"] ?>"></td>
                            <td><?= number_format($sub, 2) ?></td>
                            <td><a class="btn btn-sm btn-danger" href="remove_cart.php?id=<?= $x["id"] ?>">ลบ</a></td>
                        </tr><?php endwhile; ?></tbody>
            </table>
        </div><button class="btn btn-outline-primary">อัปเดต</button><span class="float-end fs-4">รวม <?= number_format($total, 2) ?> บาท <a class="btn btn-primary" href="checkout.php">สั่งซื้อ</a></span>
    </form>
</div><?php include "footer.php"; ?>