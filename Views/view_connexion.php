<?php require "view_begin.php";?>


<form action="?controller=connexion&action=se_connecter" method = "post">
    <a class ="inscription" href ="?controller=connexion&action=form_inscription">S'inscrire</a><br>
    <label class ="seconnecter"> Connexion</label>
    <div class = "group-form">
        <input type = "text" name = "mail" placeholder = "Adresse mail">
    </div>
    <div class = "group-form">
        <input type = "password" name = "motdepasse" placeholder = "Mot de passe">
    </div>
    <p><?php if (isset($mail_err)){ echo $mail_err;} ?></p>
    <p><?php if (isset($motdepasse_err)){ echo $motdepasse_err;} ?></p>
    <p><?php if (isset($connect_err)){ echo $connect_err;} ?></p>
    <button type = "submit">Se connecter</button>
</form>


<?php require "view_end.php"; ?>