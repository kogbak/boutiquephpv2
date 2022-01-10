<?php
session_start();
include "./head.php";
include "./header.php";
include "./function.php";


if(isset($_POST["modif_infos"])){
modifier_informations();
}
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



?>

<h3 class="text-center">Modifier mes informations</h3>


<form class="w-50 mx-auto" action="modifier_mes_informations.php" method="post">
  <div class="mb-3 mt-5">
    <label for="nom" class="form-label">Nom: </label>
    <input required type="text" class="form-control" name="nom" value="<?php echo $_SESSION["client"]["nom"]?>"> 
  </div>
  <div class="mb-3">
    <label for="prenom" class="form-label">Prénom: </label>
    <input required type="text" class="form-control" name="prenom" value="<?php echo $_SESSION["client"]["prenom"]?>">
  </div>
  <div class="mb-3 ">
    <label for="Email" class="form-label">Adresse email: </label>
    <input required type="email" class="form-control" name="email" aria-describedby="emailHelp"value="<?php echo $_SESSION["client"]["email"]?>">
  </div>

  
  <input type="hidden" name="modif_infos" value="true">
  <button type="submit" class="btn btn-primary mb-5">Modifier</button>
  
</form>



    </div>
</div>




<?php
include "./footer.php";
?>