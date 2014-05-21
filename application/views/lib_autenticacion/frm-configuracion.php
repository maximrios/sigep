<?php
/**
 * 
 *
 * @author Marcelo Gutierrez
 * @version 1.0.0
 * @copyright 2011-12
 * @package base30
 */
$vcMsjSrv = (!empty($vcMsjSrv))? $vcMsjSrv: '';
$vcNombreFrm = (!empty($vcNombreFrm))? $vcNombreFrm: 'Configuración';
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
			<?php
            if (is_array($config)){
				foreach ($config as $clave => $valor){
				    if (is_array($valor)){
        				foreach ($valor as $clave2 => $valor2){
        				    $clave3 = 'arr_'.$clave.'_arr_'.$clave2;
        					echo '<div class="fila">';
        					echo '<label for="'.$clave3.'">'.str_replace('_', ' ', $titulo[$clave][$clave2]).':</label>';
                            getInputConfig($clave3, $valor2);
        					echo '</div>';
        				}
				    } else {
    					echo '<div class="fila">';
    					echo '<label for="'.$clave.'">'.str_replace('_', ' ', $titulo[$clave]).':</label>';
    					getInputConfig($clave, $valor);
    					echo '</div>';
				    }
				}
			}
            ?>		    		   
	        
		</fieldset>
		<br/>
		<div class="buttons">
			<input type="submit" class="button guardar btn-accion" value="Guardar"/>
	    	<a href="autenticacion/configuracion/ver" id="btn-cancelar" class="button cancelar btn-accion">Cancelar</a>
	    </div>
	    <div class="clearfloat">&nbsp;</div>
	    <input type="hidden" id="vcForm" name="vcForm" value="<?= $vcFormName; ?>" />
	</form>
	</div>
	<script type="text/javascript">
		$(document).ready(function(){
			$('#<?= $vcFormName; ?> input:first').focus();

		});
	</script>