<?php

header('Content-Type: application/json');
require_once("../config/config.php");

$date_du = date("Y-m-d", strtotime("-10 years"));
$date_au = date("Y-m-d");

if (isset($_GET["date_du"]) && $_GET["date_du"] != "") {
    $date_du = $_GET["date_du"];
}

if (isset($_GET["date_au"]) && $_GET["date_au"] != "") {
    $date_au = $_GET["date_au"];
}

$SIREN = "%";
$nom = "%";
$id = "%";

if (isset($_GET["id"])) {
    $id = $_GET["id"];
}



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
AND remise.date_traitement BETWEEN DATE(:date_du) AND DATE(:date_au)
AND remise.id = transac.id_remise 
AND transac.id_remise LIKE :id
GROUP BY remise.id


";

if ($id != "%") {
    $sql =
        "SELECT client.Raison_sociale, transac.date_transaction, transac.Reseau,transac.numero_carte, remise.devise, transac.montant,transac.sens,transac.num_autorisation
    FROM b__entreprise client, b__remise remise, b__transaction transac
    WHERE remise.id = :id
    AND remise.SIREN = client.SIREN
    AND remise.id = transac.id_remise
    AND remise.siren LIKE :SIREN
    
";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':SIREN', $SIREN, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($result);
    exit();
}

try {
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':SIREN', $SIREN, PDO::PARAM_STR);
    $stmt->bindParam(':date_du', $date_du);
    $stmt->bindParam(':date_au', $date_au);
    $stmt->bindParam(':nom', $nom, PDO::PARAM_STR);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($result);
} catch (Exception $e) {
    echo $e->getMessage();
}
