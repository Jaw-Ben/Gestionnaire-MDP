<?php require "view_begin.php"; ?>

<form action="?controller=form&action=modifierMasterPassword" method = "post">
    <label>Modifier le mot de passe maître</label>
    <div class = "group-form">
        <input id = "mdp" type = "text" name = "motdepasse" value = "<?php echo $password;?>">
    </div>
    <?php if (isset($audit)){ echo "<ul>"; foreach($audit as $t){ echo "<li><p>" . $t . "</p></li>";} echo "</ul>";} ?><br>
    <button type = "submit">Mettre à jour</button>
</form>

<?php require "view_end.php"; ?>