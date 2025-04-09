<?php
include 'util.php';

if (isset($_POST['Enregistrer'])) {
  $Nom = $_POST['Nom'];
  $Prenom = $_POST['Prenom'];
  $MotDePasse = $_POST['Mot_de_passe'];
  if (empty($Nom) || empty($Prenom) || empty($MotDePasse)) {
    $erreur = "Veuillez remplir tous les champs.";
    echo $erreur;
  } 
else {
  // Redirection vers la nouvelle page avec header()
  header("Location: intro.php");
  }
}
else {
$pageHTML = getDebutHTML("Page d'accueil");
$pageHTML .= intoBalise("h1","Palmares d'athlétisme");
$pageHTML .= intoBalise("h3","Log in");
$name = array('Nom','Prenom');
$pageHTML .= "<form action='index.php' method='POST'>";
$pageHTML .= getInputText($name);
$pageHTML .= getInputPassword("Mot_de_passe");
$pageHTML .= "<p><input type='submit' name='Enregistrer' value='Enregistrer' /></p>
</form>";  
$pageHTML .= getFinHTML();
echo $pageHTML;
}
?>