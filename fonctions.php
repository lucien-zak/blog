<?php
require('config.php');
$PATH = '';


class Module_Connexion
{
    private $_email;
    private $_mdp;
    private $_Malert;
    private $_Talert;


    function __construct(string $email, string $mdp)
    {
        $this->_email = $email;
        $this->_mdp = $mdp;
    }


    private function verif_exist_util()
    {
        $req = "SELECT `email` FROM `utilisateurs` WHERE email='$this->_email'";
        $stmt = $GLOBALS['PDO']->query($req);
        $list_util = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (isset($list_util[0]['email']) && $list_util[0]['email'] != "") {
            $verifexist = TRUE;
            return $verifexist;
        } else {
            $verifexist = FALSE;
            return $verifexist;
        }
    }

    private function verif_mdp()
    {
        $req = "SELECT `email`, `password` FROM `utilisateurs` WHERE email='$this->_email'";
        $stmt = $GLOBALS['PDO']->query($req);
        $list_util_mdp = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (password_verify($this->_mdp, $list_util_mdp[0]['password'])) {
            $verif = TRUE;
            return $verif;
        } else {
            $verif = FALSE;
            return $verif;
        }
    }


    public function alerts()
    {
        if ($this->_Talert == 1) {
            echo "<div class='succes'>" . $this->_Malert . "</div>";
        } else {
            echo "<div class='error'>" . $this->_Malert . "</div>";
        }
    }

    public function connexion()
    {
        if ($this->_email != "") {
            if ($this->verif_exist_util()) {
                if ($this->verif_mdp()) {
                    $this->_Malert = 'Connexion réussie';
                    $this->_Talert = 1;

                    $req = "SELECT * FROM `utilisateurs` WHERE email='$this->_email'";
                    $res = $GLOBALS['PDO']->query($req);
                    $info_util = $res->fetchAll(PDO::FETCH_ASSOC);

                    $_SESSION['email'] = $info_util[0]['email'];
                    $_SESSION['id'] = $info_util[0]['id'];
                    $_SESSION['login'] = $info_util[0]['login'];
                    $_SESSION['perms'] = $info_util[0]['id_droits'];

                    header('refresh:2;url=/blog/index.php');
                } else {
                    $this->_Malert = 'Mot de passe erroné';
                    $this->_Talert = 0;
                }
            } else {
                $this->_Malert = "L'utilisateur " . $this->_email . " n'existe pas";
                $this->_Talert = 0;
            }
        } else {
            $this->_Malert = 'Veuillez remplir les champs';
            $this->_Talert = 0;
        }
    }
}

class Module_Inscription
{

    private $_login;
    private $_password;
    private $_password_verif;
    private $_email;
    private $_Malert;
    private $_Talert;


    function __construct(string $login, string $password, string $password_verif, string $email, int $droit = 1)
    {

        $this->_login = $login;
        $this->_password = $password;
        $this->_password_verif = $password_verif;
        $this->_email = $email;
        $this->_droit = $droit;
    }

    private function verif_mdp_verif()
    {
        if ($this->_password === $this->_password_verif && $this->_password != "") {
            return TRUE;
        }
    }

    private function verif_util()
    {

        $req = "SELECT `login` FROM `utilisateurs` WHERE login='$this->_login'";
        $stmt = $GLOBALS['PDO']->query($req);
        $list_util = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (isset($list_util[0]['login'])) {
            $verifexist = TRUE;
            return $verifexist;
        } else {
            $verifexist = FALSE;
            return $verifexist;
        }
    }

    private function verif_mail()
    {

        $req = "SELECT `email` FROM `utilisateurs` WHERE email='$this->_email'";
        $stmt = $GLOBALS['PDO']->query($req);
        $list_mail = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (isset($list_mail[0]['email'])) {
            $verifexist = TRUE;
            return $verifexist;
        } else {
            $verifexist = FALSE;
            return $verifexist;
        }
    }
    public function alerts()
    {
        if ($this->_Talert == 1) {
            echo "<div class='succes'>" . $this->_Malert . "</div>";
        } else {
            echo "<div class='error'>" . $this->_Malert . "</div>";
        }
    }

