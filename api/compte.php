<?php




// JSON
header('Content-Type: application/json');
require_once("../config/config.php");

$SIREN = "%%";
$nom = "%%";

if (isset($_GET["libelle"])) {
    $nom = "%" . $_GET["libelle"] . "%";
}

if (isset($_GET["SIREN"])) {
    $SIREN = $_GET["SIREN"];
}

// N'affiche que les clients qui ont des transactions
try {
    $sql = "
    SELECT Raison_sociale nom, client.SIREN, SUM(montant) tresorerie  
    FROM b__entreprise client, b__transaction transac 
    WHERE client.SIREN = transac.SIREN 
    AND client.SIREN LIKE :SIREN 
    AND Raison_sociale LIKE :libelle 
    GROUP BY client.SIREN;";


    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':libelle', $nom);
    $stmt->bindParam(':SIREN', $SIREN);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($result);
} catch (Exception $e) {
    echo $e->getMessage();
}
