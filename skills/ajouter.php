<?php
require_once('../connexion.php');

$success = false;

if (!empty($_POST)) {
	if ($_POST['dateFin'] == '') $_POST['dateFin'] = null;
	$requete = 'INSERT INTO competence (nom, date_debut, date_fin, lieu, besoin, travail, moyen, chronologie, resultat, avis)
				VALUES (:nom, :dateDebut, :dateFin, :lieu, :besoin, :travail, :moyen, :chronologie, :resultat, :avis)';
	$req = $bdd->prepare($requete);
	$success = $req->execute($_POST);
	$req = $bdd->query('SELECT id FROM competence ORDER BY id desc LIMIT 1');
	$id = (int) $req->fetch()['id'];
}

/*if (isset($_POST['nom']) and !empty($_POST['nom'])) {
	var_dump($_POST);
}*/
?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8" />
        <title>Ajouter une compétence</title>
		<link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
		<link href="../css/style.css" rel="stylesheet"/>
    </head>

    <body>

		<?php
		$skills = true;
		include('../navbar.php');
		?>

		<div class="container">

			<?php if($success) { ?>
				<div class="alert alert-success">
					<strong>Succès : </strong>La compétence a bien été ajoutée ! Voir <a href="competence.php?id=<?php echo $id; ?>">la compétence</a>.
				</div>
			<?php } ?>

			<div class="row">
				<div class="col-lg-12">
					<h1>
						Ajouter une nouvelle compétence
					</h1>
				</div>
			</div>

			<form action="ajouter.php" method="post">
				<div class="row">
					<div class="col-sm-2">
						<label for="nom">Nom de la compétence</label>
					</div>
					<div class="col-sm-10">
						<input class="form-control" type="text" name="nom" id="nom" size="70" maxlength="150" placeholder="Exemple : Développer un site en PHP">
					</div>
				</div>

				<div class="row">
					<div class="col-sm-2">
						<label for="dateDebut">Date de début</label>
					</div>
					<div class="col-sm-2">
						<input class="form-control" type="date" name="dateDebut" id="dateDebut" value="<?php echo date('Y-m-d'); ?>">
					</div>
					<div class="col-sm-offset-1 col-sm-2">
						<label for="dateFin">Date de fin</label>
					</div>
					<div class="col-sm-2">
						<input class="form-control" type="date" name="dateFin" id="dateFin" value="<?php echo date('Y-m-d'); ?>">
					</div>
					<div class="col-sm-3 checkbox-inline">
						<label><input type="checkbox" value="NULL">En cours</label>
					</div>
				</div>

				<div class="row">
					<div class="col-sm-2">
						<label for="lieu">Lieu</label>
					</div>
					<div class="col-sm-10">
						<input class="form-control" type="text" name="lieu" id="lieu" size="50" maxlength="50" placeholder="Nom de l'entreprise, de l'école ou si c'est perso">
					</div>
				</div>

				<div class="row">
					<div class="col-sm-2">
						<label for="besoin">Besoin de l'entreprise</label>
					</div>
					<div class="col-sm-10">
						<textarea class="form-control" name="besoin" id="besoin" placeholder="Besoin interne ou externe, du client,…"></textarea>
					</div>
				</div>

				<div class="row">
					<div class="col-sm-2">
						<label for="travail">Travail global</label>
					</div>
					<div class="col-sm-10">
						<textarea class="form-control" name="travail" id="travail" placeholder="Ce que j’ai accompli (tout ou partie du besoin de l’entreprise"></textarea>
					</div>
				</div>

				<div class="row">
					<div class="col-sm-2">
						<label for="moyen">Moyens et contraintes</label>
					</div>
					<div class="col-sm-10">
						<textarea class="form-control" name="moyen" id="moyen" placeholder="- Matériels = machine, accès à internet, dossier
- Informations
- Aides = tuteur, équipe
- Délai
- Budget
- Collaborateur"></textarea>
					</div>
				</div>

				<div class="row">
					<div class="col-sm-2">
						<label for="chronologie">Chronologiquement</label>
					</div>
					<div class="col-sm-10">
						<textarea class="form-control" name="chronologie" id="chronologie" placeholder="Tâches que j’ai successivement exécutées"></textarea>
					</div>
				</div>

				<div class="row">
					<div class="col-sm-2">
						<label for="resultat">Résultats obtenus</label>
					</div>
					<div class="col-sm-10">
						<textarea class="form-control" name="resultat" id="resultat" placeholder="D’après moi = par rapport à ce qui m’a été demandé"></textarea>
					</div>
				</div>

				<div class="row">
					<div class="col-sm-2">
						<label for="avis">Ce que les autres ont dit de mes résultats</label>
					</div>
					<div class="col-sm-10">
						<textarea class="form-control" name="avis" id="avis" placeholder="Chef, tuteur, client, utilisateurs internes ou extérieur à l’entreprise"></textarea>
					</div>
				</div>

				<div class="row">
					<div class="col-xs-6 text-right">
						<input class="btn btn-default" type="submit" value="Ajouter">
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