<?php

class Controller_connexion extends Controller{

    public function action_default() {
        $this->action_form_connection();
    }

    public function action_form_connection() {
        $m = Model::getModel();

        $data = [
            "nbUser" => $m->getNbUser()
        ];

        $this->render("connexion", $data, "connexion");
    }

    public function action_se_connecter(){
        if (empty($_POST['mail'])){
            $erreur = [
                "mail_err" => 'Veuillez saisir un email '
            ];
            $this->render("connexion",$erreur, "connexion");
            exit;
        }

        if (empty($_POST['motdepasse'])){
            $erreur = [
                "motdepasse_err" => 'Veuillez saisir un mot de passe '
            ];
            $this->render("connexion",$erreur, "connexion");
            exit;
        }
        
        $m = Model::getModel();

        if (!$m->isInDatabase($_POST['mail'])){
            $erreur = [
                "connect_err" => "Ce compte n'existe pas"
            ];
            $this->render("connexion",$erreur, "connexion");
            exit;
        }

        $infos = $m->getUserInfo($_POST['mail']);
        include "Utils/RSA.php";

        if (chiffrementRSA($_POST['motdepasse'], $masterkey['publique']) != $infos['mdp']){
            $erreur = [
                "motdepasse_err" => "Le mot de passe est incorrect "
            ];
            $this->render("connexion",$erreur, "connexion");
            exit;
        }

        session_start();
        $_SESSION['mail'] = $_POST['mail'];
        $_SESSION['motdepasse'] = $_POST['motdepasse'];
        $_SESSION['id'] = $infos['id'];
        $_SESSION['nom'] = $infos['nom'];


        $appmdp = $m->getAppIdMdp($_SESSION['id']);
        $tab = "<table><tr><th>Application</th><th>Identifiant</th><th>Mot de passe</th><th></th></tr>";
        foreach($appmdp as $tr){
            $tab .= "<tr>";
            foreach($tr as $td){
                if ($tr['mdp'] == $td){
                    $td = dechiffrementRSA($td, $mdpkey['privee']);
                }
                $tab .= "<td>" . $td . "</td>";
            }
            $tab .= "<td><a href='?controller=accueil&action=form_modifier&app=" . e($tr['app']) . "'>Modifier</a></td></tr>";
        }
        $tab .= "</table>";
        $data = ["infos" => $infos, "tableau" => $tab];
        
        $this->render("accueil", $data, "accueil");
    }
    
    public function action_form_inscription(){
        $data = ["text" => "S'incrire"];
        $this->render("form_inscription",$data, "form");
    }
}
?>