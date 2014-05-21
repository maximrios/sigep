<?php
	$vcFormName = antibotHacerLlave();
	$vcMsjSrv = (!empty($vcMsjSrv))? $vcMsjSrv: '';
	$vcFrmAction = (!empty($vcFrmAction))? $vcFrmAction: '';
?>
<div class="forms">
	<?= $vcMsjSrv; ?>
<form id="<?= $vcFormName; ?>" name="<?= $vcFormName; ?>" action="<?= $vcFrmAction; ?>" method="post" target="contenido-abm">
	<li>
		<label>Nombre del Curso</label>
		<span>Ingrese el nombre del Curso</span>
		<input type="text" id="nombreCurso" name="nombreCurso" tabindex="1" placeholder="Ingrese el nombre completo del curso" value="<?php echo $Reg['nombreCurso']?>">
	</li>
	<li class="medio">
		<label>Fecha de Inicio</label>
		<span>Fecha de inicio del curso.</span>
		<input class="fecha" type="text" id="fechaInicioCurso" name="fechaInicioCurso" tabindex="3" placeholder="dd-mm-yyyy" value="<?php echo $Reg['fechaInicioCurso']?>">
	</li>
	<li class="medio">
		<label>Fecha de Fin</label>
		<span>Fecha de finalizacion del curso.</span>
		<input class="fecha" type="text" id="fechaFinCurso" name="fechaFinCurso" tabindex="4" placeholder="dd-mm-yyyy" value="<?php echo $Reg['fechaFinCurso'];?>"<?php echo classRegValidation('fechaFinCurso');?> >
	</li>
	<li>
		<label>Comisiones</label>
		<span>Selecciona la cantidad de comisiones.</span>
		<select id="comisionesCurso" name="comisionesCurso">
			<option value="1">1</option>
			<option value="2">2</option>
			<option value="3">3</option>
		</select>
	</li>
	<li>
		<label>Organismo</label>
		<span>Ingrese el nombre del organismo a cargo.</span>
		<input type="text" id="nombreOrganismo" name="nombreOrganismo" tabindex="1" placeholder="Nombre del organismo" value="">
	</li>
	<li>
		<label><a href="capacitacion/cursos/comisiones" id="agregarComision">Agregar Comisin</a></label>
	</li>
	<div class="buttons">
		<!--<button class="btn btn-primary">Guardar</button>-->
		<input type="submit" class="button guardar btn-accion<?= (empty($Reg['idCurso'])?' btn-reset':''); ?>" value="Guardar"/>
		<a href="administrator/noticias" id="btn-cancelar" class="button cancelar btn-accion">Cancelar</a>
	</div>
	<input type="hidden" id="idCurso" name="idCurso" value="<?php echo $Reg['idCurso']?>">
	<input type="hidden" id="vcForm" name="vcForm" value="<?= $vcFormName; ?>" />
</form>
</div>
<script>
	$('.fecha').datepicker({
		format: 'dd/mm/yyyy'
	});
	$('#agregarComision').on('click', agregarComision);
</script>
