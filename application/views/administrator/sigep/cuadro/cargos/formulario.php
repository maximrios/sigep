<?php
	$vcFormName = antibotHacerLlave();
	$vcMsjSrv = (!empty($vcMsjSrv))? $vcMsjSrv: '';
	$vcFrmAction = (!empty($vcFrmAction))? $vcFrmAction: '';
?>
<div class="forms">
	<?= $vcMsjSrv; ?>
<form id="<?= $vcFormName; ?>" name="<?= $vcFormName; ?>" action="<?= $vcFrmAction; ?>" method="post" target="contenido-abm">
	<li>
		<label>Denominacion del Cargo</label>
		<span>Ingrese la denominacion del Cargo</span>
		<input type="text" id="denominacionCargo" name="denominacionCargo" tabindex="1" placeholder="Denominacion del Cargo" value="<?php echo $Reg['denominacionCargo']?>">
	</li>
	<div class="buttons">
		<!--<button class="btn btn-primary">Guardar</button>-->
		<input type="submit" class="button guardar btn-accion<?= (empty($Reg['idCargo'])?' btn-reset':''); ?>" value="Guardar"/>
		<a href="cuadro/cargos/listado" id="btn-cancelar" class="button cancelar btn-accion">Cancelar</a>
	</div>
	<input type="hidden" id="idCargo" name="idCargo" value="<?php echo $Reg['idCargo']?>">
	<input type="hidden" id="vcForm" name="vcForm" value="<?= $vcFormName; ?>" />
</form>
</div>
