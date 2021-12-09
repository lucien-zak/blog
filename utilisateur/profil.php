<?php
require('../fonctions.php');
if(!$_SESSION) {
	header('Location: /blog/index.php');
}

if (isset($_GET['id']) && $_SESSION['perms'] == "1337") {
    $idutil = $_GET['id'];
} else {
    $idutil = $_SESSION['id'];
}
if (!isset($_POST['droit'])) {
    $_POST['droit'] = 1;
}
$util = new Modif_Profil($idutil);
if (isset($_POST['submit'])) {
    $util->modif_util($_POST['email'], $_POST['password'], $_POST['password_confirmation'], $_POST['login'], $_POST['droit']);
} elseif(isset($_POST['return'])) {
    header('Location: /blog/index.php');
}
$util->get_utilisateur();
if (!isset($_POST['droit'])) {
    $_POST['droit'] = 1;
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
    <main class="login" style="overflow: hidden;">
        <div class="container" id="forms">
            <form action="" method="post" class="forms">
                <div class="box" id="top">
                    <?php
                    //if($_SESSION) {
                    //  echo '<h1>MODIFIER VOTRE PROFIL</h1>';
                    //} else {
                    //  echo '<h1>MODIFICATION DU PROFILE DE name</h1>';
                    //}
                    ?>
                </div>
                <?php if (isset($_POST['submit'])) {
                    $util->alerts();
                } ?>
                <div class="box" id="middle">
                    <input type="text" name="email" placeholder="Adresse courriel" value="<?= $util->_mail  ?>"><br>
                    <input type="text" name="login" placeholder="Nom d'utilisateur" value="<?= $util->_login  ?>"><br>
                    <?php if($_SESSION['perms'] == 1337) { ?>
                    <SELECT name="droit" id="edit-select">
                        <option value="<?= $util->_iddroit ?>"><?= $util->_droit ?></option>
                        <?php
                        $req = "SELECT * FROM `droits` WHERE `nom` != '$util->_droit'";
                        $stmt = $GLOBALS['PDO']->query($req);
                        $list_droits = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        for ($i = 0; $i < count($list_droits); $i++) { ?>
                            <option value="<?= $list_droits[$i]['id'] ?>"><?= $list_droits[$i]['nom'] ?></option>
                        <?php } ?>
                    </SELECT>
                    <?php } ?>
                    <input type="password" name="password" placeholder="Mot de passe"><br>
                    <input type="password" name="password_confirmation" placeholder="Confirmer le Mot de passe">
                </div>
                <div class="box" id="bottom">
                    <input type="submit" name="submit" class="btn green" value="Modifier les informations">
                </div>
                <div class="box" id="register">
                    <hr>
                    </hr>
                    <span id="text">Ou</span>
                    <hr>
                    </hr>
                </div>
                <div class="box" id="bottom">
                    <input type="submit" name="return" class="btn blue" value="Revenir à la page principale">
                </div>
            </form>
        </div>
    </main>
    <script src="https://kit.fontawesome.com/225d5fd287.js" crossorigin="anonymous"></script>
</body>

</html>