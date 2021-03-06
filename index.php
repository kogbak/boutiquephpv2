<head>
  <?php
  include "./head.php";
  include "./function.php";
  session_start();

  if (!isset($_SESSION["panier"])) {
    $_SESSION["panier"] = [];
  }

  if (isset($_POST['commande-valide'])) {
    sauvegarder_la_commande();
    vider_totalement_le_panier();
  }

  if (isset($_POST["bouton_inscription"])) {
    inscription();
  }


  if (isset($_POST["bouton_connexion"])) {
    connexion();
  }


  if (isset($_POST["deconnexion"])) {
    deconnexion();
  } ?>
</head>
<header>

  <?php
  include "./header.php"
  ?>
</header>

<body>

  <div class="container-fluid">
    <div class="row">
      <div class="col-12 mb-5">
        <div class="accueil_image"></div>
      </div>
    </div>
  </div>

  <!--LES CARDS-->

  <section>

    <div class="container">
      <div class="row">

        <?php
        afficher_articles(liste_article());
        ?>

      </div>
    </div>

  </section>
</body>

<?php
include "./footer.php"
?>

</html>