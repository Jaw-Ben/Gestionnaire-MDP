<?php require "view_begin.php";?>

<form action="?controller=form&action=modifierMdp&app=<?php echo $infos['app'];?>" method = "post">
    <label>Modifier un mot de passe</label>
    <div class = "group-form">
        <label class = "app"><?php echo $infos['app'];?></label>
    </div>
    <div class = "group-form">
        <input id = "mdp" type = "text" name = "motdepasseapp" value = "<?php echo $infos['mdp'];?>">
    </div>
    <?php if (isset($audit)){ echo "<ul>"; foreach($audit as $t){ echo "<li><p>" . $t . "</p></li>";} echo "</ul>";} ?><br>
    <input id="genmdp" type = "button" value = "Générer un mot de passe"><br>
    <button type = "submit">Mettre à jour</button>
</form>

<script>
    document.getElementById("genmdp").addEventListener("click",function(){
        
    var caractere = [['a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z'],['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'],['0','1','2','3','4','5','6','7','8','9'],['&','?','!','#','~','%','$','£','µ','*','@','à','ç','ù']];
    var mdp = '';
    for(var i = 0; i < 20; i++){
        var a = Math.floor(Math.random() * 4); // Génère un nombre aléatoire entre 0 et 3
        mdp += caractere[a][Math.floor(Math.random() * caractere[a].length)]; // Sélectionne un caractère aléatoire de la liste correspondante
    }
    document.getElementById("mdp").value = mdp;
    });

    document.getElementById("mdp-mask").addEventListener("click",function(){
        let m = document.getElementById("mdp").type;
        if (m == "text"){
            m = "password";
        }
        else{
            m = "text";
        }
    })
    
</script>

<?php require "view_end.php"; ?>