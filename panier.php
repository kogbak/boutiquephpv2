
<?php

session_start();
include "./head.php";
include "./function.php";
include "./header.php";

if (isset($_POST['articleId'])){
$id_article = $_POST["articleId"];
$article = recuperer_article($id_article);

ajouter_panier($article);

}

if (isset($_POST['quantite'])){
modifier_quantite($_POST['quantite'], $_POST["articleId2"]);


}


if (isset($_POST['supprimer_article_id'])){
supprime_article($_POST['supprimer_article_id']);
}

if (isset($_POST['vider_panier'])){
    vider_totalement_le_panier();
}



echo
'<h3 class="text-center mt-5 mb-5">Recapitulatif de votre commande</h3>';

contenue_panier("panier.php");





?>



<div class="container">

<div class="row justify-content-center mb-5">

<?php
    
afficher_le_total();

?>

</div>
</div>




<form class="text-center mb-2" action="panier.php" method="post">

<button class="btn btn-danger" name="vider_panier" type="submit">Vider panier</button>

</form> 


<div class="text-center">
<a href="validation.php"><button class="btn btn-primary mb-5">ajouter-condition-Validation</button></a>
</div>






<?php


include "./footer.php";

?>