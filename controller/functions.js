getDataResultsSearch(); // get data ane update table on page load

function logout() {
    var oReq = new XMLHttpRequest();
    oReq.onload = function () {

        return this.responseText;
    };
    oReq.open("GET", "../../api/logout.php?action=logout", false);

    oReq.send();

    window.location.href = "../index.php";

}


function open_dialog() {
    document.getElementById("dialog_transac").showModal();
    // disable scrolling behind the dialog
    document.body.style.overflow = "hidden";

}

function close_dialog() {
    document.getElementById("dialog_transac").close();
    // enable scrolling behind the dialog
    document.body.style.overflow = "auto";
}
// click outside the dialog 
document.getElementById("dialog_transac").addEventListener("click", function (event) {
    if (event.target == this) {
        close_dialog();
    }
});


// GERE LES PAGES DU TABLEAU
$('#showPAGE').change(function () {
    var page = $(this).val();
    var lines = $('#showLINES').val();
    var table = $('.tableau:visible');
    page++;
    var maxPage = Math.ceil(table.find('tr').length / lines);
    if (page > maxPage) {
        $(this).val(maxPage);
    }
    table.find('tr').css('display', 'none');
    table.find('tr').slice((page - 1) * lines, page * lines).css('display', 'table-row');
    $('.tableau thead tr').css('display', 'table-row');

});

// IF DIALOG IS OPEN PREVENT SCROLLING BEHIND IT



