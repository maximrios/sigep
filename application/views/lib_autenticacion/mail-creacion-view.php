<?=$sistema?> 

Estimado/a <?=$persona?>:

Le informamos que su cuenta de Usuario ha sido creada y esta lista para ser usada.

Por favor lea atentamente la siguiente informacion la cual sera necesaria para acceder al sistema y efectuar operaciones con el mismo.

 *Usuario: <?=$usuario?> 
 *Contraseña: <?=$contrasenia?> 
<?php if (config_item('asunto_pin_enabled')): ?>
 *PIN: <?=$pin?> 
<?php endif; ?>

Para ingresar al sistema haga clic en el siguiente enlace:
<a href="<?= $vcUrlSitio ?>"><?= $vcUrlSitio ?></a> 

<?= $vcContenidoEmailPie?>