<?php
class Controller_form extends Controller{
    public function action_default(){
        switch($_GET['action']){
            case "ajouterAppMdp":
                $this->ajouterAppMdp();
            case "modifierMdp":
                $this->modifierMdp(); 
        }
    }


    public function ajouterAppMdp(){
        if (empty($_POST['motdepasse'])){
            $erreur = [
                "erreur" => 'Veuillez saisir un mot de passe '
            ];
            $this->render("form_add", $erreur, "form");
            exit;
        }

        if (empty($_POST['appli'])){
            $erreur = [
                "erreur" => 'Veuillez saisir une application '
            ];
            $this->render("form_add", $erreur, "form");
            exit;
        }

        session_start();
        $m = Model::getModel();

        if ($m->AppinDatabase($_SESSION['id'], $_POST['appli'])){
            $erreur = ["erreur" => "Cette application existe déjà"];
            $this->render("form_add", $erreur, "form");
            exit;
        }

        $t = [];
        if (!preg_match('/[a-z]/',$_POST['motdepasse'])){
            $t[] = 'Le mot de passe doit avoir au moins une miniscule';
        }
        if (!preg_match('/[A-Z]/',$_POST['motdepasse'])){
            $t[] = 'Le mot de passe doit avoir au moins une majuscule';
        }

        if (!preg_match('/\d/',$_POST['motdepasse'])){
            $t[] = 'Le mot de passe doit avoir au moins un chiffre';
        }

        if (strlen($_POST['motdepasse']) < 10){
            $t[] = "Le mot de passe n'est pas assez long";
        }


        if (empty($t)){
            include "Utils/RSA.php";
            $m->addAppandMdp($_SESSION['id'], $_POST['appli'], $_POST['pseudo'], chiffrementRSA($_POST['motdepasse'], $mdpkey['publique']));
            $infos = $m->getUserInfo($_SESSION['mail']);

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

            $data = ["infos"=>$infos, "tableau"=>$tab];
            $this->render("accueil", $data, "accueil");
            exit;
        }
        $infos = $_SESSION['id'];
        $data = ["infos"=>$infos, "audit"=>$t];
        $this->render("form_add", $data, "form");
    }
    
    public function modifierMdp(){
        if (empty($_POST['motdepasseapp'])){
            $erreur = [
                "audit" => 'Veuillez saisir un mot de passe '
            ];
            $this->render("form_update", $erreur, "form");
            exit;
        }
        
        $t = [];
        if (!preg_match('/[a-z]/',$_POST['motdepasseapp'])){
            $t[] = 'Le mot de passe doit avoir au moins une miniscule';
        }
        if (!preg_match('/[A-Z]/',$_POST['motdepasseapp'])){
            $t[] = 'Le mot de passe doit avoir au moins une majuscule';
        }

        if (!preg_match('/\d/',$_POST['motdepasseapp'])){
            $t[] = 'Le mot de passe doit avoir au moins un chiffre';
        }

        if (!preg_match('/\W/',$_POST['motdepasseapp'])){
            $t[] = 'Le mot de passe doit avoir au moins un caractère spécial';
        }
        if (strlen($_POST['motdepasseapp']) < 10){
            $t[] = "Le mot de passe n'est pas assez long";
        }

        session_start();
        $m = Model::getModel();
        if (empty($t)){
            include "Utils/RSA.php";
            $m->changeMdp($_SESSION['id'], $_GET['app'], chiffrementRSA($_POST['motdepasseapp'], $mdpkey['publique']));
            $infos = $m->getUserInfo($_SESSION['mail']);

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

            $data = ["infos"=>$infos, "tableau"=>$tab];
            $this->render("accueil", $data, "accueil");
            exit;
        }
        $infos = $m->getAppInfo($_SESSION['id'],$_GET['app']);
        $data = ["infos"=>$infos, "audit"=>$t];
        $this->render("form_update", $data, "form");
    }

    public function action_modifierMasterPassword(){
        if (empty($_POST['motdepasse'])){
            $erreur = [
                "audit" => 'Veuillez saisir un mot de passe '
            ];
            $this->render("form_update", $erreur, "form");
            exit;
        }

        $t = [];
        if (!preg_match('/[a-z]/',$_POST['motdepasse'])){
            $t[] = 'Le mot de passe doit avoir au moins une miniscule';
        }
        if (!preg_match('/[A-Z]/',$_POST['motdepasse'])){
            $t[] = 'Le mot de passe doit avoir au moins une majuscule';
        }

        if (!preg_match('/\d/',$_POST['motdepasse'])){
            $t[] = 'Le mot de passe doit avoir au moins un chiffre';
        }

        if (!preg_match('/\W/',$_POST['motdepasse'])){
            $t[] = 'Le mot de passe doit avoir au moins un caractère spécial';
        }
        if (strlen($_POST['motdepasse']) < 10){
            $t[] = "Le mot de passe n'est pas assez long";
        }

        session_start();
        $m = Model::getModel();
        if (empty($t)){
            include "Utils/RSA.php";
            $m->updateMasterPassword($_SESSION['id'], chiffrementRSA($_POST['motdepasse'], $masterkey['publique']));
            $infos = $m->getUserInfo($_SESSION['mail']);

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

            $data = ["infos"=>$infos, "tableau"=>$tab];
            $this->render("accueil", $data, "accueil");
            exit;
        }
        $infos = $_SESSION["motdepasse"];
        $data = ["password"=>$infos, "audit"=>$t];
        $this->render("form_mdpmaitre", $data, "form");
    }

    public function action_inscription(){
        if (empty($_POST['motdepasse']) || empty($_POST['mail']) || empty($_POST['nom']) || empty($_POST['fonction'])){
            $erreur = [
                "saisi" => 'Veuillez saisir les informations'
            ];
            $this->render("form_inscription", $erreur, "form");
            exit;
        }

        $m = Model::getModel();

        if ($m->isInDatabase($_POST['mail'])){
            $erreur = ["saisi" => "Ce compte existe déjà"];
            $this->render("form_inscription", $erreur, "form");
            exit;
        }

        $t = [];
        if (!preg_match('/[a-z]/',$_POST['motdepasse'])){
            $t[] = 'Le mot de passe doit avoir au moins une miniscule';
        }
        if (!preg_match('/[A-Z]/',$_POST['motdepasse'])){
            $t[] = 'Le mot de passe doit avoir au moins une majuscule';
        }

        if (!preg_match('/\d/',$_POST['motdepasse'])){
            $t[] = 'Le mot de passe doit avoir au moins un chiffre';
        }

        if (!preg_match('/\W/',$_POST['motdepasse'])){
            $t[] = 'Le mot de passe doit avoir au moins un caractère spécial';
        }
        if (strlen($_POST['motdepasse']) < 10){
            $t[] = "Le mot de passe n'est pas assez long";
        }

        if (!empty($t)){
            $data = ["audit" => $t];            
            $this->render("form_inscription", $data, "form");
            exit;
        }

        $i = $m->getNbUser()+1;
        while ($m->IdinDatabase($i)){
            $i+=1;
        }
        if ($m->isInDatabase($_POST['mail'])){
            $erreur = ["erreur" => "Ce compte existe déjà"];
            $this->render("form_inscription", $erreur, "form");
            exit;
        }
        $m->createUser($i, $_POST['nom'], $_POST['mail'], $_POST['motdepasse'], $_POST['fonction']);

        $data = ["audit" => $t];            
        $this->render("connexion", $data, "connexion");

    }
}


?>