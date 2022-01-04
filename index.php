<head>
  <?php
  include "./head.php";
  include "./function.php";
  session_start();
  ?>
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

        afficher_article();


        if (isset($_POST['commande-valide'])) {
          vider_totalement_le_panier();
        }


        ?>




      </div>


    </div>

  </section>


</body>

<?php

include "./footer.php"
?>

</html>