<?php
include "./head.php";
include "./header.php";
include "./function.php";
session_start();
?>

<div class="container-fluid">

    <div class="row">
        <div class="col-12 mb-5">
            <div class="detail_image">
            </div>
        </div>
    </div>
</div>

<div class="container mx-auto">

    <div class="row">


        <?php


if(isset($_POST["informations"])){

}?>

<h3 class="text-center">Modifier mes informations</h3>


<form class="w-50 mx-auto" action="index.php" method="post">
  <div class="mb-3 mt-5">
    <label for="nom" class="form-label">Nom: </label>
    <input required type="text" class="form-control" name="nom" value=" <?php $_SESSION["nom"] ?> "> 
  </div>
  <div class="mb-3">
    <label for="prenom" class="form-label">Prénom: </label>
    <input required type="text" class="form-control" name="prenom">
  </div>
  <div class="mb-3 ">
    <label for="Email" class="form-label">Adresse email: </label>
    <input required type="email" class="form-control" name="email" aria-describedby="emailHelp">
  </div>

  
  <button type="submit" class="btn btn-primary mb-5">Valider</button>
  <input type="hidden" name="bouton_valider" value="true">
</form>


    </div>
</div>




<?php
include "./footer.php";
?>