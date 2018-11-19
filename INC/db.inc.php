<?php

if ( count( get_included_files() ) == 1) die( '--access denied--' );

class Db {

    private $pdoException = null;
    private $iPdo = null;

    function __construct()
    {
        try {
            $this->iPdo = new PDO('mysql:host=mysql;dbname=test;charset=utf8;port=3306', 'dev', 'dev');
            $this->iPdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            $this -> pdoException = $e;
        }
    }

    public function getException(){
        return 'PDOException : ' . ($this->pdoException ? $this->pdoException->getMessage() : 'aucune !');
    }

    public function verification($choix = 'inscription', $num = ''){
        switch($choix){
            case 'connexion' :
            case 'inscription' :
                $appel = 'select * from Personnes where PersNom = ? and PersPrenom = ?';
                $sth = $this->iPdo->prepare($appel);

                $sth->bindParam(1, $nom);
                $sth->bindParam(2, $prenom);

                $nom = $_POST['nom'];
                $prenom = $_POST['prenom'];

                $sth->execute();
                $row =  $sth->fetchAll(PDO::FETCH_ASSOC);
                return $row;
                break;
            case 'correction' :
                $appel = 'select bonneReponse from Questions natural join ActQuest where ActId = ' . $num;
                $sth = $this->iPdo->prepare($appel);
                $sth->execute();
                return $sth->fetchAll(PDO::FETCH_ASSOC);
                break;

        }
    }

    public function call($nom = '', $num = '')
    {
        switch ($nom){
            case 'ajouterPersonne' :

                $appel = 'insert into Personnes(PersNom, PersPrenom, PersMdp, PersStatut, classe, IMG) value(?,?,?,?,?,?)';

                //$appel = 'select * from Questions';
                $sth = $this->iPdo->prepare($appel);

                $sth->bindParam(1, $nom);
                $sth->bindParam(2, $prenom);
                $sth->bindParam(3, $Mdp);
                $sth->bindParam(4, $statut);
                $sth->bindParam(5, $classe);
                $sth->bindParam(6, $image);


                $nom = htmlspecialchars($_POST['nom']);
                $prenom = htmlspecialchars($_POST['prenom']);
                $Mdp = htmlspecialchars($_POST['password']);
                $statut = htmlspecialchars($_POST['statut']);
                $classe = htmlspecialchars($_POST['classes']);

                $image = $statut == "Professeur" ? "prof.jpg" : "eleve.png";


                $sth->execute();

                break;

            case 'questions' :
                $appel = 'SELECT * FROM test.ActQuest natural join Questions where ActId = '. $_SESSION['activiteId'];
                //$appel = 'select * from Questions where activite = '. $num .'.;
                $sth = $this->iPdo->prepare($appel);
                $sth->execute();
                return $sth->fetchAll(PDO::FETCH_ASSOC);
                break;

            case 'PersAct' :

                $appel = 'INSERT INTO PersAct (PersId, ActId, cote) VALUES ((select PersId from test.Personnes where PersPrenom = "'. $_SESSION['user'][0]['PersPrenom'] .'" and PersNom = "'. $_SESSION['user'][0]['PersNom'] .'"), ?, NULL) ON DUPLICATE KEY UPDATE cote = cote';
                $sth = $this->iPdo->prepare($appel);
                $sth->bindParam(1, $idAct);

                $idAct = $_SESSION['activiteId'];

                $sth->execute();
                break;

            case 'ajouterNote' :
                $appel = 'UPDATE PersAct SET cote = '. $num .' WHERE ActId= '. $_SESSION['activiteId'] .' and PersId = (select PersId from test.Personnes where PersPrenom = "'. $_SESSION['user'][0]['PersPrenom'] .'" and PersNom = "'. $_SESSION['user'][0]['PersNom'] .'")';
                $sth = $this->iPdo->prepare($appel);
                $sth->execute();
                break;

            case 'classes' :
                $appel = 'SELECT PersNom, PersPrenom, ActNom, ActNombreQuestion, Cote FROM `Personnes` natural join PersAct NATURAL join Activites where classe = "' . $num .'"';
                $sth = $this->iPdo->prepare($appel);
                $sth->execute();
                return $sth->fetchAll(PDO::FETCH_ASSOC);
                break;
        }
    }
}