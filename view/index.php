<?php
$file = "index.php";
require_once("../config/config.php");
require_once("../include/html.header.inc.php");
if (!isset($_SESSION['user'])) {
    header("Location: ./account_auth.php");
    exit();
}
