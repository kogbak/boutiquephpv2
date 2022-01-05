<?php // ** connexion à la base de données OK**

function getConnection()
{
    try {
        $db = new PDO(
            'mysql:host=localhost;dbname=boutique_en_ligne;charset=utf8',
            'ben2679',
            'Bobo7994260894,',
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


function recuperer_article_db($id){

    $db = getConnection();
    $result = $db->prepare("SELECT `id`,`image`,`nom`,`description_detaillee`, `prix` FROM `articles` WHERE `id`=?");
    $result->execute([$id]);
    return $result->fetch();
}



function afficher_article()
{

    $liste_article = liste_article();

    foreach ($liste_article as $article) {

        echo '<div class="card mx-auto col-md-4 mb-5" style="width: 22rem;">
  <img src="./images/' . $article['image'] . '" class="card-img-top" alt="...">
  <div class="card-body">
    <h5 class="card-title">' . $article['nom'] . '</h5>
    <p class="card-text">' . $article['description'] . '</p>
    


    <form action="panier.php" method="post">
    <button type="submit" class="btn btn-primary text-center">Ajouter au panier</button>
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
