<?php

require_once("../../config/config.php");
require_once("../../include/html.header.inc.php");

if (($_SESSION['user'] == null)  ||  ($_SESSION['role'] != "PO")) {
    header("Location: ../account_auth.php");
}
echo "Compte PO";
?>