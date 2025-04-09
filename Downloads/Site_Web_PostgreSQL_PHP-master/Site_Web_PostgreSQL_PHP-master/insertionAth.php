<?php
include_once 'util.php';
include 'monEnv.php';

$pageHTML = getDebutHTML("Insertion dans la table athlète");
$pageHTML .= intoBalise('h2',"Insertion d'un nouveau athlète");
$pageHTML .= intoBalise('p','Veuillez prendre en compte les types de sports proposés dans le tableau ci-dessous');
$pageHTML .= "<form method='GET'>";
$pageHTML .= "<input type='hidden' name='Athlète_Id' value=''>";
$attri = array("Nom","Prenom","Nationalité");
$pageHTML .= getInputText($attri);
$valeurs = array("Homme","Femme");
$nomVar = "Sexe";
$pageHTML .= getRadiosFromArray($valeurs,$nomVar);
$pageHTML .= listeDeroulante('Sport_Catégorie', 'Catégorie');
$pageHTML .= '<br>';
$pageHTML .= getInputText(['Sport_Type']);
$tab = getSportCatType();
foreach($tab as $att){
    $pageHTML .= $att;
}
$pageHTML .= "<p><input type='submit' name='Envoyer' value='Envoyer' /></p>
</form>";
if (isset($_GET['Envoyer'])) {
    array_pop($_GET); // supprimer le bouton Envoyer de $_GET
    $athlete = array(
        'Athlète_Nom' => $_GET['Nom'],
        'Athlète_Prénom' => $_GET['Prenom'],
        'Athlète_Nationalité' => $_GET['Nationalité'],
        'Athlète_Sexe' => $_GET['Sexe'],
    );
    $leNouveauAth = insertIntoAthlete($athlete);
    if (isset($leNouveauAth['message'])) {
        $pageHTML .= intoBalise('p', $leNouveauAth['message']);
    } else {
        //Recuperation de l'id du nouveau athlète inserer
        $athleteId = $leNouveauAth[0];
        $spCatTyp = array(
            'Sport_Catégorie' => $_GET['Sport_Catégorie'],
            'Sport_Type' => $_GET['Sport_Type'],
        );
        //Recuperation de l'ID du sport que l'athlète pratique
        $idSportVoulu = intval(getSportID($spCatTyp));
        //Insertion dans la table pratique
        $inserePratqiue = insertIntoPratique($idSportVoulu,$athleteId);
        $pageHTML .= intoBalise('p',"Les éléments de la table 'Athlète'");
        //Affichage de la table athlète.
        $tableau1 = getAllAthlete();
        foreach($tableau1 as $ligne){
            $pageHTML .= $ligne;
        }
        $pageHTML .= intoBalise('p',"Les éléments de la table 'Pratique'");
        //Affichage de la table pratique
        $tableau2 = getAllPratique();
        foreach($tableau2 as $ligne){
            $pageHTML .= $ligne;
        }
    }
    if (empty($_GET['Nom']) || empty($_GET['Prenom']) || empty($_GET['Nationalité']) || empty($_GET['Sexe']) || empty($_GET['Sport_Catégorie']) || empty($_GET['Sport_Type'])) {
        $erreur = "Veuillez remplir tous les champs.";
        $pageHTML .= intoBalise('p', $erreur);
    }
}
$pageHTML .= "<a href = 'Accueil.php'> Page précédente </a>";
$pageHTML .= getFinHTML();
echo $pageHTML;
?>