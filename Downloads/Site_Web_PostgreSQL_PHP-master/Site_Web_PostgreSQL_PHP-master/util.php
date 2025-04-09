<?php
// début du document HTML 5
function getDebutHTML(string $title='Title content') : string {
    return "<!doctype html>
    <html lang='fr'>
    <head>
      <meta charset='utf-8'>
      <title>$title</title>
      <link rel='stylesheet' href='Projet.css'>
      <link rel='icon' href='https://etapes.com/app/uploads/2011/01/rio-devoile-le-logo-des-jo-2016-1.jpg'>
    </head>
    <body>";
}

// fin du document HTML
function getFinHTML(): string {
    return '</body></html>';
}

function intoBalise_v1(string $nomElement, string $contenuElement) : string {
    if ($contenuElement==='') // if (!$contenuElement) ne suffit pas
        $resu ="<$nomElement />";
    else
        $resu = "<$nomElement>$contenuElement</$nomElement>";
    return $resu;
}

function intoBalise(string $nomElement, string $contenuElement,
                    array $params = null) : string {
    $resu = "<$nomElement "; // amorce la construction de la balise ouvrante
    if (isset($params)) { // traite le 3e parametre s'il existe
        foreach ($params as $attribut => $valeur)
            $resu .= $attribut."='$valeur' "; // construit les attributs de la balise HTML
    }
    if ($contenuElement==='')
        $resu .=' />'; // ferme la balise s'il s'agit d'un élément vide
    else
        $resu .= ">$contenuElement</$nomElement>"; // termine la balise ouvrante, intègre le contenu et ferme la balise
    return $resu; // retourne la chaine de caractères construite
}

function getInputText(array $name){
    $formulaire = "";
    foreach($name as $attribut){
      $formulaire .= "<label> $attribut : <input type='text' name='$attribut' size='15' /></label>";
    }
    return $formulaire;
}

function getInputPassword($attribut){
    $formulaire = "<label> $attribut : <input type='password' name='$attribut' size='15' /></label>";
    return $formulaire;
}

function getInputNumber(array $name){
    $formulaire = "";
    foreach($name as $attribut){
      $formulaire .= "<label><b> $attribut : <input type='number' name='$attribut' size='15' /></label>";
    }
    return $formulaire;
}

// fabrication d'une collection de checkbox HTML à partir d'un tableau de valeurs
function getCheckBoxesFromArray(array $valeurs, string $nomVar): string {
    $lesCheckBoxes = "";
    foreach ($valeurs as $valeur) {
        $lesCheckBoxes .= "$valeur <input type='checkbox' name='$nomVar"."[]' ";
        if (isset($_REQUEST[$nomVar]) && in_array($valeur, $_REQUEST[$nomVar])) {
            $lesCheckBoxes .= "checked='checked' ";
        }
        $lesCheckBoxes .= "value='$valeur'>\n";
    }
    return $lesCheckBoxes;
}

// fabrication d'une collection de boutons radio HTML à partir d'un tableau de valeurs
function getRadiosFromArray(array $valeurs, string $nomVar): string {
    $lesRadios = "";
    foreach ($valeurs as $valeur) {
        $lesRadios .= "$valeur <input type='radio' name='$nomVar' ";
        if (isset($_REQUEST[$nomVar]) && $valeur == $_REQUEST[$nomVar]) {
            $lesRadios .= "checked='checked' ";
        }
        $lesRadios .= "value='$valeur'>\n";
    }
    return $lesRadios;
}

