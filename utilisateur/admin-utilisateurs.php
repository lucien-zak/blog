<?php
require ('../fonctions.php');

if(($_SESSION['perms'] != 42) && ($_SESSION['perms'] != 1337)) {
    header('Location: /blog/index.php');
} else {
    if(isset($_POST['return'])) {
        header('Location: /blog/utilisateur/admin.php');
    } elseif(isset($_POST['edit'])) {

    } elseif(isset($_POST['delete'])) {
        $delete = "DELETE FROM `utilisateurs` WHERE login='". $_POST['delete'] ."'";
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
                <h1>GÉRER LES UTILISATEURSS</h1>
            </div>
            <div class="box" id="middle-fix">
                <?php
                $req = "SELECT * FROM `utilisateurs` ORDER BY `id_droits` DESC";
                $stmt = $GLOBALS['PDO']->query($req);
                $list_utilisateurs = $stmt->fetchAll(PDO::FETCH_ASSOC);

                foreach($list_utilisateurs as $key => $value) {
                    if($value['id_droits'] == 1337) {
                        $role = "Administrateur";
                    } elseif ($value['id_droits'] == 42) {
                        $role = "Moderateur";
                    } elseif ($value['id_droits'] == 1 || $value['id_droits'] != 42 || $value['id_droits'] != 1337) {
                        $role = "Utilisateur";
                    };

                    echo '
                    <div id="btn-fix">
                        <div id="btn-left">
                            <h4> Nom d\'utilisateur: '.$value['login'].'</h4>
                            <h4> Email: '.$value['email'].'</h4>
                            <h4> Rôle: '.$role.'</h4>
                        </div>
                        <div id="btn-right">
                            <form action="" method="post">';
                                if( $_SESSION['perms'] == 1337 ) {
                                    echo '<a href="/blog/utilisateur/profil.php?id=' . $value['id'] . '" class="btn yellow" id="edit-button" value="'.$value['login'].'">Edit</a>';
                                    echo '<button type="submit" name="delete" class="btn red" value="'.$value['login'].'">Delete</button>';
                                } elseif( $_SESSION['perms'] == 42 ) {
                                    echo '<button type="submit" name="edit" class="btn yellow" value="'.$value['id'].'">Edit</button>';
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