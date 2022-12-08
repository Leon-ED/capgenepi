<?php
require_once("../config/config.php");

if (($_SESSION['user'] == null)  ||  ($_SESSION['role'] != "PO")) {
    header("Location: ../view/account_auth.php");
}

function generate_compte_list(){
    global $conn;
    $sql = "SELECT * FROM b__client";
    $req = $conn->prepare($sql);
    $req->execute();




}