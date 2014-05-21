<?php
/**
 * 
 *
 * @author Silvia Farfan
 * @version 1.0.0
 * @copyright 2011-12
 * @package
 */
$vcMsjSrv = (!empty($vcMsjSrv))? $vcMsjSrv: '';
$vcNombreFrm = (!empty($vcNombreFrm))? $vcNombreFrm: 'Módulo';
$vcAccion = (!empty($vcAccion))? $vcAccion: 'Agregar';
$vcFormName = antibotHacerLlave();
$vcFrmAction = (!empty($vcFrmAction))? $vcFrmAction: '';
?>
	<span class="ico-subtitulo herramientas-30">&nbsp;</span>
	<h2 class="fontface-arimo-subtitulo"><?= ($vcAccion. '&nbsp;'. $vcNombreFrm); ?></h2>
	<div class="forms">
	<?= $vcMsjSrv; ?>    
	<form id="<?= $vcFormName; ?>" name="<?= $vcFormName; ?>" action="<?= $vcFrmAction; ?>" method="post" target="contenido-abm">
		<fieldset>
            <div class="fila">
		        <label for="inIdModuloPadre">Módulo Padre:</label>
                <?php 
                      $aNodPadre = array(''=>'Seleccione...') + $aNodPadre;
                      $sValidacion = 'id="inIdModuloPadre" '.classRegValidation('vcModNombre'); 

                      echo form_dropdown('inIdModuloPadre', $aNodPadre, $Reg['inIdModuloPadre'], $sValidacion);
                ?>                                                      		       	
		    </div>
            <div class="clearfloat"></div>
		    <div class="fila">
		        <label for="vcModNombre">Nombre del Módulo: </label>
		       	<input type="text" name="vcModNombre" id="vcModNombre" value="<?= $Reg['vcModNombre']; ?>" <?=classRegValidation('vcModNombre')?> style="width: 250px;"/>
		    </div>
		   	<div class="fila">
		        <label for="vcModTitulo">Titulo del módulo:</label>
		       	<input type="text" name="vcModTitulo" id="vcModTitulo" value="<?= $Reg['vcModTitulo']; ?>" <?=classRegValidation('vcModTitulo')?> style="width: 375px;"/>
		    </div>
            <div class="clearfloat"></div>
		    <div class="fila">
		        <label for="vcModCod">Dirección Url del módulo:</label>
		       	<input type="text" name="vcModUrl" id="vcModUrl" value="<?= $Reg['vcModUrl']; ?>" <?=classRegValidation('vcModUrl')?> style="width: 250px;"/>
		    </div>    	
            <div class="fila">
		        <label for="boModEsMenu">Pertenece al menú: </label>
                
                <div class="radioFloat">
                    <input type="radio" id="boModEsMenuSi" name="boModEsMenu" value="1" style="margin: 10px;" <?=($Reg['boModEsMenu'] != 0 ? 'checked="checked"' : '')?>/>
                    <label for="boModEsMenuSi">SI</label>
    
                    <input type="radio" id="boModEsMenuNo" name="boModEsMenu" value="0" style="margin: 10px;" <?=($Reg['boModEsMenu'] == 0 ? 'checked="checked"' : '')?>/>
                    <label for="boModEsMenuNo">No</label>
                    <div class="clearfloat"></div>
                </div>                           		       	
		    </div>            
	        <div class="clearfloat">&nbsp;</div>
            <input type="hidden" id="inIdModulo" name="inIdModulo" value="<?= $Reg['inIdModulo']; ?>" />
	        <input type="hidden" id="vcForm" name="vcForm" value="<?= $vcFormName; ?>" />
		</fieldset>
		<br/>	
        <div class="buttons">
			<input type="submit" class="button guardar btn-accion<?= (empty($Reg['inIdModulo'])?' btn-reset':''); ?>" value="Guardar"/>
	    	<a href="autenticacion/modulos/listado" id="btn-cancelar" class="button cancelar btn-accion">Cancelar</a>
	    </div>
	    <div class="clearfloat">&nbsp;</div>	    
	</form>
	</div>
	<script type="text/javascript">
		$(document).ready(function(){
			$('#<?= $vcFormName; ?> input:first').focus();

		});
	</script>