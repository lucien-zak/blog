<?php
require('../fonctions.php');

?>

<!--    HEAD   -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $GLOBALS['name'] . ' - Article' ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" type="text/css" href="/blog/css/style.css">
</head>

<body>
    <!--    Header   -->
    <?php
    require('../header.php');
    $article = new Article();
    $article->getArticleParId($_GET['id']);
    ?>
    <?php
    require('../footer.php');
    ?>
</body>

</html>