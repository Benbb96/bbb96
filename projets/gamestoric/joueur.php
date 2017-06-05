<?php
require_once('../../connexion.php');

require_once('verification.php');

if (isset($_POST['pseudo'])) {
    $ajout = $bdd->prepare('INSERT INTO joueur (pseudo) VALUES (:pseudo)');
    $ajout->execute(array('pseudo' => $_POST['pseudo']));
    $ajout->closeCursor();
}

if (isset($_GET['id'])) {
    $req = $bdd->prepare('SELECT * FROM joueur WHERE id = :id');
    $req->execute(array('id' => $_GET['id']));
    $profilJoueur = $req->fetch();
    if (!$profilJoueur) header('Location: joueur.php');
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <title><?php if (!isset($profilJoueur)) echo "Joueurs"; else echo "Joueur - " . $profilJoueur['pseudo']; ?></title>
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

        <div class="col-md-3">
            <ul class="nav nav-pills nav-stacked">
                <li><a href="index.php">Home</a></li>
                <li><a href="match.php">Match</a></li>
                <li class="active"><a href="joueur.php">Joueur</a></li>
                <li><a href="index.php?deco=true">Déconnexion</a></li>
            </ul>
        </div>
        <?php if (isset($profilJoueur)) { ?>
        <div class="col-md-9">
            <div class="row">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h2><?php echo $profilJoueur['pseudo']; ?></h2>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-offset-1 col-sm-3 panel panel-info text-center">
                                <div class="panel-heading">Nombre de match joué</div>
                                <div class="panel-body h1 text-info"><?php
                                    $nbMatchs = $bdd->prepare('SELECT count(*) FROM game WHERE id_j1 = :id OR id_j2 = :id');
                                    $nbMatchs->execute(array('id' => $profilJoueur['id']));
                                    echo $nbMatchs->fetch()[0];
                                    ?>
                                </div>
                            </div>
                            <div class="col-sm-offset-1 col-sm-3 panel panel-danger text-center">
                                <div class="panel-heading">Nombre de match gagné</div>
                                <div class="panel-body h1 text-danger"><?php
                                    $nbMatchsGagnes = $bdd->prepare('SELECT count(*) FROM game WHERE vainqueur = :id');
                                    $nbMatchsGagnes->execute(array('id' => $profilJoueur['id']));
                                    echo $nbMatchsGagnes->fetch()[0];
                                    ?>
                                </div>
                            </div>
                            <div class="col-sm-offset-1 col-sm-3 panel panel-success text-center">
                                <div class="panel-heading">Nombre de but moyen par match</div>
                                <div class="panel-body h1 text-success"><?php
                                    $moyButs = $bdd->prepare('SELECT avg(case id_j1 when :id then score_j1 else score_j2 end) FROM game WHERE id_j1 = :id OR id_j2 = :id');
                                    $moyButs->execute(array('id' => $profilJoueur['id']));
                                    $avg = $moyButs->fetch()[0];
                                    echo is_null($avg) ? '0' : $avg;
                                    ?>
                                </div>
                            </div>
                        </div>
                        <h2>Derniers matchs</h2>
                        <div class="row">
                            <table class="table table-striped">
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
                                $reponse = $bdd->prepare('SELECT game.id_j1, j1.pseudo as "pseudo1", score_j1, game.id_j2, j2.pseudo as "pseudo2", score_j2, datetime, comment, game.id
                                        FROM game
                                        INNER JOIN joueur j1 ON j1.id = game.id_j1
                                        INNER JOIN joueur j2 ON j2.id = game.id_j2
                                        WHERE id_j1 = :id OR id_j2 = :id
                                        ORDER BY datetime DESC
                                        LIMIT 20');
                                $reponse->execute(array('id' => $profilJoueur['id']));
                                while ($match = $reponse->fetch()) { ?>
                                    <tr class="text-center">
                                        <td class="col-md-2"><a href="joueur.php?id=<?php echo $match['id_j1']; ?>"><?php echo $match['pseudo1']; ?></a></td>
                                        <td class="col-md-2">
                                            <span class="badge"><?php echo $match['score_j1']; ?></span>
                                        </td>
                                        <td class="col-md-2"><a href="joueur.php?id=<?php echo $match['id_j2']; ?>"><?php echo $match['pseudo2']; ?></a></td>
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
                    </div>
                    <div class="panel-footer text-right">
                        <span class="text-primary">Joueur créé le <?php $date = new DateTime($profilJoueur['creation_date']); echo $date->format('d/m/Y à H:i'); ?></span>
                    </div>
                </div>
            </div>
        </div>
        <?php } else { ?>
        <div class="col-md-9">
            <?php if ($_SESSION['connected']) { ?>
            <div class="row">
                <form class="panel-default form-inline" action="joueur.php" method="post">
                    <div class="input-group-btn">
                        <input id="pseudo" type="text" class="form-control" name="pseudo" placeholder="Ajouter un joueur">
                        <button class="btn btn-default" type="submit">
                            <i class="glyphicon glyphicon-plus"></i>
                        </button>
                    </div>
                </form>
            </div>
            <?php } ?>
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
                    <td class="col-md-4"><a href="joueur.php?id=<?php echo $joueur['id']; ?>"><?php echo $joueur['pseudo']; ?></a></td>
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