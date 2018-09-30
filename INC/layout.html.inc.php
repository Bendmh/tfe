<?php if ( count( get_included_files() ) == 1) die( '--access denied--' ); ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Cours de Math</title>
    <link rel="stylesheet" type="text/css" href="CSS/index.css"/>
    <script src="/jq/jquery-3.3.1.min.js"></script>
    <script type="text/javascript" src="JS/index.js"></script>

    <style>
        #ephec {
            width: <?php echo $taille ?>;
        }

        #champ {
            display:  <?php echo $boutons ?>;
        }
    </style>
</head>
<body>
    <header>
        <div id="header">
            <img id="ephec" src="IMG/ephec_im.png" alt="image ephec">
            <div id="champ">
                <input id="inscription" type="button" value="Inscritption"><br>
                <input id="connexion" type="button" value="Connexion">
            </div>
        </div>
    </header>
    <main>
        <div id="menu">
            <!--<ul>
                <li><a href="activite1.html">Activité 1</a></li>
                <li><a href="activite2.html">Activité 2</a></li>
                <li><a href="deconnexion.html">Déconnexion</a></li>
            </ul>-->
        </div>
        <div id="login"><?php echo $message ?></div>
    </main>
    <footer>
        <p>Benoit de Mahieu - Année 2018-2019</p>
    </footer>
</body>
</html>