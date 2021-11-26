<?php
class Module_Connexion
{
    private $_login;
    private $_mdp;

    function __construct(string $login, string $mdp)
    {
        $this->_login = $login;
        $this->_mdp = $mdp;
    }


    public function verif_exist_util()
    {
        $PDO = new PDO('mysql:host=localhost;dbname=lucien-zak_blog', 'blog', 'blog123');
        $req = "SELECT `login` FROM `utilisateurs` WHERE login='$this->_login'";
        $stmt = $PDO->query($req);
        $list_util = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($list_util[0]['login'] == $this->_login) {
            $verifexist = TRUE;
            return $verifexist;
        } else {
            $verifexist = FALSE;
            return $verifexist;
        }
    }

    private function verif_mdp()
    {
        $PDO = new PDO('mysql:host=localhost;dbname=lucien-zak_blog', 'blog', 'blog123');
        $req = "SELECT `login`, `password` FROM `utilisateurs` WHERE login='$this->_login' AND password='$this->_mdp'";
        $stmt = $PDO->query($req);
        $list_util_mdp = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (isset($list_util_mdp)) {
            $verif = TRUE;
            return $verif;
        } else {
            $verif = FALSE;
            return $verif;
        }
    }

    public function connexion()
    {
        if (isset($_POST)) {
            if ($this->verif_exist_util()) {
                if ($this->verif_mdp()) {
                    echo 'connexion réussie';
                } else {
                    echo 'Mot de passe faux';
                }
            } else {
                echo 'Utilisateur existe pas';
            }
        }
    }
}

class Module_Inscription
{

    private $_login;
    private $_password;
    private $_password_verif;
    private $_email;

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
        $PDO = new PDO('mysql:host=localhost;dbname=lucien-zak_blog', 'blog', 'blog123');
        $req = "SELECT `login` FROM `utilisateurs` WHERE login='$this->_login'";
        $stmt = $PDO->query($req);
        $list_util = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($list_util[0]['login'] == $this->_login) {
            $verifexist = TRUE;
            return $verifexist;
        } else {
            $verifexist = FALSE;
            return $verifexist;
        }
    }

    private function verif_mail()
    {
        $PDO = new PDO('mysql:host=localhost;dbname=lucien-zak_blog', 'blog', 'blog123');
        $req = "SELECT `email` FROM `utilisateurs` WHERE email='$this->_email'";
        $stmt = $PDO->query($req);
        $list_mail = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($list_mail[0]['email'] == $this->_email) {
            $verifexist = TRUE;
            return $verifexist;
        } else {
            $verifexist = FALSE;
            return $verifexist;
        }
    }

    public function ins_util()
    {
        if ($this->_login == "") {
            echo 'Veuillez remplir Login';
        } else {
            if ($this->_password == "") {
                echo 'Veuillez remplir le mot de passe';
            }
            if ($this->verif_mdp_verif()) {
                if ($this->verif_util() == FALSE) {
                    if (filter_var($this->_email, FILTER_VALIDATE_EMAIL)) {
                        if ($this->verif_mail() == FALSE) {
                            $PDO = new PDO('mysql:host=localhost;dbname=lucien-zak_blog', 'blog', 'blog123');
                            $req = 'INSERT INTO `utilisateurs`(`login`, `password`, `email`, `id_droits`) VALUES (:login, :password, :email, :id)';
                            $stmt = $PDO->prepare($req);
                            $stmt->execute([
                                ':login' => $this->_login,
                                ':password' => $this->_password,
                                ':email' => $this->_email,
                                ':id' => $this->_id = 1,
                            ]);
                            echo 'Utilisateur crée';
                        } else {
                            echo $this->_email . " existe déjà";
                        }
                    } else {
                        echo $this->_email . " n'est pas une adresse valide";
                    }
                } else {
                    echo "L'utilisateur " . $this->_login . " existe déjà";
                }
            } else {
                echo 'Les mots de passes ne sonts pas identiques';
            }
        }
    }
}

class Article
{

    // private $_contenu;
    // private $_titre;
    // private $_idutil;
    // private $_idcat;
    // private $_id;

    // function __construct(){

    //     // $this->_contenu = $contenu;
    //     // $this->_titre = $titre;
    //     // $this->_idutil = $idutil;
    //     // $this->_idcat = $idcat;
    //     // $this->_id = $id;

    // }

    public function getArticleParId(int $id)
    {
        $PDO = new PDO('mysql:host=localhost;dbname=lucien-zak_blog', 'blog', 'blog123');
        $req = "SELECT * FROM `articles` WHERE `id`=" . $id . "";
        $stmt = $PDO->query($req);
        $list_articles = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function getArticleLimite(int $limit, int $OFFSET = 0)
    {
        $PDO = new PDO('mysql:host=localhost;dbname=lucien-zak_blog', 'blog', 'blog123');
        $req = "SELECT `articles`.`id`, `articles`.`article`,`articles`.`titre`,`articles`.`date`, `categories`.`nom` AS 'categorie', `utilisateurs`.`login`  FROM `articles` INNER JOIN `categories` ON `articles`.`id_categorie` = `categories`.`id` INNER JOIN `utilisateurs` ON `articles`.`id_utilisateur` = `utilisateurs`.`id` LIMIT " . $limit . "";
        $stmt = $PDO->query($req);
        $list_articles = $stmt->fetchAll(PDO::FETCH_ASSOC);
        for ($i = 0; $i < $limit; $i++) { ?>
            <div class="container-2">
                <div class="card">
                    <div class="card-header">
                        <img src="https://aitechnologiesng.com/wp-content/uploads/2021/01/Software-Development-Training-in-Abuja1-1024x768.jpg" alt="city" />
                    </div>
                    <div class="card-body">
                        <a href="#main"><span class="tag tag-blue"><?php echo $list_articles[$i]['categorie'] ?></span></a>
                        <h2>
                            <?php echo $list_articles[$i]['titre'] ?>
                        </h2>
                        <p>
                            <?php echo $list_articles[$i]['article'] ?>
                        </p>
                        <div class="user">
                            <img src="https://studyinbaltics.ee/wp-content/uploads/2020/03/3799Ffxy.jpg" alt="user" />
                            <div class="user-info">
                                <h5><?php echo $list_articles[$i]['login'] ?></h5>
                                <small><?php echo $list_articles[$i]['date'] ?></small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
<?php
        }
    }
}
?>