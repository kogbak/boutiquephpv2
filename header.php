<?php
include "./head.php";

?>

<!--TITRE-->

<div class="container">
  <div class="row">
    <div class="col-12  text-center mt-3 mb-3">
      <h1 class="fw-bold">La Boutique</h1>
      <div class="row">
        <div class="col-12 text-center">
        <h2>ORDI ULTRA</h2>
        </div>
      </div>
    </div>
  </div>
</div>

<!--NAVBAR-->

<nav class="navbar navbar-expand-lg navbar-light bg-light ">
  <div class="container-fluid">
    
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav mx-auto">
        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="index.php">Acceuil</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="gammes.php">Gammes</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="panier.php">Panier</a>
        </li>

        </li>
        <?php 
        
        if(!isset($_SESSION["client"]["id"])){
        
        echo'
        <li class="nav-item">
          <a class="nav-link" href="connexion.php">Connexion</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="inscription.php">Inscription</a>
        </li>
        
        ';
      }else{
        echo'
        <li class="nav-item">
          <a class="nav-link" href="profil.php">Profil</a>
        </li>
        <li class="nav-item">

          <form method="POST" action="index.php" class="nav-link">
          <input type="hidden" name="deconnexion" >
          <input type="submit" value="Déconnexion" style="color: red; border:none; background:none; border-bottom: solid 1px;">
          </form>
          
        </li>
        
        ';
}
      
      
      
      ?>
        
        
        
      </ul>
    </div>
  </div>
</nav>






