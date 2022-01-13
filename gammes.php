<?php
session_start();
include "./head.php";
include "./header.php";
include "./function.php";
?>

<div class="container">
    <div class="row">
        <?php
        afficher_gammes();
        ?>
    </div>
</div>

<?php
include "./footer.php";
?>


