<?php require_once "config.php";
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit;
}
$id = (int)($_GET["id"] ?? 0);
$uid = (int)$_SESSION["user"]["id"];
$st = $conn->prepare("SELECT qty FROM products WHERE id=?");
$st->bind_param("i", $id);
$st->execute();
$p = $st->get_result()->fetch_assoc();
if ($p && $p["qty"] > 0) {
    $st = $conn->prepare("INSERT INTO carts(user_id,product_id,quantity) VALUES(?,?,1) ON DUPLICATE KEY UPDATE quantity=LEAST(quantity+1,?)");
    $st->bind_param("iii", $uid, $id, $p["qty"]);
    $st->execute();
}
header("Location: cart.php");
exit;