function connexion(){
    $strConnex = 'host='.$_ENV['dbHost'].' dbname='.$_ENV['dbName'].' user='.$_ENV['dbUser'].' password='.$_ENV['dbPassword'];
    $ptrDB = pg_connect($strConnex);
    return $ptrDB;
}
function getAthleteById(String $id) : array {
    $ptrDB = connexion();
    $query = "SELECT * FROM Athlète WHERE Athlète_Id = $1";
    // La fonction pg_prepare pour preparer la requete
    pg_prepare($ptrDB,'reqPrepSelectById',$query);
    $ptrQuery = pg_execute($ptrDB,'reqPrepSelectById',array($id));
    $resu = array();
    if($ptrQuery){
        $resu[] = '<table border = "2">';
        $attributs = array("Athlète_Id","Nom","Prénom","Nationalité","Sexe");
        foreach($attributs as $att){
            $resu[] .= "<th> $att </th>";
        }
        while($ligne = pg_fetch_assoc($ptrQuery)){
            $resu[] .=  "<tr>";
            foreach($ligne as $valeur){
                $resu[] .= "<td>";
                $resu[] .=  $valeur." ";
                $resu[] .= "</td>";
            }
        }
        $resu[] .= "</table>";
    }
    //Liberation de ressource
    pg_free_result($ptrQuery);
    //On ferme la connexion avec pg_close()
    pg_close($ptrDB);
    return $resu;
}

function getSportById(String $id) : array {
    $ptrDB = connexion();
    $query = "SELECT * FROM Sport WHERE Sport_Id = $1";
    // La fonction pg_prepare pour preparer la requete
    pg_prepare($ptrDB,'reqPrepSelectSportById',$query);
    $ptrQuery = pg_execute($ptrDB,'reqPrepSelectSportById',array($id));
    if(isset($ptrQuery)){
        //recuperation du tableau associatif avec pg_fetch_assoc dans $resu
        $resu = pg_fetch_assoc($ptrQuery);
        if(empty($resu)){
            $resu = array("message" => "Identifiant de sport non valide : $id");
        }
    }
    //Liberation de ressource
    pg_free_result($ptrQuery);
    //On ferme la connexion avec pg_close()
    pg_close($ptrDB);
    return $resu;
}
function getAllAthlete() : array {
    $ptrDB = connexion();
    $query = "SELECT * FROM Athlète";
    //Préparation de la requête
    pg_prepare($ptrDB,'reqPrepSelectAll',$query);
    $ptrQuery = pg_execute($ptrDB,'reqPrepSelectAll',array());
    $resu = array();
    if($ptrQuery){
        $resu[] = '<table border="2">';
        $attributs = array("Athlète_Id","Nom","Prénom","Nationalité","Sexe","Update","Supprimer");
        foreach($attributs as $att){
            $resu[] .= "<th>$att</th>" ;
        }
        $resu[] .= "</tr>";
        while($ligne = pg_fetch_row($ptrQuery)){
            $id = $ligne[0];
            $resu[] .= "<tr>";
            foreach($ligne as $colonne){
                $resu[] .= "<td>";
                $resu[] .= $colonne." ";
                $resu[] .= "</td>";
            }
            // Ajout des colonnes d'hyperliens
            $resu[] .= "<td><form method='GET' action='updateAth.php'><input
                            type='hidden' name='id' value='$id'><button
                            type='submit'>Modifier</button></form></td>";

            $resu[] .= "<td><form method='GET' action='SuprimerAth.php'><input
                            type='hidden' name='id' value='$id'><button
                            type='submit'>Supprimer</button></form></td>";
            $resu[] .= "</tr>";
        }
        $resu[] .= "</table>";
    }
    pg_free_result($ptrQuery);
    pg_close($ptrDB);
    return $resu;
}

