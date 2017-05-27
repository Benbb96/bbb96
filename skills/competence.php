<?php
if (isset($_GET['id']) and !empty($_GET['id'])) {
	$id = (int) $_GET['id'];
}

require_once('../connexion.php');

$success = false;

if (!empty($_POST)) {
	if ($_POST['dateFin'] == '') $_POST['dateFin'] = null;
	$requete = 'UPDATE competence SET nom = :nom, date_debut = :dateDebut, date_fin = :dateFin, lieu = :lieu, besoin = :besoin,
				travail = :travail, moyen = :moyen, chronologie = :chronologie, resultat = :resultat, avis = :avis
				WHERE id = :id';
	$req = $bdd->prepare($requete);
	$success = $req->execute($_POST);
}

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
        <title>Compétence n°<?php echo $competence['id']; ?></title>
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
				<strong>Succès : </strong>La compétence a bien été modifiée !
			</div>
			<?php } ?>

			<div class="row text-center">
				<div class="col-lg-12">
					<h1>
						Compétence Professionnelle n°<?php echo $competence['id']; ?> :
					</h1>
				</div>
			</div>

			<div class="row text-center">
				<!-- Traiter l'apostrophe -->
				<h2 class="col-lg-12">Être capable de <?php echo $competence['nom']; ?></h2>
				<div class="row sous-titre">
					<div class="col-lg-offset-1 col-lg-5">
						Exercée du <?php $date = new DateTime($competence['date_debut']); echo $date->format('d/m/Y') ?>
						<?php if (is_null($competence['date_fin'])) {
							echo "à Aujourd'hui";
						} else {
							$dateFin = new DateTime($competence['date_fin']);
							echo 'au ' . $dateFin->format('d/m/Y');
						}?>
					</div>
					<div class="col-lg-4 col-lg-offset-1">
						Lieu : <?php echo $competence['lieu']; ?>
					</div>
				</div>

			</div>

			<table class="table">
				<thead>
					<tr>
						<th class="border col-lg-6">
							<h2>Situation de départ</h2>
						</th>
						<th class="col-lg-6">
							<h2>Performances et résultats obtenus</h2>
						</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td class="border col-lg-6">
							<h3>Besoin de l'entreprise</h3>
							<div class="text-justify">
								<?php echo $competence['besoin']; ?>
							</div>

							<h3>Travail global</h3>
							<div class="text-justify">
								<?php echo $competence['travail']; ?>
							</div>

							<h3>Moyens et contraintes</h3>
							<div class="text-justify">
								<?php echo $competence['moyen']; ?>
							</div>
						</td>
						<td class="col-lg-6">
							<h3>Chronologiquement</h3>
							<div class="text-justify">
								<?php echo $competence['chronologie']; ?>
							</div>

							<h3>Résultats obtenus</h3>
							<div class="text-justify">
								<?php echo $competence['resultat']; ?>
							</div>

							<h3>Ce que les autres ont dit de mes résultats</h3>
							<div class="text-justify">
								<?php echo $competence['avis']; ?>
							</div>
						</td>
					</tr>
				</tbody>
			</table>

			<div class="row">
				<div class="col-lg-6 text-right">
					<a href="modifier.php?id=<?php echo $competence['id']; ?>">
						<button class="btn-default btn-lg">Modifier</button>
					</a>
				</div>
				<div class="col-lg-6 text-left">
					<button class="btn-default btn-lg" onclick="supprime(<?php echo $competence['id']; ?>)">Supprimer</button>
				</div>
			</div>

		</div>

		<?php include('../footer.php'); ?>

		<script>
			function supprime(id){
				if (confirm('Es-tu sûr de vouloir supprimer cette compétence ?')) {
					document.location.href="index.php?delete=" + id;
				}
			};
		</script>

	</body>
</html>