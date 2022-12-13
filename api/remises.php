<?php

header('Content-Type: application/json');
require_once("../config/config.php");

$date_du = date("Y-m-d", strtotime("-1 month"));
$date_au = date("Y-m-d");

if (isset($_GET["date_du"]) && isset($_GET["date_au"])) {
    $date_du = $_GET["date_du"];
    $date_au = $_GET["date_au"];
}

$SIREN = "%";
$nom = "%";
$id = "%";

if (isset($_GET["id"])) {
    $id = $_GET["id"];
}

if($_SESSION["role"] == "PO"){
if (isset($_GET["SIREN"]) && $_GET["SIREN"] != "") {
    if ($_GET["SIREN"] == "none") {
        $SIREN = "%";
    } else {
        $SIREN = "%".$_GET["SIREN"]."%";
    }
}
if (isset($_GET["nom"]) && $_GET["nom"] != "") {
    if ($_GET["nom"] == "none") {
        $nom = "%";
    } else {
        $nom = "%".$_GET["nom"]."%";
    }
}
}

if(!$_SESSION["user"]){
    http_response_code(401);
    echo "Vous n'êtes pas connecté";
    exit();
}

// Retourne la liste des remises pour un client une période donnée, nom donne et siren donnée sinon retourne toutes les remises pour une période de 1 mois
/***
 * Retourne : SIREN, nom, date_traitement, nombre_transaction,devise, montant_total
 * 
 *  */


$sql = "
SELECT remise.SIREN SIREN, client.Raison_sociale nom,remise.date_traitement date_traitement, remise.id , COUNT(*) nombre_transaction, devise, SUM(montant) montant_total
FROM b__remise remise , b__transaction transac, b__entreprise client
WHERE remise.SIREN LIKE :SIREN
AND client.SIREN = remise.SIREN
AND client.Raison_sociale LIKE :nom 
AND remise.date_traitement BETWEEN :date_du AND :date_au
AND remise.id = transac.id_remise 
AND transac.id_remise LIKE :id
GROUP BY remise.id;
";



try {
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':SIREN',$SIREN, PDO::PARAM_STR);
    $stmt->bindParam(':date_du', $date_du);
    $stmt->bindParam(':date_au', $date_au);
    $stmt->bindParam(':nom', $nom);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($result);
    
} catch (Exception $e) {
    echo $e->getMessage();
    
}
