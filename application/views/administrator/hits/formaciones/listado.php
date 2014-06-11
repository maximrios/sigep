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
<a href="administrator/formaciones/formulario" id="btn-nuevo" class="btn btn-primary btn-accion"><span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;Agregar Nueva Formacion</a>
	<?= $vcMsjSrv; ?>
	<?= $vcGridView; ?>