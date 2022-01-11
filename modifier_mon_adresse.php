<?php
include "./head.php";
include "./header.php";
include "./function.php";

session_start();

if (isset($_POST["modif_adresse"])) {
  modifier_adresse();
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
    <h3 class="text-center">Modifier mon adresse : </h3>


    <form class="w-50 mx-auto" action="modifier_mon_adresse.php" method="post">
      <div class="mb-3 mt-5">
        <label for="adresse" class="form-label">Adresse : </label>
        <input required type="text" class="form-control" name="adresse" value="<?php echo $_SESSION["adresse"]["adresse"] ?>">
      </div>
      <div class="mb-3">
        <label for="cp" class="form-label">Code postal : </label>
        <input required type="text" class="form-control" name="cp" value="<?php echo $_SESSION["adresse"]["code_postal"] ?>">
      </div>
      <div class="mb-3 ">
        <label for="ville" class="form-label">Ville : </label>
        <input required type="text" class="form-control" name="ville" value="<?php echo $_SESSION["adresse"]["ville"] ?>">
      </div>


      <input type="hidden" name="modif_adresse" value="true">
      <button type="submit" class="btn btn-primary mb-5">Modifier</button>

    </form>

  </div>
</div>




<?php
include "./footer.php";
?>