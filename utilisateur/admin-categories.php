<?php
require('../fonctions.php');

if(($_SESSION['perms'] != 42) && ($_SESSION['perms'] != 1337)) {
    header('Location: /blog/index.php');
} else {
    if (isset($_POST['return'])) {
        header('Location: /blog/utilisateur/admin.php');
    } elseif (isset($_POST['delete'])) {
        $delete = "DELETE FROM `categories` WHERE id='" . $_POST['delete'] . "'";
        $res = $GLOBALS['PDO']->exec($delete);
        header('refresh:0');
    } elseif (isset($_POST['submitcategory'])) {
        $req = "INSERT INTO `categories`(`nom`) VALUES (:categorie)";
            $stmt = $GLOBALS['PDO']->prepare($req);
            $stmt->execute([
                ':categorie' => $_POST['categorie'],
            ]);
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
                    <h1>GÉRER LES CATÉGORIES</h1>
                </div>
                <div class="box" id="middle-fix">
                    <form action="#" method="post" id="form-category">
                        <input type="text" id="input-category" placeholder="Nom de votre catégorie" name="categorie">
                        <input type="submit" class="btn green" name="submitcategory">
                    </form>
                    <?php
                    $req = "SELECT * FROM `categories` ORDER BY `nom` ASC";
                    $stmt = $GLOBALS['PDO']->query($req);
                    $list_category = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($list_category as $key => $value) {
                        echo '
                    <div id="btn-fix">
                        <div id="btn-left">
                            <h4> ID: ' . $value['id'] . '</h4>
                            <h4> Titre: ' . $value['nom'] . '</h4>
                        </div>
                        <div id="btn-right">
                            <form action="" method="post">';
                        if ($_SESSION['perms'] == 1337) {
                            echo '<button type="submit" name="edit" class="btn yellow" value="' . $value['id'] . '">Edit</button>';
                            echo '<button type="submit" name="delete" class="btn red" value="' . $value['id'] . '">Delete</button>';
                        } elseif ($_SESSION['perms'] == 42) {
                            echo '<button type="submit" name="edit" class="btn yellow" value="' . $value['id'] . '">Edit</button>';
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