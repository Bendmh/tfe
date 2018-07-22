<?php


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

    public function verification($choix = 'inscription'){
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
                $appel = 'select bonneReponse from Questions';
                $sth = $this->iPdo->prepare($appel);
                $sth->execute();
                return $sth->fetchAll(PDO::FETCH_ASSOC);
                break;

            /*case 'connexion' :
                $appel = 'select * from Personnes where PersNom = ? and PersPrenom = ?';
                $sth = $this->iPdo->prepare($appel);

                $sth->bindParam(1, $nom);
                $sth->bindParam(2, $prenom);

                $nom = $_POST['nom'];
                $prenom = $_POST['prenom'];

                $sth->execute();
                return $sth->fetchAll(PDO::FETCH_ASSOC);
                break;*/
        }
    }

    public function call($nom = '')
    {
        switch ($nom){
            case 'ajouterPersonne' :

                $appel = 'insert into Personnes(PersNom, PersPrenom, PersMdp, PersStatut) value(?,?,?,?)';

                //$appel = 'select * from Questions';
                $sth = $this->iPdo->prepare($appel);

                $sth->bindParam(1, $nom);
                $sth->bindParam(2, $prenom);
                $sth->bindParam(3, $Mdp);
                $sth->bindParam(4, $statut);

                $nom = $_POST['nom'];
                $prenom = $_POST['prenom'];
                $Mdp = $_POST['password'];
                $statut = 'élèves';

                $sth->execute();

            case 'questions' :
                $appel = 'select * from Questions';
                $sth = $this->iPdo->prepare($appel);
                $sth->execute();
                return $sth->fetchAll(PDO::FETCH_ASSOC);
        }
        /*$tab = [];
        switch ($nom) {
            case 'whoIs' : $tab[] = '?';
            case 'userProfil' :
            case 'mc_group' :
            case 'mc_coursesGroup' : $tab[] = '?';
            case 'mc_allGroups' :
            try {
                $appel = 'call 1718he201458.' . $nom . '(' . implode(',', $tab) . ')';
                $sth = $this->iPdo->prepare($appel);
                $sth->execute($param);
                return $sth->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                $this->pdoException = $e;
                return ['__ERR__' => $this->pdoException];
            }
            break;
                default : return ['__ERR__' => 'call impossible à ' . $nom];
        }*/
    }
}