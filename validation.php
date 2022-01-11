<?php

session_start();
include "./head.php";
include "./function.php";
include "./header.php";



if (isset($_POST['quantite'])) {
    $quantite_article = $_POST['quantite'];

    modifier_quantite($_POST['quantite'], $_POST["articleId2"]);
}


if (isset($_POST['supprimer_article_id'])) {
    supprime_article($_POST['supprimer_article_id']);
}



if (isset($_POST["modif_infos"])) {

    modifier_informations();
}


if (isset($_POST["modif_adresse"])) {

    modifier_adresse();
}


afficher_panier("validation.php");

?>

<div class="container">

    <div class="row justify-content-center mb-5">

        <?php

        afficher_le_total();
        ?>


<!-- FRAIS DE LIVRAISON DOMICILE 10€ ET POINT RELAY 5€-->

        <form action="validation.php" method="POST">

        <div class="mb-3 form-check ">
            <input required type="checkbox" class="form-check-input" id="exampleCheck1" name="domicile">
            <label class="form-check-label" for="exampleCheck1">A domicile = 10€</label>
        </div>

        <div class="mb-3 form-check">
            <input required type="checkbox" class="form-check-input" id="exampleCheck1" name="point-relais">
            <label class="form-check-label" for="exampleCheck1">En point-relais = 5€</label>
        </div>
        </form>






        <div class="row justify-content-center mb-5">
            <?php
            afficher_le_total_avec_frais_de_port()
            ?>
        </div>
    </div>
</div>
<!-- AFFICHER ICI LA FUNCTION MODIFICATION INFORMATION AVEC LE BON POSTE-->


<?php
echo '<h3 class="text-center">Informations de commande</h3>';
afficher_modif_infos("validation.php");


echo '<h3 class="text-center">Informations de livraison</h3>';
afficher_modif_adresse("validation.php");
?>

<!-- AFFICHER ICI LA FUNCTION MODIFICATION ADRESSE AVEC LE BON POSTE (JE PENSE) -->


<!-- Button trigger modal -->
<button type="button" class="btn btn-primary d-flex justify-content-center mx-auto text-center mb-4" data-bs-toggle="modal" data-bs-target="#exampleModal">
    Valider
</button>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mx-auto" style="color: green;" id="exampleModalLabel">Votre commande à été validée</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">


                <div class="espace" style="line-height: 2.5;">
                    <?php

                    afficher_le_total_avec_frais_de_port();

                    echo "<br>" . " Elle sera expédié le : ";


                    setlocale(LC_TIME, 'fr_FR.utf8', 'fra');                      // passage au fuseau horaire français
                    $date = date("Y-m-d");                               // récupère date du jour (2021-12-23)
                    echo utf8_encode(strftime("%A %d %B %Y", strtotime($date . " + 2 days")));

                    echo "<br>" . " Livraison prévue le : ";

                    echo utf8_encode(strftime("%A %d %B %Y", strtotime($date . " + 5 days")));

                    echo "<br>" . " Merci pour votre confiance";


                    ?>

                </div>

            </div>
            <div class="modal-footer text-center mx-auto">

                <form action="index.php" method="POST">
                    <input type="hidden" name="commande-valide">
                    <button type="submit" class="btn btn-primary text-center mx-auto">Retour à l'acceuil</button>
                </form>

            </div>
        </div>
    </div>
</div>

<?php

include "./footer.php";

?>