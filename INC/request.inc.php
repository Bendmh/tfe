<?php

require_once 'INC/db.inc.php';

function gereRequete($rq=""){
    switch($rq){
        case 'inscription' :
            $iDB = new Db();
            $retour = $iDB->verification();
            //return print_r($retour[0], 1);
            if($retour != []){
                return '{"erreur" : "Ce compte existe déjà" }';
            }else {
                $_SESSION['user'] = $_POST;
                return '{"inscription" : ' . JSON_encode($iDB->call('ajouterPersonne')) .'}';
            }
            break;
        case 'connexion' :
            //return print_r($_POST, 1);
            $iDB = new Db();
            $retour = $iDB->verification('connexion');
            if($retour[0]["PersMdp"] != $_POST["password"]){
                return '{"erreur" : "Mot de passe incorrect" }';
            }else {
                $_SESSION['user'] = $_POST;
                return '{"inscription" : ""}';
            }
            break;
        case 'activite1' :
        case 'activite2' :
            $_SESSION['activiteId'] = substr($rq, -1, 1);
            $iDB = new Db();
            $iDB->call('PersAct');
            //return '{"questions" : ' . JSON_encode($iDB->call('PersAct')) .'}';
            return '{"questions" : ' . JSON_encode($iDB->call('questions', $_SESSION['activiteId'])) .'}';
        break;
        case 'correction' :
            //return print_r($_POST, 1);
            $size = count($_POST);
            $result = 0;
            $iDB = new Db();
            $retour = $iDB->verification('correction' , $_SESSION['activiteId']);
            //return print_r($retour, 1);
            for($i = 0; $i < $size-1; $i++){
                if($retour[$i]['bonneReponse'] == $_POST['reponses'.$i]){
                    $result = $result+1;
                }
            }
            $iDB->call('ajouterNote', $result);
            return '{"correction" : "'. $result . '"}';
                //print_r($result, 1);
            break;
        case 'deconnexion' :
            unset($_SESSION['user']);
            return '{"deconnexion" : "<p>Au revoir</p>"}';
            break;
        default :
            return '{"default":"Requête inconnue : ' . $rq . '"}';
    }
}