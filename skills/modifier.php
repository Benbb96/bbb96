<?php
if (isset($_GET['id']) and !empty($_GET['id'])) {
	$id = (int) $_GET['id'];
}

require_once('../connexion.php');

$reponse = $bdd->prepare('SELECT * FROM competence WHERE id = :id');
$reponse->execute(array('id' => $id));

if (!is_null($competence = $reponse->fetch()) && !$competence) {
	header('Location: index.php');
}
$reponse->closeCursor();
?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8" />
        <title>Modifier une compétence</title>
		<link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
		<link href="../css/style.css" rel="stylesheet"/>
    </head>

    <body>

		<?php
		$skills = true;
		include('../navbar.php');
		?>

		<div class="container">

			<div class="row">
				<div class="col-lg-12">
					<h1>
						Modifier la compétence n°<?php echo $competence['id']; ?>
					</h1>
				</div>
			</div>

			<form action="competence.php?id=<?php echo $competence['id']; ?>&success=true" method="post">
				<div class="row">
					<div class="col-sm-2">
						<label for="nom">Nom de la compétence</label>
					</div>
					<div class="col-sm-10">
						<input class="form-control" type="text" name="nom" id="nom" size="70" value="<?php echo $competence['nom']; ?>" maxlength="150">
					</div>
				</div>

				<div class="row">
					<div class="col-sm-2">
						<label for="dateDebut">Date de début</label>
					</div>
					<div class="col-sm-2">
						<input class="form-control" type="date" name="dateDebut" id="dateDebut" value="<?php echo $competence['date_debut']; ?>">
					</div>
					<div class="col-sm-offset-1 col-sm-2">
						<label for="dateFin">Date de fin</label>
					</div>
					<div class="col-sm-2">
						<input class="form-control" type="date" name="dateFin" id="dateFin" value="<?php echo $competence['date_fin']; ?>">
					</div>
					<div class="col-sm-3 checkbox-inline">
						<label><input type="checkbox" value="NULL" <?php if(is_null($competence['date_fin'])) echo 'checked'; ?>>En cours</label>
					</div>
				</div>

				<div class="row">
					<div class="col-sm-2">
						<label for="lieu">Lieu</label>
					</div>
					<div class="col-sm-10">
						<input class="form-control" type="text" name="lieu" id="lieu" size="50" maxlength="50" value="<?php echo $competence['lieu']; ?>">
					</div>
				</div>

				<div class="row">
					<div class="col-sm-2">
						<label for="besoin">Besoin de l'entreprise</label>
					</div>
					<div class="col-sm-10">
						<textarea class="form-control" name="besoin" id="besoin"><?php echo $competence['besoin']; ?></textarea>
					</div>
				</div>

				<div class="row">
					<div class="col-sm-2">
						<label for="travail">Travail global</label>
					</div>
					<div class="col-sm-10">
						<textarea class="form-control" name="travail" id="travail"><?php echo $competence['travail']; ?></textarea>
					</div>
				</div>

				<div class="row">
					<div class="col-sm-2">
						<label for="moyen">Moyens et contraintes</label>
					</div>
					<div class="col-sm-10">
						<textarea class="form-control" name="moyen" id="moyen"><?php echo $competence['moyen']; ?></textarea>
					</div>
				</div>

				<div class="row">
					<div class="col-sm-2">
						<label for="chronologie">Chronologiquement</label>
					</div>
					<div class="col-sm-10">
						<textarea class="form-control" name="chronologie" id="chronologie"><?php echo $competence['chronologie']; ?></textarea>
					</div>
				</div>

				<div class="row">
					<div class="col-sm-2">
						<label for="resultat">Résultats obtenus</label>
					</div>
					<div class="col-sm-10">
						<textarea class="form-control" name="resultat" id="resultat"><?php echo $competence['resultat']; ?></textarea>
					</div>
				</div>

				<div class="row">
					<div class="col-sm-2">
						<label for="avis">Ce que les autres ont dit de mes résultats</label>
					</div>
					<div class="col-sm-10">
						<textarea class="form-control" name="avis" id="avis"><?php echo $competence['avis']; ?></textarea>
					</div>
				</div>

				<div class="row">
					<div class="col-xs-6 text-right">
						<input type="hidden" name="id" value="<?php echo $competence['id']; ?>">
						<input class="btn btn-default" type="submit" value="Modifier">
					</div>
					<div class="col-xs-6">
						<a href="index.php"><button type="button" class="btn btn-default">Retour</button></a>
					</div>
				</div>
			</form>

		</div>

		<?php include('../footer.php'); ?>

	</body>
</html>