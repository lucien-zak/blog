<footer>
    <div id="top">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="#ffffff" fill-opacity="1" d="M0,224L48,213.3C96,203,192,181,288,192C384,203,480,245,576,256C672,267,768,245,864,213.3C960,181,1056,139,1152,128C1248,117,1344,139,1392,149.3L1440,160L1440,0L1392,0C1344,0,1248,0,1152,0C1056,0,960,0,864,0C768,0,672,0,576,0C480,0,384,0,288,0C192,0,96,0,48,0L0,0Z"></path></svg>
    </div>
    <div id="bottom">
        <div class="container">
            <h2><?php echo $GLOBALS['name'] ?></h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt.</p>
            <ul id="icons">
                <li id="icon" class="list-inline-item"><a href="#" target="_blank" title="twitter"><i class="fa fa-twitter"></i></a></li>
                <li id="icon" class="list-inline-item"><a href="#" target="_blank" title="facebook"><i class="fa fa-facebook"></i></a></li>
                <li id="icon" class="list-inline-item"><a href="#" target="_blank" title="instagram"><i class="fa fa-instagram"></i></a></li>
            </ul>
        </div>
        <div class="container">
            <h2>Onglet</h2>
            <ul>
                <?php
                    if (!$_SESSION) {
                        echo ('
                            <li><a href="/blog/utilisateur/connexion.php">Connexion</a></li>
                            <li><a href="/blog/utilisateur/inscription.php">Inscription</a></li>
                        ');
                    } else {
                        echo ('
                            <a href="/blog/article/articles.php?categorie=tout"><li>Voir les articles</li></a>
                            <a href="/blog/utilisateur/profil.php"><li>Profil</li></a>'
                        ); 
                        if ($_SESSION['perms'] == 1337 || $_SESSION['perms'] == 42) {
                            echo '<a href="/blog/utilisateur/admin.php">Admin</a>';
                            echo '<a href="/blog/article/creer-article.php"><li>Écrire un article</li></a>';
                        }
                    }
                ?>

            </ul>
        </div>
        <div class="container">
            <h2>Catégories</h2>
            <ul>
            <?php
                $req = "SELECT * FROM `categories`";
                $stmt = $GLOBALS['PDO']->query($req);
                $list_articles = $stmt->fetchAll(PDO::FETCH_ASSOC);
                for ($i = 0; $i < count($list_articles); $i++) { ?>
                    <a href="/blog/article/articles.php?categorie=<?php echo $list_articles[$i]['nom'] ?>"><?php echo $list_articles[$i]['nom'] ?></a> <?php 
                } ?>
                <br><a href="/blog/article/articles.php?categorie=tout">Afficher toute les catégories</a>
            </ul>
        </div>
        <div class="container">
            <h2>NEWSLETTER</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. At itaque temporibus.</p>
        </div>
    </div>
</footer>