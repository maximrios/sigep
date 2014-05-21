<?php
	$vcFormName = antibotHacerLlave();
	$vcMsjSrv = (!empty($vcMsjSrv))? $vcMsjSrv: '';
	$vcFrmAction = (!empty($vcFrmAction))? $vcFrmAction: '';
?>
<div class="forms">
	<?= $vcMsjSrv; ?>
<form id="<?= $vcFormName; ?>" name="<?= $vcFormName; ?>" action="<?= $vcFrmAction; ?>" method="post" target="contenido-abm">
	<li>
		<label>Nombre de la encuesta</label>
		<span>Ingrese un nombre para identificar la encuesta</span>
		<input type="text" id="nombreOposicion" name="nombreOposicion" tabindex="1" placeholder="Nombre de la encuesta" value="<?php echo $Reg['nombreOposicion']?>">
	</li>
	<li>
		<label>Descripcion de la encuesta</label>
		<span>Ingrese una breve descripcion de la encuesta, el objetivo de la encuesta, a quienes va dirigida, porque? etc...</span>
		<textarea id="descripcionOposicion" name="descripcionOposicion" tabindex="2"><?php echo $Reg['descripcionOposicion']?></textarea>
	</li>
	<li class="medio">
		<label>Fecha de Inicio</label>
		<span>Fecha de inicio de publicación de la encuesta.</span>
		<input class="fecha" type="text" id="inicioOposicion" name="inicioOposicion" tabindex="3" placeholder="dd-mm-yyyy" value="<?php echo $Reg['inicioOposicion']?>">
	</li>
	<li class="medio">
		<label>Fecha de Fin</label>
		<span>Fecha de fin de publicación de la encuesta.</span>
		<input class="fecha" type="text" id="finOposicion" name="finOposicion" tabindex="4" placeholder="dd-mm-yyyy" value="<?php echo $Reg['finOposicion'];?>"<?php echo classRegValidation('finOposicion');?> >
	</li>
	<li>
		<label>Estado de la encuesta</label>
		<span>Seleccione el estado de la encuesta.</span>
		<?php echo form_dropdown('idOposicionEstado', $estados, $Reg['idOposicionEstado']);?>
	</li>
	<div class="buttons">
		<input type="submit" id="probar" class="btn btn-primary guardar btn-accion<?= (empty($Reg['idOposicion'])?' btn-reset':''); ?>" value="Guardar"/>
	</div>
	<input type="hidden" id="idOposicion" name="idOposicion" value="<?php echo $Reg['idOposicion']?>">
	<input type="hidden" id="vcForm" name="vcForm" value="<?= $vcFormName; ?>" />
</form>
</div>