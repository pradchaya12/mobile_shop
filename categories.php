<?php require_once "auth.php";
if (isset($_POST["name"])) {
    $n = trim($_POST["name"]);
    if ($n) {
        $st = $conn->prepare("INSERT IGNORE INTO categories(name) VALUES(?)");
        $st->bind_param("s", $n);
        $st->execute();
    }
}
if (isset($_GET["delete"])) {
    $id = (int)$_GET["delete"];
    $st = $conn->prepare("DELETE FROM categories WHERE id=?");
    $st->bind_param("i", $id);
    $st->execute();
}
$r = $conn->query("SELECT c.*,COUNT(p.id) n FROM categories c LEFT JOIN products p ON p.category_id=c.id GROUP BY c.id");
include "header.php"; ?><div class="container py-5">
    <h2>จัดการหมวดหมู่</h2>
    <form method="post" class="d-flex gap-2 my-3"><input class="form-control" name="name" placeholder="ชื่อหมวดหมู่" required><button class="btn btn-primary">เพิ่ม</button></form>
    <table class="table table-bordered">
        <tr>
            <th>หมวดหมู่</th>
            <th>สินค้า</th>
            <th>จัดการ</th>
        </tr><?php while ($c = $r->fetch_assoc()): ?><tr>
                <td><?= htmlspecialchars($c["name"]) ?></td>
                <td><?= $c["n"] ?></td>
                <td><a class="btn btn-sm btn-danger" onclick="return confirm('ลบ?')" href="?delete=<?= $c["id"] ?>">ลบ</a></td>
            </tr><?php endwhile; ?>
    </table>
