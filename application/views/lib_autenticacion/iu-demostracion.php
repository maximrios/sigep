<?php
/**
 * 
 *
 * @author Marcelo Gutierrez
 * @version 1.0.0
 * @copyright 2011-12
 * @package base
 */
$vcGridView = (!empty($vcGridView))? $vcGridView: '';
?>

   <span class="ico-subtitulo identificacion-32">&nbsp;</span>
   <h2 class="fontface-arimo-subtitulo">Listado</h2><p>Hola</p>
   <div class="toolbar-rgt">		      
	  <a href="#" class="button left historial-pases">Hist. Pase</a>
	  <a href="#" class="button middle pase">Crear Pase</a>
	  <a href="#" class="button middle corresponde">Corresponde</a>                            
	  <a href="#" class="button middle agregado">Agregado</a>              
	  <a href="#" class="button middle desglose">Desglose</a>
	  <a href="#" class="button right adjuntar">Adj. Archivo</a>                           	                                   
	  <a href="#" class="button left editar">Modificar</a>
	  <a href="#" class="button middle cambio-caratula">Camb. Car&aacute;tula</a>
	  <a href="#" class="button right cambio-estado">Camb. Estado</a>                         
   </div>	
	 
	<div class="toolbar-rgt">
		
		<!-- enlaces -->
		<a href="#" class="button ok">Confirmar</a>
		<a href="#" id="btn-nuevo" class="button agregar" onclick="$('#contenido-abm').viaAjax('send', {'url': 'autenticacion/roles/formulario'}); return false;">Nuevo</a>
		<a href="#" class="button eliminar">Eliminar</a>
		<a href="#" class="button marcar">Marcar</a>
		<a href="#" class="button arriba">&nbsp;</a>
		<a href="#" class="button abajo">&nbsp;</a>
		<a href="#" class="button editar">Editar</a>
		<a href="#" class="button guardar">Guardar</a>
		<a href="#" class="button cancelar">Cancelar</a>
		<a href="#" class="button adjuntar">Adjuntar</a>
		<a href="#" class="button pase">Pase</a>
		<a href="#" class="button corresponde">Corresponde</a>
		<a href="#" class="button desglose">Desglose</a>
		<a href="#" class="button agregado">Agregados</a>
		<a href="#" class="button cambio-caratula">Camb. car&aacute;tula</a>
		<a href="#" class="button cambio-estado">Camb. estado</a>
		<a href="#" class="button historial-pases">Hist. Pases</a>
		<a href="#" class="button buscar">Buscar</a>
		&nbsp;
		<a href="#" class="button-sp1"><span class="icono-buscar-bco">&nbsp;</span>&nbsp;Buscar</a>
		<a href="#" class="button-sp1"><span class="icono-buscar-bco">&nbsp;</span></a>
		<a href="#" class="button-sp2">Algo para hacer!</a>
		<a href="#" class="button-sp2">...</a>
		<!-- botones -->
		<input type="button" class="button ok" value="Confirmar"/>
		<input type="button" class="button guardar" value="Guardar"/>
		<input type="button" class="button cancelar" value="Cancelar"/>
	</div>
	<div class="clearfloat">&nbsp;</div>
<div>
<?= $vcGridView; ?>
</div>
<?php
$vcRespuestaSrv = (!empty($vcRespuestaSrv))? $vcRespuestaSrv: '';
$vcFormName = 'frmRoles';
$vcFrmAction = '';
?>

<br/>

<div class="forms">
<?= $vcRespuestaSrv; ?>
<form id="<?= $vcFormName; ?>" name="<?= $vcFormName; ?>" action="<?= $vcFrmAction; ?>" method="post">
	<fieldset>
	    <div class="fila">
	        <label for="vcRolNombre">Nombre del Rol</label>
	       	<input type="text" name="vcRolNombre" id="vcRolNombre" value=""/>
	    </div>
	    <div class="fila">
	        <label for="vcRolCod">C&oacute;digo:</label>
	       	<input type="text" name="vcRolCod" id="vcRolCod" value=""/>
	    </div>    	
	   	<div class="fila">
	        <label for="inRolRango">Rango / Orden</label>
	       	<input type="text" name="inRolRango" id="inRolRango" value=""/>
	       	<a href="#" class="button-sp1"><span class="icono-buscar-bco">&nbsp;</span></a>
	    </div>
	  	<div class="fila">
	        <label for="select-1">Select / dropdown list</label>
	       	<select name="select-1" id="select-1">
	       		<option>Seleccionar...</option>
	       		<option>Opcion 1</option>
	       	</select>
	    </div>
	    <div class="clearfloat">&nbsp;</div>
	  	<div class="fila">
        	<label for="checkbox-1"><input type="checkbox" name="checkbox-1" />&nbsp;Check It!</label>
	   </div>
	   <div class="fila">
	   		<label for="checkbox-2"><input type="checkbox" name="checkbox-2" />&nbsp;Check It new! &nbsp;</label>
	   </div>
	   <div class="clearfloat">&nbsp;</div>
	   <div class="fila">
	   		<a href="#">Un enlace</a>
	   </div>
	   <div class="clearfloat">&nbsp;</div>
	</fieldset> 
	<br/> 
	<div class="buttons">
		<input type="submit" class="button guardar" value="Guardar"/>
    	<a class="button"><img src="assets/images/actions-images/cancel.png"/> Cancelar</a>
    </div>
    <div class="clearfloat">&nbsp;</div> 
</form>
</div>