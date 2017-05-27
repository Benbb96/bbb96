<?php
require_once('../../connexion.php');

require_once('verification.php');
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
                <li class="active"><a href="match.php">Match</a></li>
                <li><a href="joueur.php">Joueur</a></li>
                <li><a href="index.php?deco=true">Déconnexion</a></li>
            </ul>
        </div>
        <div class="col-md-9">
            <h2>Les derniers matchs</h2>
            <table class="row table table-striped">
                <thead>
                <tr>
                    <th class="col-md-2">Joueur 1</th>
                    <th class="col-md-2">Score</th>
                    <th class="col-md-2">Joueur 2</th>
                    <th class="col-md-2">Score</th>
                    <th class="col-md-2">Date</th>
                    <th class="col-md-2">Commentaire</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $reponse = $bdd->query('SELECT game.id_j1, j1.pseudo as "pseudo1", score_j1, game.id_j2, j2.pseudo as "pseudo2", score_j2, datetime, comment, game.id
                                        FROM game
                                        INNER JOIN joueur j1 ON j1.id = game.id_j1
                                        INNER JOIN joueur j2 ON j2.id = game.id_j2
                                        ORDER BY datetime DESC
                                        LIMIT 20');
                while ($match = $reponse->fetch()) { ?>
                    <tr class="text-center">
                        <td class="col-md-2"><?php echo $match['pseudo1']; ?></td>
                        <td class="col-md-2">
                            <span class="badge"><?php echo $match['score_j1']; ?></span>
                        </td>
                        <td class="col-md-2"><?php echo $match['pseudo2']; ?></td>
                        <td class="col-md-2">
                            <span class="badge"><?php echo $match['score_j2']; ?></span>
                        </td>
                        <td class="col-md-2"><?php $date = new DateTime($match['datetime']); echo $date->format('d/m/Y - H:i'); ?></td>
                        <td class="col-md-2"><?php echo $match['comment']; ?></td>
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