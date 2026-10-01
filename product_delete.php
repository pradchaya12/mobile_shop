<?php require_once "auth.php";
$id = (int)$_GET["id"];
$st = $conn->prepare("DELETE FROM products WHERE id=?");
$st->bind_param("i", $id);
$st->execute();
header("Location: products.php");
exit;
