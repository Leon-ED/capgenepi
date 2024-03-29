<?php





// JSON
header('Content-Type: application/json');
require_once("../config/config.php");

if (!isset($_SESSION["role"])) {
    http_response_code(401);
    echo "Vous n'êtes pas connecté";
    exit();
}

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        GET_REQUEST();
        break;
    case 'POST':
        POST_REQUEST();
        break;
    default:
        http_response_code(405);
        echo "Méthode non supportée";
        break;
}




function GET_REQUEST()
{
    global $conn;
    $SIREN = "%";
    $nom = "%";
    $date_du = date("Y-m-d", strtotime("-10 year"));
    $date_au = date("Y-m-d");

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

    // N'affiche que les clients qui ont des transactions
    try {
        $sql = "
    SELECT Raison_sociale nom, client.SIREN, SUM(montant) tresorerie, COUNT(DISTINCT transac.numero_transaction) transactions, COUNT(DISTINCT remise.id) remises  
    FROM b__entreprise client, b__transaction transac , b__remise remise
    WHERE client.SIREN = transac.SIREN 
    AND transac.id_remise = remise.id
    AND client.SIREN LIKE :SIREN 
    AND Raison_sociale LIKE :libelle 
    AND (transac.date_transaction BETWEEN :date_du AND :date_au OR remise.date_traitement BETWEEN :date_du AND :date_au)
    GROUP BY client.SIREN;";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':libelle', $nom);
        $stmt->bindParam(':SIREN', $SIREN);
        $stmt->bindParam(':date_du', $date_du);
        $stmt->bindParam(':date_au', $date_au);
        $stmt->execute();

        $sql = "
        SELECT COUNT(DISTINCT numero_transaction) impayes FROM b__transaction
        where SIREN LIKE :SIREN
        AND numero_dossier_impaye IS NOT NULL;
        ";

        $sql3 = "
        SELECT SUM(montant) impayes FROM b__transaction
        where SIREN LIKE :SIREN AND numero_dossier_impaye IS NOT NULL;
        ";
        $stmt2 = $conn->prepare($sql);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $key => $value) {
            $stmt2->bindParam(':SIREN', $value["SIREN"]);
            $stmt2->execute();
            $result[$key]["impayes"] = $stmt2->fetchAll(PDO::FETCH_ASSOC)[0]["impayes"];

            $stmt3 = $conn->prepare($sql3);
            $stmt3->bindParam(':SIREN', $value["SIREN"]);
            $stmt3->execute();
            $result[$key]["impayes_montant"] = $stmt3->fetchAll(PDO::FETCH_ASSOC)[0]["impayes"];
        }





        echo json_encode($result);
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}

function POST_REQUEST()
{
    if ($_SESSION["role"] != "ADMIN") {
        http_response_code(401);
        echo "Vous n'êtes pas autorisé à effectuer cette action";
        exit();
    }


    $postBody = file_get_contents("php://input");
    $postBody = json_decode($postBody, true);

    $SIREN = $postBody["SIREN"];
    $nom = $postBody["libelle"];
    $login = $postBody["login"];
    $password = $postBody["password"];
    $nomCompte = $postBody["nom"];
    $prenomCompte = $postBody["prenom"];
    $emailCompte = $postBody["email"];

    if (!isset($SIREN) || !isset($nom) || !isset($login) || !isset($password) || !isset($nomCompte) || !isset($prenomCompte) || !isset($emailCompte)) {
        http_response_code(400);
        echo json_encode(array("message" => "Un des champs n'est pas renseigné", "error" => "true"));
        return;
    }

    global $conn;

    try {
        $sql = "SELECT * FROM b__compte WHERE login = :login OR email = :email;";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':email', $emailCompte);
        $stmt->bindParam(':login', $login);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (count($result) > 0) {
            echo json_encode(array("message" => "Le compte existe déjà", "error" => "true"));
            return;
        }
        $sql = "SELECT * FROM b__entreprise WHERE SIREN = :SIREN;";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':SIREN', $SIREN);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (count($result) > 0) {
            http_response_code(409);
            echo json_encode(array("message" => "Le client existe déjà", "error" => "true"));
            return;
        }


        $sql = "INSERT INTO b__compte (login, password,email,nom,prenom) VALUES (:login, :password,:email,:nom,:prenom);";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':login', $login);
        $stmt->bindParam(':email', $emailCompte);
        $stmt->bindParam(':nom', $nomCompte);
        $stmt->bindParam(':prenom', $prenomCompte);
        $password = password_hash($password, PASSWORD_DEFAULT);
        $stmt->bindParam(':password', $password);
        $stmt->execute();
        $id_user = $conn->lastInsertId();

        $sql = "INSERT INTO b__entreprise (SIREN, Raison_sociale) VALUES (:SIREN, :libelle);";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':SIREN', $SIREN);
        $stmt->bindParam(':libelle', $nom);
        $stmt->execute();

        $sql = "INSERT INTO b__controle (id,SIREN ) VALUES (:id, :SIREN);";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id_user);
        $stmt->bindParam(':SIREN', $SIREN);
        $stmt->execute();

        $array = array("message" => "Le client et son compte ont été créés", "SIREN" => $SIREN, "libelle" => $nom, "login" => $login, "error" => "false");
        echo json_encode($array);
    } catch (Exception $e) {
        echo json_encode(array("error" => "true", "message" => $e->getMessage()));
    }
}
