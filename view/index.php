<?php
$file = "index.php";
require_once("../config/config.php");
require_once("../include/html.header.inc.php");
if (!isset($_SESSION['user'])) {
    header("Location: ./account_auth.php");
    exit();
}
?>
<h1> Vous êtes arrivé ici par erreur </h1>
</body>
</html>
<!-- Page d'accueil connecté avec une gestion des transactions -->
