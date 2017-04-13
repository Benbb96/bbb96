<?php

// Crée la connexion à la bdd en fonction de si on est sur le local ou sur le site free.fr

if( file_exists("C:/Users/Ben") ) {
	define("__LOCAL_PATH__", "http://localhost/bbb");
	$host = 'localhost';
	$dbname = 'bbb';
	$pseudo = 'root';
	$mdp = '';
} else {
	define("__LOCAL_PATH__", "");
	$host = 'sql.free.fr';
	$dbname = 'bbb96';
	$pseudo = 'bbb96';
	$mdp = 'bbb1996';
}

function Connect_db($host, $dbname, $pseudo, $mdp){
	try {
		$bdd = new PDO('mysql:host=' . $host . ';dbname=' . $dbname . ';charset=utf8',
			$pseudo,
			$mdp,
			array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
		return $bdd;
	} catch (Exception $e) {
		die('Erreur : '.$e->getMessage());
	}
}

$bdd = Connect_db($host, $dbname, $pseudo, $mdp); //connexion à la BDD