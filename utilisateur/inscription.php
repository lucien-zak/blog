<?php
require ('../fonctions.php');

if(isset($_POST['submit'])) {
    $connexion = new Module_Inscription($_POST['login'], $_POST['password'], $_POST['password_confirmation'], $_POST['email'], 1);
    $connexion->ins_util();
} elseif(isset($_POST['login-button'])) {
    header("Location: connexion.php");
}
?>

<!--    HEAD   -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $GLOBALS['name'] . ' - Register' ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" type="text/css" href="../css/style.css">
</head>

<body>
    <main class="login" style="overflow: hidden;">
        <div class="container" id="forms">
            <form action="#" method="post" class="forms">
                <div class="box" id="top">
                    <h1>INSCRIPTION</h1>
                </div>
                <div class="box" id="middle">
                    <input type="email" name="email" placeholder="Adresse courriel"><br>
                    <input type="email" name="login" placeholder="Nom d'utilisateur"><br>
                    <input type="password" name="password" placeholder="Mot de passe"><br>
                    <input type="password" name="password_confirmation" placeholder="Confirmer le Mot de passe">
                </div>
                <div class="box" id="bottom">
                    <input type="submit" name="submit" id="connection" autofocus value="Créer le compte">
                </div>
                <div class="box" id="register">
                    <hr></hr>
                    <span id="text">Ou</span>
                    <hr></hr>
                </div>
                <div class="box" id="bottom">
                    <input type="submit" name="login-button" id="forgot" value="Vous avez déjà un compte ? Connectez-vous.">
                </div>
            </form>
        </div>
    </main>
</body>
</html>