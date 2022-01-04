<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0/css/all.min.css">
<?php


function liste_article()
{

    return [
        [
            'name' => 'Zenbook S UX393EA-HK001T',
            'id' => 1,
            'price' => 1454,
            'description' => 'Un ultraportable élégant',
            'detailedDescription' => 'Avec son Zenbook S UX393EA-HK001T, Asus repousse encore un peu plus loin les limites des PC Portables. L\'écran de ce nouveau Zenbook est en effet tout simplement bluffant et saisissant avec sa résolution 3K et son format non conventionnel de 3:2. Mais il ne s\'arrête pas là pour vous surprendre : charnière Ergolift et pavé tactile Numpad sont aussi présents pour faire de cet UX393 un véritable condensé de technicité et d\'innovation. Côté configuration, performance et polyvalence sont au rendez-vous pour ce PC portable avec un processeur i7 Tiger Lake, 16 Go de RAM et stockage SSD grosse capacité.',
            'picture' => 'asus.png'
        ],

        [
            'name' => 'Huawei MateBook X Pro 2021',
            'id' => 2,
            'price' => 1899,
            'description' => 'Un ultraportable premium',
            'detailedDescription' => 'L\'ordinateur portable HUAWEI MateBook X Pro 2021 est un laptop de 13.9 pouces avec un écran Fullview 3K et un processeur Intel de 11e génération. Avec son fini métallique, il pèse environ 1.3 kg et mesure 14.6 mm d\'épaisseur.',
            'picture' => 'huawei.jpeg'
        ],

        [
            'name' => 'Acer Swift 5 SF514-55T-71NL',
            'id' => 3,
            'price' => 2299,
            'description' => 'Un ultraportable, endurant',
            'detailedDescription' => 'La situation actuelle exige un nouveau type d\'ordinateur portable avec des solutions antimicrobiennes complètes (le châssis et l\'écran tactile en verre antimicrobien. Option en fonction du modèle. Corning® Gorilla® 4). Avec un poids d\'environ 1 kg1, une épaisseur de 14,95 mm1 et un rapport écran/châssis incroyable de 90 %, il est également doté des tout derniers processeurs Intel® Core™ de 11e génération 1, d\'une puissante carte graphique NVIDIA® GeForce® MX3501 et affiche jusqu\'à 17 heures d\'autonomie',
            'picture' => 'acer.png'
        ]

    ];
}

function afficher_article()
{

    $liste_article = liste_article();

    foreach ($liste_article as $article) {

        echo '<div class="card mx-auto col-md-4 mb-5" style="width: 18rem;">
  <img src="./images/' . $article['picture'] . '" class="card-img-top" alt="...">
  <div class="card-body">
    <h5 class="card-title">' . $article['name'] . '</h5>
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
