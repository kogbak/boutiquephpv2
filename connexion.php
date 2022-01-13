<?php
include "./head.php";
include "./header.php";
include "./function.php";
session_start();
?>

<div class="container"> 

<div class="row">
<form class="w-50 mx-auto" action="index.php" method="post">

  <div class="mb-3 mt-5 ">
    <label for="Email" class="form-label">Adresse email: </label>
    <input required type="email" class="form-control" name="email" aria-describedby="emailHelp">
    <div id="emailHelp" class="form-text">L'email n'est pas correcte</div>
  </div>
  <div class="mb-3">
    <label for="Password" class="form-label">Mot de passe: </label>
    <input required type="password" class="form-control" name="mdp">
  </div>

  <button type="submit" class="btn btn-primary mb-5">Connexion</button>
  <input type="hidden" name="bouton_connexion" value="true">
</form>
</div>
</div>

<?php
include "./footer.php";
?>