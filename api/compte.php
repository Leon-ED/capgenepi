<?php





// JSON
header('Content-Type: application/json');
require_once("../config/config.php");

if(!$_SESSION["user"]){
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
    $SIREN = "%%";
    $nom = "%%";

    if($_SESSION["role"] == "CLIENT" && !isset($_SESSION["SIREN"])){
        http_response_code(401);
        echo "Vous n'avez pas le droit";
        exit();
    }elseif($_SESSION["role"] == "CLIENT" && isset($_SESSION["SIREN"])){
        $SIREN = $_SESSION["SIREN"];
    }
    


    if (isset($_GET["libelle"])) {
        $nom = "%" . $_GET["libelle"] . "%";
    }

    if (isset($_GET["SIREN"])) {
        $SIREN = "%" . $_GET["SIREN"] . "%";
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
}

function POST_REQUEST()
{
    if(!$_SESSION["role"] != "ADMIN" || !$_SESSION["role"] != "PO"){
        http_response_code(401);
        echo "Vous n'êtes pas connecté";
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
            http_response_code(409);
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
        $stmt->bindParam(':password', password_hash($password, PASSWORD_DEFAULT));
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
