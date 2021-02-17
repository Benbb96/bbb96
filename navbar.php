<nav class="navbar navbar-inverse">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="/index.php">BBB96</a>
        </div>
        <ul class="nav navbar-nav">
            <li <?php if (isset($accueil)) echo 'class="active"'; ?>>
                <a href="/index.php">Accueil</a>
            </li>
            <li>
                <a href="/CV/index.html">Voir mon CV</a>
            </li>
            <li <?php if (isset($oneShot)) echo 'class="active"'; ?>>
                <a href="/one-shot.php">One Shot</a>
            </li>
        </ul>
    </div>
</nav>