// GERE LES LIGNES DU TABLEAU
$('#showLINES').change(function () {
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
$(document).ready(function () {
    $('.form_link').click(function () {
        $('.tableau').css('display', 'none');
        $('.form_link').attr('data-selected', 'false');
        $(this).attr('data-selected', 'true');
        $('.graph').css('display', 'none');
        const form_type = $("#form_type");
        var form_type_value = form_type.val();
        form_type.val($(this).attr('name'));
        var SIREN = document.getElementById("SIREN_select").options[document.getElementById("SIREN_select").selectedIndex].value;
        if (form_type.val() == "tresorerie") {

        } else if (form_type.val() == "remises") {

            if (SIREN != "none") {
                getRemiseList(all = false, _SIREN = document.getElementById("SIREN_select").value);
            } else {
                getRemiseList(all = true);

            }
        } else if (form_type.val() == "impayes") {
            if (SIREN != "none") {
                getImpayesList(all = false, _SIREN = document.getElementById("SIREN_select").value);
            } else {
                getImpayesList(all = true);

            }
        }
        var name = $(this).attr('name');

        var form_name = ".tableau_" + name;

        if (document.getElementById("SIREN_select").options[document.getElementById("SIREN_select").selectedIndex].text != "--Sélectionner SIREN--") {
            splitted_name = document.getElementById("SIREN_select").options[document.getElementById("SIREN_select").selectedIndex].text.split(" - ");
            $("#table_desc").text(" de " + splitted_name[1] + " - " + splitted_name[0]);
        }
        else {
            $("#table_desc").text("");
        }
        $("#table_cat").text(name);

        if (name == "tresorerie") {
            $("#tableau").css('display', 'none');
        } else {
            $("#tableau").css('display', 'flex');
        }

        var graph_name = "#" + name + "_graph";
        $(graph_name).css('display', 'block');


        $(form_name).css('display', 'block');
    });
});

// GERE LES DROPDOWN


function updateGraphe(graph_name, data = false, nom = false) {
    var i = 0;
    if (graph_name == "tresorerie") {
        i = 0;
    } else if (graph_name == "remises") {
        i = 1;
    } else if (graph_name == "impayes") {
        i = 2;
    }

    var chart = Highcharts.charts[i];
    var date_debut = document.getElementById("date_debut").value;
    var date_fin = document.getElementById("date_fin").value;
    var SIREN = document.getElementById("SIREN_select").options[document.getElementById("SIREN_select").selectedIndex].value;
    var raison = document.getElementsByName("raison_sociale")[0].value;

    if (i == 1) {
        var url = "../../api/stats_remises.php?date_debut=" + date_debut + "&date_fin=" + date_fin + "&SIREN=" + SIREN + "&libelle=" + raison;


        fetch(url).then(function (response) {
            response.json().then(function (data) {
                var mois = [];
                var nbr = [];
                for (var j = 0; j < data.length; j++) {
                    mois.push(data[j].date);
                    nbr.push(parseInt(data[j].nb));
                }
                chart.series[0].setData(nbr, true);
                chart.xAxis[0].setCategories(mois, true);
                return;

            });
        }
        );
        return;
    }


    if (i == 2) {
        var url = "../../api/motifs_impayes.php?date_debut=" + date_debut + "&date_fin=" + date_fin + "&SIREN=" + SIREN + "&libelle=" + raison;

        fetch(url).then(function (response) {
            response.json().then(function (data) {
                var pie = [];
                for (var j = 0; j < data.length; j++) {
                    pie.push({
                        name: data[j].libelle,
                        y: parseInt(data[j].nb)
                    });

                }
                chart.series[0].update({ data: pie }, true);
            });
        });
        return;
    }

    //change chart data
    if (data == "all") {
        chart.series[0].setData([1, 2, 3, 4, 5, 6, 7, 8, 9, 10]);
        chart.xAxis[0].setCategories(["1", "2", "3", "4", "5", "6", "7", "8", "9", "10"]);

    } else {
        chart.series[0].setData(data);
        chart.xAxis[0].setCategories(nom);
    }


}

$(document).ready(function () {
    $('#pdf_click').click(function () {

        window.jsPDF = window.jspdf.jsPDF;

        var table = "#" + $('.tableau:visible').attr('id') + '_html';

        var titre = $('#table_cat').text();
        // Définition du titre du pdf
        if ($('#table_desc').text() != "") {
            titre += " " + $('#table_desc').text();
        }

        var doc = new jsPDF()
        doc.setTextColor(40);
        doc.setFontSize(15);
        var title_doc = "Liste des " + titre;
        // add siren,raison sociale et nom de l'entreprise si précisée dans le formulaire
        if ($('#siren').val() != undefined) {
            title_doc += " de " + $('#siren').val();
        }
        if ($('#raison_sociale').val() != undefined) {
            title_doc += " de " + $('#raison_sociale').val();
        }

        doc.text(7, 15, title_doc.toUpperCase());
        var date = new Date();
        var date_string = date.getDate() + "/" + (date.getMonth() + 1) + "/" + date.getFullYear() + " " + date.getHours() + ":" + date.getMinutes();
        doc.setFontSize(10);
        doc.text(180, 15, date_string);
        doc.setLineWidth(0.1);
        doc.line(7, 20, 200, 20);

        doc.setTextColor(0, 0, 200);

        doc.autoTable({
            html: table,
            startY: 30,
        });
        titre.replace(/[\/|\\:*?"<>]/g, " ");
        doc.save(titre + '.pdf');

    });

});


// SORT TABLE BY COLUMN EVEN IF ROW IS NOT VISIBLE

$(document).ready(function () {
    $('th').click(function () {
        var table = $(this).parents('table').eq(0)
        table.find('tr').show();
        var rows = table.find('tr:gt(0)').toArray().sort(comparer($(this).index()))
        this.asc = !this.asc
        if (!this.asc) { rows = rows.reverse() }
        for (var i = 0; i < rows.length; i++) { table.append(rows[i]) }
        table.find('tr').css('display', 'none');
        table.find('tr').slice(0, $('#showLINES').val()).css('display', 'table-row');
    })
    function comparer(index) {
        return function (a, b) {
            var valA = getCellValue(a, index), valB = getCellValue(b, index)

            return $.isNumeric(valA) && $.isNumeric(valB) ? valA - valB : valA.toString().localeCompare(valB)
        }
    }
    function getCellValue(row, index) { return $(row).children('td').eq(index).text() }



});


function TableToCSV() {
    const id = $("table:visible").attr("id");


    var csv = [];
    var rows = document.querySelectorAll("table#" + id + " tr");

    for (var i = 0; i < rows.length; i++) {
        var row = [],
            cols = rows[i].querySelectorAll("td, th");

        for (var j = 0; j < cols.length; j++)
            row.push(cols[j].innerText);

        csv.push(row.join(";"));
    }

    downloadCSV(csv.join("\n"), "tableau.csv");
}

function downloadCSV(csv, filename) {
    var csvFile;
    var downloadLink;

    csvFile = new Blob([csv], {
        type: "text/csv"
    });

    downloadLink = document.createElement("a");

    downloadLink.download = filename;

    downloadLink.href = window.URL.createObjectURL(csvFile);

    downloadLink.style.display = "none";

    document.body.appendChild(downloadLink);

    downloadLink.click();
}



function TableToXLS() {
    const id = $("table:visible").attr("id");

    var csv = [];
    var rows = document.querySelectorAll("table#" + id + " tr");

    for (var i = 0; i < rows.length; i++) {
        var row = [],
            cols = rows[i].querySelectorAll("td, th");

        for (var j = 0; j < cols.length; j++)
            row.push(cols[j].innerText);

        csv.push(row.join("\t"));
    }

    downloadXLS(csv.join("\n"), "tableau.xls");
}

function downloadXLS(csv, filename) {
    var csvFile;
    var downloadLink;

    csvFile = new Blob([csv], {
        type: "application/vnd.ms-excel"
    });
    downloadLink = document.createElement("a");
    downloadLink.download = filename;
    downloadLink.href = window.URL.createObjectURL(csvFile);
    downloadLink.style.display = "none";
    document.body.appendChild(downloadLink);
    downloadLink.click();
}


function form_search() {
    getTresorerieList();
    const form_type = $("#form_type").val();
    if (form_type == "remises") {
        getRemiseList();
    }
    if (form_type == "impayes") {
        getImpayesList();
    }
    if (form_type == "tresorerie") {
        getTresorerieList();
    }


    editNameTable(); // Modifier le nom du tableau recherché en fonction du formulaire


}

function getTresorerieList() {
    const SIREN_select = $("#SIREN_select").val();
    const libelle = $("#libelle").val();
    const SIREN_libre = $("#SIREN_libre").val();
    const date_du = $("#date_debut").val();
    const date_au = $("#date_fin").val();
    var SIREN = "";
    var url = "";


    if (SIREN_select == SIREN_libre) {
        SIREN = SIREN_select;
    } else if (SIREN_select == "none" && SIREN_libre != "") {
        SIREN = SIREN_libre;
    } else if (SIREN_select != "none" && SIREN_libre == "") {
        SIREN = SIREN_select;
    } else {
        SIREN = SIREN_select;
    }

    fetch("../../api/compte.php?SIREN=" + SIREN + "&libelle=" + libelle + "&date_du=" + date_du + "&date_au=" + date_au).then(function (response) {
        return response.json();
    }).then(function (data) {
        var comptes = data;
        updateResultsSearch(comptes);
    });
}

function getDataResultsSearch() {
    fetch("../../api/compte.php").then(function (response) {
        return response.json();
    }).then(function (data) {
        var comptes = data;
        updateResultsSearch(comptes);
    });
}

function updateResultsSearch(data) {
    var comptes = data;
    document.getElementById("liste_clients").innerHTML = "";


    document.getElementById("search_result").innerHTML = comptes.length;
    var dataGraphe = [];
    var nomGraphe = [];
    var liste = document.getElementById("liste_clients");
    for (var i = 0; i < comptes.length; i++) {
        var compte = comptes[i];
        var SIREN = compte['SIREN'];
        var nom = compte['nom'];
        var tresorerie = compte['tresorerie'];
        var nombre_transaction = compte['transactions'];
        var remises = compte['remises'];
        var somme_impayes = compte['impayes_montant'];
        var impayes = compte['impayes'];
        dataGraphe.push(parseInt(tresorerie));
        nomGraphe.push(nom);
        var type_solde = tresorerie >= 0 ? "client_solde" : "client_solde_negatif";
        var client = document.createElement("div");
        client.className = "client";
        client.innerHTML = '<div class="client_header"> <span class="client_nom">' + nom + '</span> <span class=' + type_solde + '>' + tresorerie + '€</span> </div> <span class="client_siren">SIREN : ' + SIREN + '</span><p> Nombre de Remises : ' + remises + ' | Nombre de transactions : ' + nombre_transaction + ' | Nombre d\'impayés : ' + impayes + '<br> Montant impayés : ' + somme_impayes + ' €</p>';
        liste.appendChild(client);
    }
    updateGraphe("tresorerie", dataGraphe, nomGraphe);

}

function editNameTable() {
    if (document.getElementById("SIREN_select").options[document.getElementById("SIREN_select").selectedIndex].text != "--Sélectionner SIREN--") {
        splitted_name = document.getElementById("SIREN_select").options[document.getElementById("SIREN_select").selectedIndex].text.split(" - ");
        $("#table_desc").text(" de " + splitted_name[1] + " - " + splitted_name[0]);
    }

    else {
        $("#table_desc").text("");
    }
    if ($("#libelle").val() != "" && $("#libelle").val() != undefined) {
        $("#table_desc").text(" de " + $("#libelle").val());
    }
    if ($("#SIREN_libre").val() != undefined && $("#SIREN_libre").val() != "") {
        $("#table_desc").text($("#table_desc").text() + " - " + $("#SIREN_libre").val());
    }


}

function afficheRemises(data) {
    $("#tableau_remises_html tbody").empty();
    $("#total_lines").text(data.length + " lignes au total");

    var montants = [];
    var noms = [];
    for (var remise of data) {
        montants.push(parseInt(remise.montant_total));
    }
    for (var remise of data) {
        noms.push(remise.nom);
    }

    updateGraphe("remises", montants, noms);

    var max_lines = 10;
    var lines = 0;
    if (data.length < $("#max_lines").val()) {


    }
    for (var remise of data) {

        const tr = $("<tr></tr>");

        tr.attr("onclick", "affiche_details_remise(" + remise.id + ")");
        for (let [k, v] of Object.entries(remise)) {

            var td = $("<td></td>");
            if (k == "montant_total") {
                if (parseInt(v) < 0) {
                    td = $("<td class='client_solde_negatif'></td>");
                }
                else {
                    td = $("<td class='client_solde'></td>");
                }
            }

            td.text(v);
            tr.append(td);
        }

        if (lines++ >= max_lines) {
            tr.attr("style", "display:none");
        }
        $("#tableau_remises_html tbody").append(tr);
    }
}




function affiche_details_remise(idRemise) {
    $("#detail_remise_numero").text(idRemise);
    const dialog_content = $("#dialog_content");
    open_dialog();
    get_transactions_from_remise(idRemise);
}

function get_transactions_from_remise(idRemise) {
    $.ajax({
        url: "../../api/remises.php?id=" + idRemise,
        type: "GET",
        success: function (data) {
            affiche_transactions_from_remise(data);
        },
        error: function (data) {
        }
    });
}

function makeAuthNum(length) {
    var result = '';
    var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    var charactersLength = characters.length;
    for (var i = 0; i < length; i++) {
        result += characters.charAt(Math.floor(Math.random() * charactersLength));
    }
    return result;
}

function affiche_transactions_from_remise(data) {
    $("#table_dialog_transac tbody").empty();


    for (var transaction of data) {
        const tr = $("<tr></tr>");
        for (let [k, v] of Object.entries(transaction)) {
            var td = $("<td></td>");
            if (k == "montant") {
                if (parseInt(v) < 0) {
                    td = $("<td class='client_solde_negatif'></td>");
                }
                else {
                    td = $("<td class='client_solde'></td>");
                }
            }

            if (k == "nombre_transaction") {
                continue;
            }

            if (k == "id") {
                var card_network = ["visa", "mastercard", "american express", "diners club", "discover", "jcb", "unionpay", "maestro", "elo", "hipercard", "izly", "izly", "izly", "izly", "izly"]
                v = card_network[Math.floor(Math.random() * card_network.length)].toUpperCase();
            }

            td.text(v);
            tr.append(td);
        }
        $("#table_dialog_transac tbody").append(tr);
    }

}


function getRemiseList(all = false, _SIREN = null) {

    const SIREN_select = $("#SIREN_select").val();
    const libelle = $("#libelle").val();
    const date_du = $("#date_debut").val();
    const date_au = $("#date_fin").val();
    const SIREN_libre = $("#SIREN_libre").val();
    var SIREN = "";
    var url = "";


    if (SIREN_select == SIREN_libre) {
        SIREN = SIREN_select;
    } else if (SIREN_select == "none" && SIREN_libre != "") {
        SIREN = SIREN_libre;
    } else if (SIREN_select != "none" && SIREN_libre == "") {
        SIREN = SIREN_select;
    } else {
        SIREN = SIREN_select;
    }
    if (_SIREN != null) {
        SIREN = _SIREN;

    }
    url = "../../api/remises.php?SIREN=" + SIREN + "&libelle=" + libelle + "&date_du=" + date_du + "&date_au=" + date_au;
    if (SIREN_select == "none" && SIREN_libre == "" && libelle == "") {
        url = "../../api/remises.php";

    }
    if (all) {
        url = "../../api/remises.php";
    }

    $.ajax({
        url: url,
        type: "GET",
        dataType: "json",
        data: {
            action: "getRemiseList"
        },
        success: function (data) {
            afficheRemises(data);
        }

    });
}



function getImpayesList(all = false, _SIREN = null) {

    const SIREN_select = $("#SIREN_select").val();
    const libelle = $("#libelle").val();
    const SIREN_libre = $("#SIREN_libre").val();
    const date_du = $("#date_debut").val();
    const date_au = $("#date_fin").val();

    var SIREN = "";
    var url = "";

    updateGraphe("impayes", [], []);

    if (SIREN_select == SIREN_libre) {
        SIREN = SIREN_select;
    } else if (SIREN_select == "none" && SIREN_libre != "") {
        SIREN = SIREN_libre;
    } else if (SIREN_libre == "" && SIREN_select != "none") {
        SIREN = SIREN_select;
    } else {
        SIREN = SIREN_select;
    }
    if (_SIREN != null) {
        SIREN = _SIREN;

    }
    if (SIREN_select == "none" && SIREN_libre == "" && libelle == "") {
        url = "../../api/impayes.php";

    }
    url = "../../api/impayes.php?libelle=" + libelle + "&SIREN=" + SIREN + "&date_du=" + date_du + "&date_au=" + date_au;
    if (all) {
        url = "../../api/impayes.php";
    }

    $.ajax({
        url: url,
        type: "GET",
        dataType: "json",
        data: {
            action: "getImpayesList"
        },
        success: function (data) {
            afficheImpayes(data);
        }

    });
}

function afficheImpayes(data) {
    $("#tableau_impayes_html tbody").empty();
    $("#total_lines").text(data.length + " lignes au total");
    var max_lines = 10;
    var lines = 0;

    for (var remise of data) {
        const tr = $("<tr></tr>");

        for (let [k, v] of Object.entries(remise)) {
            const td = $("<td></td>");
            td.text(v);
            tr.append(td);
        }
        if (lines++ >= max_lines) {
            tr.attr("style", "display:none");


        }
        $("#tableau_impayes_html tbody").append(tr);

    }


}

