<?php
/**
 * @author Nacho Fassini
 * @version 1.0.0
 * @copyright 2011-12
 * @package base
 */
$vcMsjSrv = (!empty($vcMsjSrv)) ? $vcMsjSrv : '';
$vcNombreFrm = (!empty($vcNombreFrm)) ? $vcNombreFrm : 'Cargos';
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
                <label for="inIdFaq">Denominacion del Cargo</label>
                <input type="text" name="denominacionCargo" id="denominacionCargo" value="<?= $Reg['denominacionCargo']; ?>" style="width: 150px;"/>
            </div>
            <div class="clearfloat">&nbsp;</div>
        </fieldset>
        <br/>
        <div class="buttons">
            <input type="submit" class="button guardar btn-accion <?= (empty($Reg['idCargo'])) ? 'btn-reset' : '' ; ?>" value="Eliminar"/>
            <a href="cuadro/cargos/listado" id="btn-cancelar" class="button cancelar btn-accion">Cancelar</a>
        </div>
        <div class="clearfloat">&nbsp;</div>
        <input type="hidden" id="idCargo" name="idCargo" value="<?= $Reg['idCargo']; ?>" />
        <input type="hidden" id="vcForm" name="vcForm" value="<?= $vcFormName; ?>" />
    </form>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $('#<?= $vcFormName; ?> input:first').focus();
    });
</script>
