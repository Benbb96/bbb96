<?php
require_once('connexion.php');
?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8" />
        <title>Page réservé</title>
		<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
		<link href="css/style.css" rel="stylesheet"/>
    </head>

    <body>
		<?php
		$accueil = true;
		include('navbar.php');
		include('header.php');
        ?>

		<!--
		<div align="center">
			<form action ="connexion.php">
				<div>
					<label for="pseudo">Pseudo</label>
					<input type="text" name="pseudo" id="pseudo">
				</div>
				<div>
					<label for="mdp">Mot de passe :</label>
					<input type="text" name="mdp" id="mdp">
				</div>
				<div>
					<input type="submit" value"valider">
				</div>
			</form>
		</div>
		-->

		<?php include('footer.php'); ?>

    </body>
</html>