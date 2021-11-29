<?php
require ('../fonctions.php');
error_reporting(E_ALL);
ini_set('display_errors', 1);
if(isset($_POST['submit'])) {
    $connexion = new Module_Connexion($_POST['email'], $_POST['password']);
    $connexion->connexion();
} elseif(isset($_POST['forgot-button'])) {
    header("Location: ./index.php");
} elseif(isset($_POST['register-button'])) {
    header("Location: inscription.php");
}
?>

<!--    HEAD   -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $GLOBALS['name'] . ' - Login' ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" type="text/css" href="../css/style.css">
</head>

<body>
    <main class="login" style="overflow: hidden;">
        <div class="container" id="forms">
            <form action="#" method="post" class="forms">
                <div class="box" id="top">
                    <h1>CONNEXION</h1>
                </div>
                <?php if (isset($_POST['submit'])) {$connexion->alerts(); } ?>
                <div class="box" id="middle">
                    <input type="email" name="email" placeholder="Adresse courriel"><br>
                    <input type="password" name="password" placeholder="Mot de passe">
                </div>
                <div class="box" id="bottom">
                    <input type="submit" name="submit" id="connection" autofocus value="Connexion">
                    <input type="submit" name="forgot-button" id="forgot" autofocus value="Mot de passe oublié?">
                </div>
                <div class="box" id="register">
                    <hr></hr>
                    <span id="text">Ou</span>
                    <hr></hr>
                </div>
                <div class="box" id="bottom">
                    <input type="submit" name="register-button" id="forgot" value="Pas encore de compte, créez-en un dès maintenant.">
                </div>
            </form>
        </div>
    </main>
</body>
</html>