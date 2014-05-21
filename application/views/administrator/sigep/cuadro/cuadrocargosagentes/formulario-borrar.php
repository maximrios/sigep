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
        </fieldset><?php
    $vcFormName = antibotHacerLlave();
    $vcMsjSrv = (!empty($vcMsjSrv))? $vcMsjSrv: '';
    $vcFrmAction = (!empty($vcFrmAction))? $vcFrmAction: '';
?>
<div class="forms">
    <?= $vcMsjSrv; ?>
<form id="<?= $vcFormName; ?>" name="<?= $vcFormName; ?>" action="<?= $vcFrmAction; ?>" method="post" target="contenido-abm">
    <li>
        <label>Cuadro</label>
        <span>Instrumento Legal</span>
        <input type="text" id="instrumentoCuadro" name="instrumentoCuadro" tabindex="1" placeholder="Instrumento Legal" value="<?php echo $Reg['instrumentoCuadro']?>" readonly>
    </li>
    <li>
        <label>Orden</label>
        <span>Numero de Orden</span>
        <input type="text" id="ordenCuadroCargo" name="ordenCuadroCargo" tabindex="1" placeholder="Número de orden" value="<?php echo $Reg['ordenCuadroCargo']?>">
    </li>
    <li>
        <label>Area</label>
        <span>Ingrese el nombre de la Gerencia o Area operativa</span>
        <input type="text" id="nombreEstructura" name="nombreEstructura" tabindex="1" placeholder="Nombre de Area" value="<?php echo $Reg['nombreEstructura']?>">
    </li>
    <li>
        <label>Cargo</label>
        <span>Ingrese el nombre del cargo</span>
        <input type="text" id="denominacionCargo" name="denominacionCargo" tabindex="1" placeholder="Denominación del Cargo" value="<?php echo $Reg['denominacionCargo']?>">
    </li>
    <li>
        <label>Datos del cargo</label>
        <span>Datos de la estructura de cargo</span>
        <select id="idEscalafon" name="idEscalafon">
            <option value="0">Seleccione un item ...</option>
            <option value="01">01</option>
            <option value="02">02</option>
        </select>
        <select class="mini" id="idAgrupamiento" name="idAgrupamiento" size="1">
            <option value="0">Seleccione un item ...</option>
            <option value="1">P</option>
            <option value="2">A</option>
            <option value="3">M</option>
        </select>
        <select class="mini" id="idFuncion" name="idFuncion" size="1">
            <option value="0">Seleccione un item ...</option>
            <option value="1">P1</option>
            <option value="2">P2</option>
            <option value="3">P3</option>
            <option value="4">P4</option>
            <option value="5">A1</option>
            <option value="6">A2</option>
        </select>
    </li>
    <div class="buttons">
        <!--<button class="btn btn-primary">Guardar</button>-->
        <input type="submit" class="button guardar btn-accion<?= (empty($Reg['idCargo'])?' btn-reset':''); ?>" value="Guardar"/>
    </div>
    <input type="hidden" id="idCuadroCargo" name="idCuadroCargo" value="<?php echo $Reg['idCuadroCargo']?>">
    <input type="hidden" id="idCuadro" name="idCuadro" value="<?php echo $Reg['idCuadro']?>">
    <input type="hidden" id="idEstructura" name="idEstructura" value="<?php echo $Reg['idEstructura']?>">
    <input type="hidden" id="idCargo" name="idCargo" value="<?php echo $Reg['idCargo']?>">
    <input type="hidden" id="vcForm" name="vcForm" value="<?= $vcFormName; ?>" />
</form>
</div>
<script>
    $("#nombreEstructura").autocomplete({
        source: "cuadro/cuadrocargos/obtenerAutocomplete",
        select: function(event, ui){
            $('#idEstructura').val(ui.item.id);
        }
    });
    $("#denominacionCargo").autocomplete({
        source: "cuadro/cuadrocargos/obtenerAutocompleteCargos",
        select: function(event, ui){
            $('#idCargo').val(ui.item.id);
        }
    });
</script>

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
