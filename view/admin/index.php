<?php

require_once("../../config/config.php");

if (($_SESSION['user'] == null)  ||  ($_SESSION['role'] != "ADMIN")) {
    header("Location: ../account_auth.php");
}

require_once("../../include/html.header.inc.php");


?>

<nav id="header_nav">
    <span>Gestionnaire de paiements</span>
    <span id="name"> Bienvenue <?= $_SESSION['prenom']." ".$_SESSION['nom']?></span>
    <a onclick="logout()">Deconnexion</a>
</nav>
<section id="header">
    <h1>Capgénépi > Administration </h1>
</section>