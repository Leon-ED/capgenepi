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
}

function close_dialog() {
    document.getElementById("dialog_transac").close();
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
    var maxPage = Math.ceil(table.find('tr').length / lines);
    if (page > maxPage) {
        $(this).val(maxPage);
    }
    table.find('tr').css('display', 'none');
    table.find('tr').slice((page - 1) * lines, page * lines).css('display', 'table-row');
    $('.tableau thead tr').css('display', 'table-row');

});


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
        // hide all the forms with class tableau
        $('.tableau').css('display', 'none');
        // add data-selected="false" to all the links but this one 
        $('.form_link').attr('data-selected', 'false');
        // add data-selected="true" to this link
        $(this).attr('data-selected', 'true');

        //disable all graphes 
        $('.graph').css('display', 'none');





        // form_type
        const form_type = $("#form_type");
        // get form_type value
        var form_type_value = form_type.val();
        // change form_type value
        form_type.val($(this).attr('name'));
        if (form_type.val() == "tresorerie") { } else if (form_type.val() == "remises") {
            getRemiseList(all = true);
        } else if (form_type.val() == "impayes") {
            getImpayesList(all = true);
        }

        // name of form_link 
        var name = $(this).attr('name');
        // name of the form to display
        var form_name = ".tableau_" + name;

        //table_cat
        $("#table_cat").text(name);

        // if tresorerie hide table
        if (name == "tresorerie") {
            $("#tableau").css('display', 'none');
        } else {
            $("#tableau").css('display', 'flex');
        }

        var graph_name = "#" + name + "_graph";
        console.log(graph_name);
        $(graph_name).css('display', 'block');


        $(form_name).css('display', 'block');
    });
});

// GERE LES DROPDOWN
//if dropdown-content is clicked get the value of the clicked button 

$(document).ready(function () {
    $('#pdf_click').click(function () {



        window.jsPDF = window.jspdf.jsPDF;

        // get the id of the visible 
        var table = "#" + $('.tableau:visible').attr('id') + '_html';




        var doc = new jsPDF()
        // set header
        doc.setFontSize(18);
        doc.setTextColor(40);
        doc.text("test", 14, 22);
        doc.setFontSize(25);
        //color to var(--blue)
        doc.setTextColor(0, 0, 200);
        const titre = $('#table_cat').text() + " " + $('#table_desc').text();
        //doc.text(7, 15, titre);
        doc.autoTable({
            html: table,
        });
        titre.replace(/[\/|\\:*?"<>]/g, " ");
        doc.save(titre + '.pdf');

    });

});





//  table to csv
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

    // CSV file
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
    const form_type = $("#form_type").val();
    if (form_type == "remises") {
        getRemiseList();
    }
    if(form_type == "impayes"){
        getImpayesList();
    }



}

function afficheRemises(data) {
    // clear tbody for tableau_remises_html
    $("#tableau_remises_html tbody").empty();

    // for each data 

    console.log(data);
    for (var remise of data) {
        const tr = $("<tr></tr>");
        // tr onclick

        // add onclick to tr html
        tr.attr("onclick", "affiche_details_remise(" + remise.id + ")");
        console.log(typeof remise);
        // remise = JSON.stringify(remise);
        for (let [k, v] of Object.entries(remise)) {
            const td = $("<td></td>");
            td.text(v);
            tr.append(td);
        }
        // append tr to tbody
        $("#tableau_remises_html tbody").append(tr);

    }


}

function affiche_details_remise(idRemise) {
    $("#detail_remise_numero").text(idRemise);
    const dialog_content = $("#dialog_content");
    open_dialog();
}

function get_transactions_from_remise(idRemise) {

}

function getRemiseList(all = false) {

    const SIREN_select = $("#SIREN_select").val();
    const libelle = $("#libelle").val();
    const SIREN_libre = $("#SIREN_libre").val();
    var SIREN = "";
    var url = "";


    if (SIREN_select == SIREN_libre) {
        SIREN = SIREN_select;
    } else if (SIREN_select == "none" && SIREN_libre != "") {
        SIREN = SIREN_libre;
    } else if (SIREN_libre == "" && SIREN_select != "none") {
        SIREN = SIREN_select;
    } else {
        SIREN = SIREN_select;
    }
    url = "../../api/remises.php?libelle=" + libelle + "&SIREN=" + SIREN;
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

/**  FETCH API */
fetch("../../api/compte.php").then(function (response) {
    return response.json();
}).then(function (data) {
    var comptes = data;

    document.getElementById("search_result").innerHTML = comptes.length;

    var liste = document.getElementById("liste_clients");
    for (var i = 0; i < comptes.length; i++) {
        var compte = comptes[i];
        var SIREN = compte['SIREN'];
        var nom = compte['nom'];
        var tresorerie = compte['tresorerie'];
        var type_solde = tresorerie >= 0 ? "client_solde" : "client_solde_negatif";
        var client = document.createElement("div");
        client.className = "client";
        client.innerHTML = '<div class="client_header"> <span class="client_nom">' + nom + '</span> <span class=' + type_solde + '>' + tresorerie + '€</span> </div> <span class="client_siren">SIREN : ' + SIREN + '</span>';
        liste.appendChild(client);
    }

});

function getImpayesList(all = false) {

    const SIREN_select = $("#SIREN_select").val();
    const libelle = $("#libelle").val();
    const SIREN_libre = $("#SIREN_libre").val();
    var SIREN = "";
    var url = "";


    if (SIREN_select == SIREN_libre) {
        SIREN = SIREN_select;
    } else if (SIREN_select == "none" && SIREN_libre != "") {
        SIREN = SIREN_libre;
    } else if (SIREN_libre == "" && SIREN_select != "none") {
        SIREN = SIREN_select;
    } else {
        SIREN = SIREN_select;
    }
    url = "../../api/impayes.php?libelle=" + libelle + "&SIREN=" + SIREN;
    if (SIREN_select == "none" && SIREN_libre == "" && libelle == "") {
        url = "../../api/impayes.php";

    }
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

function afficheImpayes(data){
        // clear tbody for tableau_remises_html
        $("#tableau_impayes_html tbody").empty();

        // for each data 
    
        console.log(data);
        for (var remise of data) {
            const tr = $("<tr></tr>");
            // tr onclick
    
            // add onclick to tr html
            //tr.attr("onclick", "affiche_details_remise(" + remise.id + ")");
            console.log(typeof remise);
            // remise = JSON.stringify(remise);
            for (let [k, v] of Object.entries(remise)) {
                const td = $("<td></td>");
                td.text(v);
                tr.append(td);
            }
            // append tr to tbody
            $("#tableau_impayes_html tbody").append(tr);
    
        }
    

}