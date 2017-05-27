<?php
require_once('../../connexion.php');

require_once('verification.php');

if (isset($_POST['pseudo'])) {
    $ajout = $bdd->prepare('INSERT INTO joueur (pseudo) VALUES (:pseudo)');
    $ajout->execute(array('pseudo' => $_POST['pseudo']));
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <title>GameStoric</title>
    <link href="../../bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../../css/style.css" rel="stylesheet"/>
</head>

<body>

<?php
$gamestoric = true;
include('../../navbar.php');
?>

<div class="container">
    <h1>GameStoric</h1>
    <div class="row">

        <?php if (!$_SESSION['connected']) { ?>
        <div class="panel-danger col-lg-5">
            <div class="panel-heading">Veuillez saisir le mot de passe pour accéder à cette page.</div>
            <div class="panel-body">
                <form class="form-inline" action="index.php" method="post">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                        <input id="password" type="password" class="form-control" name="password"
                               placeholder="Mot de passe">
                    </div>
                    <button type="submit" class="btn btn-default">Ok</button>
                </form>
            </div>
        </div>
        <?php } else { ?>
        <div class="col-md-3">
            <ul class="nav nav-pills nav-stacked">
                <li><a href="index.php">Home</a></li>
                <li><a href="match.php">Match</a></li>
                <li class="active"><a href="joueur.php">Joueur</a></li>
                <li><a href="index.php?deco=true">Déconnexion</a></li>
            </ul>
        </div>
        <div class="col-md-9">
            <div class="row">
                <form class="panel-default form-inline" action="joueur.php" method="post">
                    <h4 class="input-group ">Ajouter un nouveau joueur :</h4>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-plus"></i></span>
                        <input id="pseudo" type="text" class="form-control" name="pseudo"
                               placeholder="Pseudo">
                    </div>
                    <button type="submit" class="btn btn-default">Créer</button>
                </form>
            </div>
            <table class="row table table-striped">
                <thead>
                <tr>
                    <th class="col-md-4">Pseudo</th>
                    <th class="col-md-4">Date de création</th>
                    <th class="col-md-4">Nombre de victoire</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $reponse = $bdd->query('SELECT * FROM joueur ORDER BY id');
                while ($joueur = $reponse->fetch()) { ?>
                <tr class="text-center">
                    <td class="col-md-4"><?php echo $joueur['pseudo']; ?></td>
                    <td class="col-md-4"><?php $date = new DateTime($joueur['creation_date']); echo $date->format('d/m/Y - H:i'); ?></td>
                    <td class="col-md-4">
                        <span class="badge">
                            <?php
                        $req = $bdd->prepare('SELECT count(*) as winner FROM game WHERE vainqueur = :id');
                        $req->execute(array('id' => $joueur['id']));
                        echo $req->fetch()['winner'];
                        ?>
                        </span>
                    </td>
                </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
        <?php } ?>

    </div>
</div>

<?php include('../../footer.php'); ?>

</body>
</html>