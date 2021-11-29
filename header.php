<?php
?>

<header>
    <nav class="navbar">
        <div class="container-left">
            <a href="index.php"><?php echo $GLOBALS['name'] ?></a>
        </div>
        <div class="container-right">
            <div class="box">
                <a href="#">Accueil</a>
            </div>
            <div class="dropdown">
                <a class="dropbtn">Articles</a>
                <div class="dropdown-content">
                    <div>
                        <h3>Les Catégories</h3>
                        <a href="#">Voir tous les articles</a>
                        <a href="#">Voir tous les articles</a>
                        <a href="#">Voir tous les articles</a>
                        <a href="#">Voir tous les articles</a>
                        <a href="#">Voir tous les articles</a>
                    </div>
                    <div>
                        <h3>Les derniers articles</h3>
                        <a href="#">Voir tous les articles</a>
                        <a href="#">Voir tous les articles</a>
                        <a href="#">Voir tous les articles</a>
                        <a href="#">Voir tous les articles</a>
                        <a href="#">Voir tous les articles</a>
                    </div>
                </div>
            </div>
            <?php if($_SESSION) {
                if($_SESSION['perms'] == 1337 || $_SESSION['perms'] == 42) {
                    echo ('
                        <div class="box">
                            <a href="admin.php">Admin</a>
                        </div>
                    ');
                } ?>
            <div class="box">
                <a href="#">Profil</a>
            </div>
            <div class="box">
                <a href="">Se déconnecter</a>
            </div>
            <?php } else { ?>
            <div class="box">
                <a href="./utilisateur/connexion.php">Connexion</a>
            </div>
            <div class="box">
                <a href="./utilisateur/inscription.php">Inscription</a>
            </div>
            <?php } ?>
        </div>
    </nav>
</header>
