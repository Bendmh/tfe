<?php

session_start();

if(!isset($_SESSION['start'])){
    $_SESSION['start'] = date('YmdHis');
}

$bienvenue = '<h2>Bienvenue sur le site. Commence par t\'inscrire ou te connecter !</h2>';
$taille = '85%';
$boutons = 'block';

if (isset($_GET['rq'])){
    require_once "INC/request.inc.php";
    die(gereRequete($_GET['rq']));
}

if(isset($_SESSION['user'])){
    $taille = '100%';
    $boutons = 'none';
    if($_SESSION['user'][0]['PersStatut'] == "Eleves"){
        $bienvenue = '<h1> Bienvenue ' . $_SESSION['user'][0]['PersPrenom'] . '</h1>';
        $message =
            '<ul>
                <li><a href="activite1.html">Activité 1</a></li>
                <li><a href="activite2.html">Activité 2</a></li>
                <li><a href="deconnexion.html">Déconnexion</a></li>
             </ul>';
    }else {
        $bienvenue = '<h1> Bienvenue ' . $_SESSION['user'][0]['PersPrenom'] . '</h1>';
        $tab = explode(",", $_SESSION['user'][0]['classe']);
        $message = '<ul><li>Classe : </li><ul>';
        foreach ($tab as $value){
            $message .= '<li><a href="'. $value .'.html">' . $value . '</a></li>';
        }
        $message .= '</ul><li><a href="deconnexion.html">Déconnexion</a></li></ul>';
    }
    //$message = '<p>Page rafraichie : vous êtes toujours connecté '. $_SESSION['user']['prenom'] . ' !</p>';
}

require_once "INC/layout.html.inc.php";
