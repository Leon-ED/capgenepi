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
    <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
    <script src="../../files/product_owner.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js" integrity="sha512-qZvrmS2ekKPF2mSznTQsxqPgnpkI4DNTlrdUmTzrDgektczlKNRRhy5X5AAOnx5S09ydFYWWNSfcEqDTTHgtNA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.28/jspdf.plugin.autotable.min.js" integrity="sha512-03CCNkeosDFN2zCCu4vLpu3pJfZcrL48F3yB8k87ejT+OVMwco7IH3FW02vtbGhdncS6gyYZ/duYaC/K62xQPQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <title>Capgénépi Banque</title>
    <link rel="icon" href="../../files/img/genepi.png">
</head>
<?php

?>

<body>

    <nav id="header_nav">
        <h1>Gestionnaire de paiements</h1>
        <h2 id="name"> <?= $_SESSION['prenom'] . " " . $_SESSION['nom'] ?></h2>
        <a href="../index.php">Deconnexion</a>
    </nav>

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
                    <input type="text" placeholder="Raison Sociale" name="raison_sociale">
                    <input type="text" placeholder="SIREN" name="SIREN">
                    <select>
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
                <!-- FORMULAIRE REMISES -->
                <div class="formulaire_input" id="form_remises" style="display:none">
                    <input type="text" placeholder="Raison Sociale" name="raison_sociale">
                    <input type="text" placeholder="SIREN" name="SIREN">
                    <select>
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
                <!-- FORMULAIRE IMPAYES -->
                <div class="formulaire_input" id="form_impayes" style="display:none">
                    <input type="text" placeholder="Raison Sociale" name="raison_sociale">
                    <input type="text" placeholder="SIREN" name="SIREN">
                    <select>
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

                <button id="btn_recherche">Rechercher</button>
            </div>
        </section>
        <section id="comptes_clients">
            <h1><span id="search_result">8</span> Résultat(s) recherche </h1>
            <div id="liste_clients">
                <div class="client">
                    <div class="client_header">
                        <span class="client_nom">ACTION CONTRE LA SOIF</span>
                        <span class="client_solde_negatif">30 000 €</span>
                    </div>
                    <span class="client_siren">SIREN : 2057EJS65</span>


                </div>
                <div class="client">
                    <div class="client_header">
                        <span class="client_nom">ACTION CONTRE LA SOIF</span>
                        <span class="client_solde_negatif">30 000 €</span>
                    </div>
                    <span class="client_siren">SIREN : 2057EJS65</span>


                </div>
                <div class="client">
                    <div class="client_header">
                        <span class="client_nom">ACTION CONTRE LA SOIF</span>
                        <span class="client_solde_negatif">30 000 €</span>
                    </div>
                    <span class="client_siren">SIREN : 2057EJS65</span>
                </div>
                <div class="client">
                    <div class="client_header">
                        <span class="client_nom">ACTION CONTRE LA SOIF</span>
                        <span class="client_solde_negatif">30 000 €</span>
                    </div>
                    <span class="client_siren">SIREN : 2057EJS65</span>
                </div>
                <div class="client">
                    <div class="client_header">
                        <span class="client_nom">ACTION CONTRE LA SOIF</span>
                        <span class="client_solde_negatif">30 000 €</span>
                    </div>
                    <span class="client_siren">SIREN : 2057EJS65</span>
                </div>
            </div>


            </div>


        </section>
    </article>
    <article id="article_po" class="flex_row">
        <section id="tableau">
            <h1>Tableau</h1>
            <div id="tableau_remises" class="tableau_remises tableau" style="display:none">
                <table title="Tableau des remises" name="nom" id="tableau_remises_html">
                    <thead>
                        <tr>
                            <th>SIREN</th>
                            <th>Raison sociale</th>
                            <th>Date</th>
                            <th>ID Remise</th>
                            <th>Nombre de transactions</th>
                            <th>Montant total</th>
                        </tr>

                    </thead>
                    <tbody>
                        <tr>
                            <td>2057EJS65</td>
                            <td>Association Action contre la soif</td>
                            <td>01/01/2020</td>
                            <td>1</td>
                            <td>10</td>
                            <td>1000€</td>
                        </tr>
                        <tr>
                            <td>2057EJS65</td>
                            <td>Association Action contre la soif</td>
                            <td>01/01/2020</td>
                            <td>1</td>
                            <td>10</td>
                            <td>1000€</td>
                        </tr>
                        <tr>
                            <td>2057EJS65</td>
                            <td>Association Action contre la soif</td>
                            <td>01/01/2020</td>
                            <td>1</td>
                            <td>10</td>
                            <td>1000€</td>
                        </tr>
                        <tr>
                            <td>2057EJS65</td>
                            <td>Association Action contre la soif</td>
                            <td>01/01/2020</td>
                            <td>1</td>
                            <td>10</td>
                            <td>1000€</td>
                        </tr>
                        <tr>
                            <td>2057EJS65</td>
                            <td>Association Action contre la soif</td>
                            <td>01/01/2020</td>
                            <td>1</td>
                            <td>10</td>
                            <td>1000€</td>
                        </tr>
                        <tr>
                            <td>2057EJS65</td>
                            <td>Association Action contre la soif</td>
                            <td>01/01/2020</td>
                            <td>1</td>
                            <td>10</td>
                            <td>1000€</td>
                        </tr>
                        <tr>
                            <td>2057EJS65</td>
                            <td>Association Action contre la soif</td>
                            <td>01/01/2020</td>
                            <td>1</td>
                            <td>10</td>
                            <td>100</td>
                        </tr>

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
                            <th>Carte N°</th>
                            <th>Montant</th>
                            <th>Devise</th>
                            <th>Raison</th>
                        </tr>

                    </thead>
                    <tbody>
                        <tr>
                            <td>2057EJS65</td>
                            <td>Association Action contre la soif</td>
                            <td>01/01/2020</td>
                            <td>1</td>
                            <td>10</td>
                            <td>1000€</td>
                            <td>EUR</td>
                            <td>Titulaire Décédé</td>
                        </tr>
                        <tr>
                            <td>2057EJS65</td>
                            <td>Association Action contre la soif</td>
                            <td>01/01/2020</td>
                            <td>1</td>
                            <td>10</td>
                            <td>1000€</td>
                            <td>EUR</td>
                            <td>Titulaire Emprisonné</td>
                        </tr>
                        <tr>
                            <td>2057EJS65</td>
                            <td>Association Action contre la soif</td>
                            <td>01/01/2020</td>
                            <td>1</td>
                            <td>10</td>
                            <td>1000€</td>
                            <td>EUR</td>
                            <td>IZLY Refusé</td>
                        </tr>
                        <tr>
                            <td>2057EJS65</td>
                            <td>Association Action contre la soif</td>
                            <td>01/01/2020</td>
                            <td>1</td>
                            <td>10</td>
                            <td>1000€</td>
                            <td>EUR</td>
                            <td>Fraude CROUS</td>
                        </tr>
                        <tr>
                            <td>2057EJS65</td>
                            <td>Association Action contre la soif</td>
                            <td>01/01/2020</td>
                            <td>1</td>
                            <td>10</td>
                            <td>1000€</td>
                            <td>EUR</td>
                            <td>Remboursement</td>
                        </tr>
                        <tr>
                            <td>2057EJS65</td>
                            <td>Association Action contre la soif</td>
                            <td>01/01/2020</td>
                            <td>1</td>
                            <td>10</td>
                            <td>1000€</td>
                            <td>EUR</td>
                            <td>Remboursement</td>
                        </tr>


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
                            <button value="csv">CSV</button>
                            <button value="xls">XLS</button>
                        </div>
                    </div>
                </div>



        </section>
        <section id=" graphique">
            <h1>graphique</h1>



        </section>
    </article>


    <script>
        // GERE LES PAGES DU TABLEAU
        $('#showPAGE').change(function() {
            var page = $(this).val();
            var lines = $('#showLINES').val();
            var table = $('.tableau:visible');
            var maxPage = Math.ceil(table.find('tr').length / lines);
            if (page > maxPage) {
                $(this).val(maxPage);
            }
            table.find('tr').css('display', 'none');
            table.find('tr').slice((page - 1) * lines, page * lines).css('display', 'table-row');
            $('.tableau thead tr').css('display', 'table-row');

        });


        // GERE LES LIGNES DU TABLEAU
        $('#showLINES').change(function() {
            var lines = $(this).val();
            lines++;
            if (lines > $('.tableau tr').length) {
                $(this).val($('.tableau tr').length);
            }
            var table = $('.tableau:visible');
            table.find('tr').css('display', 'none');
            table.find('tr').slice(0, lines).css('display', 'table-row');
        });


        // GERE LES FORMULAIRES POUR AFFICHER LES TABLEAUX ET GRAPHES CORRESPONDANTS
        $(document).ready(function() {
            $('.form_link').click(function() {
                // hide all the forms with class tableau
                $('.tableau').css('display', 'none');
                // add data-selected="false" to all the links but this one 
                $('.form_link').attr('data-selected', 'false');
                // add data-selected="true" to this link
                $(this).attr('data-selected', 'true');

                // name of form_link 
                var name = $(this).attr('name');
                // name of the form to display
                var form_name = ".tableau_" + name;

                $(form_name).css('display', 'block');
            });
        });

        // GERE LES DROPDOWN
        //if dropdown-content is clicked get the value of the clicked button 
        $('.dropdown-content').click(function() {

            // value of the button clicked
            var value = $(this).find('button').attr('value');
            console.log(value);

            if (value == 'pdf') {
                window.jsPDF = window.jspdf.jsPDF;
                var value = $(this).find('button').attr('value');

                // get the id of the visible 
                var table = "#" + $('.tableau:visible').attr('id') + '_html';

                console.log(table);



                var doc = new jsPDF()
                console.log(table);
                doc.autoTable({
                    html: table,
                });
                doc.save('table.pdf');
            } else if (value == 'csv') {


                var table = "#" + $('.tableau:visible').attr('id') + '_html';
                var htmltable = document.querySelector(table);
                var html = htmltable.outerHTML;
                window.open('data:application/vnd.ms-excel,' + encodeURIComponent(html));


            } else if (value == 'xls') {
                // export to xls with TableExport
                var table = $('.tableau:visible').attr('id');
                console.log(table);
                $('#' + table).tableExport({
                    type: 'xls',
                    escape: 'false',
                    fileName: 'table'
                });

            }
        });
    </script>


</body>

</html>