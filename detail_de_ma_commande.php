<?php
session_start();
include "./head.php";
include "./header.php";
include "./function.php";
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
        if (isset($_POST["detail_commande"])) {

            detail_de_ma_commande($_POST["detail_commande"]);
        }
        ?>

    </div>
</div>

<?php
include "./footer.php";
?>