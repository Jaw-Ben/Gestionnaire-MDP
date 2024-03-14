<?php require "view_begin.php";?>

<form action="?controller=form&action=inscription" method = "post">
    <label class ="seconnecter"> Inscription</label>
    <div class = "group-form">
        <input type = "text" name = "mail" placeholder = "Adresse mail">
    </div>
    <div class = "group-form">
        <input type = "password" name = "motdepasse" placeholder = "Mot de passe">
    </div>
    <div class = "group-form">
        <input type = "text" name = "nom" placeholder = "Nom complet">
    </div>
    <div class = "group-form">
        <input type = "text" name = "fonction" placeholder = "Fonction">
    </div>
    <?php if (isset($saisi)){ echo "<p>" . $saisi . "</p>";} ?>
    <?php if (isset($err)){ echo "<p>" . $err . "</p>";} ?>
    <?php if (isset($audit)){ echo "<ul>"; foreach($audit as $t){ echo "<li><p>" . $t . "</p></li>";} echo "</ul>";} ?><br>
    <button type = "submit">S'inscrire</button>
</form>

<?php require "view_end.php";?>