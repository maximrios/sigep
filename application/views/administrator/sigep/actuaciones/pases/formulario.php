<?php
	$vcFormName = antibotHacerLlave();
	$vcMsjSrv = (!empty($vcMsjSrv))? $vcMsjSrv: '';
	$vcFrmAction = (!empty($vcFrmAction))? $vcFrmAction: '';
?>
    <div class="panel panel-default">
        <div class="panel-heading">Información de Actuación <?=$actuacion['codigoActuacion']?></div>
        <div class="panel-body">
            <?php if($actuacion['referenciaActuacion'] != '') { ?>
                <span class="col-lg-5">Tipo: Externa</span>
                <span class="col-lg-7">Referencia: <?=$actuacion['referenciaActuacion']?></span>    
            <?php } 
            else { ?>
                <span class="col-lg-12">Tipo: Interna</span>
            <?php } ?>
            <span class="col-lg-5">Tipo de Actuación: <?=$actuacion['nombreActuacionTipo']?></span>
            <span class="col-lg-7">Tema de Actuación: <?=$actuacion['nombreActuacionTema']?></span>
            <span class="col-lg-12">N° de Actuación: <?=$actuacion['codigoActuacion']?></span>
            <span class="col-lg-12">Iniciado por: <?=$actuacion['nombreIniciador']?></span>
        </div>
    </div>

	<?=$vcMsjSrv; ?>
	<form id="<?=$vcFormName;?>" name="<?=$vcFormName;?>" action="<?=$vcFrmAction;?>" method="post" target="contenido-abm" enctype="multipart/form-data">
    	<div class="form-group col-lg-12">
    		<label for="nombreOrigen">Remitente</label>
			<input type="text" id="nombreOrigen" name="nombreOrigen" tabindex="1" class="form-control" placeholder="Nombre del Area de Origen." value="<?=$Reg['nombreOrigen']?>" readonly>
    	</div>
        <div class="form-group col-lg-12">
            <label for="idDestino">Destino</label>
            <?=form_dropdown('idDestino', $mesas, $Reg['idDestino'], 'tabindex="2" class="form-control"');?>
        </div>
        <div class="form-group col-lg-1">
            <label for="foliosActuacionPase">Folios</label>
            <input type="text" id="foliosActuacionPase" name="foliosActuacionPase" tabindex="3" class="form-control" value="<?=$actuacion['foliosActuacion']?>">
        </div>
    	<div class="form-group col-lg-12">
    		<label for="observacionActuacionPase">Observaciones</label>
            <textarea id="observacionActuacionPase" name="observacionActuacionPase" class="form-control" placeholder="Observaciones" rows="3"><?=$Reg['observacionActuacionPase']?></textarea>
    	</div>
        <div class="col-lg-12">
            <input id="btnnuevo" type="submit" class="btn btn-primary btn-accion pull-right" value="Guardar"/>    
        </div>
		<input type="hidden" id="idActuacion" name="idActuacion" value="<?=$actuacion['idActuacion']?>">
        <input type="hidden" id="idOrigen" name="idOrigen" value="<?=$Reg['idOrigen']?>">
        <input type="hidden" id="idUsuario" name="idUsuario" value="<?=$Reg['idUsuarioOrigen']?>">
		<input type="hidden" id="vcForm" name="vcForm" value="<?= $vcFormName; ?>" />
    </form>
