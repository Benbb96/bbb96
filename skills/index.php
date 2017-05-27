<?php
require_once('../connexion.php');

//Si une compétence est passé en paramètre pour être supprimée
if (isset($_GET['delete']) and !empty($_GET['delete'])) {
    $id = (int) $_GET['delete'];
    $query = $bdd->prepare('DELETE FROM competence WHERE id = :id');
    $query->execute(array('id' => $id));
    $query->closeCursor();
}
?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8" />
        <title>Compétences</title>
		<link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
		<link href="../css/style.css" rel="stylesheet"/>
    </head>

    <body>

		<?php
		$skills = true;
		include('../navbar.php');
		?>
		<h1>
			Liste de mes compétences
		</h1>

		<table class="table">
			<thead>
				<tr>
					<th class="col-lg-1">ID</th>
					<th class="col-lg-5">Intitulé</th>
					<th class="col-lg-2">Lieu</th>
					<th class="col-lg-2">Date début</th>
					<th class="col-lg-2">Actions</th>
				</tr>
			</thead>
			<tbody>
				<?php

				$reponse = $bdd->query('SELECT * FROM competence ORDER BY id');
				$i = 1;
				// On affiche chaque entrée une à une
				while ($competence = $reponse->fetch())
				{
				?>
				<tr>
					<td  class="col-lg-1 text-center"><?php echo $i; ?></td>
					<td class="col-lg-5">
						<a href="competence.php?id=<?php echo $competence['id']; ?>">
							<?php echo $competence['nom']; ?>
						</a>
					</td>
					<td class="col-lg-2 text-center"><?php echo $competence['lieu']; ?></td>
					<td class="col-lg-2 text-center"><?php $date = new DateTime($competence['date_debut']); echo $date->format('d/m/Y'); ?></td>
					<td class="col-lg-2 text-center">
                        <a href="modifier.php?id=<?php echo $competence['id']; ?>">
						    <button class="btn-block">
								Modifier
						    </button>
                        </a>
						<button type="button" class="btn-block btn-danger" onclick="supprime(<?php echo $competence['id']; ?>)">Supprimer</button>
					</td>
				</tr>
				<?php $i++;
				}

				$reponse->closeCursor(); // Termine le traitement de la requête
				?>
			</tbody>
		</table>

		<?php if ($i == 0) echo "<h4 class='well text-center'>Aucune compétence à afficher.</h4>"; ?>

		<div class="text-center">
			<button class="btn-lg"><a href="ajouter.php">Ajouter une nouvelle compétence</a></button>
		</div>

		<?php include('../footer.php'); ?>

	</body>

    <script>
        function supprime(id){
            if (confirm('Es-tu sûr de vouloir supprimer cette compétence ?')) {
                document.location.href="index.php?delete=" + id;
            }
        };
    </script>

</html>