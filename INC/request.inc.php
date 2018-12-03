<?php

if ( count( get_included_files() ) == 1) die( '--access denied--' );

require_once 'INC/db.inc.php';

function gereRequete($rq=""){
    switch($rq){
        case 'inscription' :
            if($_POST['nom'] == "" || $_POST['prenom'] == "" || $_POST['password'] == ""){
                return '{"erreur" : "Il faut compléter le formulaire" }';
            }
            $iDB = new Db();
            $retour = $iDB->verification();
            if($retour != []){
                return '{"erreur" : "Ce compte existe déjà" }';
            }else {
                $iDB->call('ajouterPersonne');
                $_SESSION['user'] = $iDB->verification('connexion');
                //return JSON_encode($_SESSION);
                return '{"inscription" : ' . JSON_encode($_SESSION['user'][0]) . '}';
            }
            break;
        case 'connexion' :
            if($_POST['nom'] == "" || $_POST['prenom'] == "" || $_POST['password'] == ""){
                return '{"erreur" : "Il faut compléter le formulaire" }';
            }
            $iDB = new Db();
            $retour = $iDB->verification('connexion');
            //return hash('sha256',$_POST["password"], false );
            //return JSON_encode($retour);
            if($retour[0]["MDPHash"] != hash('sha256',$_POST["password"], false )){
                return '{"erreur" : "Mot de passe incorrect" }';
            }else {
                $_SESSION['user'] = $retour;
                //return JSON_encode($_SESSION);
                return '{"inscription" : ' . JSON_encode($_SESSION['user'][0]) . '}';
            }
            break;
        case 'activite1' :
        case 'activite2' :
            $_SESSION['activiteId'] = substr($rq, -1, 1);
            $iDB = new Db();
            $iDB->call('PersAct');
            $_SESSION['question'] = $iDB->call('questions');
            return '{"questions" : ' . JSON_encode($iDB->call('questions')) .'}';
        break;
        case 'correction' :
            $size = count($_POST);
            $result = 0;
            for($i = 0; $i < $size-1; $i++){
                if($_SESSION['question'][$i]['bonneReponse'] == $_POST['reponses'.$i]){
                    $result = $result+1;
                }
            }
            $iDB = new Db();
            $iDB->call('ajouterNote', $result);
            return '{"correction" : "'. $result . '"}';
            break;
        case 'deconnexion' :
            unset($_SESSION['user']);
            unset ($_SESSION['question']);
            return '{"deconnexion" : "<p>Au revoir</p>"}';
            break;
        case '1A' :
        case '1B' :
        case '1C' :
        case '1D' :
        case '1E' :
            $iDB = new Db();
            return '{"classes" : ' . JSON_encode($iDB->call("classes", $rq)) .'}';
            break;
        default :
            return '{"default":"Requête inconnue : ' . $rq . '"}';
    }
}