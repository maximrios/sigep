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
$vcFrmAction = (!empty($vcFrmAction)) ? $vcFrmAction : '';
?>
<span class="ico-subtitulo mensajes-30">&nbsp;</span>
<h2 class="fontface-arimo-subtitulo"><?= ($vcAccion . '&nbsp;' . $vcNombreFrm); ?></h2>
<div class="forms">
    <?= $vcMsjSrv; ?>
    <form id="<?= $vcFormName; ?>" name="<?= $vcFormName; ?>" action="<?= $vcFrmAction; ?>" method="post" target="contenido-abm">
        <fieldset>
            <div class="fila">
                <label for="inIdTemaFaq">Tema</label>
                <?= form_dropdown('inIdTemaFaq', $rsTemas, $Reg['inIdTemaFaq'], 'id="inIdTemaFaq" class="'.classRegValidation('inIdTemaFaq').'"'); ?>
            </div>
            <div class="fila">
                <label for="tsFecPublicacion">Publicaci&oacute;n:</label>
                <input type="text" name="tsFecPublicacion" id="tsFecPublicacion" value="<?= $Reg['tsFecPublicacion']; ?>"<?= classRegValidation('tsFecPublicacion') ?> placeholder="dd/mm/aaaa"/>
            </div>
            <div class="clearfloat">&nbsp;</div>	
            <div class="fila">
                <label for="vcPregunta">Pregunta:</label>
                <textarea name="vcPregunta" id="vcPregunta"<?= classRegValidation('vcPregunta') ?> style="width: 450px; height: 70px; resize: none;"><?= $Reg['vcPregunta']; ?></textarea>
            </div>
            <div class="clearfloat">&nbsp;</div>
            <div class="fila">
                <label for="vcRespuesta">Respuesta:</label>
                <textarea name="vcRespuesta" id="vcRespuesta"<?= classRegValidation('vcRespuesta') ?> style="width: 450px; height: 150px; resize: none;"><?= $Reg['vcRespuesta']; ?></textarea>
            </div>
            <div class="clearfloat">&nbsp;</div>
            <div class="fila">
                <label for="inIdOrden">Orden:</label>
                <input type="text" name="inIdOrden" id="inIdOrden" value="<?=$Reg['inIdOrden'];    ?>"<?= classRegValidation('inIdOrden')    ?> />
            </div>
            <div class="clearfloat">&nbsp;</div>
            <div class="fila">
                <label for="bActivo">Activo:</label> 
                <input name="bActivo" type="checkbox" id="bActivo" value="bActivo" <?= classRegValidation('bActivo')    ?> <?= ((bool)$Reg['bActivo'] == 't') ?  'checked="true"' : ''; ?> />
            </div>
            <div class="clearfloat">&nbsp;</div>
        </fieldset>
        <br/>
        <div class="buttons">
            <input type="submit" class="button guardar btn-accion <?= (empty($Reg['inIdFaq'])) ? 'btn-reset' : '' ; ?>" value="Guardar"/>
            <a href="autenticacion/faq/listado" id="btn-cancelar" class="button cancelar btn-accion">Cancelar</a>
        </div>
        <div class="clearfloat">&nbsp;</div>
        <input type="hidden" id="inIdFaq" name="inIdFaq" value="<?= $Reg['inIdFaq']; ?>" />
        <input type="hidden" id="vcForm" name="vcForm" value="<?= $vcFormName; ?>" />
    </form>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $('#<?= $vcFormName; ?> select:first').focus();
    });
</script>
