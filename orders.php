<?php require_once "auth.php";
if (isset($_POST["status"])) {
    $id = (int)$_POST["id"];
    $s = $_POST["status"];
    $st = $conn->prepare("UPDATE orders SET status=? WHERE id=?");
    $st->bind_param("si", $s, $id);
    $st->execute();
}
$r = $conn->query("SELECT * FROM orders ORDER BY id DESC");
include "header.php"; ?><div class="container py-5">
    <h2>จัดการคำสั่งซื้อ</h2>
    <table class="table table-bordered">
        <tr>
            <th>เลขที่</th>
            <th>ลูกค้า</th>
            <th>ยอด</th>
            <th>สถานะ</th>
            <th>วันที่</th>
        </tr><?php while ($o = $r->fetch_assoc()): ?><tr>
                <td>#<?= $o["id"] ?></td>
                <td><?= htmlspecialchars($o["customer_name"]) ?></td>
                <td><?= number_format($o["total"], 2) ?></td>
                <td>
                    <form method="post" class="d-flex"><input type="hidden" name="id" value="<?= $o["id"] ?>"><select name="status" class="form-select"><?php foreach (["รอดำเนินการ", "กำลังจัดส่ง", "จัดส่งแล้ว", "ยกเลิก"] as $s): ?><option <?= $o["status"] === $s ? "selected" : "" ?>><?= $s ?></option><?php endforeach; ?></select><button class="btn btn-primary ms-1">บันทึก</button></form>
                </td>
                <td><?= $o["created_at"] ?></td>
            </tr><?php endwhile; ?>
    </table>