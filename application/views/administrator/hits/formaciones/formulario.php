<?php
	$vcFormName = antibotHacerLlave();
	$vcMsjSrv = (!empty($vcMsjSrv))? $vcMsjSrv: '';
	$vcFrmAction = (!empty($vcFrmAction))? $vcFrmAction: '';
?>
	<?=$vcMsjSrv; ?>
	<form id="<?=$vcFormName;?>" name="<?=$vcFormName;?>" action="<?=$vcFrmAction;?>" method="post" target="contenido-abm" enctype="multipart/form-data">
        <div class="form-group col-lg-6">
            <label for="idNivel">Agente</label>
            <?=form_dropdown('idPersona', $agentes, $Reg['idPersona'], 'class="form-control"');?>
        </div>
        <div class="form-group col-lg-6">
            <label for="idNivel">Nivel de Estudio Max. Alcanzado</label>
            <?=form_dropdown('idNivel', $niveles, $Reg['idNivel'], 'class="form-control"');?>
        </div>
    	<div class="form-group col-lg-6">
    		<label for="idTitulo">Titulo</label>
			<?=form_dropdown('idTitulo', $titulos, $Reg['idTitulo'], 'class="form-control"');?>
    	</div>
        <div class="form-group col-lg-6">
            <label for="idTitulo">Avance</label>
            <?=form_dropdown('idAvance', $avances, $Reg['idAvance'], 'class="form-control"');?>
        </div>
        <div class="col-lg-12">
            <input id="btnnuevo" type="submit" class="btn btn-primary btn-accion pull-right" value="Guardar"/>    
        </div>
		<input type="hidden" id="idFormacion" name="idFormacion" value="<?=$Reg['idFormacion']?>">
		<input type="hidden" id="vcForm" name="vcForm" value="<?= $vcFormName; ?>" />
    </form>