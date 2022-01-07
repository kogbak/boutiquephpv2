<?php // ** connexion à la base de données OK**

include "head.php";

function getConnection()
{
    try {
        $db = new PDO(
            'mysql:host=localhost;dbname=boutique_en_ligne;charset=utf8',
            'root',
            '',
            array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC)
        );
    } catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }
    return $db;
}





function liste_article()
{

    $db = getConnection();
    $query = $db->query("SELECT `id`,`image`,`nom`,`description`, `prix` FROM `articles`");
    return $query->fetchAll();
}


function recuperer_article_db($id)
{

    $db = getConnection();
    $result = $db->prepare("SELECT `id`,`image`,`nom`,`description_detaillee`, `prix` FROM `articles` WHERE `id`=?");
    $result->execute([$id]);
    return $result->fetch();
}


function recuperer_gammes()
{


    $db = getConnection();
    $query = $db->query("SELECT * FROM `gammes`");
    return $query->fetchAll();
}

function article_gammes($id_gamme)
{
    $db = getConnection();
    $result = $db->prepare("SELECT `id`,`image`,`nom`,`description`, `prix` FROM `articles` WHERE `id_gamme`=?");
    $result->execute([$id_gamme]);
    return $result->fetchAll();
}


function afficher_gammes()
{

    echo '<div class="text-center m-5"><h1>Nos Gammes :</h1></div>';
    $gammes = recuperer_gammes();



    foreach ($gammes as $gamme) {


        echo '<div class="bg-primary text-white mb-5 mt-2"><h3 class="text-center">' . $gamme["nom"] . '</h3></div>';

        $articles = article_gammes($gamme["id"]);

        afficher_articles($articles);
    }
}



function afficher_articles($liste_articles)
{



    foreach ($liste_articles as $article) {

        echo '<div class="card mx-auto col-md-4 mb-5" style="width: 22rem;">
  <img src="./images/' . $article['image'] . '" class="card-img-top" alt="...">
  <div class="card-body">
    <h5 class="card-title">' . $article['nom'] . '</h5>
    <p class="card-text">' . $article['description'] . '</p>
    


    <form action="panier.php" method="post">
    <button type="submit" class="btn btn-primary text-center mb-3">Ajouter au panier</button>
    <input type="hidden" name="articleId" value=' . $article['id'] . '> 
    </form>

    <form action="detail.php" method="post">
    <button type="submit" class="btn btn-secondary ">+ de détail</button>
    <input type="hidden" name="articleId" value=' . $article['id'] . '> 
    </form>

  </div>
</div>';
    }
}
// enregistrer LES INFORMATIONS INSCRIPTION DES CLIENT !!!!!!!!!!!!!!!!!! 

function inscription()
{

    $db = getConnection(); // 1) connexion à la base

    if (verifier_champs_libre()) { // 2) vérif champs vides (créer autre fonction et l'appeler)

        return;
    } else {


        if (verifier_longueur_champs()) { // 3) si pas de champs vides : vérifier longueur des champs (via autre fonction)

            return;
        } else {

            if (!verifier_mot_de_passe()) { // 4) si ok : vérifier si le passeword est sécurisé (via autre fonction)

                echo "Le format de votre mot de passe est incorrect";
                return;
            } else {


                $mot_de_passe = password_hash($_POST["mdp"], PASSWORD_DEFAULT);

                //5) si ok : hasher le mot de passe (via password_hash) et inscrire l'utilisateur en base via une requête (dans la table clients)


                $result = $db->prepare("INSERT INTO `clients`(`nom`,`prenom`,`email`,`mot_de_passe`) VALUES (?,?,?,?)");
                $result->execute([
                    $_POST["nom"],
                    $_POST["prenom"],
                    $_POST["email"],
                    $mot_de_passe
                ]);


                //En plus++) verifier id_client avant d'ajouter adresse

                $id = $db->lastInsertId();

                // 6) insérer son adresse dans la table adresses via une autre requête

                $result_adresse = $db->prepare("INSERT INTO `adresses`(`id_client`,`adresse`,`code_postal`,`ville`) VALUES (?,?,?,?)");
                $result_adresse->execute([
                    $id,
                    $_POST["adresse"],
                    $_POST["cp"],
                    $_POST["ville"]
                ]);

                // 7) Afficher une alert
                echo "<script>alert(\"Inscription validé ! \")</script>";
            }
        }
    }
}


function verifier_champs_libre()
{

    $champ_vide = FALSE;
    $message = "";


    foreach ($_POST as $champ => $saisie) {

        if (empty($saisie)) {
            $message .= "Vous n'avez pas rempli le champ " . $champ . "<br>";

            $champ_vide = TRUE;
        }
    }

    echo $message;
    return $champ_vide;
}

// VERIFIER LONGUER CHAMPS !!!!!!!!!!!!!!!!!! 


function verifier_longueur_champs()
{

    $nom = $_POST["nom"];
    $prenom = $_POST["prenom"];
    $email = $_POST["email"];
    $adresse = $_POST["adresse"];
    $cp = $_POST["cp"];
    $ville = $_POST["ville"];

    $champ_trop_long = FALSE;



    if (strlen($nom) > 25 || strlen($nom < 3)) {
        echo '<div class="erreur">Votre Nom est trop grand</div>';
        $champ_trop_long = TRUE;
    }

    if (strlen($prenom) > 25 || strlen($prenom < 3)) {
        echo '<div class="erreur">Votre Prénom est trop grand</div>';
        $champ_trop_long = TRUE;
    }

    if (strlen($email) > 40 || strlen($email < 3)) {
        echo '<div class="erreur">Votre Adresse mail est trop grand</div>';
        $champ_trop_long = TRUE;
    }

    if (strlen($adresse) > 40 || strlen($adresse < 3)) {
        echo '<div class="erreur">Votre Adresse mail est trop grand</div>';
        $champ_trop_long = TRUE;
    }

    if (strlen($cp) !== 5) {
        echo '<div class="erreur">Erreur dans le code postale</div>';
        $champ_trop_long = TRUE;
    }

    if (strlen($ville) > 25 || strlen($ville < 3)) {
        echo '<div class="erreur">Votre ville est trop grand</div>';
        $champ_trop_long = TRUE;
    }



    return $champ_trop_long;
}


