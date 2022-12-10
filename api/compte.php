<?php




// JSON
header('Content-Type: application/json');
require_once("../config/config.php");

if (!isset($_GET["libelle"]) && !isset($_GET["SIREN"])) {
    try {
        $sql = "SELECT Raison_sociale nom, client.SIREN, SUM(montant) tresorerie  FROM b__entreprise client, b__transaction transac WHERE client.SIREN = transac.SIREN GROUP BY client.SIREN;";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($result);
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

if (isset($_GET["libelle"]) && !isset($_GET["SIREN"])) {
    try {

        $sql = "SELECT Raison_sociale nom, client.SIREN, SUM(montant) tresorerie  FROM b__entreprise client, b__transaction transac WHERE client.SIREN = transac.SIREN AND Raison_sociale LIKE :libelle GROUP BY client.SIREN;";
        $stmt = $conn->prepare($sql);
        $libelle = "%" . $_GET["libelle"] . "%";
        $stmt->bindParam(':libelle', $libelle);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($result);
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}

if (isset($_GET["SIREN"]) && !isset($_GET["libelle"])) {
    try {
        $sql = "SELECT Raison_sociale nom, client.SIREN, SUM(montant) tresorerie  FROM b__entreprise client, b__transaction transac WHERE client.SIREN = transac.SIREN AND client.SIREN = :SIREN GROUP BY client.SIREN;";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':SIREN', $_GET["SIREN"]);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($result);
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}

if (isset($_GET["SIREN"]) && isset($_GET["libelle"])) {
    try {
        $sql = "SELECT Raison_sociale nom, client.SIREN, SUM(montant) tresorerie  FROM b__entreprise client, b__transaction transac WHERE client.SIREN = transac.SIREN AND client.SIREN = :SIREN AND Raison_sociale LIKE :libelle GROUP BY client.SIREN;";
        $stmt = $conn->prepare($sql);
        $libelle = "%" . $_GET["libelle"] . "%";
        $stmt->bindParam(':libelle', $libelle);
        $stmt->bindParam(':SIREN', $_GET["SIREN"]);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($result);
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}
