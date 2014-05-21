<?php
	$vcFormName = antibotHacerLlave();
	$vcMsjSrv = (!empty($vcMsjSrv))? $vcMsjSrv: '';
	$vcFrmAction = (!empty($vcFrmAction))? $vcFrmAction: '';
?>
	<?=$vcMsjSrv; ?>
	<form id="<?=$vcFormName;?>" name="<?=$vcFormName;?>" action="<?=$vcFrmAction;?>" method="post" target="contenido-abm" enctype="multipart/form-data">
        <?php if($Reg['idActuacion']) { ?>
            <div class="form-group col-lg-12">
                <label for="numeroActuacion">N° interno de Actuación</label>
                <input type="text" id="numeroActuacion" name="numeroActuacion" class="form-control" value="<?=$Reg['numeroActuacion']?>" autofocus>
            </div>
        <?php } 
        else { ?>
            <div class="form-group col-lg-12">
                <label for="my-checkbox">Actuación</label><br>
                <input type="checkbox" class="form-control" name="my-checkbox" checked>
            </div>
        <?php } ?>
		<div class="form-group col-lg-5">
    		<label for="fechaCreacionActuacion">Fecha de Creación | Recepción</label>
			<input type="text" id="fechaCreacionActuacion" name="fechaCreacionActuacion" class="form-control" placeholder="Fecha de Recepción." value="<?=$Reg['fechaCreacionActuacion']?>">
    	</div>
        <div id="campoReferenciaActuacion" class="form-group col-lg-6">
            <label for="referenciaActuacion">N° de Referencia SICE</label>
            <input type="text" id="referenciaActuacion" name="referenciaActuacion" class="form-control" placeholder="Numero de Referencia SICE completo." value="<?=$Reg['referenciaActuacion']?>">
        </div>
        <div class="form-group col-lg-1">
            <label for="foliosActuacion">Folios</label>
            <input type="text" id="foliosActuacion" name="foliosActuacion" class="form-control" placeholder="N°" value="<?=$Reg['foliosActuacion']?>">
        </div>
        <div class="form-group col-lg-1">
            <label for="iudIniciador">I.U.D</label>
            <input type="text" id="iudIniciador" name="iudIniciador" tabindex="1" class="form-control" placeholder="0000" value="<?=$Reg['iudIniciador']?>">
        </div>
    	<div class="form-group col-lg-11">
    		<label for="nombreIniciador">Iniciador</label>
			<input type="text" id="nombreIniciador" name="nombreIniciador" tabindex="1" class="form-control" placeholder="Nombre de la Dependencia." value="<?=$Reg['nombreIniciador']?>">
    	</div>
    	<div class="form-group col-lg-6">
    		<label for="idActuacionTipo">Tipo de Actuacion</label>
			<?=form_dropdown('idActuacionTipo', $tipos, $Reg['idActuacionTipo'], 'class="form-control"');?>
    	</div>
    	<div class="form-group col-lg-6">
    		<label for="idActuacionTema">Tema</label>
			<?=form_dropdown('idActuacionTema', $temas, $Reg['idActuacionTema'], 'class="form-control"');?>
    	</div>
    	<div class="form-group col-lg-12">
    		<label for="caratulaActuacion">Carátula | Extracto</label>
            <textarea id="caratulaActuacion" name="caratulaActuacion" class="form-control" placeholder="Carátula" rows="5"><?=$Reg['caratulaActuacion']?></textarea>
    	</div>
        <div class="col-lg-12">
            <input id="btnnuevo" type="submit" class="btn btn-primary btn-accion pull-right" value="Guardar"/>    
        </div>
		<input type="hidden" id="idActuacion" name="idActuacion" value="">
        <input type="hidden" id="idActuacionEstado" name="idActuacionEstado" value="<?=$Reg['idActuacionEstado']?>">
        <input type="hidden" id="idIniciador" name="idIniciador" value="<?=$Reg['idIniciador']?>">
        <input type="hidden" id="iudEstructura" name="iudEstructura" value="<?=$this->lib_ubicacion->iudEstructura()?>">
        <input type="hidden" id="idEstructura" name="idEstructura" value="<?=$this->lib_ubicacion->idEstructura()?>">
        <input type="hidden" id="nombreEstructura" name="nombreEstructura" value="<?=$this->lib_ubicacion->nombreEstructura()?>">
        <input type="hidden" id="idUsuario" name="idUsuario" value="<?=$Reg['idUsuario']?>">
		<input type="hidden" id="vcForm" name="vcForm" value="<?= $vcFormName; ?>" />
    </form>
<script type="text/javascript">
    $('input[name="my-checkbox"]').bootstrapSwitch({
        onText: 'Ext',
        offText: 'Int',
    });
    $('input[name="my-checkbox"]').on('switchChange.bootstrapSwitch', function(event, state) {
        if(state.value == true) {
            $('#idIniciador').val('');
            $('#iudIniciador').val('');
            $('#iudIniciador').removeAttr('readonly');
            $('#nombreIniciador').val('');
            $('#nombreIniciador').removeAttr('readonly');
            $('#referenciaActuacion').removeAttr('readonly');
        }
        else {
            $('#idIniciador').val($('#idEstructura').val());
            $('#iudIniciador').val($('#iudEstructura').val());
            $('#iudIniciador').attr('readonly', 'readonly');
            $('#nombreIniciador').val($('#nombreEstructura').val());
            $('#nombreIniciador').attr('readonly', 'readonly');
            $('#referenciaActuacion').attr('readonly', 'readonly');
        }
    });
    $('#iudIniciador').on('change', function() {
        $.ajax({
            url:    'administrator/actuaciones/buscarMesa',
            type:   'post',
            data:   'iud='+$(this).val(),
            dataType: 'json',
            success: function(data) {
                if(data) {
                    $('#idIniciador').val($.trim(data.idEstructura));
                    $('#iudIniciador').val($.trim(data.iudEstructura));
                    $('#nombreIniciador').val($.trim(data.nombreEstructura)); 
                    $('#nombreIniciador').attr('readonly', true);
                }
                else {
                    alert('El numero de mesa no existe.\nVerifique a comuniquese con el Area de Tecnologias Informatica')
                    $('#idIniciador').val('');
                    $('#iudIniciador').val('');
                    $('#nombreIniciador').val(''); 
                    $('#nombreIniciador').removeAttr('readonly');
                    $('#iudIniciador').focus();
                }
            }
        })
    });
</script>