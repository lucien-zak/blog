<?php
require('../fonctions.php');

if(($_SESSION['perms'] != 42) && ($_SESSION['perms'] != 1337)) {
    header('Location: /blog/index.php');
} else {
    if (isset($_POST['return'])) {
        header('Location: /blog/utilisateur/admin.php');
    } elseif (isset($_POST['delete'])) {
        $delete = "DELETE FROM `articles` WHERE id='". $_POST['delete'] ."'";
        $res = $GLOBALS['PDO']->exec($delete);
        header('refresh:0');
    }
?>

    <!--    HEAD   -->
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo $GLOBALS['name'] . ' - Admin' ?></title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
        <link rel="stylesheet" type="text/css" href="../css/style.css">
    </head>

    <body>
        <main class="admin">
            <div class="container" id="admin">
                <div class="box" id="top">
                    <h1>GÉRER LES ARTICLES</h1>
                </div>
                <div class="box" id="middle-fix">
                    <?php
                    $req = "SELECT articles.id, `login`, `article`, `titre`, `date` FROM `articles` INNER JOIN `utilisateurs` ON articles.id_utilisateur = utilisateurs.id INNER JOIN `categories` ON articles.id_categorie = categories.id";
                    $stmt = $GLOBALS['PDO']->query($req);
                    $list_articles = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($list_articles as $key => $value) {
                        echo '
                    <div id="btn-fix">
                        <div id="btn-left">
                            <h4> ' . $value['titre'] . '</h4><br>
                            <h4> ' . substr($value['article'], 0, 200)  . '...</h4><br>
                            <h4> Par ' . $value['login'] . ' le ' . $value['date'] . '</h4>
                        </div>
                        <div id="btn-right">
                            <form action="" method="post">';
                                if ($_SESSION['perms'] == 1337) {
                                    echo '<a href="/blog/article/article.php?id='.$value['id'].'" id="edit-button" class="btn green">Voir</a>';
									echo '<a href="/blog/article/creer-article.php?id='.$value['id'].'" id="edit-button" class="btn yellow">Edit</a>';
                                    echo '<button type="submit" name="delete" value="' . $value['id'] . '" class="btn red">Delete</button>';
                                } elseif ($_SESSION['perms'] == 42) {
									echo '<a href="/blog/article/article.php?id='.$value['id'].'" id="edit-button" class="btn green">Voir</a>';
                                    echo '<a href="/blog/article/creer-article.php?id='.$value['id'].'" id="edit-button" class="btn yellow">Edit</a>';
                                }
                                echo '
                            </form>
                        </div>
                    </div>';
                    }
                    ?>
                </div>
                <div class="box" id="bottom">
                    <form method="post">
                        <input type="submit" name="return" class="btn blue" autofocus value="Revenir à la page admin">
                    </form>
                </div>
            </div>
        </main>
        <script src="https://kit.fontawesome.com/225d5fd287.js" crossorigin="anonymous"></script>
    </body>

    </html>
<?php
}
?>