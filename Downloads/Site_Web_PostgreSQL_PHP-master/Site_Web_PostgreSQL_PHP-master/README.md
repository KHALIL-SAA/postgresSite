# Athlete_Table
## A propos du projet.
Ce projet consiste a crée un site web où on utilise les tables de notre base de données de type PostgreSQL qui s'appelle 'Palmarès d’athlétisme' qui contient trois tables, une table athlète deuxième table sport et une dernière table qui renferme les deux clés primaire des deux premières tables.
### Table 'Athlète'
La table athlète se caractérise par les attributs suivants : 
**Athlète_Id** (un entier qui incrémente automatiquement) (c’est la clé primaire),Athlète_Nom (chaine de caractères),Athlète_Prénom (chaine de caractères),Athlète_Nationalité (chaine de caractères),Athlète_Sexe(chaine de caractères, soit Homme ou Femme).
### Table 'Sport'
La table Sport se caractérise par les attributs suivants :
**Sport_Id** (un entier qui incrémente automatiquement) (c’est la clé primaire), Sport_Catégorie (chaine de caractères), Sport_Type(chaine de caractères).
### Table 'Pratique'
La table Pratique se caractérise par les attributs suivants :
Athlète_Id et Sport_Id qui sont les deux clés primaire des deux premières tables