function getAllSport() : array {
    $ptrDB = connexion();
    $query = "SELECT * FROM Sport";
    //Préparation de la requête
    pg_prepare($ptrDB, 'reqPrepSelectSportAll', $query);
    $ptrQuery = pg_execute($ptrDB, 'reqPrepSelectSportAll', array());
    $resu = array();
    if($ptrQuery){
        $resu[] = '<table border = "2">';
        $attributs = array("Sport Id","Catégorie","Type","Update","Supprimer");
        foreach($attributs as $att){
            $resu[] .= "<th> $att </th>";
        }
        while($ligne = pg_fetch_row($ptrQuery)){
            $id = $ligne[0];
            $resu[] .=  "<tr>";
            foreach($ligne as $valeur){
                $resu[] .= "<td>";
                $resu[] .=  $valeur." ";
                $resu[] .= "</td>";
            }
            $resu[] .= "<td><form method='GET' action='updateSport.php'><input
                        type='hidden' name='id' value='$id'><button
                        type='submit'>Modifier</button></form></td>";
            $resu[] .= "<<td><form method='GET' action='SupprimerSport.php'><input
                        type='hidden' name='id' value='$id'><button
                        type='submit'>Supprimer</button></form></td>";
            $resu[] .= "</tr>";
        }
        $resu[] .= "</table>";
    }
    pg_free_result($ptrQuery);
    pg_close($ptrDB);
    return $resu;
}
function getAllPratique() : array {
    $ptrDB = connexion();
    $query = "SELECT Athlète_Nom AS Nom, Athlète_Prénom AS prènom,Athlète_Nationalité AS nationalité, Athlète_Sexe 
                                    AS Sexe, Sport_Catégorie, Sport_Type FROM Athlète NATURAL JOIN Sport NATURAL JOIN Pratique";
    //Preparation de la requete
    pg_prepare($ptrDB,'reqPrepSelectAllPratique',$query);
    $ptrQuery = pg_execute($ptrDB,'reqPrepSelectAllPratique',array());
    $resu = array();
    if($ptrQuery){
        $resu[] = '<table border = "2">';
        $attributs = array("Nom","Prénom","Nationalité","Sexe","Sport catégorie","Sport type");
        foreach($attributs as $att){
            $resu[] .= "<th> $att </th>";
        }
        $numeroLigne = 0;
        while($ligne = pg_fetch_row($ptrQuery)){
            $resu[] .=  "<tr>";
            foreach($ligne as $colonne){
                $resu[] .= "<td>";
                $resu[] .=  $colonne." ";
                $resu[] .= "</td>";
            }
            $numeroLigne++;
            $resu[] .= "</tr>";
        }
    $resu[] .= "</table>";
}
    pg_free_result($ptrQuery);
    pg_close($ptrDB);
    return $resu;
}
//Insertion dans la table Athlete.
function insertIntoAthlete(array $athlete) : array {
    $ptrDB = connexion();
    $query = "INSERT INTO Athlète VALUES(DEFAULT,$1,$2,$3,$4) RETURNING Athlète_Id";
    pg_prepare($ptrDB,'reqPrepInsertIntoAthlete',$query);
    $result = pg_execute($ptrDB, 'reqPrepInsertIntoAthlete', $athlete);
    $newAthlete = pg_fetch_row($result);
    if (!$newAthlete) {
        return array("message" => "Erreur lors de l'insertion de l'athlète dans la base de données");
    }
    $athleteId = $newAthlete[0];
    return array($athleteId);
}
//Insertion dans la table Sport.
function insertIntoSport(array $spt) : array {
    $ptrDB = connexion();
    $query = 'INSERT INTO Sport VALUES(DEFAULT,$1,$2) RETURNING Sport_Id';
    pg_prepare($ptrDB,'reqPrepInsertIntoSport',$query);
    $result = pg_execute($ptrDB,'reqPrepInsertIntoSport',$spt);
    $newSPort = pg_fetch_row($result);
    $sportId = $newSPort[0];
    return array($sportId);
    //return getSportById($sportId);
}

//Méthode d'insertion dans la table pratique
function insertIntoPratique(int $sportId, int $athleteId) : array {
    $ptrDB = connexion();
    $query = 'INSERT INTO Pratique VALUES ($1, $2)';
    pg_prepare($ptrDB,'reqPrepInsertDansTablePratique',$query);
    $result = pg_execute($ptrDB, 'reqPrepInsertDansTablePratique', array($sportId, $athleteId));
    if (!$result) {
        return array("message" => "Erreur lors de l'insertion de l'athlète dans la pratique du sport dans la base de données");
    }
    return getAllPratique();
    //return array("message" => "L'athlète a été ajouté à la pratique du sport avec succès");
}

