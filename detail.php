<?php
include "./header.php";
include "./function.php";
session_start();
?>
<html>

<body>


  <div class="container-fluid">

    <div class="row">
      <div class="col-12 mb-5">
        <div class="detail_image">


        </div>

      </div>
    </div>

  </div>

  <!--Détails-->

  <?php

  $id_article = $_POST["articleId"];
  $article = recuperer_article_db($id_article);

  echo '



<div class="card m-5">
<img src="./images/' . $article['image'] . '" class="card-img-top w-25 mx-auto" alt="...">
  <div class="card-body">
  
<h5 class="card-title m-5 text-center">' . $article['nom'] . '</h5>

    <p class="card-text m-5 w-75 text-center mx-auto">' . $article['description_detaillee'] . '</p>
    <p class="card-text m-5 w-75 text-center mx-auto">' . $article['prix'] . '€' . '</p>
  </div>
</div>';

  ?>

  <div class="container">
    <div class="row">



    </div>

  </div>

</body>

</html>










<?php
include "./footer.php";
?>