<?php
include_once 'util.php';
include 'monEnv.php';

$pageHTML = getDebutHTML("Introduction sur l'athlètisme");
$pageHTML .= intoBalise("h1","Athlétisme");
$pageHTML .= intoBalise("h2","Histoire : ");
$pageHTML .= "<p id = intro> C’est au XVe siècle av. J.-C., en Égypte et en Crète, que 				l’on trouve les plus anciennes tracesd’une activité athlétique.
				Puis, au VIIe siècle avant notre ère, apparaissent les premiers
				concours sportifs grecs (agônes) au sein desquels l’athlétisme occupe une
				place importante. Progressivement, ces rassemblements se développent
				dans toute la péninsule hellénique et aboutissent à des jeux dont ceux
				d’Olympie sont les plus illustres (à partir de -776 av. J.-C.). La course
				du Stade, d’une distance de 192,27 mètres (soit 600 fois la longueur du
				pied d’Héraclès) est l’épreuve de course la plus ancienne. </p>";
$pageHTML .= intoBalise("h2","Qu'est ce que c'est l'athlètisme : ");
$pageHTML .= "<p id = intro> L'athlétisme est une discipline qui regroupe plusieurs sport collectifs ou individuels.La plus célèbre est la 100 mètres, une course où il faut courir une distance de 100m.Parmi les courses de vitesse où l'endurance de l athlète est mise en épreuve par exemple : le marathon 42 kilomètres.L'athlètisme s’agit de l’art de dépasser la performance des adversaires en vitesse ou en endurance, en distance ou en hauteur.Son succès peut être expliquer par sa simplicité et le peu de moyens nécessaires à sa pratique</p>";
$pageHTML .= intoBalise('h3','Concernant notre projet');
$pageHTML .= "<p id = intro> Pour établir un site web contenant notre base de données nous avons utilisé des fonctions php qui nous permettre de se connecter à notre base de données de type 'PostgreSQL' avec une API 'pg_connect'.Vous allez trouver ainsi l'affichage des trois tables: la table Athlète, Sport, Pratique.Il existe aussi un moyen pour ajouter, supprimer ou modifier les tables. </p>";
$pageHTML .= intoBalise('h3',"Exemple d'athlète");
$pageHTML .= "<div class='images'>
  			  <img src='im1.jpg'>
  			  <img src='im2.jpg'>
			  </div>";
$pageHTML .= '<p><a href="index.php"> Page précédente </a></p>';
$pageHTML .= '<p><a href="Accueil.php"> Page suivante </a></p>';
$pageHTML .= getFinHTML();
echo $pageHTML;

?>