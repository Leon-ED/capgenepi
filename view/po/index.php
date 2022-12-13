<?php

require_once("../../config/config.php");

if (($_SESSION['user'] == null)  ||  ($_SESSION['role'] != "PO")) {
    header("Location: ../account_auth.php");
}

require_once("../../include/html.header.inc.php");


?>

<body>

    <nav id="header_nav">
        <h1>Gestionnaire de paiements</h1>
        <h2 id="name"> <?= $_SESSION['prenom'] . " " . $_SESSION['nom'] ?></h2>
        <a onclick="logout()" href="../index.php">Deconnexion</a>
    </nav>

    <dialog id="dialog_transac">
        <div class="dialog_header">
            <button id="dialog_close" onclick="close_dialog()">X</button><br><br>
            <h1 class="dialog_title">Transactions de la remise N° <span id="detail_remise_numero">5842684</span></h1>
        </div>
        <div class="dialog_content">
            <div class="tableau_dialog_transac">
                <table id="table_dialog_transac">
                    <thead>
                        <tr>
                            <th>SIREN</th>
                            <th>Date</th>
                            <th>Carte N°</th>
                            <th>Réseau</th>
                            <th>Autorisation N°</th>
                            <th>Devise</th>
                            <th>Sens</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>

                </table>


            </div>
        </div>
    </dialog>
    <!-- open dialog 1-->




    <article id="article_po" class="flex_row">
        <section id="recherche">
            <h1>Recherche Clients</h1>
            <div id="formulaire_recherche">
                <div class="formulaire_header">
                    <span class="form_link" name="tresorerie" data-selected="true">Trésorerie</span>
                    <span class="form_link" name="remises">Remises</span>
                    <span class="form_link" name="impayes">Impayes</span>
                </div>
                <!-- FORMULAIRE TRESORERIE -->
                <div class="formulaire_input" id="form_tresorerie" style="display:flex">
                    <input type="text" placeholder="Raison Sociale" name="raison_sociale" id="libelle">
                    <input type="text" placeholder="SIREN" name="SIREN" id="SIREN_libre">
                    <input type="hidden" id="form_type" value="tresorerie">
                    <select id="SIREN_select">
                        <option value="none">--Sélectionner SIREN--</option>
                        <?php
                        $liste = get_compte_list();
                        foreach ($liste as $compte) {
                            $SIREN = $compte['SIREN'];
                            $nom = $compte['Raison_sociale'];
                            echo '<option value="' . $SIREN . '">' . $SIREN . ' - ' . $nom . '</option>';
                        }

                        ?>
                    </select>
                </div>

                <button id="btn_recherche" onclick="form_search()">Rechercher</button>
            </div>
        </section>
        <section id="comptes_clients">
            <h1><span id="search_result">x</span> Résultat(s) recherche </h1>
            <small>seul les clients avec au minimum 1 transaction sont affichés</small>
            <div id="liste_clients">

            </div>


            </div>


        </section>
    </article>
    <article id="article_po" class="flex_row">
        <section id="tableau" style="display: none">
            <h1><span id="table_cat"></span><span id="table_desc"></span></h1>
            <div id="tableau_remises" class="tableau_remises tableau" style="display:none">
                <table title="Tableau des remises" name="nom" id="tableau_remises_html">
                    <thead>
                        <tr>
                            <th>SIREN</th>
                            <th>Raison sociale</th>
                            <th>Date</th>
                            <th>ID Remise</th>
                            <th>Nombre de transactions</th>
                            <th>Devise</th>
                            <th>Montant total</th>
                        </tr>

                    </thead>
                    <tbody>
                        
                        <!-- GENERER ICI EN AJAX LES DONNES SELON LA RECHERCHE -->
                    </tbody>
                </table>

            </div>
            <div id="tableau_impayes" class="tableau_impayes tableau" style="display:none;">
                <table id="tableau_impayes_html">
                    <thead>
                        <tr>
                            <th>SIREN</th>
                            <th>Raison sociale</th>
                            <th>Date</th>
                            <th>Num. Dossier</th>
                            <th>Num Transaction</th>
                            <th>Num Remise</th>
                            <th>Carte N°</th>
                            <th>Sens</th>
                            <th>Montant</th>
                            <th>Devise</th>
                            <th>Raison</th>
                        </tr>

                    </thead>
                    <tbody>
                        <!-- GENERER ICI EN AJAX LES DONNES SELON LA RECHERCHE -->

                    </tbody>
                </table>

            </div>
            <div class="control_table">
                <div>
                    <label>Afficher : </label>
                    <input type="number" min="1" max="100" id="showLINES" value="15">
                </div>
                <div>
                    <label>Page numéro : </label>
                    <input type="number" min="1" max="100" id="showPAGE" value="1">
                </div>
                <div>
                    <div class="dropdown">
                        <button class="dropbtn">Exporter</button>
                        <div class="dropdown-content">
                            <button value="pdf" id="pdf_click">PDF</button>
                            <button value="csv" onclick="TableToCSV()">CSV</button>
                            <button value="xls" onclick="TableToXLS()">XLS</button>
                        </div>
                    </div>
                </div>



        </section>
        <section id=" graphique">
            <h1>Graphique</h1>
            <!-- highcharts graph -->
            <div id="tresorerie_graph" class="graph" style=" display:block;margin: 0 auto"></div>
            <div id="remises_graph" class="graph" style=" display:none;margin: 0 auto"></div>
            <div id="impayes_graph" class="graph" style=" display:none;margin: 0 auto"></div>






        </section>
    </article>


</body>

</html>