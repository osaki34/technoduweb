<?php
// Ceci est un Webservice. Il renvioe des données au format JSON

// Entête HTTP pour spécifier le type de contenu (JSON)
header('Content-Type: application/json');

// Cette fonction lit tous les messages depuis la base de données, et les renvoie
// au format JSON
function get_messages() {
    try {
    	// Connexion à la base de données (pensez à changer vos identifiants)
        $bdd = new PDO('mysql:host=venus;dbname=votrelogin', 'votrelogin', 'votremotdepasse');
    }
    catch (Exception $e) {
		// Entête HTTP pour spécifier le code de retour. 500 signifie "erreur interne du serveur"
		http_response_code(500);
		// On envoie l'erreur (qu'on récupère dans $e) au client, histoire qu'il ait des précisions sur pourquoi ça ne marche pas
		echo json_encode(array('Erreur' => $e->getMessage()));
		// Et on sort du programme, car on est dans un cas d'erreur
		exit;
    }

	// On prépare une structure de données pour stocker les messages qu'on enverra ensuite
    $data = Array("msgs" => Array ());    
    // Requête dans la base de données pour récupérer tous les messages
    $query = $bdd->query('SELECT * FROM msgs ORDER BY ID DESC');
    // On place tous les messages dans notre tableau
    while ($donnees = $query->fetch()) {
        $data['msgs'][] = Array('nom' => $donnees['nom'], 'msg' => $donnees['msg']);
    }
    return $data;
}    

// On appelle notre fonction (définie ci-dessus) pour obtenir tous les messages
$msg_data = get_messages();

// Entête HTTP pour spécifier le code de retour. 200 signifie "tout va bien" (c'est le code par défaut)
http_response_code(200);
// On encode les données en JSON et on les "affiche" (echo) sur la sortie standard, pour les envoyer au client
echo json_encode($msg_data);
?>
