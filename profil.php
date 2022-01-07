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

<h3 class="text-center">Mon compte</h3>

<!--PREMIER FORMULAIRE-->

<div class="col-md-3 mt-5 text-center">
<i class="fas fa-user mb-3 fa-3x"></i>


<form action="modifier_mes_informations.php" method="post">
<button type="submit" class="btn btn-primary mb-5">Modifier mes informations</button>
<input type="hidden" name="informations" value="true">
</form>
</div>

<!--DEUXIEME FORMULAIRE-->
<div class="col-md-3 mt-5 text-center">
<i class="fas fa-key mb-3 fa-3x"></i>



<form action="modifier_mon_mot_de_passe.php" method="post">
<button type="submit" class="btn btn-primary mb-5">Modifier mon mot de passe</button>
<input type="hidden" name="mot_de_passe" value="true">
</form>
</div>

<!--TROIZIEME FORMULAIRE-->
<div class="col-md-3 mt-5 text-center ">
<i class="fas fa-home mb-3 fa-3x"></i>



<form action="modifier_mon_adresse" method="post">
<button type="submit" class="btn btn-primary mb-5">Modifier mon adresse</button>
<input type="hidden" name="adresses" value="true">
</form>
</div>

<!--QUATRIEME FORMULAIRE-->
<div class="col-md-3 mt-5 text-center">
<i class="fas fa-th-list mb-3 fa-3x"></i>



<form action="voir_mes_commandes.php" method="post">
<button type="submit" class="btn btn-primary mb-5">Voir mes commandes</button>
<input type="hidden" name="commandes" value="true">
</form>
</div>

<?php



?>


</div>
</div>




<?php
include "./footer.php";
?>