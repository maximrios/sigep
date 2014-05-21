<?=$sistema?> 

Estimado/a <?=$persona?>:

Le informamos que el cambio <?=$cambio?> con éxito

<?php if  ($pass>=0 ): ?>
*Su contraseña ahora es: <?=$pass?> 
<?php endif;?>
<?php if  ($pin>=0 and config_item('asunto_pin_enabled')): ?>
*Su Pin ahora es: <?=$pin?> 
<?php endif;?>

Para ingresar al sistema haga clic en el siguiente enlace:
<a href="<?= $vcUrlSitio ?>"><?= $vcUrlSitio ?></a>  

<?= $vcContenidoEmailPie?>