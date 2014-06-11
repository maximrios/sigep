<?php
/**
 * @author Maximiliano Ezequiel Rios
 * @version 1.0.0
 * @copyright 2013
 * @package sigepv1
 */
$vcGridView = (!empty($vcGridView))? $vcGridView: '';
$vcNombreList = (!empty($vcNombreList))? $vcNombreList: 'Cargos';
$vcMsjSrv = (!empty($vcMsjSrv))? $vcMsjSrv: '';
?>
<a href="administrator/cuadrocargos/formulario" id="btn-nuevo" class="btn btn-primary btn-accion"><span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;Agregar Nuevo Cargo</a>
<?= $vcMsjSrv; ?>
<?= $vcGridView; ?>