//Update de la table Athlète
function updateAthlete(array $Ath) {
    $ptrDB = connexion();
    //Preparation de la requete
    $query = 'UPDATE Athlète SET Athlète_Nom = $2, Athlète_Prénom = $3, Athlète_Nationalité = $4, Athlète_Sexe = $5 WHERE Athlète_Id = $1';
    pg_prepare($ptrDB,'reqUpdateAthlete',$query);
    //execution de la requete
    pg_execute($ptrDB,'reqUpdateAthlete',$Ath);
    return getAthleteById($Ath['Athlète_Id']);
}

//Update de la table Sport
function updateSport(array $spt) {
    $ptrDB = connexion();
    //Preparation de la requete
    $query = 'UPDATE Sport SET Sport_Catégorie = $2, Sport_Type = $3 WHERE Sport_Id = $1';
    pg_prepare($ptrDB,'reqUpdateSport',$query);
    //execution de la requete
    pg_execute($ptrDB,'reqUpdateSport',$spt);
    return getSportById($spt['Sport_Id']);
}

// Suppression dans la table Athlete
function deleteAthlete(String $id) {
    $ptrDB = connexion();
    //Preparation de la requete
    $query = 'DELETE FROM Athlète WHERE Athlète_Id = $1';
    pg_prepare($ptrDB, 'reqPrepDeletAthlete',$query);
    pg_execute($ptrDB,'reqPrepDeletAthlete',array($id));
    return getAllAthlete();
}
// Suppression dans la table Sport
function deleteSport(String $id) {
    $ptrDB = connexion();
    //Preparation de la requete
    $query = 'DELETE FROM Sport WHERE Sport_Id = $1';
    pg_prepare($ptrDB, 'reqPrepDeletSport',$query);
    pg_execute($ptrDB,'reqPrepDeletSport',array($id));
}

// Méthode de suppresion dans la table Pratique
function deletePratiqueAthlete(String $AthleteID) {
    $ptrDB = connexion();
    //Preparation de la requete
    $query = 'DELETE FROM Pratique WHERE Athlète_Id = $1';
    pg_prepare($ptrDB, 'reqPrepDeletSport',$query);
    pg_execute($ptrDB,'reqPrepDeletSport',array($AthleteID));
}
function deletePratiqueSport(String $sportID){
    $ptrDB = connexion();
    $query = 'DELETE FROM Pratique WHERE Sport_Id = $1';
    //Preparation de la requete
    pg_prepare($ptrDB, 'requeteDeleteFromSport',$query);
}
function modifiePratiqueAthlete($id, $nom, $prenom, $nationalite, $sexe){
    $ptrDB = connexion();
    $query = "UPDATE Athlète SET Athlète_Nom = $2, Athlète_Prénom = $3, Athlète_Nationalité = $4, Athlète_Sexe = $5 WHERE Athlète_Id = $1";
    pg_prepare($ptrDB, 'reqModifiePratiqueAthlete', $query);
    pg_execute($ptrDB, 'reqModifiePratiqueAthlete', array($id, $nom, $prenom, $nationalite, $sexe));
}
function modifiePratiqueSport($id, $categorie, $type){
    $ptrDB = connexion();
    $query = "UPDATE Sport SET Sport_Catégorie = $2, Sport_Type = $3 WHERE Sport_Id = $1";
    pg_prepare($ptrDB, "reqModifiePratiqueSport", $query);
    pg_execute($ptrDB, "reqModifiePratiqueSport", array($id,$categorie,$type));
}

