<?php
include "./head.php";
include "./header.php";
include "./function.php";
session_start();
?>

<div class="container"> 

<div class="row">

<html>

<form class="w-50 mx-auto" action="index.php" method="post">
  <div class="mb-3 mt-5">
    <label for="nom" class="form-label">Nom: </label>
    <input required type="text" class="form-control" name="nom">
  </div>
  <div class="mb-3">
    <label for="prenom" class="form-label">Prénom: </label>
    <input required type="text" class="form-control" name="prenom">
  </div>
  <div class="mb-3 ">
    <label for="Email" class="form-label">Adresse email: </label>
    <input required type="email" class="form-control" name="email" aria-describedby="emailHelp">
    <div id="emailHelp" class="form-text">L'email n'est pas correcte</div>
  </div>
  <div class="mb-3">
    <label for="Password" class="form-label">Mot de passe: </label>
    <small id="emailHelp" class="form-text text-muted">Entre 8 et 15 caractères, minimum 1 lettre, 1 chiffre et 1 caractère spécial</small>
    <input required type="password" class="form-control" name="mdp">
  </div>
  <div class="mb-3">
    <label for="adresse" class="form-label">Adresse: </label>
    <input required type="text" class="form-control" name="adresse">
  </div>
  <div class="mb-3">
    <label for="code_postale" class="form-label">Code Postal: </label>
    <input required type="text" class="form-control" name="cp">
  </div>
  <div class="mb-3">
    <label for="ville" class="form-label">Ville: </label>
    <input required type="text" class="form-control" name="ville">
  </div>
  <div class="mb-3 form-check">
    <input required type="checkbox" class="form-check-input" id="exampleCheck1">
    <label class="form-check-label" for="exampleCheck1">Accepter les conditions d'utilisation</label>
  </div>
  <button type="submit" class="btn btn-primary mb-5">Inscription</button>
  <input type="hidden" name="bouton_inscription" value="true">
</form>


</div>
</div>
</html>



<?php
include "./footer.php";
?>