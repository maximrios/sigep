<?php
/**
 * @author Nacho Fassini
 * @version 1.0.0
 * @copyright 2011-12
 * @package base
 */
$vcMsjSrv = (!empty($vcMsjSrv)) ? $vcMsjSrv : '';
$vcNombreFrm = (!empty($vcNombreFrm)) ? $vcNombreFrm : 'Preguntas Frecuentes';
$vcAccion = (!empty($vcAccion)) ? $vcAccion : 'Agregar';
$vcFormName = antibotHacerLlave();
$vcFrmAction = (!empty($vcFrmAction)) ? $vcFrmAction : '';;
?>
<span class="ico-subtitulo mensajes-30">&nbsp;</span>
<h2 class="fontface-arimo-subtitulo"><?= ($vcAccion . '&nbsp;' . $vcNombreFrm); ?></h2>
<div class="forms readonly">
<?= $vcMsjSrv; ?>
    <form id="<?= $vcFormName; ?>" name="<?= $vcFormName; ?>" action="<?= $vcFrmAction; ?>" method="post" target="contenido-abm">
        <fieldset>
            <div class="fila">
                <label for="inIdFaq">Numero de Pregunta:</label>
                <input type="text" name="inIdFaq" id="inIdFaq" value="<?= $Reg['inIdFaq']; ?>" style="width: 150px;"/>
            </div>
            <div class="fila">
                <label for="tsFecPublicacion">Fecha de Publicaci&oacute;n:</label>
                <input type="text" name="tsFecPublicacion" id="tsFecPublicacion" value="<?= $Reg['tsFecPublicacion']; ?>" />
            </div>
            <div class="clearfloat">&nbsp;</div>
            <div class="fila">
                <label for="vcTemaFaq">Tema:</label>
                <input type="text" name="vcTemaFaq" id="vcTemaFaq" value="<?= $Reg['vcTemaFaq']; ?>" />
            </div>
            <div class="clearfloat">&nbsp;</div>
            <div class="fila">
                <label for="vcPregunta">Pregunta:</label>
                <textarea name="vcPregunta" id="vcPregunta" style="width: 450px; height: 150px; resize: none;"><?= $Reg['vcPregunta']; ?></textarea>
            </div>
            <div class="clearfloat">&nbsp;</div>  	
            <div class="fila">
                <label for="vcRespuesta">Respuesta:</label>
                <textarea name="vcRespuesta" id="vcRespuesta" style="width: 450px; height: 150px; resize: none;"><?= $Reg['vcRespuesta']; ?></textarea>
            </div>
            <div class="clearfloat">&nbsp;</div>
        </fieldset>
        <br/>
        <div class="buttons">
            <input type="submit" class="button guardar btn-accion <?= (empty($Reg['inIdFaq'])) ? 'btn-reset' : '' ; ?>" value="Eliminar"/>
            <a href="autenticacion/faq/listado" id="btn-cancelar" class="button cancelar btn-accion">Cancelar</a>
        </div>
        <div class="clearfloat">&nbsp;</div>
        <input type="hidden" id="inIdFaq" name="inIdFaq" value="<?= $Reg['inIdFaq']; ?>" />
        <input type="hidden" id="vcForm" name="vcForm" value="<?= $vcFormName; ?>" />
    </form>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $('#<?= $vcFormName; ?> input:first').focus();
    });
</script>
