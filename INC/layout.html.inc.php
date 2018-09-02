<?php if ( count( get_included_files() ) == 1) die( '--access denied--' ); ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Cours de Math</title>
    <link rel="stylesheet" type="text/css" href="CSS/index.css"/>
    <script src="/jq/jquery-3.3.1.min.js"></script>
    <script type="text/javascript" src="JS/index.js"></script>

</head>
<body>
    <header>
        <div id="header">
            <img id="ephec" src="IMG/ephec.jpg" alt="image ephec">
            <div id="champ">
                <input id="inscription" type="button" value="Inscritption"><br>
                <input id="connexion" type="button" value="Connexion">
            </div>
        </div>
    </header>
    <main>
        <?php echo $message ?>
        <!--<video id="video" src="IMG/Monfilm.mp4" controls width="500" height="300"></video>-->
        <!--<?php require_once "INC/template.login.inc.php"; ?>-->
    </main>
    <footer>
        <p>Benoit de Mahieu - Année 2018-2019</p>
    </footer>
</body>
</html>