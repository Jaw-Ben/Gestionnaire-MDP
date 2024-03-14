<?php

class Model
{
    /**
     * Attribut contenant l'instance PDO
     */
    private $bd;

    /**
     * Attribut statique qui contiendra l'unique instance de Model
     */
    private static $instance = null;

    /**
     * Constructeur : effectue la connexion à la base de données.
     */
    private function __construct()
    {
        include "Utils/credentials.php";
        $this->bd = new PDO($dsn, $login, $password);
        $this->bd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->bd->query("SET nameS 'utf8'");
    }

    /**
     * Méthode permettant de récupérer un modèle car le constructeur est privé (Implémentation du Design Pattern Singleton)
     */
    public static function getModel()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Retourne les applications et leurs mots de passe
     * @return [array] Contient les informations des prix nobel
     */
    public function getAppIdMdp($id)
    {
        $req = $this->bd->prepare('SELECT app, identifiant, mdp FROM mdpuser WHERE id = :id');
        $req->bindValue(':id', $id);
        $req->execute();
        return $req->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Retourne le nombre de mots de passe
     * @return [int]
     */
    public function getNbMdp()
    {
        $req = $this->bd->prepare('SELECT COUNT(*) FROM mdpuser');
        $req->execute();
        $tab = $req->fetch(PDO::FETCH_NUM);
        return $tab[0];
    }

    /**
     * Retourne les prix nobels dans la base de données du ($offset+1)ème au ($offset + $limit) ème
     * @param [int] $offset Position de départ
     * @param [int] $limit Nombre de résultats retournés
     * @return [array] Contient les informations des prix nobel
     */
    public function changeMdp($id, $app, $mdp)
    {
        $requete = $this->bd->prepare('UPDATE mdpuser SET mdp = :mdp WHERE id = :id AND app = :app');
        $requete->bindValue(':mdp', $mdp);
        $requete->bindValue(':id', $id, PDO::PARAM_INT);
        $requete->bindValue(':app', $app);
        $requete->execute();
        return $requete->rowCount();
    }

    /**
     * Retourne l'id de l'utilisateur
     * @return [array] Tableau contenant les catégories (les valeurs sont les catégories, les clés les indices)
     */

    public function getUserInfo($mail){
        $requete = $this->bd->prepare("SELECT * FROM employe WHERE mail = :mail");
        $requete->bindValue(':mail', $mail);
        $requete->execute();
        return $requete->fetch(PDO::FETCH_ASSOC);
    }

    public function isInDatabase($mail){
        return $this->getUserInfo($mail) !== false;
    }

    public function getNbUser(){
        $req = $this->bd->prepare("SELECT COUNT(*) FROM employe");
        $req->execute();
        $tab = $req->fetch(PDO::FETCH_NUM);
        return $tab[0];
    }

    public function addAppandMdp($id, $app, $pseudo, $mdp){
        $req = $this->bd->prepare("INSERT INTO mdpuser (id, app, identifiant, mdp) VALUES (:id, :app, :identifiant, :mdp)");
        $req->bindValue(":id", $id);
        $req->bindValue(":identifiant", $pseudo);
        $req->bindValue(":app", $app);
        $req->bindValue(":mdp", $mdp);
        $req->execute();
        return $req->rowCount();
    }

    public function getUserInfobyId($id){
        $requete = $this->bd->prepare("SELECT * FROM employe WHERE id = :id ");
        $requete->bindValue(':id', $id);
        $requete->execute();
        return $requete->fetch(PDO::FETCH_ASSOC);
    }

    public function getAppInfo($id, $app){
        $req = $this->bd->prepare("SELECT * FROM mdpuser WHERE id = :id AND app = :app");
        $req->bindValue(":id",$id);
        $req->bindValue(":app",$app);
        $req->execute();
        return $req->fetch(PDO::FETCH_ASSOC);
    }

    public function updateMasterPassword($id, $mdp){
        $req = $this->bd->prepare("UPDATE employe SET mdp = :mdp WHERE id = :id");
        $req->bindValue(":id", $id);
        $req->bindValue(":mdp", $mdp);
        $req->execute();
        return $req->rowCount();
    }

    public function createUser($id, $nom, $mail, $mdp, $fct){
        $req = $this->bd->prepare("INSERT INTO employe (id, nom, mail, mdp, fonction) VALUES (:id, :nom, :mail, :mdp, :fct)");
        $req->bindValue(":mdp", $mdp);
        $req->bindValue(":id", $id);
        $req->bindValue(":nom", $nom);
        $req->bindValue(":mail", $mail);
        $req->bindValue(":fct", $fct);
        $req->execute();
        return $req->rowCount();
    }

    public function IdinDatabase($id){
        $req = $this->bd->prepare("SELECT * FROM employe WHERE id = :id");
        $req->bindValue(":id",$id);
        $req->execute();
        return $req->rowCount();
    }

    public function AppinDatabase($id, $app){
        $req = $this->bd->prepare("SELECT * FROM mdpuser WHERE id = :id AND app = :app");
        $req->bindValue(":id",$id);
        $req->bindValue(":app",$app);
        $req->execute();
        return $req->rowCount();
    }
}