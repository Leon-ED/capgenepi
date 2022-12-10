<?php
$file = "index.php";
require_once("../config/config.php");

if (!isset($_SESSION['user'])) {
    header("Location: ./account_auth.php");
    exit();
}
else {
    require_once("../controller/functions.php");
    auth_success();
}
?>
<h1> Page de Redirection </h1>
</body>
</html>
