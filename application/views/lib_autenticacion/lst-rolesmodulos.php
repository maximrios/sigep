<?php
/**
 * @author Duran Francisco Javier
 * @version 1.0.0
 * @copyright 2011-12
 * @package base
 */
$vcGridView = (!empty($vcGridView))? $vcGridView: '';
$btGuardar = (!empty($btGuardar))? $btGuardar: '';
$btCancelar = (!empty($btCancelar))? $btCancelar: '';
$vcNombreList = (!empty($vcNombreList))? $vcNombreList: 'Permisos';
$vcFormName = antibotHacerLlave();
$vcMsjSrv = (!empty($vcMsjSrv))? $vcMsjSrv: '';
$inIdRol = (!empty($inIdRol))? $inIdRol: '';
?>
	<div class="box-layout-50-rt">
  		<div class="toolbar-rgt-sb">
			<div class="toolbar-rgt-sb-der">
				<div class="forms">
					<form id="frmBuscador" name="frmBuscador" action="autenticacion/rolesmodulos/listadoVer" method="post" target="contenido-abm">
						<div class="fila">
							<div class="clearfloat"></div>
							<div class="fila">
    						<label for="inIdRol">Seleccione un Rol &raquo;</label>
    					    <!-- Mostramos o no el boton editar segun se halla elegido algun Rol-->
    						<?php
    							if ($inIdRol != '') {
									echo HacerListaDesplegable($aRoles,'inIdRol','id="inIdRol" class="inputPegadosIzq" placeholder="Ingrese un Criterio de Búsqueda"','inIdRol','vcRolNombre','Seleccionar...',$inIdRol);
                				    echo '<a href="autenticacion/rolesmodulos/listadoEditar/'.$inIdRol.'" target="contenido-abm" class="button editar btn-accion inputPegadosDer" >Editar</a>';
								} else {
									echo HacerListaDesplegable($aRoles,'inIdRol','id="inIdRol" placeholder="Ingrese un Criterio de Búsqueda"','inIdRol','vcRolNombre','Seleccionar...',$inIdRol);	
								}					    							
                			?>                			
    						</div>																
						</div>
						<div class="clearfloat">&nbsp;</div>						
                        <input type="hidden" id="vcForm" name="vcForm" value="<?= $vcFormName; ?>" />
					</form>
				</div>
			</div>
		</div>
	</div>	
	<div class="box-layout-50-lt">
    	<span class="ico-subtitulo herramientas-30">&nbsp;</span>
    	<h2 class="fontface-arimo-subtitulo box-layout-titulo">Listado de <?= $vcNombreList; ?></h2>
 	</div>
	<div class="clearfloat">&nbsp;</div>
	<?= $vcMsjSrv; ?>
	<?= $vcGridView; ?>		
	<br/>
	<div class="buttons">
	<?= $btGuardar; ?>
	<?= $btCancelar; ?>    
    </div>
 
<script type="text/javascript">
$(document).ready(function(){
	$('#frmBuscador input:first').focus();
	$('#frmBuscador').viaAjax();	
  	$('.btn-accion').viaAjax();
	$('#btn-cancelar').click(function(e) {
		$('#contenido-abm').viaAjax('send', {'url': 'autenticacion/rolesmodulos/listadoVer/'+$('#contenido-abm select').val()}); return false;
		e.preventDefault();
	});
	
	// Acciones de los Checkbox para Deschequear y Chequear todos los checkbox de cada columna.
	$('#accTodos').click(function(){
		$('input[type=checkbox][name=boModAcceso]').attr('checked',$(this).is(':checked'));
	});
	$('#altaTodos').click(function(){
		$('input[type=checkbox][name=boRolModAlta]').attr('checked',$(this).is(':checked'));
	});
	$('#modifTodos').click(function(){
		$('input[type=checkbox][name=boRolModModif]').attr('checked',$(this).is(':checked'));
	});
	$('#bajaTodos').click(function(){
		$('input[type=checkbox][name=boRolModBaja]').attr('checked',$(this).is(':checked'));
	});
	$('#reqpinTodos').click(function(){
		$('input[type=checkbox][name=boRolModReqPin]').attr('checked',$(this).is(':checked'));
	});

	// Eventos de click y change para el listbox y para el boton guardar
	$('#inIdRol').change(function(){
		$('#contenido-abm').viaAjax('send', {'url': 'autenticacion/rolesmodulos/listadoVer/'+$('#contenido-abm select').val()}); return false;
	})
	$('#lnkGuardar').click(function(){
    	var aPOST = '';		
        var cnct = '';
      	$('input[type=checkbox][name=boModAcceso]').each(function(){
            aPOST += cnct + $(this).attr('id');
            aPOST += ','  + ($(this).is(':checked')?1:0); //boModAcceso
            aPOST += ','  + ($('input[type=checkbox][id='+$(this).attr('id')+'][name=boRolModAlta]').is(':checked')?1:0);
            aPOST += ','  + ($('input[type=checkbox][id='+$(this).attr('id')+'][name=boRolModModif]').is(':checked')?1:0);
            aPOST += ','  + ($('input[type=checkbox][id='+$(this).attr('id')+'][name=boRolModBaja]').is(':checked')?1:0);
            aPOST += ','  + ($('input[type=checkbox][id='+$(this).attr('id')+'][name=boRolModReqPin]').is(':checked')?1:0);
            cnct = '|';
        });
        //alert(cnct);
        $('#contenido-abm').viaAjax('send', {'type': 'POST','url': 'autenticacion/rolesmodulos/guardar','vars': 'cnct='+aPOST+'&vcForm='+$('#vcForm').val()+'&inIdRol='+$('#inIdRol').val()}); return false;
        //alert(aPOST);
	});
    function chkChildren(id, tipo){
        if (!$(this).is(':checked')){
            $('input[type=checkbox][name=' + tipo + '][value=' + id + ']').attr('checked',false);
            $('input[type=checkbox][name=' + tipo + '][value=' + id + ']').each(function(){
                chkChildren($(this).attr('id'), tipo);
            })
        }
    }
    $('input[type=checkbox][name=boModAcceso]').change(function(){
        chkChildren($(this).attr('id'), 'boModAcceso');
    });
    $('input[type=checkbox][name=boRolModAlta]').change(function(){
        chkChildren($(this).attr('id'), 'boRolModAlta');
    });
    $('input[type=checkbox][name=boRolModModif]').change(function(){
        chkChildren($(this).attr('id'), 'boRolModModif');
    });
    $('input[type=checkbox][name=boRolModBaja]').change(function(){
        chkChildren($(this).attr('id'), 'boRolModBaja');
    });
    $('input[type=checkbox][name=boRolModReqPin]').change(function(){
        chkChildren($(this).attr('id'), 'boRolModReqPin');
    });
    // Ocultar Mostrar Checkbox que son posibles marcar
    function estadoCheckbox() {
        $('input[type=checkbox][name=boModAcceso], '+
          'input[type=checkbox][name=boRolModAlta], '+
          'input[type=checkbox][name=boRolModModif], '+
          'input[type=checkbox][name=boRolModBaja], '+
          'input[type=checkbox][name=boRolModReqPin]').each(function(){
            if (!$(this).attr('value') || $('input[type=checkbox][name=' + $(this).attr('name') + '][id=' + $(this).attr('value') + ']').is(':checked'))
                 $(this).show('fast');
            else $(this).hide('fast').attr('checked',false);
        });
    }
    $('input[type=checkbox]').change(function(){
        estadoCheckbox();
    });
    //Lo llama al inicio, cuando se carga el documento
    estadoCheckbox();
});
</script>
