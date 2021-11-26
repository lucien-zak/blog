<footer>
    <div id="top">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="#ffffff" fill-opacity="1" d="M0,224L48,213.3C96,203,192,181,288,192C384,203,480,245,576,256C672,267,768,245,864,213.3C960,181,1056,139,1152,128C1248,117,1344,139,1392,149.3L1440,160L1440,0L1392,0C1344,0,1248,0,1152,0C1056,0,960,0,864,0C768,0,672,0,576,0C480,0,384,0,288,0C192,0,96,0,48,0L0,0Z"></path></svg>
    </div>
    <div id="bottom">
        <div class="container">
            <h2><?php echo $GLOBALS['name'] ?></h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt.</p>
            <ul>
                <li class="list-inline-item"><a href="#" target="_blank" title="twitter"><i class="fa fa-twitter"></i></a></li>
                <li class="list-inline-item"><a href="#" target="_blank" title="facebook"><i class="fa fa-facebook"></i></a></li>
                <li class="list-inline-item"><a href="#" target="_blank" title="instagram"><i class="fa fa-instagram"></i></a></li>
            </ul>
        </div>
        <div class="container">
            <h2>Onglet</h2>
            <ul>
                <?php
                    if (!$_SESSION) {
                        echo ('
                            <li><a href="login.php">Connexion</a></li>
                            <li><a href="register.php">Inscription</a></li>
                        ');
                    } else {
                        echo ('
                            <a><li>Voir les articles</li></a>
                            <a><li>Écrire un article</li></a>
                            <a><li>Profil</li></a>
                        ');
                    }
                ?>

            </ul>
        </div>
        <div class="container">
            <h2>Catégories</h2>
            <ul>
                <?php
                // Boucle sur les catégories des articles
                // foreach($res as $key => $value) {
                //     echo '<li>$value</li>';
                // }
                ?>
            </ul>
        </div>
        <div class="container">
            <h2>NEWSLETTER</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. At itaque temporibus.</p>
        </div>
    </div>
</footer>