<?php
try {
	// Connexion à la base de données (pensez à changer vos identifiants)
    $bdd = new PDO('mysql:host=venus;dbname=votrelogin', 'votrelogin', 'votremotdepasse');
}
catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

// Création de la table "msgs" dans la base de données (la première fois seulement)
$sql = 'CREATE TABLE msgs
        (
         ID int NOT NULL AUTO_INCREMENT,
         nom varchar(255),
         msg varchar(255),
         PRIMARY KEY (ID)
         )';

// Requête de création de la table
$query = $bdd->query($sql);
// Debug : affichage du résultat de la requête
var_dump($query);

// Vidage de la table (peut servir par la suite pour réinitialiser sans détruire et recréer la table)
$sql = 'TRUNCATE msgs';
$query = $bdd->query($sql);
// Debug : affichage du résultat de la requête
var_dump($query);

?>
