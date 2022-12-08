<?php
require_once("../config/config.php");


if (is_connected()) {
    header("Location: ../view/index.php");
    exit();
}
if (!test_form()) {
    header("Location: ../index.php");
    exit();
}

global $conn;
$login = $_POST['login'];
$password = $_POST['password'];

$sql = "SELECT * FROM b__compte WHERE login = :login";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':login', $login);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

if ($result) {
    if (password_verify($password, $result['password'])) {
        $_SESSION['user'] = $result['id'];
        $_SESSION['login'] = $result['login'];
        $_SESSION['nom'] = $result['nom'];
        $_SESSION['prenom'] = $result['prenom'];
        $_SESSION['email'] = $result['email'];
        $_SESSION['role'] = $result['role'];
        auth_success();
    }
}
auth_fail();




function auth_success()
{
    if ($_SESSION['role'] == "ADMIN") {
        header("Location: ../view/admin/");
        exit();
    } else if ($_SESSION['role'] == "PO") {
        header("Location: ../view/po/");
        exit();
    }
    else if ($_SESSION['role'] == "CLIENT") {
        header("Location: ../view/client/");
        exit();
    }
}

function auth_fail()
{
    header("Location: ../index.php");
    exit();
}



function test_auth()
{
    if (isset($_SESSION['user'])) {
        auth_success();
    } else {
        auth_fail();
    }
}

/**
 * Test si le formulaire de connexion est correctement rempli
 */
function test_form()
{
    if (isset($_POST["login"]) && isset($_POST["password"])) {
        if (empty($_POST["login"]) || empty($_POST["password"])) {
            return false;
        }
        if (strlen($_POST["login"]) < 1 || strlen($_POST["login"]) < 1) {
            return false;
        }
        return true;
    }
    return false;
}
