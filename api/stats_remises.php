<?php

header('Content-Type: application/json');
require_once("../config/config.php");

$date_du = date("Y-m-d", strtotime("-10 years"));
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
if($_SESSION["role"] == "CLIENT" && !isset($_SESSION["SIREN"])){
    http_response_code(401);
    echo "Vous n'avez pas le droit";
    exit();
}elseif($_SESSION["role"] == "CLIENT" && isset($_SESSION["SIREN"])){
    $SIREN = $_SESSION["SIREN"];
    $nom = "%";
}


// get number of remises in the given period by month
$sql = 
"SELECT COUNT(transaction.montant) AS nb, 
DATE_FORMAT(date_traitement, '%m') AS date
 FROM b__remise remise, b__entreprise client, b__transaction transaction
 WHERE date_traitement BETWEEN :from AND :to 
 AND transaction.SIREN LIKE :SIREN 
 AND Raison_sociale LIKE :nom 
AND client.SIREN = remise.SIREN
 AND remise.id LIKE :id_remise 
 GROUP BY DATE_FORMAT(date_traitement, '%m') 
 ORDER BY date_traitement ASC";

$stmt = $conn->prepare($sql);
$stmt->execute([
    "from" => $date_du,
    "to" => $date_au,
    "SIREN" => $SIREN,
    "nom" => $nom,
    "id_remise" => $id
]);

$remises = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($remises);
