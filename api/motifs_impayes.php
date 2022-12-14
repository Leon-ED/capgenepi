<?php

header('Content-Type: application/json');
require_once("../config/config.php");

if(!$_SESSION["user"]){
    http_response_code(401);
    echo "Vous n'êtes pas connecté";
    exit();
}

$date_du = date("Y-m-d", strtotime("-1 month"));
$date_au = date("Y-m-d");

if (isset($_GET["date_du"]) && isset($_GET["date_au"])) {
    $date_du = $_GET["date_du"];
    $date_au = $_GET["date_au"];
}

$SIREN = "%%";
$nom = "%%";
if($_SESSION["role"] == "PO"){
    if (isset($_GET["SIREN"])) {
        $SIREN = $_GET["SIREN"];
    }
    if (isset($_GET["nom"])) {
        $nom = $_GET["nom"];
    }
}

$sql2 = "SELECT COUNT(*) as nb, libelle FROM b__transaction transac, b__impaye impaye, b__motifs_impayes motif
WHERE transac.numero_dossier_impaye IS NOT NULL 
AND transac.montant < 0
AND transac.numero_dossier_impaye = impaye.numero_dossier_impaye
AND impaye.code = motif.code
AND transac.date_transaction BETWEEN :date_du AND :date_au
GROUP BY motif.libelle
ORDER BY nb DESC;  ";

$stmt2 = $conn->prepare($sql2);
$stmt2->bindParam(':date_du', $date_du);
$stmt2->bindParam(':date_au', $date_au);
$stmt2->execute();
$motifs = $stmt2->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($motifs);