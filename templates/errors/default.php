<?php require_once _ROOTPATH_.'/templates/header.php'; ?>


<?php if($error) { ?>   <!-- création d'un template error, qui se chargera dès qu'il y a une erreur -->
                        <!-- donc s'il y a bien un message d'erreur, il affiche la div avec le message d'erreur -->
    <div class="alert alert-danger"> <!-- classe Bootstrap -->
        <?=$error; ?>
    </div>
<?php } ?>


<?php require_once _ROOTPATH_.'/templates/footer.php'; ?>