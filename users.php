<?php require_once "auth.php";
$r = $conn->query("SELECT id,name,email,role,created_at FROM users ORDER BY id DESC");
include "header.php"; ?><div class="container py-5">
    <h2>สมาชิก</h2>
    <table class="table table-bordered">
        <tr>
            <th>ID</th>
            <th>ชื่อ</th>
            <th>อีเมล</th>
            <th>สิทธิ์</th>
            <th>วันที่</th>
        </tr><?php while ($u = $r->fetch_assoc()): ?><tr>
                <td><?= $u["id"] ?></td>
                <td><?= htmlspecialchars($u["name"]) ?></td>
                <td><?= htmlspecialchars($u["email"]) ?></td>
                <td><?= $u["role"] ?></td>
                <td><?= $u["created_at"] ?></td>
            </tr><?php endwhile; ?>
    </table>