//Affichage de l'athlè
function getAthleteByNom(String $nom) : array {
    $ptrDB = connexion();
    $query = "SELECT * FROM Athlète WHERE Athlète_Nom = $1";
    // La fonction pg_prepare pour preparer la requete
    pg_prepare($ptrDB,'reqPrepSelectByNom',$query);
    $ptrQuery = pg_execute($ptrDB,'reqPrepSelectByNom',array($nom));
    if(isset($ptrQuery)){
        //recuperation du tableau associatif avec pg_fetch_assoc dans $resu
        $resu = pg_fetch_row($ptrQuery, 0);
        if(empty($resu)){
            $resu = array("message" => "Nom introuvable : $nom");
        }
    }
    //Liberation de ressource
    pg_free_result($ptrQuery);
    //On ferme la connexion avec pg_close()
    pg_close($ptrDB);
    return $resu;
}
function listeDeroulante(String $req, String $titre){
    $ptrDB = connexion();
    $query = "SELECT DISTINCT $req FROM Sport";
    pg_prepare($ptrDB, 'reqDeLaListeDeroulante', $query);
    $ptrQuery = pg_execute($ptrDB, 'reqDeLaListeDeroulante', []);
    $formulaire = "<label for='$titre'>$titre</label><select name='$req'>";
    while ($attr = pg_fetch_row($ptrQuery)) {
        $formulaire .= "<option value='" . $attr[0] . "'>" . $attr[0] . "</option>";
    }
    $formulaire .= "</select>";
    return $formulaire;
}
function listeDeroulante2(String $req, String $titre, String $categorie){
    $selectedOption = $_POST[$req] ?? ''; // récupérer la valeur sélectionnée par l'utilisateur ou une chaîne vide par défaut
    $ptrDB = connexion();
    $query = "SELECT DISTINCT $req FROM Sport WHERE Sport_Catégorie = $1";
    pg_prepare($ptrDB, 'reqDeLaListeDeroulante', $query);
    $ptrQuery = pg_execute($ptrDB, 'reqDeLaListeDeroulante', [$categorie]);
    $formulaire = "<form method='GET'>";
    $formulaire .= "<label for='$titre'>$titre</label><select name='$req' onchange='this.form.submit()'>";
    while ($attr = pg_fetch_row($ptrQuery)) {
        $selected = ($selectedOption === $attr[0]) ? 'selected' : ''; // vérifier si la valeur actuelle est sélectionnée
        $formulaire .= "<option value='" . $attr[0] . "' $selected>" . $attr[0] . "</option>";
    }
    $formulaire .= "</select>";
    $formulaire .= "</form>";
    return $formulaire;
}
function getAllSportTypes() {
    $ptrDB = connexion();
    //La requete
    $query = "SELECT DISTINCT Sport_Type FROM Sport";
    /*retourne un objet ressource qui représente le résultat de la requête.
    Cet objet ressource peut ensuite être utilisé pour récupérer les données retournées par la requête */
    $result = pg_query($ptrDB, $query);
    $sportTypes = [];
    while ($row = pg_fetch_row($result)) {
        $sportTypes[] = $row[0];
    }
    pg_free_result($result);
    pg_close($ptrDB);
    return $sportTypes;
}
function getSportCatType() : array {
    $ptrDB = connexion();
    // La requete 
    $query = "SELECT Sport_Catégorie, Sport_Type FROM Sport";
    //Préparation de la requête
    pg_prepare($ptrDB, 'reqPrepSelectSportCatType', $query);
    $ptrQuery = pg_execute($ptrDB, 'reqPrepSelectSportCatType', array());
    $resu = array();
    if($ptrQuery){
        $resu[] = '<table border = "2">';
        $attributs = array("Catégorie","Type");
        foreach($attributs as $att){
            $resu[] .= "<th> $att </th>";
        }
        while($ligne = pg_fetch_assoc($ptrQuery)){
            $resu[] .=  "<tr>";
            foreach($ligne as $valeur){
                $resu[] .= "<td>";
                $resu[] .=  $valeur." ";
                $resu[] .= "</td>";
            }
            $resu[] .= "</tr>";
        }
        $resu[] .= "</table>";
    }
    pg_free_result($ptrQuery);
    pg_close($ptrDB);
    return $resu;

}
function getSportID(array $spCatTyp) {
    $ptrDB = connexion();
    $query = "SELECT Sport_Id FROM Sport WHERE Sport_Catégorie = $1 AND Sport_Type = $2";
    pg_prepare($ptrDB, 'reqgetSportID', $query);
    $result = pg_execute($ptrDB, 'reqgetSportID', [$spCatTyp['Sport_Catégorie'], $spCatTyp['Sport_Type']]);
    $row = pg_fetch_row($result);
    return $row[0];
}
?>