    public function ins_util()
    {
        if ($this->_email == "") {
            $this->_Malert = 'Veuillez remplir votre email';
        } else {
            if ($this->_password == "" && $this->_password_verif == "") {
                $this->_Malert = 'Veuillez remplir le mot de passe';
            } else {
                if ($this->verif_mdp_verif()) {
                    if ($this->verif_util() == FALSE) {
                        if (filter_var($this->_email, FILTER_VALIDATE_EMAIL)) {
                            if ($this->verif_mail() == FALSE) {

                                $req = 'INSERT INTO `utilisateurs`(`login`, `password`, `email`, `id_droits`) VALUES (:login, :password, :email, :id)';
                                $stmt = $GLOBALS['PDO']->prepare($req);
                                $stmt->execute([
                                    ':login' => $this->_login,
                                    ':password' => password_hash($this->_password, PASSWORD_DEFAULT),
                                    ':email' => $this->_email,
                                    ':id' => $this->_id = 1,
                                ]);
                                $this->_Malert = 'Utilisateur crée';
                                $this->_Talert = 1;
                                header('Refresh:2 ; URL=/blog/index.php');
                            } else {
                                $this->_Malert = $this->_email . " existe déjà";
                            }
                        } else {
                            $this->_Malert = $this->_email . " n'est pas une adresse valide";
                        }
                    } else {
                        $this->_Malert = "L'utilisateur " . $this->_login . " existe déjà";
                    }
                } else {
                    $this->_Malert = 'Les mots de passes ne sont pas identiques';
                }
            }
        }
    }
}

class Article
{

    public $_count;
    public $_countnext;
    private $_Malert = "Article modifié";
    private $_Talert = 1;
    // private $_idcat;
    // private $_id;

    // function __construct(){

    //     // $this->_contenu = $contenu;
    //     // $this->_titre = $titre;
    //     // $this->_idutil = $idutil;
    //     // $this->_idcat = $idcat;
    //     // $this->_id = $id;

    // }

    public function alerts()
    {
        if ($this->_Talert == 1) {
            echo "<div class='succes'>" . $this->_Malert . "</div>";
        } else {
            echo "<div class='error'>" . $this->_Malert . "</div>";
        }
    }


