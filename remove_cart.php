<?php require_once "config.php";
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit;
}
$id = (int)$_GET["id"];
$uid = (int)$_SESSION["user"]["id"];
$st = $conn->prepare("DELETE FROM carts WHERE id=? AND user_id=?");
$st->bind_param("ii", $id, $uid);
$st->execute();
header("Location: cart.php");
exit;
