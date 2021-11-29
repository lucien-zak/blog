<?php
require ('./fonctions.php');
?>

<!--    HEAD   -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $GLOBALS['name'] . ' - Accueil' ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>

<body>
<!--    Header   -->
<?php
require('header.php');
?>

    <main class="home">
        <div class="container-top">
            <div class="box">
                <h2><?php echo $GLOBALS['name'] ?></h2>
            </div>
        </div>
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="#fff" fill-opacity="1" d="M0,32L34.3,48C68.6,64,137,96,206,112C274.3,128,343,128,411,112C480,96,549,64,617,90.7C685.7,117,754,203,823,208C891.4,213,960,139,1029,128C1097.1,117,1166,171,1234,160C1302.9,149,1371,75,1406,37.3L1440,0L1440,320L1405.7,320C1371.4,320,1303,320,1234,320C1165.7,320,1097,320,1029,320C960,320,891,320,823,320C754.3,320,686,320,617,320C548.6,320,480,320,411,320C342.9,320,274,320,206,320C137.1,320,69,320,34,320L0,320Z"></path></svg>
    </main>

    <section class="container">
        <div class="container-1">
            <h2 id="title">Nos derniers articles</h2>
        </div>
        <!--    Generation Card   -->
        <div class="container-2">
        <?php
        $article = new Article();
        $article->getArticleLimite("3");
        ?>
        </div>
        <!--   Fin Generation Card   -->
    </section>

<?php
require('footer.php');
?>
</body>
</html>