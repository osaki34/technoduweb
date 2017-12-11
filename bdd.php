<?php

// cette fonction vous connecte à la base de données et retourne
// un objet grâce auquel vous allez effectuer des requêtes SQL
function connexionbd() {

	// A MODIFIER : spécifiez votre login et votre mot de passe ici
	$host = "localhost";
	$username = "plant";
	$password = "plant";
	$dbname = $username;

	// chaîne de connexion pour PDO (ne pas modifier)
	$dsn = "mysql:host=$host;dbname=$dbname";

	// connexion au serveur de bases de données
	$bd = new PDO($dsn, $username, $password);
	
	return $bd;
}

// cette fonction effectue une requête SQL. On doit lui fournir
// l'objet base de données et la requête
function requete($bd, $req) {

	// appel de la méthode query() sur l'objet base de données :
	// la requête est traitée par le serveur et retourne un pointeur de résultat
	$resultat = $bd->query($req);

	// on demande à ce pointeur d'aller chercher toutes les données de résultat
	// d'un coup - on obtient un tableau de tableaux associatifs (un par ligne de la table)
	// Note : dans le cas d'une insertion, on ne récupère pas le résultat
	if ($resultat) {
		$tableau = $resultat->fetchAll(PDO::FETCH_ASSOC);	
		// on retourne ce tableau
		return $tableau;
	}
}

// crée la table qui stockera les relevés botaniques
function creation_table() {
	$maBd = connexionbd();
	$maRequeteCreation = "CREATE TABLE releves (id integer AUTO_INCREMENT, nom_plante varchar(50), lieu varchar(50), latitude float, longitude float, date_releve date, photo varchar(255), nom_collecteur varchar(50), prenom_collecteur varchar(50), commentaire text, PRIMARY KEY(id)) CHARACTER SET UTF8";
	$monResultat = requete($maBd, $maRequeteCreation);
}

// insère des données d'exemple dans la page
function insertion_exemples() {
	$maBd = connexionbd();
	$maRequeteInsertion = "INSERT INTO releves VALUES "
		. "(DEFAULT, 'Geranium nodosum', 'Montpellier centre', 43.61097, 3.87668, '2017-07-23', 'http://api.tela-botanica.org/img:000275387CRS.jpg', 'Martin', 'Pierre', 'Aplati par les passants'),"
		. "(DEFAULT, 'Pissenlit', '', 43.61097, 3.87668, '2011-05-01', 'http://api.tela-botanica.org/img:000276175CRS.jpg', 'Wayne', 'John', ''),"
		. "(DEFAULT, 'Hortensia', 'Bort-les-Orgues', 45.401, 2.4954, '2015-09-24', 'http://api.tela-botanica.org/img:000275925CRS.jpg', 'Martinez', 'Martine', 'Il faisait beau !'),"
		. "(DEFAULT, 'Ginkgo biloba', 'Montpellier centre', 43.60982, 3.87351, '2016-10-11', 'http://api.tela-botanica.org/img:000276006O.jpg', 'Tassier', 'Jean', 'En face de chez mon amie Martine'),"
		. "(DEFAULT, 'Chene vert', 'Mauguio, dans un champ', 43.61085, 4.02314, '1992-04-30', 'http://api.tela-botanica.org/img:000276001O.jpg', 'Passure', 'Alice', 'Je ne suis pas certaine du nom de la plante')"
	;
	$monResultat = requete($maBd, $maRequeteInsertion);
}

// vide la table de toutes ses données
function vidage_table() {
	$maBd = connexionbd();
	$maRequeteVidage = "TRUNCATE TABLE releves";
	$monResultat = requete($maBd, $maRequeteVidage);
}

?>

