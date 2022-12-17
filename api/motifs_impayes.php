<?php

header('Content-Type: application/json');
require_once("../config/config.php");

if (!$_SESSION["user"]) {
    http_response_code(401);
    echo "Vous n'êtes pas connecté";
    exit();
}

$date_du = date("Y-m-d", strtotime("-10 years"));
$date_au = date("Y-m-d");

if (isset($_GET["date_du"]) && isset($_GET["date_au"])) {
    $date_du = $_GET["date_du"];
    $date_au = $_GET["date_au"];
}

$SIREN = "%%";
$nom = "%%";


if ($_SESSION["role"] == "CLIENT" && !isset($_SESSION["SIREN"])) {
    http_response_code(401);
    echo "Vous n'avez pas le droit";
    exit();
} elseif ($_SESSION["role"] == "CLIENT" && isset($_SESSION["SIREN"])) {
    $SIREN = $_SESSION["SIREN"];
}



if (isset($_GET["date_au"]) && strpos($_GET["date_au"], "-") !== false) {
    $date_au = $_GET["date_au"];
}

if (isset($_GET["date_du"]) && strpos($_GET["date_du"], "-") !== false) {
    $date_du = $_GET["date_du"];
}

if (isset($_GET["libelle"]) && !empty($_GET["libelle"]) && $_GET["libelle"] != "none" && $_GET["libelle"] != "undefined" && $_GET["libelle"] != "") {
    $nom = "%" . $_GET["libelle"] . "%";
} else {
    $nom = "%";
}

if (isset($_GET["SIREN"]) && $_GET["SIREN"] != "none" && $_GET["SIREN"] != "undefined" && !empty($_GET["SIREN"])) {
    $SIREN = "%" . $_GET["SIREN"] . "%";
}



$sql2 = "SELECT COUNT(*) as nb, libelle FROM b__transaction transac, b__impaye impaye, b__motifs_impayes motif, b__entreprise client
WHERE transac.numero_dossier_impaye IS NOT NULL 

AND transac.montant < 0
AND transac.numero_dossier_impaye = impaye.numero_dossier_impaye
AND impaye.code = motif.code
AND transac.date_transaction BETWEEN :date_du AND :date_au
AND transac.SIREN LIKE :SIREN
AND client.SIREN LIKE transac.SIREN
AND client.Raison_sociale LIKE :nom
GROUP BY motif.libelle
ORDER BY nb DESC;  ";



$stmt2 = $conn->prepare($sql2);
$stmt2->bindParam(':date_du', $date_du);
$stmt2->bindParam(':date_au', $date_au);
$stmt2->bindParam(':SIREN', $SIREN);
$stmt2->bindParam(':nom', $nom);
$stmt2->execute();
$motifs = $stmt2->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($motifs);
