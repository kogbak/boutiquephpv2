<?php
session_start();
include "./head.php";
include "./header.php";
include "./function.php";

if(isset($_POST["modif_mdp"])){
  modifier_mot_de_passe();
    
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

<h3 class="text-center">Modifier mon mot de passe : </h3>

<form class="w-50 mx-auto" action="modifier_mon_mot_de_passe.php" method="post">
<div class="mb-3 mt-5">
    <label for="ville" class="form-label">Mot de passe actuel : </label>
    <input required type="password" class="form-control" name="mdp_actuel" value="">
  </div>

  <div class="mb-3 mt-5">
    <label for="ville" class="form-label">Nouveau mot de passe : </label>
    <input required type="password" class="form-control" name="nouveau_mdp" value="">
    <small id="emailHelp" class="form-text text-muted">Entre 8 et 15 caractères, minimum 1 lettre, 1 chiffre et 1 caractère spécial</small>
  </div>

  
  <input type="hidden" name="modif_mdp" value="true">
  <button type="submit" class="btn btn-primary mb-5">Modifier</button>
  
</form>

</div>
</div>




<?php
include "./footer.php";
?>