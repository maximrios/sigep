<?php
/**
 * @author Maximiliano Ezequiel Rios
 * @version 1.0.0
 * @copyright 2014
 * @package Sabandijas Rodados
 */
	$vcFormName = antibotHacerLlave();
	$vcMsjSrv = (!empty($vcMsjSrv))? $vcMsjSrv: '';
	$vcFrmAction = (!empty($vcFrmAction))? $vcFrmAction: '';
    //$clase = ($Reg['thumbImagenNoticia'])? 'col-lg-6':'col-lg-12';
?>
<div class="row">
	<div class="forms">
    	<?= $vcMsjSrv; ?>
    	<form id="proba" name="<?= $vcFormName; ?>" action="<?= $vcFrmAction; ?>" method="post" target="contenido-abm" enctype="multipart/form-data">
        	<div class="form-group col-lg-6">
            	<label for="expedienteNota">Expediente de Referencia</label>
            	<input type="text" id="expedienteNota" name="expedienteNota" tabindex="1" class="form-control" placeholder="Titulo de Novedad." value="" autofocus>
        	</div>
            <div class="form-group col-lg-6">
                <label for="idTipoInforme">Tipo de Informe</label>
                <input type="text" id="idTipoInforme" name="idTipoInforme" tabindex="2" class="form-control" placeholder="Epígrafe de Novedad." value="">
            </div>
            <div class="form-group col-lg-12">
                <label for="referenciaNota">Referencia</label>
                <input type="text" id="referenciaNota" name="referenciaNota" tabindex="2" class="form-control" placeholder="Epígrafe de Novedad." value="">
            </div>
        	<div class="form-group col-lg-12">
            	<label for="cuerpoNota">Cuerpo de Nota</label>
                <textarea id="cuerpoNota" name="cuerpoNota" tabindex="3" class="ckeditor form-control" placeholder="Descripcion de Novedad." rows="10"></textarea>
        	</div>
            <input type="submit" id="uploadFilesBt" class="btn btn-primary" value="Guardar" name="btnvo"/>
    	    <input type="hidden" id="vcForm" name="vcForm" value="<?= $vcFormName; ?>" />
	</form>
</div>
<?php echo display_ckeditor($ckeditor_texto); ?>
<script type="text/javascript">
    /*$('#uploadFilesBt').on('click', function() {
        var contenido = CKEDITOR.instances['cuerpoNota'].getData();
        $('#cuerpoNota').val(contenido);    
    });*/
</script>