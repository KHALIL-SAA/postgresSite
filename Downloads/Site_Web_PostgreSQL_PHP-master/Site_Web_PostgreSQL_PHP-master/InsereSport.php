<?php
include_once 'util.php';
include 'monEnv.php';
$pageHTML = getDebutHTML("Insertion dnas la table athlète");
$pageHTML .= "<form method='GET'>";
$attri = array("Sport_Catégorie","Sport_Type");
$pageHTML .= getInputText($attri);
$pageHTML .= "<p><input type='submit' name='Envoyer' value='Envoyer' /></p>
</form>";
if (isset($_GET['Envoyer'])) {
    // supprimer le bouton Envoyer de $_GET
    array_pop($_GET); 
    $Categorie = $_GET['Sport_Catégorie'];
    $Type = $_GET['Sport_Type'];
    insertIntoSport($_GET);
    $tableau = getAllSport();
    foreach($tableau as $ligne){
        $pageHTML .= $ligne;
    }
    if (empty($Categorie) || empty($Type)) {
        $erreur = "Veuillez remplir tous les champs.";
        $pageHTML .= $erreur;
    }
}
$pageHTML .= "<a href = 'Accueil.php'> Page précédente </a>";
$pageHTML .= getFinHTML();
echo $pageHTML;
?>