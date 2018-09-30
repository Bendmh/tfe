<?php

session_start();

if(!isset($_SESSION['start'])){
    $_SESSION['start'] = date('YmdHis');
}

$message = '<p>Bienvenue sur le site. Commence par t\'inscrire ou te connecter !</p>';
$taille = '85%';
$boutons = 'block';

if (isset($_GET['rq'])){
    require_once "INC/request.inc.php";
    die(gereRequete($_GET['rq']));
}

if(isset($_SESSION['user'])){
    $taille = '100%';
    $boutons = 'none';
    if($_SESSION['user'][0]['PersStatut'] == "élèves"){
        $message =
            '<ul>
                <li><a href="activite1.html">Activité 1</a></li>
                <li><a href="activite2.html">Activité 2</a></li>
                <li><a href="deconnexion.html">Déconnexion</a></li>
             </ul>';
    }else {
        $message =
            '<ul>
                <li>Classe : </li>
                    <ul>
                        <li><a href="classe.html">1A</a></li>
                        <li><a href="classe.html">1B</a></li>
                        <li><a href="classe.html">1C</a></li>
                        <li><a href="classe.html">1D</a></li>
                        <li><a href="classe.html">1E</a></li>
                    </ul>
                <li><a href="deconnexion.html">Déconnexion</a></li>
            </ul>';
    }
    /*$message =
    '<ul>
        <li><a href="activite1.html">Activité 1</a></li>
        <li><a href="activite2.html">Activité 2</a></li>
        <li><a href="deconnexion.html">Déconnexion</a></li>
     </ul>';*/
    //$message = '<p>Page rafraichie : vous êtes toujours connecté '. $_SESSION['user']['prenom'] . ' !</p>';
}

require_once "INC/layout.html.inc.php";