    public function getArticleParId(int $id)
    {
        $req = "SELECT `articles`.`id`, `articles`.`article`,`articles`.`titre`,`articles`.`date`, `categories`.`nom` AS 'categorie', `utilisateurs`.`login`  FROM `articles` INNER JOIN `categories` ON `articles`.`id_categorie` = `categories`.`id` INNER JOIN `utilisateurs` ON `articles`.`id_utilisateur` = `utilisateurs`.`id` WHERE `articles`.`id` = $id";
        $stmt = $GLOBALS['PDO']->query($req);
        $article = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $creq = "SELECT `commentaire`, `id_article`, `login`, `commentaires`.`date` FROM `commentaires` INNER JOIN `utilisateurs` ON commentaires.id_utilisateur = utilisateurs.id INNER JOIN `articles` ON commentaires.id_article = articles.id WHERE id_article=$id";
        $cstmt = $GLOBALS['PDO']->query($creq);
        $commentaire = $cstmt->fetchAll(PDO::FETCH_ASSOC);
        if (isset($_POST['submit'])) {
            $id_util = $_SESSION['id'];
            $comment = $_POST['commentaire'];
            if (strlen(str_replace(' ', '', $comment)) > 8) {
                $screq = 'INSERT INTO `commentaires`(`commentaire`, `id_article`, `id_utilisateur`) VALUES (:commentaire, :id, :id_util)';
                $scstmt = $GLOBALS['PDO']->prepare($screq);
                $scstmt->execute([
                    ':commentaire' => $comment,
                    ':id' => $id,
                    ':id_util' => $id_util,
                ]);
                header('refresh: 0;');
            }
        }
?>
        <main class="view-article">
            <div class="container-top">
                <div class="box">
                    <h2><?php echo $article[0]['titre']; ?></h2>
                </div>
            </div>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
                <path fill="#fff" fill-opacity="1" d="M0,32L34.3,48C68.6,64,137,96,206,112C274.3,128,343,128,411,112C480,96,549,64,617,90.7C685.7,117,754,203,823,208C891.4,213,960,139,1029,128C1097.1,117,1166,171,1234,160C1302.9,149,1371,75,1406,37.3L1440,0L1440,320L1405.7,320C1371.4,320,1303,320,1234,320C1165.7,320,1097,320,1029,320C960,320,891,320,823,320C754.3,320,686,320,617,320C548.6,320,480,320,411,320C342.9,320,274,320,206,320C137.1,320,69,320,34,320L0,320Z"></path>
            </svg>
        </main>

        <section class="view-article">
            <div class="container">
                <h2 class="title"><?php echo $article[0]['titre'] ?></h2>
                <h4 id="sous-title">Crée par <?php echo $article[0]['login']; ?> le <?php echo $article[0]['date']; ?></h4>
            </div>
            <div class="container-2">
                <span>
                    <?php echo $article[0]['article']; ?>
                </span>
            </div>
            <h2 class="title">Réagir à l'article</h2>
            <?php if ($_SESSION) { ?>
                <form action="" method="post" id="form-commentaire">
                    <textarea placeholder="8 caractères minimum" name="commentaire" minlength="5" rows="10" cols="45"></textarea>
                    <input type="submit" class="btn green" name="submit">
                </form>
            <?php } else { ?>
                <h4 id="sous-title">Vous devez être connectez pour pouvoir réagir à l'article.</h4>
            <?php } ?>
            <div class="container-2" id="container-commentaire">
                <?php foreach ($commentaire as $value) { ?>
                    <div class="container-3">
                        <div class="box">
                            <span>
                                <?= $value['commentaire'] ?>
                            </span>
                            <div class="box" id="bottom">
                                <h5>Posté par <?php echo $value['login'] . ' le ' . $value['date'] ?></h5>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </section>
        <?php
    }

    public function insArticle(string $article, string $titre, int $id_utilisateur, int $id_categorie)
    {
        if ($article == "") {
            $this->_Malert = 'Veuillez remplir le champ "Texte"';
        } elseif ($titre == "") {
            $this->_Malert = 'Veuillez remplir le champ "Titre"';
        } else {
            $req = "INSERT INTO `articles`(`article`, `titre`, `id_utilisateur`, `id_categorie`) VALUES (:article,:titre,:id_utilisateur,:id_categorie)";
            $stmt = $GLOBALS['PDO']->prepare($req);
            $stmt->execute([
                ':article' => $article,
                ':titre' => $titre,
                ':id_utilisateur' => $id_utilisateur,
                ':id_categorie' => $id_categorie,
            ]);
            $this->_Malert = 'Articles crée';
            $this->_Talert = 1;
        }
    }

    public function countnext(int $limit, int $OFFSET = 0, string $type, string $categorie)
    {
        if ($categorie == 'tout') {
            $req = "SELECT `articles`.`id`, `articles`.`article`,`articles`.`titre`,`articles`.`date`, `categories`.`nom` AS 'categorie', `utilisateurs`.`login`  FROM `articles` INNER JOIN `categories` ON `articles`.`id_categorie` = `categories`.`id` INNER JOIN `utilisateurs` ON `articles`.`id_utilisateur` = `utilisateurs`.`id` LIMIT $limit OFFSET $OFFSET";
        } else {
            $req = "SELECT `articles`.`id`, `articles`.`article`,`articles`.`titre`,`articles`.`date`, `categories`.`nom` AS 'categorie', `utilisateurs`.`login`  FROM `articles` INNER JOIN `categories` ON `articles`.`id_categorie` = `categories`.`id` INNER JOIN `utilisateurs` ON `articles`.`id_utilisateur` = `utilisateurs`.`id` WHERE `categories`.`nom`='$categorie' LIMIT $limit OFFSET $OFFSET";
        }
        $stmt = $GLOBALS['PDO']->query($req);
        $list_articles = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $this->_countnext = count($list_articles);
    }

    public function getArticleLimite(int $limit, int $OFFSET = 0, string $type, string $categorie)
    {
        if ($categorie == 'tout') {
            $req = "SELECT `articles`.`id`, `articles`.`article`,`articles`.`titre`,`articles`.`date`, `categories`.`nom` AS 'categorie', `utilisateurs`.`login`  FROM `articles` INNER JOIN `categories` ON `articles`.`id_categorie` = `categories`.`id` INNER JOIN `utilisateurs` ON `articles`.`id_utilisateur` = `utilisateurs`.`id` ORDER BY `articles`.`date` DESC LIMIT $limit OFFSET $OFFSET";
        } else {
            $req = "SELECT `articles`.`id`, `articles`.`article`,`articles`.`titre`,`articles`.`date`, `categories`.`nom` AS 'categorie', `utilisateurs`.`login`  FROM `articles` INNER JOIN `categories` ON `articles`.`id_categorie` = `categories`.`id` INNER JOIN `utilisateurs` ON `articles`.`id_utilisateur` = `utilisateurs`.`id` WHERE `categories`.`nom`='$categorie' ORDER BY `articles`.`date` LIMIT $limit OFFSET $OFFSET";
        }
        $stmt = $GLOBALS['PDO']->query($req);
        $list_articles = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $this->_count = count($list_articles);
        if ($type == 'card') {
            for ($i = 0; $i < count($list_articles); $i++) { ?>
                <div class="card">
                    <a href="/blog/article/article.php?id=<?php echo $list_articles[$i]['id'] ?>">
                        <div class="card-header">
                            <img src="https://aitechnologiesng.com/wp-content/uploads/2021/01/Software-Development-Training-in-Abuja1-1024x768.jpg" alt="city" />
                        </div>
                    </a>
                    <div class="card-body">
                        <a href="/blog/article/articles.php?categorie=<?= $list_articles[$i]['categorie'] ?>"><span class="tag tag-blue"><?php echo $list_articles[$i]['categorie'] ?></span></a>
                        <h2>
                            <?php echo $list_articles[$i]['titre'] ?>
                        </h2>
                        <p>
                            <?= strlen($list_articles[$i]['article']) > 100 ? substr($list_articles[$i]['article'], 0, 100) . "..." : $list_articles[$i]['article']  ?>
                        </p>
                        <div class="user">
                            <img src="/blog/img/name.png" style="width:25%; height:25%;" alt="user"/>
                            <div class="user-info">
                                <h5><?php echo $list_articles[$i]['login'] ?></h5>
                                <small><?php echo $list_articles[$i]['date'] ?></small>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
            }
        } elseif ($type == 'ligne') {
            for ($i = 0; $i < count($list_articles); $i++) {  ?>
                <div class="article-card">
                    <a href="/blog/article/article.php?id=<?php echo $list_articles[$i]['id'] ?>">
                        <div class="box" id="right">
                            <span class="fa-stack fa-2x">
                                <i class="fas fa-chevron-left fa-stack-2x"></i>
                            </span>
                        </div>
                        <div class="box" id="left">
                            <h2> <?php echo $list_articles[$i]['titre'] ?></h2>
                            <span>
                                <?= strlen($list_articles[$i]['article']) > 100 ? substr($list_articles[$i]['article'], 0, 100) . "..." : $list_articles[$i]['article']  ?>
                            </span>
                            <div class="box" id="bottom">
                                <h4>Posté par <?php echo $list_articles[$i]['login'] . ' le ' . $list_articles[$i]['date'] ?></h4>
                            </div>
                        </div>
                    </a>
                </div>
<?php
            }
        }
    }
}

class Modif_Profil
{

