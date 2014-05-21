<?php
	$vcFormName = antibotHacerLlave();
	$vcMsjSrv = (!empty($vcMsjSrv))? $vcMsjSrv: '';
	$vcFrmAction = (!empty($vcFrmAction))? $vcFrmAction: '';
?>
<div class="forms">
	<?= $vcMsjSrv; ?>
<form id="<?= $vcFormName; ?>" name="<?= $vcFormName; ?>" action="<?= $vcFrmAction; ?>" method="post" target="contenido-abm">
	<li>
		<label>Titulo de la Noticia</label>
		<span>Ingrese un titulo para identificar la noticia</span>
		<input type="text" id="tituloNoticia" name="tituloNoticia" tabindex="1" placeholder="Titulo de Noticia" value="<?php echo $Reg['tituloNoticia']?>">
	</li>
	<li>
		<label>Cuerpo de la Noticia</label>
		<span>Ingrese el cuerpo completo de la noticia.</span>
		<textarea id="descNoticia" name="descNoticia" tabindex="2"><?php echo $Reg['descripcionNoticia']?></textarea>
	</li>
	<li class="medio">
		<label>Fecha de Inicio</label>
		<span>Fecha de inicio de publicación de la noticia.</span>
		<input class="fecha" type="text" id="inicioNoticia" name="inicioNoticia" tabindex="3" placeholder="dd-mm-yyyy" value="<?php echo $Reg['inicioNoticia']?>">
	</li>
	<li class="medio">
		<label>Fecha de Fin</label>
		<span>Fecha de fin de publicación de la noticia.</span>
		<input class="fecha" type="text" id="vencimientoNoticia" name="vencimientoNoticia" tabindex="4" placeholder="dd-mm-yyyy" value="<?php echo $Reg['vencimientoNoticia'];?>"<?php echo classRegValidation('vencimientoNoticia');?> >
	</li>
	<li>
		<label>Tipo de Noticia</label>
		<span>Identifique la noticia en alguno de los siguientes grupos.</span>
		<?php echo form_dropdown('idTipoNoticia', $tiposnoticias, $Reg['idTipoNoticia']);?>
		<!--<select id="idTipoNoticia" name="idTipoNoticia">
			<option value="0">Seleccione un item ...</option>
			<option value="1">Institucionales</option>
			<option value="2">Gremiales</option>
		</select>-->
	</li>
	<li class="checkbox">

		<input type="checkbox" id="publicadoNoticia" name="publicadoNoticia" checked readonly>&nbsp; Publicar noticia automaticamente dependiendo de las fechas de inicio y fin.
	</li>
	<div class="buttons">
		<!--<button class="btn btn-primary">Guardar</button>-->
		<input type="submit" id="probar" class="btn btn-primary guardar btn-accion<?= (empty($Reg['idNoticia'])?' btn-reset':''); ?>" value="Guardar"/>
		<a href="administrator/noticias" id="btn-cancelar" class="button cancelar btn-accion">Cancelar</a>
	</div>
	<input type="hidden" id="descripcionNoticia" name="descripcionNoticia" value="">
	<input type="hidden" id="idNoticia" name="idNoticia" value="<?php echo $Reg['idNoticia']?>">
	<input type="hidden" id="vcForm" name="vcForm" value="<?= $vcFormName; ?>" />
</form>
</div>
<?php echo display_ckeditor($ckeditor_texto1); ?>
<script>
	//var contenido = CKEDITOR.instances['miTextArea'].getData();
	$('.fecha').datepicker({
		format: 'dd/mm/yyyy'
	});
	$('#probar').on('click', function() {
		var contenido = CKEDITOR.instances['descNoticia'].getData();
		$('#descripcionNoticia').val(contenido);
		alert(contenido);
	})
	//var contenido = CKEDITOR.instances['miTextArea'].getData();
</script>

<?php
/*echo '<script>


        if (CKEDITOR.instances["descripcionNoticia"]) {
                            //alert("existe la instancia");
                            //CKEDITOR.instances["descripcionNoticia"].destroy();
                            for(var instanceName in CKEDITOR.instances) {
                                CKEDITOR.instances[instanceName].destroy();
                            }
                        }
                    else {
                        alert("no existe la instanca");
                    }
              
                    //CKEDITOR.replace("descripcionNoticia");
                </script>';*/
?>
