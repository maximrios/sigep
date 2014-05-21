<?php
/**
 * @author Rios Maximiliano Ezequiel
 * @version 1.0.0
 * @copyright 2014
 * @package base
 */
$vcGridView = (!empty($vcGridView))? $vcGridView: '';
$vcNombreList = (!empty($vcNombreList))? $vcNombreList: 'Agentes';
$vcMsjSrv = (!empty($vcMsjSrv))? $vcMsjSrv: '';
?>
<a href="administrator/pases/formulario/<?=$idActuacion?>" id="btn-nuevo" class="btn btn-primary btn-accion"><i class="icon-ok icon-white"></i>&nbsp;&nbsp;Agregar Nuevo</a>
	<?= $vcMsjSrv; ?>
	<?= $vcGridView; ?>