    private $_id;
    public $_login;
    public $_password;
    public $_mail;
    public $_droit;
    public $_iddroit;
    private $_Malert;
    private $_Talert;

    function __construct(int $id)
    {
        $this->_id = $id;
    }

    public function get_utilisateur()
    {
        $req = "SELECT `utilisateurs`.`id`,`login`,`password`,`email`, `droits`.`nom` AS `droits`, `droits`.`id` AS `iddroits` FROM `utilisateurs` INNER JOIN `droits` ON `utilisateurs`.`id_droits` = `droits`.`id` WHERE `utilisateurs`.`id` = $this->_id";
        $stmt = $GLOBALS['PDO']->query($req);
        $list_util = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $this->_login = $list_util[0]['login'];
        $this->_password = $list_util[0]['password'];
        $this->_mail = $list_util[0]['email'];
        $this->_droit = $list_util[0]['droits'];
        $this->_iddroit = $list_util[0]['iddroits'];
    }

    public function verif_email($mail)
    {
        $req = "SELECT `email`, `id` FROM `utilisateurs` WHERE `id`!='$this->_id'";
        $stmt = $GLOBALS['PDO']->query($req);
        $list_mail = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $mailexist = FALSE;
        for ($k = 0; isset($list_mail[$k]['email']); $k++) {
            if ($list_mail[$k]['email'] == $mail) {
                $mailexist = TRUE;
                return $mailexist;
            }
            
        }

        
    }

