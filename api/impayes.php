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


$sql = "
SELECT client.SIREN SIREN, 
client.Raison_sociale nom, 
transac.date_transaction, 
transac.numero_dossier_impaye, 
transac.numero_transaction,
transac.id_remise, 
transac.numero_carte,
transac.sens,
transac.montant,
remise.devise,
motif.libelle libelle_impaye

FROM b__transaction transac, b__entreprise client, b__impaye impaye, b__motifs_impayes motif, b__remise remise
WHERE transac.SIREN LIKE :SIREN
AND transac.numero_dossier_impaye IS NOT NULL
AND transac.montant < 0
AND client.SIREN = transac.SIREN
AND client.Raison_sociale LIKE :nom
AND transac.date_transaction BETWEEN :date_du AND :date_au
AND transac.numero_dossier_impaye = impaye.numero_dossier_impaye
AND impaye.code = motif.code
AND transac.id_remise = remise.id


";

// GET RATIO FOR EACH motif_impaye



try {
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':SIREN', $SIREN);
    $stmt->bindParam(':date_du', $date_du);
    $stmt->bindParam(':date_au', $date_au);
    $stmt->bindParam(':nom', $nom);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

 


    echo json_encode($result);
} catch (Exception $e) {
    echo $e->getMessage();
}
