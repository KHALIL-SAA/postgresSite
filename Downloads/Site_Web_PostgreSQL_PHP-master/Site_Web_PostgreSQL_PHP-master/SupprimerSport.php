<?php
include_once 'util.php';
include 'monEnv.php';

$pageHTML = getDebutHTML("Suppression d'un element dans la table");
if (isset($_GET['id'])) {
	$id = intval($_GET['id']);
    deletePratiqueSport($id);
    deleteSport($id);
    $pageHTML .= intoBalise('p',"Les éléments de la table 'Sport' sont : ");
    $tableau1 = getAllSport();
    foreach($tableau1 as $ligne){
        $pageHTML .= $ligne;
    }
    $pageHTML .= intoBalise('p',"Les éléments de la table 'Pratique' sont : ");
    $tableau2 = getAllPratique();
    foreach($tableau2 as $ligne){
        $pageHTML .= $ligne;
    }
}
$pageHTML .= "<a href = 'Accueil.php'> Page précédente </a>";
echo $pageHTML;
?>