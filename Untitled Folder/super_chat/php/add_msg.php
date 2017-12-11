<?php
// Ceci est un Webservice. Il renvioe des données au format JSON

// Entête HTTP pour spécifier le type de contenu (JSON)
header('Content-Type: application/json');

try {
    $bdd = new PDO('mysql:host=venus;dbname=votrelogin', 'votrelogin', 'votremotdepasse');
    // Connexion à la base de données (pensez à changer vos identifiants)
}
catch (Exception $e) {
	// Entête HTTP pour spécifier le code de retour. 500 signifie "erreur interne du serveur"
	http_response_code(500);
	// On envoie l'erreur (qu'on récupère dans $e) au client, histoire qu'il ait des précisions sur pourquoi ça ne marche pas
	echo json_encode(array('Erreur' => $e->getMessage()));
	// Et on sort du programme, car on est dans un cas d'erreur
	exit;
}

// Debug : affichage des données envoyées par le client (nom d'auteur et message)
// print_r($_REQUEST);

// On prépare une requête d'insertion, pour ajouter le message reçu à la base de données
$req = $bdd->prepare('INSERT INTO msgs(nom, msg) VALUES(:nom, :msg)');
// ...et on l'exécute en injectant les valeurs envoyées par le client
$ok = $req->execute(array(
	'nom' => $_REQUEST['nom'],
	'msg' => $_REQUEST['msg'],
));

// Si la requête d'insertion a fonctionné
if ($ok) {
	// Entête code de succès
	http_response_code(200);
	// On renvoie "true", ça ne sert pas à grand chose mais tant qu'à faire...
	echo json_encode($ok);
} else { // sinon, si la requête d'insertion a raté
	// Entête code d'erreur
	http_response_code(500);
	// On envoie une erreur explicite
	echo json_encode(array('Erreur' => 'La requête a échoué'));
}

?>
