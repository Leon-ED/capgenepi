<?php


function is_connected()
{
    if (isset($_SESSION['user']) && !empty($_SESSION['user'])) {
        return true;
    }
    return false;
}



function get_solde_from_SIREN($SIREN)
{
    $solde = 0;
    global $conn;
    $sql = "SELECT sens,montant FROM b__transaction transac JOIN b__entreprise entreprise ON transac.SIREN = entreprise.SIREN WHERE entreprise.SIREN = :siren;";
    $req = $conn->prepare($sql);
    $req->bindParam(':siren', $SIREN);
    $req->execute();
    $result = $req->fetchAll(PDO::FETCH_ASSOC);
    if ($result == false) {
        return "Aucun solde disponible";
    }
    foreach ($result as $transaction) {
        if ($transaction['sens'] == "+") {
            $solde += $transaction['montant'];
        } else {
            $solde -= $transaction['montant'];
        }
    }
    return $solde . " €";
}

function get_nb_transac_from_SIREN($SIREN)
{
    global $conn;
    $sql = "SELECT COUNT(*) FROM b__transaction transac JOIN b__entreprise entreprise ON transac.SIREN = entreprise.SIREN WHERE entreprise.SIREN = :siren;";
    $req = $conn->prepare($sql);
    $req->bindParam(':siren', $SIREN);
    $req->execute();
    $result = $req->fetch(PDO::FETCH_ASSOC);
    return $result['COUNT(*)'];
}

function get_all_SIREN()
{
    global $conn;
    $sql = "SELECT SIREN FROM b__entreprise;";
    $req = $conn->prepare($sql);
    $req->execute();
    $result = $req->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}

function get_all_client_data()
{
    global $conn;
    $sql = "SELECT * FROM b__entreprise;";
    $req = $conn->prepare($sql);
    $req->execute();
    $result = $req->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}
