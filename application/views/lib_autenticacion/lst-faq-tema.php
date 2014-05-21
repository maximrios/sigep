<?php
/**
 * @author  Nacho Fassini
 * @version 1.0.0
 * @copyright 2011-12
 * @package base
 */
$vcGridView = (!empty($vcGridView)) ? $vcGridView : '';
$btGuardar = (!empty($btGuardar)) ? $btGuardar : '';
$btCancelar = (!empty($btCancelar)) ? $btCancelar : '';
$vcGridView = (!empty($vcGridView)) ? $vcGridView : '';
$vcNombreList = (!empty($vcNombreList)) ? $vcNombreList : 'Temas';
//$vcFormName = antibotHacerLlave();
$vcMsjSrv = (!empty($vcMsjSrv)) ? $vcMsjSrv : '';
?>
<div class="box-layout-50-rt">
    <div class="toolbar-rgt-sb" style="margin-bottom: 10px">
        <div class="toolbar-rgt-sb-der">
            <div style="margin-top: 30px;">
                <a href="autenticacion/faq/listadoTemasEditar" id="btn-editar-tema" title="Editar el orden de los temas" class="button editar btn-accion" >Editar Orden</a>
                <a href="autenticacion/faq/formularioTema" id="btn-nuevo" title="Agregar Tema" class="button agregar btn-accion">Agregar Tema</a>
            </div>        
        </div>
        <div class="clearfloat">&nbsp;</div>
    </div>
</div>
<div class="box-layout-50-lt">
    <span class="ico-subtitulo temas-30">&nbsp;</span>
    <h2 class="fontface-arimo-subtitulo box-layout-titulo">Listado de <?= $vcNombreList; ?></h2>
</div>
<div class="clearfloat">&nbsp;</div>
<?= $vcMsjSrv; ?>
<?= $vcGridView; ?>
<div class="buttons">
    <?= $btGuardar; ?>
    <?= $btCancelar; ?>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        //$('.btn-accion').viaAjax();
        $('#lnkGuardar').one( 'click' ,function(){
            var aPOST = '';
            var cnct = '';
            $('select[name=inIdOrden]').each(function(){
                aPOST += cnct + $(this).attr('id');
                aPOST += ','  + ($(this).val());
                aPOST += ','  + ($('input[type=checkbox][id='+$(this).attr('id')+'][name=bActivo]').is(':checked')?1:0);
                cnct = '|';
            });
            $('#contenido-abm').viaAjax('send', {'type': 'POST','url': 'autenticacion/faq/guardarTemasEditar','vars': 'cnct='+aPOST});
        });
    });
</script>