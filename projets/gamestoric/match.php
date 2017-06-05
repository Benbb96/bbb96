<?php
require_once('../../connexion.php');

require_once('verification.php');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <title>Matchs</title>
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
                if (isset($_GET['page'])) {
                    $page = intval($_GET['page']);
                } else {
                    $page = 1;
                }
                $reponse = $bdd->prepare('SELECT game.id_j1, j1.pseudo as "pseudo1", score_j1, game.id_j2, j2.pseudo as "pseudo2", score_j2, datetime, comment, game.id
                                        FROM game
                                        INNER JOIN joueur j1 ON j1.id = game.id_j1
                                        INNER JOIN joueur j2 ON j2.id = game.id_j2
                                        ORDER BY datetime DESC
                                        LIMIT :limit OFFSET :offset;');
                $limit = 10;
                $offset = $page * $limit - $limit;
                $reponse->bindParam(':limit', $limit, PDO::PARAM_INT);
                $reponse->bindParam(':offset', $offset, PDO::PARAM_INT);
                $reponse->execute();
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
            <div class="row text-center">
                <ul class="pagination">
                    <?php
                    $req = $bdd->query('SELECT count(*) FROM game');
                    $req->execute();
                    $totalMatch= $req->fetch()[0];
                    // arrondi au supérieur du nombre de match divisé par la limit
                    $nbPage = ceil($totalMatch / $limit);
                    ?>
                    <li <?php if($page == 1) echo 'class="disabled"'; ?>><a href="match.php?page=<?php echo $page -1; ?>">&laquo;</a></li>
                    <?php
                    $i = 1;
                    while ($i <= $nbPage) { ?>
                    <li <?php if($page == $i) echo 'class="active"'; ?>><a href="match.php?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                    <?php
                    $i++;
                    }
                    ?>
                    <li <?php if($page == $nbPage) echo 'class="disabled"'; ?>><a href="match.php?page=<?php echo $page +1; ?>">&raquo;</a></li>
                </ul>
            </div>
        </div>

    </div>
</div>

<?php include('../../footer.php'); ?>

</body>
</html>