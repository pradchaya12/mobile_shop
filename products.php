<?php require_once "auth.php";
$r = $conn->query("SELECT p.*,c.name category_name FROM products p LEFT JOIN categories c ON p.category_id=c.id ORDER BY p.id DESC");
include "header.php"; ?><div class="container py-5">
    <div class="d-flex justify-content-between">
        <h2>จัดการสินค้า</h2><a class="btn btn-primary" href="product_add.php">+ เพิ่มสินค้า</a>
    </div>
    <div class="table-responsive mt-3">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>สินค้า</th>
                    <th>หมวดหมู่</th>
                    <th>ราคา</th>
                    <th>สต็อก</th>
                    <th>จัดการ</th>
                </tr>
            </thead>
            <tbody><?php while ($p = $r->fetch_assoc()): ?><tr>
                        <td><?= $p["id"] ?></td>
                        <td><?= htmlspecialchars($p["name"]) ?></td>
                        <td><?= htmlspecialchars($p["category_name"] ?? "-") ?></td>
                        <td><?= number_format($p["price"], 2) ?></td>
                        <td><?= $p["qty"] ?></td>
                        <td><a class="btn btn-sm btn-warning" href="product_edit.php?id=<?= $p["id"] ?>">แก้ไข</a> 
                        <a class="btn btn-sm btn-danger" onclick="return confirm('ยืนยันการลบ?')" href="product_delete.php?id=<?= $p["id"] ?>">ลบ</a> 
                        <a class="btn btn-sm btn-secondary" href="../detail.php?id=<?= $p["id"] ?>">ดู</a></td>
                    </tr><?php endwhile; ?></tbody>
        </table>
    </div>