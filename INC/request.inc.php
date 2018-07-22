<?php

require_once 'INC/db.inc.php';

function gereRequete($rq=""){
    global $toSend;
    switch($rq){
        case 'inscription' :
            $iDB = new Db();
            $retour = $iDB->verification();
            //return print_r($retour[0], 1);
            if($retour != []){
                return '{"erreur" : "Ce compte existe déjà" }';
            }else {
                return '{"inscription" : ' . JSON_encode($iDB->call('ajouterPersonne')) .'}';
            }
            break;
        case 'connexion' :
            //return print_r($_POST, 1);
            $iDB = new Db();
            $retour = $iDB->verification('connexion');
            //return print_r($retour, 1);
            if($retour[0]["PersMdp"] != $_POST["password"]){
                return '{"erreur" : "Mot de passe incorrect" }';
            }else {
                return '{"inscription" : ""}';
            }
            break;
        case 'questions' :
            $iDB = new Db();
            return '{"questions" : ' . JSON_encode($iDB->call('questions')) .'}';
        break;
        case 'correction' :
            //return print_r($_POST, 1);
            $size = count($_POST);
            $result = 0;
            $iDB = new Db();
            $retour = $iDB->verification('correction');
            //return print_r($retour, 1);
            for($i = 0; $i < $size-1; $i++){
                if($retour[$i]['bonneReponse'] == $_POST['reponses'.$i]){
                    $result = $result+1;
                }
            }
            return '{"correction" : '. $result . '}';
                //print_r($result, 1);
            break;
        case 'deconnexion' :
            return '{"deconnexion" : "Au revoir"}';
            break;
        default :
            return '{"default":"Requête inconnue : ' . $rq . '"}';
    }
}