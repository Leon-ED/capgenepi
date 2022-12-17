<?php

header('Content-Type: application/json');
require_once("../config/config.php");

if ($_SESSION["role"] == "CLIENT" && !isset($_SESSION["SIREN"])) {
    http_response_code(401);
    echo "Vous n'avez pas le droit";
    exit();
} elseif ($_SESSION["role"] == "CLIENT" && isset($_SESSION["SIREN"])) {
    $SIREN = $_SESSION["SIREN"];
}

$nom = "%";
$SIREN  = "%";
$date_du = date("Y-m-d", strtotime("-10 year"));
$date_au = date("Y-m-d");



if (isset($_GET["date_au"]) && strpos($_GET["date_au"], "-") !== false) {
    $date_au = $_GET["date_au"];
}

if (isset($_GET["date_du"]) && strpos($_GET["date_du"], "-") !== false) {
    $date_du = $_GET["date_du"];
}

if (isset($_GET["libelle"]) && !empty($_GET["libelle"]) && $_GET["libelle"] != "none" && $_GET["libelle"] != "undefined" && $_GET["libelle"] != "") {
    $nom = "%" . $_GET["libelle"] . "%";
}

if (isset($_GET["SIREN"]) && $_GET["SIREN"] != "none" && $_GET["SIREN"] != "undefined" && !empty($_GET["SIREN"])) {
    $SIREN = "%" . $_GET["SIREN"] . "%";
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

FROM b__remise remise , b__transaction transac, b__entreprise client, b__motifs_impayes motif, b__impaye
WHERE remise.SIREN LIKE :SIREN
AND transac.numero_dossier_impaye IS NOT NULL
AND transac.numero_dossier_impaye = b__impaye.numero_dossier_impaye
AND b__impaye.code = motif.code
AND client.SIREN = remise.SIREN
AND client.Raison_sociale LIKE :nom 
AND transac.date_transaction BETWEEN DATE(:date_du) AND DATE(:date_au)
AND remise.id = transac.id_remise 


";

// GET RATIO FOR EACH motif_impaye



try {


    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':SIREN', $SIREN, PDO::PARAM_STR);
    $stmt->bindParam(':date_du', $date_du);
    $stmt->bindParam(':date_au', $date_au);
    $stmt->bindParam(':nom', $nom);

    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);




    echo json_encode($result);
} catch (Exception $e) {
    echo $e->getMessage();
}
