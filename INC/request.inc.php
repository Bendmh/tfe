<?php

require_once 'INC/db.inc.php';

function gereRequete($rq=""){
    switch($rq){
        case 'inscription' :
            $iDB = new Db();
            $retour = $iDB->verification();
            if($retour != []){
                return '{"erreur" : "Ce compte existe déjà" }';
            }else {
                $_SESSION['user'] = $_POST;
                return '{"inscription" : ' . JSON_encode($iDB->call('ajouterPersonne')) .'}';
            }
            break;
        case 'connexion' :
            $iDB = new Db();
            $retour = $iDB->verification('connexion');
            //return JSON_encode($retour);
            if($retour[0]["PersMdp"] != $_POST["password"]){
                return '{"erreur" : "Mot de passe incorrect" }';
            }else {
                $_SESSION['user'] = $retour;
                //return JSON_encode($_SESSION);
                if($_SESSION['user'][0]['PersStatut'] == "élèves"){
                    return '{"inscription" : "élève"}';
                }else {
                    return '{"inscription" : "prof"}';
                }
                //return '{"inscription" : ""}';
            }
            break;
        case 'activite1' :
        case 'activite2' :
            $_SESSION['activiteId'] = substr($rq, -1, 1);
            $iDB = new Db();
            $iDB->call('PersAct');
            $_SESSION['question'] = JSON_encode($iDB->call('questions'));
            return '{"questions" : ' . JSON_encode($iDB->call('questions')) .'}';
        break;
        case 'correction' :
            //return print_r($_POST, 1);
            $size = count($_POST);
            $result = 0;
            $iDB = new Db();
            $retour = $iDB->verification('correction' , $_SESSION['activiteId']);
            //return print_r($retour, 1);
            for($i = 0; $i < $size-1; $i++){
                //if($_SESSION['question'][$i]['bonneReponse'] == $_POST['reponses'.$i]){
                if($retour[$i]['bonneReponse'] == $_POST['reponses'.$i]){
                    $result = $result+1;
                }
            }
            $iDB->call('ajouterNote', $result);
            return '{"correction" : "'. $result . '"}';
            break;
        case 'deconnexion' :
            unset($_SESSION['user']);
            return '{"deconnexion" : "<p>Au revoir</p>"}';
            break;
        default :
            return '{"default":"Requête inconnue : ' . $rq . '"}';
    }
}