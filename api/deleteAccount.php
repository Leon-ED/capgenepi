<?php
// JSON
header('Content-Type: application/json');
require_once("../config/config.php");

if(!isset($_SESSION["role"])){
    http_response_code(401);
    echo "Vous n'êtes pas connecté";
    exit();
}
$postBody = file_get_contents("php://input");
$postBody = json_decode($postBody, true);
$SIREN = $postBody["SIREN"];

if($_SESSION["role"] == "ADMIN" && $SIREN != ""){
    $sql = "DELETE FROM b__controle WHERE SIREN = :SIREN;
    DELETE FROM b__transaction WHERE SIREN = :SIREN;
    DELETE FROM b__remise WHERE SIREN = :SIREN;
    DELETE FROM b__impaye WHERE SIREN = :SIREN;
    ";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":SIREN", $SIREN);
    $stmt->execute();

    $sql = "DELETE FROM b__entreprise WHERE SIREN = :SIREN";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":SIREN", $SIREN);
    $stmt->execute();
    
    http_response_code(200);
    echo $SIREN;
}
else if($_SESSION["role"] != "ADMIN"){
    http_response_code(401);
    echo "Vous n'avez pas le droit";
    exit();
}

else{
    http_response_code(400);
    echo "Merci de fournir un numéro de SIREN";
    exit();
}