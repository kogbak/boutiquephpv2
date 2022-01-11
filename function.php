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

        echo

        '<div class="card mx-auto col-md-4 mb-5" style="width: 22rem;">
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

            if (!verifier_mot_de_passe($_POST["mdp"])) { // 4) si ok : vérifier si le passeword est sécurisé (via autre fonction)

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


function verifier_mot_de_passe($mot_de_passe)
{

    $regex = "^(?=.*[0-9])(?=.*[a-zA-Z])(?=.*[@$!%*?/&])(?=\S+$).{8,15}$^";
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
            $query->execute([$info_client["id"]]);
            $adresse = $query->fetch();
            $_SESSION["client"] = $info_client;
            $_SESSION["adresse"] = $adresse;
            echo '<script>alert("Vous êtes connecté !")</script>';
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



function afficher_panier($page_name)
{

    foreach ($_SESSION["panier"] as $article) {

        echo '



<div class="container">

<div class="row mt-5 mb-5 text-black mx-auto my-auto shadow rounded-2 p-4">

<div class="col-2 mx-auto text-center">
<img src="./images/' . $article['image'] . '" class="w-75" alt="...">
</div>

<div class="col-2 mx-auto text-center ">
<h5 class="">' . $article['nom'] . '</h5>
</div>

<div class="col-2 mx-auto text-center ">

<h5 class="">' . $article['description'] . '</h5>
</div>
<div class="col-2 mx-auto text-center ">

<h5 class="">' . $article['prix'] . '</h5>
</div>


<div class="col-2">

<form action="' . $page_name . '" method="post">
    
    <input class="mx-auto " type="number" name="quantite" value=' . $article['quantite'] . '> 

    <input type="hidden" name="articleId2" value=' . $article['id'] . '>

    <button type="submit" class="btn btn-primary text-center mx-auto mt-3">Modifier quantité</button>
    </form> 
  
<form action="' . $page_name . '" method="post">

<input type="hidden" name="supprimer_article_id" value=' . $article['id'] . '>

<button type="submit" class="mt-3 btn btn-warning">supprimer</button>
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

        $prix += $_SESSION["panier"][$i]["quantite"] * $_SESSION["panier"][$i]["prix"];
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
    echo 'Total = ' . number_format(total_general(), 2, " , ", " ") . '€';
}

function total_general()
{

    return prix_total_panier() + total_frais_de_port();
}


// FONCTION POUR MODIFIER MES INFORMATION 

function modifier_informations()
{


    if (!verifier_champs_libre()) {



        $db = getConnection();
        $result = $db->prepare('UPDATE clients SET prenom = :prenom, nom = :nom, email = :email WHERE id = :id');
        $result->execute(array(
            'prenom' =>  $_POST["prenom"],
            'nom' => $_POST["nom"],
            'email' => $_POST["email"],
            'id' => $_SESSION["client"]["id"]
        ));


        $_SESSION["client"]["prenom"] = $_POST["prenom"];
        $_SESSION["client"]["nom"] = $_POST["nom"];
        $_SESSION["client"]["email"] = $_POST["email"];

        echo "<script> alert(\"Vos modification on étaient validé!\")</script>";
    }
}

// FONCTION POUR MODIFIER ADRESSSSSSSSSSSSE

function modifier_adresse()
{

    if (!verifier_champs_libre()) {



        $db = getConnection();
        $result = $db->prepare('UPDATE adresses SET adresse = :adresse, code_postal = :cp, ville = :ville WHERE id_client = :id');
        $result->execute(array(
            'adresse' =>  $_POST["adresse"],
            'cp' => $_POST["cp"],
            'ville' => $_POST["ville"],
            'id' => $_SESSION["adresse"]["id_client"]
        ));


        $_SESSION["adresse"]["adresse"] = $_POST["adresse"];
        $_SESSION["adresse"]["code_postal"] = $_POST["cp"];
        $_SESSION["adresse"]["ville"] = $_POST["ville"];

        echo "<script> alert(\"L'adresse à était modifier avec succes !\")</script>";
    }
}


// DECONNEXION!!!!!!!!!!!!!!!!!!!!!!!!!


function deconnexion()
{

    $_SESSION = [];

    echo "<script> alert(\"Vous avez bien était déconnecté !\")</script>";
}


// CREATION NOUVEEEEEEEEEAAAAAU MOT DE PASSSSSSSSSSSSSE

function modifier_mot_de_passe()
{

    if (!verifier_champs_libre()) {

        $mot_de_passe = $_SESSION["client"]["mot_de_passe"];

        if (!password_verify($_POST["mdp_actuel"], $mot_de_passe)) {

            echo 'Le mot de passe actuel que vous avez saisie est incorrect, veuillez réessayer';
        } else {

            $nouveau_mot_de_passe = strip_tags($_POST["nouveau_mdp"]);

            if (!verifier_mot_de_passe($nouveau_mot_de_passe)) {

                echo 'Erreur : Le mot de passe ne correspond pas à la securité demandé, veuillez réessayer';
            } else {

                $nouveau_mot_de_passe = password_hash($nouveau_mot_de_passe, PASSWORD_DEFAULT);



                $db = getConnection();
                $result = $db->prepare('UPDATE clients SET mot_de_passe = :mdp WHERE id = :id');
                $result->execute(array(
                    'mdp' =>  $nouveau_mot_de_passe,
                    'id' => $_SESSION["client"]["id"],

                ));

                $_SESSION["client"]["mot_de_passe"] = $nouveau_mot_de_passe;


                echo "<script> alert('mot de passe modifié avec succés !')</script>";
            }
        }
    }
}


// Fonction afficher information avec modification ou on le souhaite


function afficher_modif_infos($nom_de_la_page)
{

    echo '
    <div class="container mx-auto">
    <div class="row">
  
      
  
      <form class="w-50 mx-auto" action="' . $nom_de_la_page . '" method="post">
        <div class="mb-3 mt-5">
          <label for="nom" class="form-label">Nom: </label>
          <input required type="text" class="form-control" name="nom" value="' . $_SESSION["client"]["nom"] . ' ">
        </div>
        <div class="mb-3">
          <label for="prenom" class="form-label">Prénom: </label>
          <input required type="text" class="form-control" name="prenom" value="' . $_SESSION["client"]["prenom"] . '">
        </div>
        <div class="mb-3 ">
          <label for="Email" class="form-label">Adresse email: </label>
          <input required type="email" class="form-control" name="email" aria-describedby="emailHelp" value="' . $_SESSION["client"]["email"] . '">
        </div>
  
        <input type="hidden" name="modif_infos" value="true">
        <button type="submit" class="btn btn-primary mb-5">Modifier</button>
      </form>
    </div>
  </div>';

    // Fonction afficher adresse avec modification ou on le souhaite


    function afficher_modif_adresse($nom_de_la_page)
    {

        echo '
    <div class="container mx-auto">
    <div class="row">
     
  
  
      <form class="w-50 mx-auto" action="' . $nom_de_la_page . '" method="post">
        <div class="mb-3 mt-5">
          <label for="adresse" class="form-label">Adresse : </label>
          <input required type="text" class="form-control" name="adresse" value="' . $_SESSION["adresse"]["adresse"] . '">
        </div>
        <div class="mb-3">
          <label for="cp" class="form-label">Code postal : </label>
          <input required type="text" class="form-control" name="cp" value="' . $_SESSION["adresse"]["code_postal"] . '">
        </div>
        <div class="mb-3 ">
          <label for="ville" class="form-label">Ville : </label>
          <input required type="text" class="form-control" name="ville" value="' . $_SESSION["adresse"]["ville"] . '">
        </div>
  
  
        <input type="hidden" name="modif_adresse" value="true">
        <button type="submit" class="btn btn-primary mb-5">Modifier</button>
  
      </form>
  
    </div>
  </div>';
    }
}

function sauvegarder_la_commande()
{

    $db = getConnection();
    $commande = $db->prepare("INSERT INTO commandes (id_client, numero, date_commande, prix) VALUES( :id_client, :numero, :date_commande, :prix)");
    $commande->execute([
        "id_client" => $_SESSION["client"]["id_client"],
        "numero" => rand(1000000, 9999999),
        "date_de_commande" => date("Y,m,d h:i:s"),
        "prix" => total_general()
    ]);


    $db = getConnection();
    $query = $db->prepare("SELECT * FROM commandes WHERE id_client = :id");
    return $query->execute($_SESSION["client"]["id_client"]);


    foreach ($_SESSION["panier"] as $articles) {



        $db = getConnection();
        $articles = $db->prepare("INSERT INTO commande_articles (id_article, quantite) VALUES( :id_article, :quantite)");
        $articles->execute([
            "id_article" => $_SESSION["id"],
            "quantite" => $_SESSION["quantite"],
        ]);
    }
}
