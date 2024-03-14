<?php 
class Controller_accueil extends Controller{
    public function action_default(){
        switch($_GET['action']){
            case "form_add":
                $this->form_add();
            case "form_modifier":
                $this->form_modifier(); 
        }
    }

    public function form_add(){
        session_start();
        $data = ["id" => $_SESSION["id"]];
        $this->render("form_add",$data, "form");
    }

    public function form_modifier(){
        session_start();
        $m = Model::getModel();
        $infos = $m->getAppInfo($_SESSION['id'],$_GET['app']);
        include "Utils/RSA.php";
        $infos['mdp'] = dechiffrementRSA($infos['mdp'], $mdpkey['privee']);
        $data = ['infos' => $infos];
        
        $this->render("form_update",$data, "form");
    }

    public function action_changerMdp(){
        session_start();
        $infos = $_SESSION['motdepasse'];
        $data = ["password"=>$infos];
        $this->render("form_mdpmaitre",$data, "form");
    }
    
}
?>