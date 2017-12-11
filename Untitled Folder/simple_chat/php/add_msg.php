<?php
//print_r($_REQUEST);

try {
    $bdd = new PDO('mysql:host=venus;dbname=votrelogin', 'votrelogin', 'votremotdepasse');
}
catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}


// ajoute un message dans la base de données
$req = $bdd->prepare('INSERT INTO msgs(nom, msg) VALUES(:nom, :msg)');
$req->execute(array(
	'nom' => $_REQUEST['nom'],
	'msg' => $_REQUEST['msg'],
));

// redirige vers la page principale
header('Location: ../index.php');

?>
