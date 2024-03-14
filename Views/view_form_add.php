<?php require "view_begin.php";?>

<form action="?controller=form&action=ajouterAppMdp" method = "post">
    <label>Ajouter un identifiant</label>
    <div class = "group-form">
        <input type = "text" name = "appli" placeholder = "Nom du logiciel">
    </div>
    <input type = "text" name="pseudo" placeholder = "Nom d'utilisateur">
    <div class = "group-form">
        <input id = "mdp" type = "text" name = "motdepasse" placeholder = "Mot de passe">
    </div>
    <?php if (isset($audit)){ echo "<ul>"; foreach($audit as $t){ echo "<li><p>" . $t . "</p></li>";} echo "</ul>";} 
    if (isset($erreur)){ echo $erreur; }?><br>
    <input id ="genmdp" type="button" value = "Générer un mot de passe"><br>
    <button type = "submit">Ajouter</button>
</form>

<script>
    document.getElementById("genmdp").addEventListener("click",function(){
        
    var caractere = [['a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z'],['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'],['0','1','2','3','4','5','6','7','8','9'],['&','?','!','#','~','%','$','£','µ','*','@','à','ç','ù']];
    var mdp = '';
    for(var i = 0; i < 20; i++) {
        var a = Math.floor(Math.random() * 4); // Génère un nombre aléatoire entre 0 et 3
        mdp += caractere[a][Math.floor(Math.random() * caractere[a].length)]; // Sélectionne un caractère aléatoire de la liste correspondante
    }
    document.getElementById("mdp").value  = mdp;
    });

</script>

<?php require "view_end.php"; ?>