    public function verif_login($login)
    {
        $req = "SELECT `login`,`id` FROM `utilisateurs` WHERE `id`!=$this->_id";
        $stmt = $GLOBALS['PDO']->query($req);
        $list_login = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $loginexist = FALSE;
        for ($j = 0; isset($list_login[$j]['login']); $j++) {
            if ($list_login[$j]['login'] == $login) {
                $loginexist = TRUE;
                return $loginexist;
            }
            
        }
    }




    public function modif_util($email, $password1, $password2, $login, $iddroit)
    {
        if ($password1 == "" or $password2 == "") {
            $this->_Malert = 'Veuillez remplir les mots de passes';
        } else {
            if ($password2 != $password1) {
                $this->_Malert = 'Les mots de passes sont différents';
            } else {
                if ($email == "") {
                    $this->_Malert = 'Veuillez remplir votre mail';
                } else {
                    if ($login == "") {
                        $this->_Malert = 'Veuillez remplir votre login';
                    } else {
                        if (filter_var($email, FILTER_VALIDATE_EMAIL) == FALSE) {
                            $this->_Malert = $email . " n'est pas un format 'email' valide";
                        } else {
                            if ($this->verif_email($email)) {
                                $this->_Malert = $email . " existe déjà";
                            } else {
                                if ($this->verif_login($login)) {
                                    $this->_Malert = $login . " existe déjà";
                                } else {
                                    $req = "UPDATE `utilisateurs` SET `login`=:login,`password`=:password,`email`=:email,`id_droits`=:iddroit WHERE `id`=:id";
                                    $stmt = $GLOBALS['PDO']->prepare($req);
                                    $stmt->execute([
                                        ':login' => $login,
                                        ':password' => password_hash($password1, PASSWORD_DEFAULT),
                                        ':email' => $email,
                                        ':iddroit' => $iddroit,
                                        ':id' => $this->_id,
                                    ]);
                                    $this->_Malert = 'Utilisateur modifié';
                                    $this->_Talert = 1;
                                    if ($_SESSION['id'] == $this->_id) {
                                    $_SESSION['email'] = $email;
                                    $_SESSION['login'] = $login;
                                    $_SESSION['perms'] = $iddroit;}
                                    // header('refresh:2');
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    //     private function verif_mdp_verif($pass1, $pass2)
    //     {
    //         if ($pass1 === $pass2 && $pass1 != "") {
    //             return TRUE;
    //         }
    //     }

    //     private function verif_util($login)
    //     {

    //         $req = "SELECT `login` FROM `utilisateurs` WHERE login='$login'";
    //         $stmt = $GLOBALS['PDO']->query($req);
    //         $list_util = $stmt->fetchAll(PDO::FETCH_ASSOC);
    //         $verifexist = FALSE;
    //         if ($_SESSION['id'] == $login) {
    //             $verifexist = FALSE;
    //             return $verifexist;
    //         }
    //         elseif ($list_util[0]['login'] == $this->_login) {
    //             $verifexist = TRUE;
    //             return $verifexist;
    //         } else {
    //             $verifexist = FALSE;
    //             return $verifexist;
    //         }var_dump($verifexist);
    //     }

    public function alerts()
    {
        if ($this->_Talert == 1) {
            echo "<div class='succes'>" . $this->_Malert . "</div>";
        } else {
            echo "<div class='error'>" . $this->_Malert . "</div>";
        }
    }


    //     private function verif_mail($email)
    //     {

    //         $req = "SELECT `login` FROM `utilisateurs` WHERE login='$email'";
    //         $stmt = $GLOBALS['PDO']->query($req);
    //         $list_util = $stmt->fetchAll(PDO::FETCH_ASSOC);
    //         if ($_SESSION['email'] == $email) {
    //             $verifexist = FALSE;
    //             return $verifexist;
    //         }
    //         elseif ($list_util[0]['email'] == $email) {
    //             $verifexist = TRUE;
    //             return $verifexist;
    //         } else {
    //             $verifexist = FALSE;
    //             return $verifexist;
    //         }
    //     }

    //     public function ins_util($email, $password1, $password2, $login)
    //     {
    //         if ($email == "") {
    //             $this->_Malert = 'Veuillez remplir votre email';
    //         } else {
    //             if ($password1 == "" && $password2 == "") {
    //                 $this->_Malert = 'Veuillez remplir le mot de passe';
    //             } else {
    //                 if ($this->verif_mdp_verif($password1, $password2)) {
    //                     if ($this->verif_util($login) == FALSE) {
    //                         if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
    //                             if ($this->verif_mail($email) == FALSE) {

    //                                 // $req = 'INSERT INTO `utilisateurs`(`login`, `password`, `email`, `id_droits`) VALUES (:login, :password, :email, :id)';
    //                                 // $stmt = $GLOBALS['PDO']->prepare($req);
    //                                 // $stmt->execute([
    //                                 //     ':login' => $this->_login,
    //                                 //     ':password' => password_hash($this->_password, PASSWORD_DEFAULT),
    //                                 //     ':email' => $this->_email,
    //                                 //     ':id' => $this->_id = 1,
    //                                 // ]);
    //                                 $this->_Malert = 'Utilisateur crée';
    //                                 $this->_Talert = 1;
    //                             } else {
    //                                 $this->_Malert = $email . " existe déjà";
    //                             }
    //                         } else {
    //                             $this->_Malert = $email . " n'est pas une adresse valide";
    //                         }
    //                     } else {
    //                         $this->_Malert = "L'utilisateur " . $login . " existe déjà";
    //                     }
    //                 } else {
    //                     $this->_Malert = 'Les mots de passes ne sonts pas identiques';
    //                 }
    //             }
    //         }
    //     }
}




?>

<style>
    .succes {
        background-color: green;
        font-weight: bold;
        font-family: "Comfortaa";
        width: 90%;
        text-align: center;
        padding: 10px;
        animation: 1s ease-in-out alertSuccess forwards;
    }

    .error {
        background-color: red;
        font-weight: bold;
        font-family: "Comfortaa";
        width: 90%;
        text-align: center;
        padding: 10px;
        animation: 1s ease-in-out alertError forwards;
    }

    @keyframes alertSuccess {
        from {
            background-color: transparent;
        }

        to {
            background-color: green;
            color: white
        }
    }

    @keyframes alertError {
        from {
            background-color: transparent;
        }

        to {
            background-color: red;
            color: white
        }
    }
</style>