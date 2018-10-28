<?php if ( count( get_included_files() ) == 1) die( '--access denied--' ); ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
                <input id="inscription" type="button" value="Inscription"><br>
                <input id="connexion" type="button" value="Connexion">
            </div>
        </div>
    </header>
    <main>
        <div id="message"><?php echo $bienvenue ?></div>
        <div id="menu"><?php echo $message ?></div>
        <div id="login"></div>
        <div id="classes"></div>
    </main>
    <footer>
        <p>Benoit de Mahieu - Année 2018-2019</p>
    </footer>
</body>
</html>