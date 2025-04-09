<?php
include_once 'util.php';
include 'monEnv.php';

$pageHTML = getDebutHTML("update d'un element dans la table sport");
if (isset($_GET['id'])) {
	$id = $_GET['id'];
    $pageHTML .= "<form method='GET'>";
    $pageHTML .= intoBalise("p",'Formulaire de mise à jour de la table sport');
    $pageHTML .= "<input type='hidden' name='id' value='$id'>";
    $attri = array("Sport_Catégorie","Sport_Type");
    $pageHTML .= getInputText($attri);
    $pageHTML .= "<label><input type='submit' name='Envoyer' value='Envoyer' /></label>
    </form>";
    if (isset($_GET['Envoyer'])) {
        // Supprimer le bouton Envoyer de $_GET
        array_pop($_GET);
        $sport = array(
            'Sport_Id' => $_GET['id'],
            'Sport_Catégorie' => $_GET['Sport_Catégorie'],
            'Sport_Type' => $_GET['Sport_Type'],
        );
        modifiePratiqueSport($sport['Sport_Id'], $sport['Sport_Catégorie'], $sport['Sport_Type']);
        updateSport($sport);
        $tableau1 = getAllSport();
        $pageHTML .= intoBalise("p","Les éléments de la table 'Sport' après modification : ");
        foreach($tableau1 as $ligne){
            $pageHTML .= $ligne;
        }
        $pageHTML .= "<br>";
        $pageHTML .= intoBalise("p","Les éléments de la table 'Pratique' apres modification");
        $tableau2 = getAllPratique();
        foreach($tableau2 as $ligne){
            $pageHTML .= $ligne;
        }
    }
}
$pageHTML .= "<a href = 'Accueil.php'> Page précédente </a>";
$pageHTML .= getFinHTML();
echo $pageHTML;
?>