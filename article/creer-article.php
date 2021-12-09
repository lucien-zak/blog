<?php
require('../fonctions.php');
error_reporting(E_ALL);
ini_set('display_errors', 1);
$article = new Article();
if (isset($_POST["submit"]) && $_POST["submit"] == "Créer l'article" ) {
    $article->insArticle($_POST['desc-article'], $_POST['title-article'], $_SESSION['id'], $_POST['choose-article']);
} elseif (isset($_POST['back'])) {
    header('Location: /blog/index.php');
} elseif (isset($_GET['id']) && $_SESSION['perms'] == 1337) {
    $idarticle = $_GET['id'];
    $req = "SELECT * FROM `articles` WHERE `id`= $idarticle";
    $stmt = $GLOBALS['PDO']->query($req);
    $arti = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
if (isset($arti[0]['id_categorie'])) {
    $id_cat = $arti[0]['id_categorie'];
}
else {
    $id_cat = "";
}
if (isset($_POST["submit"]) && $_POST["submit"] == "Modifier l'article" ) {
    $req = "UPDATE `articles` SET `article`=:article,`titre`=:titre,`id_categorie`=:idcat WHERE `id`=$idarticle";
    $stmt = $GLOBALS['PDO']->prepare($req);
    $stmt->execute([
        ':article' => $_POST['desc-article'],
        ':titre' => $_POST['title-article'],
        ':idcat' => $_POST['choose-article'],
    ]);
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
    <title><?php echo $GLOBALS['name'] . ' - Créer un article' ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" type="text/css" href="../css/style.css">
</head>

<body>
    <main class="create-article"> 
        <div class="container" id="forms">
            <form action="" method="post" class="forms">
                <?php if (isset($_POST['submit'])) {
                    $article->alerts();
                } ?>

                <div class="box" id="top">
                    <h1>CRÉER VOTRE ARTICLE</h1><br>
                </div>
                <div class="box" id="middle">
                    <input type="text" name="title-article" placeholder="Titre de l'article" value="<?= isset($arti[0]['titre']) ? $arti[0]['titre'] : ""  ?>"><br>
                    <select name="choose-article">
                        <?php 
                        $req = "SELECT * FROM `categories`";
                        $stmt = $GLOBALS['PDO']->query($req);
                        $list_articles = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        for ($i = 0; $i < count($list_articles); $i++) { ?>
                            <option value="<?php echo $list_articles[$i]['id'] ?>" <?php if ($id_cat == $list_articles[$i]['id']) {echo "selected";} ?>><?= $list_articles[$i]['nom'] ?></option> <?php } ?>
                    </select>
                    <textarea name="desc-article" placeholder="Écrivez votre article"><?= isset($arti[0]['article']) ? $arti[0]['article'] : ""  ?></textarea>
                </div>
                <div class="box" id="bottom">
                    <?php if ((isset($_GET['id']) && $_SESSION['perms'] == 1337)) { ?>
                        <input type="submit" name="submit" class="btn green" autofocus value="Modifier l'article"> <?php } else { ?>
                        <input type="submit" name="submit" class="btn green" autofocus value="Créer l'article">
                    <?php } ?>
                    <input type="submit" name="back" class="btn orange" autofocus value="Revenir à la page principale">
                </div>
            </form>
        </div>
    </main>
</body>

</html>