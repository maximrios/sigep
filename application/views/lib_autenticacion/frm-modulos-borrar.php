<?php
/**
 * 
 *
 * @author Silvia Farfan
 * @version 1.0.0
 * @copyright 2011-12
 * @package base
 */
$vcMsjSrv = (!empty($vcMsjSrv))? $vcMsjSrv: '';
$vcNombreFrm = (!empty($vcNombreFrm))? $vcNombreFrm: 'Módulo';
$vcAccion = (!empty($vcAccion))? $vcAccion: 'Agregar';
$vcFormName = antibotHacerLlave();
$vcFrmAction = (!empty($vcFrmAction))? $vcFrmAction: '';
?>
	<span class="ico-subtitulo herramientas-30">&nbsp;</span>
	<h2 class="fontface-arimo-subtitulo"><?= ($vcAccion. '&nbsp;'. $vcNombreFrm); ?></h2>
	<div class="forms readonly">
	<?= $vcMsjSrv; ?>   
	<form id="<?= $vcFormName; ?>" name="<?= $vcFormName; ?>" action="<?= $vcFrmAction; ?>" method="post" target="contenido-abm">
	<div class="buttons">
			<input type="submit" class="button guardar btn-accion" value="Eliminar" name="Eliminar"/>
	    	<a href="autenticacion/modulos/listado" id="btn-cancelar" class="button cancelar btn-accion">Cancelar</a>
	    </div>       
	    <div class="clearfloat">&nbsp;</div>
	    <input type="hidden" id="inIdModulo" name="inIdModulo" value="<?= $Reg['inIdModulo']; ?>" />
	    <input type="hidden" id="vcForm" name="vcForm" value="<?= $vcFormName; ?>" />
	</form>		
        <fieldset>            
            	<div class="clearfloat">&nbsp;</div>    
            	<?= $vcMsjSrv; ?>
            	<?= $vcGridView;?>            
		</fieldset> 
		<br/>  	
	</div>
	<script type="text/javascript">
		$(document).ready(function(){            
           
            $(".container-gridview tbody tr:first").attr('style','background-color: #444444;color:#ffffff;');                   

		});
	</script>