function verifier_mot_de_passe()
{

    $regex = "^(?=.*[0-9])(?=.*[a-zA-Z])(?=.*[@$!%*?/&])(?=\S+$).{8,15}$^";
    $mot_de_passe = $_POST["mdp"];

    return preg_match($regex, $mot_de_passe);
}


// ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^


// FONCTION CONNEXION !




function connexion()
{



    $db = getConnection();

    $query = $db->prepare("SELECT * FROM `clients` WHERE `email`=?");
    $query->execute([$_POST['email']]);
    $info_client = $query->fetch();


    if (!$info_client) {

        echo "Erreur dans l'adresse mail";
        return;
    } else {

        if (!password_verify($_POST["mdp"], $info_client["mot_de_passe"])) {


            echo "Erreur dans le mot de passe";
        } else {


            $query = $db->prepare("SELECT * FROM `adresses` WHERE `id_client`=?");
            $query->execute([$info_client["id"]]); // J'AI PAS TROP COMPRIS !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
            $adresse = $query->fetchAll();

            $_SESSION["client"] = $info_client;
            $_SESSION["adresses"] = $adresse;
            echo "Bonjour " . $info_client["prenom"] . " ,vous êtes connecté";
        }
    }
}



function recuperer_article($id_rechercher)
{

    $liste_article = liste_article();

    foreach ($liste_article as $article) {

        if ($id_rechercher == $article["id"]) {

            return $article;
        }
    }
}



// AJOUT d'article dans le panier


function ajouter_panier($article)
{
    for ($i = 0; $i < count($_SESSION['panier']); $i++) {

        if ($_SESSION['panier'][$i]['id'] == $article['id']) {
            echo "<script> alert('Article déjà présent dans le panier !');</script>";
            return;
        }
    }

    $article['quantite'] = 1;
    array_push($_SESSION['panier'], $article);
}



// affichage du style panier 



function contenue_panier($page_name)
{

    foreach ($_SESSION["panier"] as $article) {

        echo '



<div class="container ">

<div class="row bg-secondary mt-5 mb-5 text-white">

<div class="col-2  mx-auto text-center">
<img src="./images/' . $article['picture'] . '" class="w-25" alt="...">
</div>

<div class="col-2 mx-auto text-center ">
<h5 class="">' . $article['name'] . '</h5>
</div>

<div class="col-2 mx-auto text-center ">

<h5 class="">' . $article['description'] . '</h5>
</div>
<div class="col-2 mx-auto text-center ">

<h5 class="">' . $article['price'] . '</h5>
</div>


<div class="col-2">

<form action="' . $page_name . '" method="post">
    
    <input class="mx-auto " type="number" name="quantite" value=' . $article['quantite'] . '> 

    <input type="hidden" name="articleId2" value=' . $article['id'] . '>

    <button type="submit" class="btn btn-primary text-center mx-auto mt-2">Modifier quantite</button>
    </form> 
  
<form action="' . $page_name . '" method="post">

<input type="hidden" name="supprimer_article_id" value=' . $article['id'] . '>

<button type="submit">supprimer</button>
</form> 

</div>

</div>
</div>






';
    }
}


function modifier_quantite($quantite, $id_produit)
{ //boucler sur le panier, 

    for ($i = 0; $i < count($_SESSION["panier"]); $i++) {

        if ($id_produit == $_SESSION["panier"][$i]["id"]) {

            $_SESSION["panier"][$i]["quantite"] = $quantite;
        }
    }
}



function supprime_article($id_supprimer)
{

    for ($i = 0; $i < count($_SESSION["panier"]); $i++) {

        if ($id_supprimer == $_SESSION["panier"][$i]["id"]) {
            array_splice($_SESSION["panier"], $i, 1);
            return;
        }
    }
}


function vider_totalement_le_panier()
{

    $_SESSION["panier"] = [];
    echo "<script> alert(\"panier totalement vide !\")</script>";
}

function prix_total_panier()
{

    $prix = 0;

    for ($i = 0; $i < count($_SESSION["panier"]); $i++) {

        $prix += $_SESSION["panier"][$i]["quantite"] * $_SESSION["panier"][$i]["price"];
    }

    return $prix;
}


function afficher_le_total()
{


    echo 'Total = ' . number_format(prix_total_panier(), 2, " , ", " ") . '€';
}


function total_frais_de_port()
{

    $quantite = 0;

    for ($i = 0; $i < count($_SESSION["panier"]); $i++) {

        $quantite += $_SESSION["panier"][$i]["quantite"];
    }

    return $quantite * 5;
}


function afficher_le_total_avec_frais_de_port()
{
    $frais_de_port =  total_frais_de_port();
    echo 'frais de port = ' . number_format($frais_de_port, 2, " , ", " ") . '€ <br>';
    echo 'Total = ' . number_format(prix_total_panier() + $frais_de_port, 2, " , ", " ") . '€';
}


// FONCTION POUR MODIFIER MES INFORMATION 

function modifier_informations(){

    
}
