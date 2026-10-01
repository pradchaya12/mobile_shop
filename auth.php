<?php require_once __DIR__ . "/../config.php";
if (!isset($_SESSION["user"]) || $_SESSION["user"]["role"] !== "admin") {
    header("Location: ../login.php");
    exit;
}
