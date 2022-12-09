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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highcharts/10.3.2/highcharts-3d.min.js" integrity="sha512-kiHRleMJNNgSe7q0AmaYa7CKE8abI5UlvCTIIvk4NtmqQV95rgNYixSqyBFs7AAPVGFgl8NoadDko9Z/9i2LIA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
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

                <!-- GENERER ICI LES DONNES SELON LA RECHERCHE -->
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
                        <!-- GENERER ICI EN AJAX LES DONNES SELON LA RECHERCHE -->
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
                        <!-- GENERER ICI EN AJAX LES DONNES SELON LA RECHERCHE -->
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
                            <button value="pdf" disabled id="pdf_click">PDF</button>
                            <!-- <button value="csv" disabled>CSV</button>
                            <button value="xls" disabled>XLS</button> -->
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

                //disable all graphes 
                $('.graph').css('display', 'none');


                // name of form_link 
                var name = $(this).attr('name');
                // name of the form to display
                var form_name = ".tableau_" + name;

                var graph_name = "#" + name + "_graph";
                console.log(graph_name);
                $(graph_name).css('display', 'block');


                $(form_name).css('display', 'block');
            });
        });

        // GERE LES DROPDOWN
        //if dropdown-content is clicked get the value of the clicked button 
        $('#pdf_click').click(function() {
            // value of the button clicked
            var value = $(this).find('button').attr('value');
            console.log(value);


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

        });
    </script>

    <script defer>
        // GRAPH pour la trésorerie

        // highcharts graph
        Highcharts.chart('tresorerie_graph', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'Tresorerie'
            },
            subtitle: {
                text: 'Source: <a href="https://www.data.gouv.fr/fr/datasets/finances-publiques-departementales/">data.gouv.fr</a>'
            },
            xAxis: {
                // ici chopper les noms des clients 
                categories: [
                    'PIVOTEAU SARL',
                    'ACTION CONTRE LA SOIF',
                    'ACTION CONTRE LE SEXE',
                    'ACTION CONTRE L\'ALCOOLISME',
                    'ACTION CONTRE L\'ACTION',

                ],
                crosshair: true
            },
            yAxis: {

                title: {
                    text: 'Montant (€)'
                }
            },
            tooltip: {
                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                    '<td style="padding:0"><b>{point.y:.1f} €</b></td></tr>',
                footerFormat: '</table>',
                shared: true,
                useHTML: true
            },
            exporting: {
                enabled: true
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0
                }
            },
            series: [{
                // ICI CHOPPER LES TRESORERIES (dans le meme ordre que les noms des clients) logique !!!!
                name: 'Dépenses',
                data: [0, 58, -690, 157, 541]

            }]
        });
    </script>
    <script defer>
        // GRAPH pour les remises

        // highcharts graph
        Highcharts.chart('remises_graph', {
            chart: {
                type: 'line'
            },
            title: {
                text: 'Remises'
            },
            subtitle: {
                text: 'Source: <a href="https://www.data.gouv.fr/fr/datasets/finances-publiques-departementales/">data.gouv.fr</a>'
            },
            xAxis: {
                // ici chopper les mois ou pas si t'as la flemme ou pas
                categories: [
                    'Janvier',
                    'Fevrier',
                    'Mars',
                    'Avril',
                    'Mai',
                    'Juin',
                    'Juillet',
                    'Aout',
                    'Septembre',
                    'Octobre',
                    'Novembre',
                    'Decembre'
                ],
                crosshair: true
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Montant (€)'
                }
            },
            tooltip: {
                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                    '<td style="padding:0"><b>{point.y:.1f} €</b></td></tr>',
                footerFormat: '</table>',
                shared: true,
                useHTML: true
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0
                }
            },
            exporting: {
                buttons: {
                    contextButton: {
                        menuItems: ["downloadPNG", "downloadJPEG", "downloadPDF", "downloadSVG", "separator", "downloadCSV", "downloadXLS", "viewData", "openInCloud"]
                    }
                }
            },
            series: [{
                // ICI CHOPPER LES NOMBRE DE REMISES PAR MOIS ( selon la recherche , client ,date etc )
                name: 'Dépenses',
                data: [49.9, 71.5, 106.4, 129.2, 144.0, 176.0, 135.6, 148.5, 216.4, 194.1, 95.6, 54.4]

            }]
        });
    </script>
    <script defer>
        // GRAPH camembert pour les impayes par libelle d'impaye

        // highcharts graph

        Highcharts.chart('impayes_graph', {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                text: 'Répartition des motifs d\'impayés'
            },
            subtitle: {
                text: 'Source: <a href="https://www.data.gouv.fr/fr/datasets/finances-publiques-departementales/">data.gouv.fr</a>'
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                        style: {
                            color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                        }
                    }
                }
            },
            exporting: {
                buttons: {
                    contextButton: {
                        menuItems: ["downloadPNG", "downloadJPEG", "downloadPDF", "downloadSVG", "separator", "downloadCSV", "downloadXLS", "viewData", "openInCloud"]
                    }
                }
            },
            series: [{
                name: 'Impayes',
                colorByPoint: true,
                data: [{

                    // BOUCLER ET CHOPPER LE LIBELLE ET LE NOMBRE D'IMPAYES PAR LIBELLE 
                    name: 'MEURTRE DU PROPRIETAIRE',
                    y: 56.33
                }, {
                    name: '-180 balles sur le compte (SOFIANE)',
                    y: 24.03,
                    sliced: true,
                    selected: true
                }, {
                    name: 'EPICERIE SOLIDAIRE (YANIS)',
                    y: 10.38
                }, {
                    name: '1100 EUROS (DENIS)',
                    y: 4.77
                }, {
                    name: '-900 EUROS DU CROUS (Léon)',
                    y: 0.91
                }, {
                    name: 'Impayes 6',
                    y: 0.2
                }]
            }]
        });
    </script>


</body>

</html>