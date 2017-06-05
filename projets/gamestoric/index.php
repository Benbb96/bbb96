<?php
require_once('../../connexion.php');

require_once('verification.php');

$success = false;
if (isset($_POST['score1'])) {
    if (!$s1 = intval($_POST['score1'])) $err1 = true;
}
if (isset($_POST['score2'])) {
    if (!$s2 = intval($_POST['score2'])) $err2 = true;
}
if (isset($_POST['j1']) && isset($_POST['j2']) && $_POST['j1'] != $_POST['j2']) {
    if (isset($s1) && isset($s2) && $s1 != $s2) {
        $ajout = $bdd->prepare('INSERT INTO game (id_j1, id_j2, score_j1, score_j2, vainqueur, comment) VALUES (:j1, :j2, :score1, :score2, :winner, :comment)');
        $ajout->execute(array(
            'j1' => $_POST['j1'],
            'j2' => $_POST['j2'],
            'score1' => $s1,
            'score2' => $s2,
            'winner' => $s1 > $s2 ? $_POST['j1'] : $_POST['j2'],
            'comment' => $_POST['comment']
        ));
        $success = true;
    } else {
        $err1 = true;
        $err2 = true;
    }
} else {
    $errJ = true;
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

        <div class="col-md-3">
            <ul class="nav nav-pills nav-stacked">
                <li class="active"><a href="index.php">Home</a></li>
                <li><a href="match.php">Match</a></li>
                <li><a href="joueur.php">Joueur</a></li>
                <li><a href="index.php?deco=true">Déconnexion</a></li>
            </ul>
        </div>
        <div class="col-md-9">

            <div class="row">
                <?php if (!$_SESSION['connected']) { ?>
                    <div class="panel-danger">
                        <div class="panel-heading">Veuillez saisir le mot de passe pour pouvoir ajouter des matchs.</div>
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
                <h2>Ajouter un nouveau match</h2>

                <?php if($success) { ?>
                    <div class="alert alert-success">
                        <strong>Ok : </strong>Le match a bien été créé !
                    </div>
                <?php } ?>

                <form action="index.php" method="post">
                    <div class="col-md-5 panel-info">
                        <div class="panel-heading">Joueur 1</div>
                        <div class="panel panel-body">
                            <div class="form-group <?php if (isset($errJ) && $errJ) echo "has-error"; ?>">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                    <select class="form-control" name="j1">
                                        <?php
                                        $req = $bdd->query("SELECT * FROM joueur ORDER BY pseudo");
                                        while ($j = $req->fetch()) { ?>
                                            <option value="<?php echo $j['id']; ?>"><?php echo $j['pseudo']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group <?php if (isset($err1) && $err1) echo "has-error"; ?>">
                                <input id="score1" type="number" class="form-control" name="score1" placeholder="Score du joueur 1" min="0">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2 text-center">
                        <h1>VS</h1>
                    </div>

                    <div class="col-md-5 panel-warning">
                        <div class="panel-heading">Joueur 2</div>
                        <div class="panel panel-body">
                            <div class="form-group  <?php if (isset($errJ) && $errJ) echo "has-error"; ?>">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                    <select class="form-control" name="j2">
                                        <?php
                                        $req = $bdd->query("SELECT * FROM joueur ORDER BY pseudo");
                                        while ($j = $req->fetch()) { ?>
                                            <option value="<?php echo $j['id']; ?>"><?php echo $j['pseudo']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group  <?php if (isset($err2) && $err2) echo "has-error"; ?>">
                                <input id="score2" type="number" class="form-control" name="score2" placeholder="Score du joueur 2" min="0">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <input id="comment" type="text" class="form-control" name="comment" placeholder="Commentaire (facultatif)">
                    </div>
                    <button class="btn btn-block btn-primary">Valider</button>
                </form>
            </div>
            <?php } ?>
        </div>

    </div>
</div>

<?php include('../../footer.php'); ?>

</body>
</html>