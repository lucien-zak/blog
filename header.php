<?php
?>

<header>
    <nav class="navbar">
        <div class="container-left">
            <a href="/blog/index.php"><?php echo $GLOBALS['name'] ?></a>
        </div>
        <div class="container-right">
            <div class="box">
                <a href="/blog/index.php">Accueil</a>
            </div>
            <div class="dropdown">
                <a class="dropbtn">Articles</a>
                <div class="dropdown-content">
                    <div>
                        <h3>Les Catégories</h3>
                        <?php
                        $req = "SELECT * FROM `categories`";
                        $stmt = $GLOBALS['PDO']->query($req);
                        $list_articles = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        for ($i = 0; $i < count($list_articles); $i++) {
                        ?>
                            <a href="/blog/article/articles.php?categorie=<?php echo $list_articles[$i]['nom'] ?>"><?php echo $list_articles[$i]['nom'] ?></a> <?php } ?>
                            <a href="/blog/article/articles.php?categorie=tout">Afficher toute les catégories</a>
                    </div>
                    <div>
                        <h3>Les derniers articles</h3>
                        <?php $req = "SELECT `titre`, `id` FROM `articles` ORDER BY `date` DESC LIMIT 4";
                        $stmt = $GLOBALS['PDO']->query($req);
                        $list_articles = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        for ($i = 0; $i < count($list_articles); $i++ ) { ?>
                        <a href="/blog/article/article.php?id=<?php echo $list_articles[$i]['id'] ?>"><?php echo $list_articles[$i]['titre']; ?></a>
                        <?php }?>
                        <a href="/blog/article/articles.php?categorie=tout">Afficher tout les articles</a>
                    </div>
                </div> 
            </div>
            <?php if($_SESSION) {?>
                <div class="dropdown">
                    <a class="dropbtn"> <?php echo $_SESSION['login'] ?> </a>
                    <div class="dropdown-content" id="moyen">
                        <div>
                            <?php  if($_SESSION['perms'] == 1337 || $_SESSION['perms'] == 42) {
                                echo '<a href="/blog/utilisateur/admin.php">Admin</a>';
                                echo '<a href="/blog/article/creer-article.php">Créer un article</a>';
                            } ?>
                            <a href="/blog/utilisateur/profil.php">Profil</a>
                            <a href="/blog/disconnect.php">Se déconnecter</a>
                        </div>
                    </div>
                </div>
            <?php } else {
                echo ('<div class="box">
                    <a href="/blog/utilisateur/connexion.php">Connexion</a>
                </div>
                <div class="box">
                    <a href="/blog/utilisateur/inscription.php">Inscription</a>
                </div>');
            } ?>
        </div>
    </nav>
</header>