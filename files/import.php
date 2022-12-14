<?php
require_once '../config/config.php';

$impayes_code_libelle = ["01","02","03","04","05","06","07","08","09"];
$devises = ["EUR","CHF","CFA","USD","CAD","CNY"];

$reseaux = ["VISA","CB","MasterCard","American Express","UP Déjeuner","IZY","IZLY"];
$lettres = ["A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z"];

$LISTE_SIREN = array();
$sql = "SELECT SIREN FROM b__entreprise;";
$result = $conn->prepare($sql);
$result->execute();
$LISTE_SIREN = $result->fetchAll(PDO::FETCH_COLUMN);

const POURCENT_IMPAYE = 25; 


// $LISTE_SIREN = ["147258369"];e


foreach($LISTE_SIREN as $SIREN){
    echo "SIREN : ".$SIREN." <br>";
    for($i = 0 ; $i < 30; $i++){
        $return = create_remise($SIREN, $conn);
        $id_remise = $return["id"];
        $date = $return["date"];

        for($j = 0; $j < rand(3,45); $j++){
            // date between $date and 2w before
            $date_facture = date("Y-m-d", rand(strtotime($date), strtotime("-2 week", strtotime($date))));
            if(rand(0,100) <= POURCENT_IMPAYE){
                $code = $impayes_code_libelle[array_rand($impayes_code_libelle, 1)];
                //var_dump($code);
                $id_impaye = create_impaye($conn,$code);
                create_transaction($conn,$id_remise,$date_facture,$SIREN, $impaye = true, $id_impaye =$id_impaye);
            }else{
                create_transaction($conn,$id_remise,$date_facture,$SIREN, $impaye = false);
            }
        }




    }

}

function create_transaction($conn,$id_remise,$date,$SIREN,$impaye = false, $id_impaye = null){
    global $reseaux;
    global $lettres;
    if($impaye && $id_impaye != null){
        $montant = rand(-2_000, -50);
        // echo "id impaye :";
        // var_dump($id_impaye);
    }else{
        $id_impaye = NULL;
        $montant = rand(10, 2_000);
    }
   
    $numero_carte = "****-****-****-".rand(1000,9999);
    $num_autorisation = $lettres[array_rand($lettres, 1)].$lettres[array_rand($lettres, 1)].$lettres[array_rand($lettres, 1)].$lettres[array_rand($lettres, 1)].rand(1000,9999).rand(1000,9999);


    $sql = "INSERT INTO b__transaction(SIREN, date_transaction, id_remise, numero_dossier_impaye,Reseau,num_autorisation, montant,sens,numero_carte) VALUES (:SIREN, :date_transaction, :id_remise, :numero_dossier_impaye, :reseau, :autoriz, :montant,:sens, :carte );";
    $result = $conn->prepare($sql);
    $sens = $montant > 0 ? "+" : "-";
    $result->bindParam(":SIREN", $SIREN, PDO::PARAM_STR);
    $result->bindParam(":date_transaction", $date, PDO::PARAM_STR);
    $result->bindParam(":id_remise", $id_remise, PDO::PARAM_INT);
    $result->bindParam(":numero_dossier_impaye", $id_impaye, PDO::PARAM_INT);
    $result->bindParam(":reseau", $reseaux[array_rand($reseaux, 1)], PDO::PARAM_STR);
    $result->bindParam(":autoriz", $num_autorisation, PDO::PARAM_STR);
    $result->bindParam(":montant", $montant, PDO::PARAM_INT);
    $result->bindParam(":sens", $sens, PDO::PARAM_STR);
    $result->bindParam(":carte", $numero_carte, PDO::PARAM_STR);
    $result->execute();

    // $result->execute(array(
    //     "SIREN" => $SIREN,
    //     "date_transaction" => $date,
    //     "id_remise" => $id_remise,
    //     "numero_dossier_impaye" => $id_impaye,
    //     "reseau" => $reseaux[array_rand($reseaux, 1)],
    //     "autoriz" => $num_autorisation,
    //     "montant" => $montant,
    //     "sens" => $montant > 0 ? "+" : "-",
    //     "carte" => $numero_carte
    // ));





}

function create_impaye($conn, $code){
    try{
    $sql = "INSERT INTO b__impaye(code) VALUES (:code);";
    $result = $conn->prepare($sql);
    $result->bindParam(":code", $code, PDO::PARAM_STR);
    $result->execute();

    return $conn->lastInsertId();
    }catch(Exception $e){
        var_dump($code);   
        echo "erreur : ".$e->getMessage();
    }
}

function create_remise($SIREN, $conn){
    global $devises;
    // random date between 2018-01-01 and now()
    $date = date("Y-m-d", rand(strtotime("2022-01-01"), time()));

    $sql = "INSERT INTO b__remise(SIREN, date_traitement, devise) VALUES (:SIREN, :date_traitement, :devise);";
    $result = $conn->prepare($sql);
    $result->execute(array(
        "SIREN" => $SIREN,
        "date_traitement" => $date,
        "devise" => $devises[array_rand($devises, 1)]
    ));

    $return = array( "id" => $conn->lastInsertId(), "date" => $date);
    return $return;

}

function generate_SIREN(){
    // generate a random SIREN
    $siren = rand(1,9);
    for($i = 0; $i < 8; $i++){
        $siren .= rand(0,9);
    }
    return $siren;
}