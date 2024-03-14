<?php require "view_begin.php";?>

<nav>
		<ul>
			<li><a href="?controller=accueil&action=form_add"> Ajouter un identifiant</a></li>
			<li><a href="?controller=accueil&action=changerMdp"> Modifier le mot de passe maître</a></li>
			<!-- <li><a href="?controller=list&action=pagination"> All the Nobel Prizes</a></li> -->
			<!-- <li><a href="?controller=search"> Search among the Nobel prizes</a></li> -->
		</ul>
</nav>

<h1>Bonjour <?php echo $infos["nom"]; ?></h1>
<?php

if (!empty($tableau)){
	echo $tableau;
}


require "view_end.php"; ?>