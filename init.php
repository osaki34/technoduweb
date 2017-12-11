<?php

try {
    $bdd = new PDO('mysql:host=localhost;dbname=plant', 'votrelogin', 'votremotdepasse');
}
catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

// création de la table
$sql = 'CREATE TABLE msgs (ID int NOT NULL AUTO_INCREMENT, nom varchar(255), msg varchar(255), PRIMARY KEY (ID))';
$query = $bdd->query($sql);
var_dump($query);

// décommenter ceci pour vider la table
//$sql = 'TRUNCATE msgs';
//$query = $bdd->query($sql);
//var_dump($query);

?>