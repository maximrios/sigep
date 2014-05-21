<?php
/**
 * @author Nacho Fassini
 * @version 1.0.0
 * @copyright 2011-12
 * @package base
 */
$vcMsjSrv = (!empty($vcMsjSrv)) ? $vcMsjSrv : '';
$vcNombreFrm = (!empty($vcNombreFrm)) ? $vcNombreFrm : 'Tema de Preguntas Frecuentes';
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
            <div class="clearfloat">&nbsp;</div>
            <div class="fila">
                <label for="vcTemaFaq">Tema</label>
                <textarea name="vcTemaFaq" id="vcTemaFaq"<?= classRegValidation('vcTemaFaq') ?> style="width: 450px; height: 35px; resize: none;"><?= $RegTema['vcTemaFaq']; ?></textarea>
            </div>
            <div class="clearfloat">&nbsp;</div>  
            <div class="fila">
                <label for="vcTemaDesc">Descripcion:</label>
                <textarea name="vcTemaDesc" id="vcTemaDesc"<?= classRegValidation('vcTemaDesc') ?> style="width: 450px; height: 90px; resize: none;"><?= $RegTema['vcTemaDesc']; ?></textarea>
            </div>
            <div class="clearfloat">&nbsp;</div>           
            <div class="fila">
                <label for="inIdOrden">Orden:</label>
                <input type="text" name="inIdOrden" id="inIdOrden" value="<?= $RegTema['inIdOrden']; ?>"<?= classRegValidation('inIdOrden')?> />
            </div>
            <div class="clearfloat">&nbsp;</div>
            <div class="fila">
                <label for="bActivo">Activo:</label> 
                <input name="bActivo" type="checkbox" id="bActivo" value="bActivo" <?= classRegValidation('bActivo') ?><?= ((bool)$RegTema['bActivo'] == 't') ?  'checked="true"' : ''; ?> />
            </div>
        </fieldset>
        <br/>
        <div class="buttons">
            <input type="submit" class="button guardar btn-accion <?= (empty($RegTema['inIdTemaFaq'])) ? 'btn-reset' : '' ; ?>" value="Guardar"/>
            <a href="autenticacion/faq/listadoTemas" id="btn-cancelar" class="button cancelar btn-accion">Cancelar</a>
        </div>
        <div class="clearfloat">&nbsp;</div>
        <input type="hidden" id="inIdTemaFaq" name="inIdTemaFaq" value="<?= $RegTema['inIdTemaFaq']; ?>" />
        <input type="hidden" id="vcForm" name="vcForm" value="<?= $vcFormName; ?>" />
    </form>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $('#vcTemaFaq').focus();
    });
</script>
