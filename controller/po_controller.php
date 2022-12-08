<?php
require_once(__DIR__."../../config/config.php");


function get_compte_list(){
    global $conn;
    $sql = "SELECT * FROM b__entreprise;";
    $req = $conn->prepare($sql);
    $req->execute();

    $result = $req->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}

function show_compte_liste(){
    $liste = get_compte_list();
    foreach ($liste as $compte) {
        $SIREN = $compte['SIREN'];
        $nom = $compte['Raison_sociale'];
        $solde = get_solde_from_SIREN($SIREN);
        $solde_negatif = $solde < 0 ? "solde-negatif" : "";
        echo '
        <div class="compte_client" onclick=showCompte("'.$SIREN.'")>
        <div class="compte_client-nom">'.$nom.'</div>
        <div class="compte_client-solde '.$solde_negatif.'"> Solde : '.$solde.' </div>
    </div>';
    }



}