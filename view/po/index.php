<?php

require_once("../../config/config.php");
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Projet du BUT Informatique">
    <meta name="author" content="Delmas Denis, Edmee Léon">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <link rel="stylesheet" href="../../files/style.css">
    
    
    <title>Capgénépi Banque</title>
    <link rel="icon" href="../../files/img/genepi.png">
</head>
<?php
if (($_SESSION['user'] == null)  ||  ($_SESSION['role'] != "PO")) {
    header("Location: ../account_auth.php");
}
?>
<body>

<nav id="header_nav">
    <span>Gestionnaire de paiements</span>
    <span id="name"> Bienvenue <?= $_SESSION['prenom']." ".$_SESSION['nom']?></span>
    <a href="../index.php">Deconnexion</a>
</nav>
<section id="header">
    <h1>Capgénépi > Product Owner </h1>
</section>
<h2 class="text-center">Liste des comptes clients</h2>
<section id="liste-compte_client">
    <div class="compte_client">
        <div class="compte_client-nom">Carrefour Paris 13</div>
        <div class="compte_client-solde">Solde : 300 $</div>
    </div>
    <div class="compte_client">
        <div class="compte_client-nom">Carrefour Paris 13</div>
        <div class="compte_client-solde">Solde : 300 $</div>
    </div>
    <div class="compte_client">
        <div class="compte_client-nom">Carrefour Paris 13</div>
        <div class="compte_client-solde">Solde : 300 $</div>
    </div>
    <div class="compte_client">
        <div class="compte_client-nom">Carrefour Paris 13</div>
        <div class="compte_client-solde solde-negatif">Solde : - 300 $</div>
    </div>
    <div class="compte_client">
        <div class="compte_client-nom">Carrefour Paris 13</div>
        <div class="compte_client-solde solde-negatif">Solde : - 300 $</div>
    </div>
    <div class="compte_client">
        <div class="compte_client-nom">Carrefour Paris 13</div>
        <div class="compte_client-solde solde-negatif">Solde : - 300 $</div>
    </div>
    <div class="compte_client" onclick="click(1)">
        <div class="compte_client-nom">Carrefour Paris 13</div>
        <div class="compte_client-solde solde-negatif">Solde : - 300 $</div>
    </div>
</section>






<script>
    function show_compte_client(id) {
        // Truc à faire quand on clic sur un compte client
    }
</script>
</body>
</html>