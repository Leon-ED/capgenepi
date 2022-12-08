<?php

require_once("../../config/config.php");
require_once("../../controller/po_controller.php");

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
    <script src="../../files/product_owner.js" defer></script>


    <title>Capgénépi Banque</title>
    <link rel="icon" href="../../files/img/genepi.png">
</head>
<?php

?>

<body>

    <nav id="header_nav">
        <span>Gestionnaire de paiements</span>
        <span id="name"> Bienvenue <?= $_SESSION['prenom'] . " " . $_SESSION['nom'] ?></span>
        <a href="../index.php">Deconnexion</a>
    </nav>
    <section id="header">
        <h1>Capgénépi > Product Owner </h1>
    </section>
    <article id="po_recherche">
        <section class="po_search-form">
            <div class="po_search-tab">
                <a href="#" data-tab="po_search-tab-tresorerie" data-selected="false" id="tresorerie">Trésorerie</a>
                <a href="#" data-tab="po_search-tab-remises" id="remises">Remises</a>
                <a href="#" data-tab="po_search-tab-impayes" id="impayes">Impayés</a>
            </div>
            <div id="po_search-tab-tresorerie" class="form_elems" style="display:flex">
                <input type="hidden" name="type_recherche" value="tresorerie">
                <input id="po_search-tab-tresorerie-raison_sociale" type="text" placeholder="Recherche Raison Sociale">
                <select id="po_search-tab-tresorerie-SIREN">
                    <option value="0" selected>Sélectionner SIREN</option>
                    <?php
                    $datas = get_all_client_data();
                    foreach ($datas as $client) {
                        echo "<option value='" . $client['SIREN'] . "'>" . $client['SIREN'] . " - " . $client["Raison_sociale"] . "</option>";
                    }

                    ?>
                </select>
            </div>

            <div id="po_search-tab-remises" style="display:none">
                <input type="hidden" name="type_recherche" value="remises">
                <input id="po_search-tab-tresorerie-raison_sociale" type="text" placeholder="Recherche Raison Sociale">
                <select id="po_search-tab-tresorerie-SIREN">
                    <option value="0" selected>Sélectionner SIREN</option>
                    <?php
                    $datas = get_all_client_data();
                    foreach ($datas as $client) {
                        echo "<option value='" . $client['SIREN'] . "'>" . $client['SIREN'] . " - " . $client["Raison_sociale"] . "</option>";
                    }

                    ?>
                </select>
            </div>
            <div id="po_search-tab-impayes" style="display:none">
                <input type="hidden" name="type_recherche" value="impayes">


                b
            </div>
            <div class="po_search-form-btn">
                <button id="po_search-form-btn-search" class="send">Rechercher</button>
                <button id="po_search-form-btn-reset" class="reset">Réinitialiser</button>
            </div>
        </section>
        <section>
            <h2>Liste des comptes clients</h2>
            <p>(cliquer pour accéder au compte client)</p>
            <section id="liste-compte_client">
                <?php show_compte_liste(); ?>
            </section>
            <section>
    </article>


    <section id="compte_client_details">
        <div class="compte_client_details-header">
            <h1>Details du compte client : </h1>
            <span id="compte_client_details-libelle">NOM</span>, SIREN : <span id="compte_client_details-SIREN">SIREN</span>
        </div>
        <div class="compte_client_details-form">
        </div>







    </section>






    <script>
        function show_compte_client(id) {
            // Truc à faire quand on clic sur un compte client
        }
    </script>
</body>

</html>