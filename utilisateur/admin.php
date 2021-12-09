<?php
require ('../fonctions.php');

if(($_SESSION['perms'] != 42) && ($_SESSION['perms'] != 1337)) {
    header('Location: /blog/index.php');
} else {
    if(isset($_POST['submit'])) {
        header('Location: /blog/index.php');
    } elseif(isset($_POST['utilisateurs'])) {
        header('Location: /blog/utilisateur/admin-utilisateurs.php');
    } elseif(isset($_POST['articles'])) {
        header('Location: /blog/utilisateur/admin-articles.php');
    } elseif(isset($_POST['categories'])) {
        header('Location: /blog/utilisateur/admin-categories.php');
    };
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
        <div class="container" id="forms">
            <form action="#" method="post" class="forms">
                <div class="box" id="top">
                    <h1>ADMINISTRATION</h1>
                </div>
                <div class="box" id="middle">
                    <?php if($_SESSION['perms'] == 1337) { ?>
                        <input type='submit' name='utilisateurs' id='create' style='background-image: url("/blog/img/user.png");' autofocus value='Gérer les utilisateurs'>
                        <input type="submit" name="articles" id="create" style="background-image: url('/blog/img/article.png');" autofocus value="Gérer les articles">
                        <input type="submit" name="categories" id="create" style="background-image: url('/blog/img/category.png');" autofocus value="Gérer les catégories">
                    <?php } elseif ($_SESSION['perms'] == 42) { ?>
                        <input type="submit" name="articles" id="create" style="background-image: url('/blog/img/article.png');" autofocus value="Gérer les articles">
                        <input type="submit" name="categories" id="create" style="background-image: url('/blog/img/category.png');" autofocus value="Gérer les catégories">
                    <?php } ?>
                </div>
                <div class="box" id="middle-2">
                    <hr></hr>
                    <span id="text">Ou</span>
                    <hr></hr>
                </div>
                <div class="box" id="bottom">
                    <input type="submit" name="submit" class="btn blue" autofocus value="Revenir à la page principale">
                </div>
            </form>
        </div>
    </main>
    <script src="https://kit.fontawesome.com/225d5fd287.js" crossorigin="anonymous"></script>
</body>
</html>
<?php
}
?>