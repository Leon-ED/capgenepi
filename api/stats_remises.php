<?php

header('Content-Type: application/json');
require_once("../config/config.php");

$date_du = date("Y-m-d", strtotime("-10 years"));
$date_au = date("Y-m-d");


$SIREN = "%";
$nom = "%";
$id = "%";

if (isset($_GET["id"])) {
    $id = $_GET["id"];
}



if ($_SESSION["role"] == "PO") {
    if (isset($_GET["SIREN"]) && $_GET["SIREN"] != "" && !empty($_GET["SIREN"]) && $_GET["SIREN"] != "none" && $_GET["SIREN"] != "undefined") {
        $SIREN = "%" . $_GET["SIREN"] . "%";
    }

    if (isset($_GET["nom"]) && !empty($_GET["libelle"]) && $_GET["libelle"] != "none" && $_GET["libelle"] != "undefined" && $_GET["libelle"] != "") {
        $nom = "%" . $_GET["libelle"] . "%";
    }
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



// get number of remises in the given period by month
$sql =
    "
SELECT 
    DATE_FORMAT(date_traitement, '%m') as date,
    COUNT(DISTINCT remise.id) AS nb



FROM b__remise remise,
    b__entreprise client,
    b__transaction transac
WHERE transac.SIREN LIKE :SIREN
AND client.SIREN LIKE transac.SIREN
AND remise.id = transac.id_remise
AND client.Raison_sociale LIKE :nom
AND date_traitement BETWEEN :from AND :to

GROUP BY date 
ORDER BY date ASC;
";



try {
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':SIREN', $SIREN);
    $stmt->bindParam(':nom', $nom);
    $stmt->bindParam(':from', $date_du);
    $stmt->bindParam(':to', $date_au);

    $stmt->execute();


    $remises = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // Remplacer number by month name in french
    setlocale(LC_TIME, 'fr_FR');
    foreach ($remises as $key => $value) {
        $remises[$key]["date"] = date("F", mktime(0, 0, 0, $value["date"], 10));
    }
} catch (PDOException $e) {
    echo $e->getMessage();
    exit();
}

echo json_encode($remises);
