<nav class="navbar navbar-inverse">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="<?php echo __LOCAL_PATH__; ?>/index.php">BBB96</a>
        </div>
        <ul class="nav navbar-nav">
            <li <?php if (isset($accueil)) { ?>class="active"<?php } ?>>
                <a href="<?php echo __LOCAL_PATH__; ?>/index.php">Accueil</a>
            </li>
            <li <?php if (isset($cv)) { ?>class="active"<?php } ?>>
                <a href="<?php echo __LOCAL_PATH__; ?>/CV/index.html">Voir mon CV</a>
            </li>
            <li <?php if (isset($skills)) { ?>class="active"<?php } ?>>
                <a href="<?php echo __LOCAL_PATH__; ?>/skills">Mes Compétences</a>
            </li>
            <li <?php if (isset($oneShot)) { ?>class="active"<?php } ?>>
                <a href="<?php echo __LOCAL_PATH__; ?>/projets/one-shot.php">One Shot</a>
            </li>
            <li <?php if (isset($gamestoric)) { ?>class="active"<?php } ?>>
                <a href="<?php echo __LOCAL_PATH__; ?>/projets/gamestoric/index.php">GameStoric</a>
            </li>
        </ul>
    </div>
</nav>