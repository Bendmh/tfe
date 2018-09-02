<?php

session_start();

if(!isset($_SESSION['start'])){
    $_SESSION['start'] = date('YmdHis');
}

$message = '<p>Bienvenue sur le site. Commence par t\'inscrire ou te connecter !</p>';

if (isset($_GET['rq'])){
    require_once "INC/request.inc.php";
    die(gereRequete($_GET['rq']));
}

if(isset($_SESSION['user'])){
    $message = '<p>Page rafraichie : vous êtes toujours connecté '. $_SESSION['user']['prenom'] . ' !</p>';
}

require_once "INC/layout.html.inc.php";
