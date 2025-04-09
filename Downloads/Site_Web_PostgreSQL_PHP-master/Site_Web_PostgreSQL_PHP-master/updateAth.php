<?php
include_once 'util.php';
include 'monEnv.php';

$pageHTML = getDebutHTML("update d'un element dans la table");
if (isset($_GET['id'])) {
	$id = $_GET['id'];
    $pageHTML .= "<form method='GET'>";
    $pageHTML .= intoBalise("p",'Formulaire de mise à jour');
    $pageHTML .= "<input type='hidden' name='id' value='$id'>";
    $attri = array("Nom","Prenom","Nationalité");
    $pageHTML .= getInputText($attri);
    $valeurs = array("Homme","Femme");
    $nomVar = "Sexe";
    $pageHTML .= getRadiosFromArray($valeurs,$nomVar);
    $pageHTML .= "<label><input type='submit' name='Envoyer' value='Envoyer' /></label>
    </form>";
    if (isset($_GET['Envoyer'])) {
        // Supprimer le bouton Envoyer de $_GET
        array_pop($_GET);
        $athlete = array(
            'Athlète_Id' => $_GET['id'],
            'Athlète_Nom' => $_GET['Nom'],
            'Athlète_Prénom' => $_GET['Prenom'],
            'Athlète_Nationalité' => $_GET['Nationalité'],
            'Athlète_Sexe' => $_GET['Sexe'],
        );
        updateAthlete($athlete);
        modifiePratiqueAthlete($athlete['Athlète_Id'], $athlete['Athlète_Nom'], $athlete['Athlète_Prénom'], $athlete['Athlète_Nationalité'], $athlete['Athlète_Sexe']);
        $pageHTML .= intoBalise('p',"La ligne modifiée de la table athlète");
        $pageHTML .= intoBalise('p',"La table athlète");
        $tableau1 = getAllAthlete();
        foreach($tableau1 as $ligne){
            $pageHTML .= $ligne;
        }
        $pageHTML .= '<br>';
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
