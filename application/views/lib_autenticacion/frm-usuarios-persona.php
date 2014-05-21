<?php
 /**
	 *
	 *
	 * @author Artigas Daniel
	 * @version 1.0.0
	 * @copyright 2011-12
	 * @package base
	 */
$vcMsjSrv = (!empty($vcMsjSrv))? $vcMsjSrv: '';
$vcNombreFrm = (!empty($vcNombreFrm))? $vcNombreFrm: 'Usuario';
$vcAccion = (!empty($vcAccion))? $vcAccion: 'Agregar';
$vcFormName = antibotHacerLlave();
$vcFrmAction = (!empty($vcFrmAction))? $vcFrmAction: '';
?>
	<span class="ico-subtitulo herramientas-30">&nbsp;</span>
	<h2 class="fontface-arimo-subtitulo"><?= ($vcAccion. '&nbsp;'. $vcNombreFrm); ?></h2>
	<div class="forms">
		<?= $vcMsjSrv; ?>
		<form id="<?= $vcFormName; ?>" name="<?= $vcFormName; ?>" action="<?=$vcFrmAction?>" method="post">
			
			<fieldset>
				<input type="hidden" name="inIdUsuario" id="inIdUsuario" value="<?if(isset($usuario['inIdUsuario'])){echo $usuario['inIdUsuario'];}?>"/>
				<div class="readonly">
        			<div class="fila"><label>N&uacute;mero de Documento</label>
        				<div class="readonly">
        					<input type="text" style="width: 140px;" value="<?=$Ndocumento; ?>"<?=($usuario<=0?' class="inputPegadosIzq"':'')?> />
        	    			<?php
        	                if ($usuario<=0){
        	    			?>
        						<a href="autenticacion/usuarios/formulario" id="btn-nuevo" class="button buscar btn-accion inputPegadosDer">Buscar de Nuevo</a>
            				<?php
                            }
                            ?>
        				</div>
        				<input type="hidden" name="vcUsuLogin" value="<?=$Ndocumento; ?>" id="vcUsuLogin"/>
        			</div>
                    <div class="clearfloat"></div>
					<div class="fila"><label>Persona</label>
	
	                <?php if (count($personas)>1):?>
	        			<select name="persona"<?=($usuario<=0?' class="inputPegadosIzq"':'')?>>
	    					<?php foreach($personas as $fila){ ?>
	          					<option value="<?=$fila['inIdPersona']?>"><?=$fila['vcPerNombre']?></option>
	      					<?}?>
	        			</select>
	                <?php else: ?>
						<?php foreach($personas as $fila){ ?>
	                        <input type="hidden" id="persona" name="persona" value="<?=$fila['inIdPersona']?>" />
	                        <input type="text" value="<?=$fila['vcPerNombre']?>" style="width: 300px;" />
	  					<?}?>
	                	<?php endif;?>
					</div>
				</div>
			
			
            <div class="clearfloat"></div>

			<div class="fila">
                <label>Estado</label>
                <select name="estado">
	    		<!-- este foreach es para cargar el list box -->
	    		<?php foreach($estados as $fila)
	    		{ ?>
	    		<!-- si existe la variable usuario quiere decir que esta modificando -->
  					<option
  				 <?if (isset($usuario['inIdSegEstado']))
						{
						//si $usuario['inIdSegEstado']==$fila['inIdSegEstado'] coinciden entondes utilizamos la propiedad selected para seleccionar ese elemento del list box, para su modificacion
				   if (($usuario['inIdSegEstado']==$fila['inIdSegEstado']))
							{
							echo 'selected';							
							}
						} 
			     ?>
					 value="<?=$fila['inIdSegEstado']?>"><?=$fila['vcSegEstDesc']?>
					 </option>
  				<?
  				//si no esta modificando quiere decir que esta agregando un nuevo usuario, por lo tanto mostramos solamente el primer elemento del listbox que es "HABILITADO"
  					if ($usuario>0){}
					else{break;}
				}?>
                </select>
			</div>
			
			<div class="fila">
                <label>Rol</label>
    			<select name="rol">
					<?php foreach($roles as $fila){ ?>
  					<option  
  					 <?php if (isset($usuario['inIdRol']))
					 	{
					 		if ($usuario['inIdRol']==$fila['inIdRol'])
							{
					 		echo 'selected';
							}
						} 
					 ?>
  					value="<?=$fila['inIdRol']?>">
  					<?=$fila['vcRolNombre']?>
  					</option>
  					<?}?>
    			</select>
			</div>

			<div class="fila">
                <label for="vcUsuEmail">Email</label>
		       	<input type="text" name="vcUsuEmail" value="<?=$Reg['vcUsuEmail'];?>"<?=classRegValidation('vcUsuEmail')?> id="vcUsuEmail" style="width: 250px;" />
    		 	<input type="hidden" name="validar_documento" <?=classRegValidation('validar_documento')?> id="validar_documento"style="width: 250px;" value="1"/>
			</div> 
			
            <div class="clearfloat"></div>
            <br />
            <div class="clearfloat"></div>
	
    		<div id="divChkEmail" class="fila despliegueLateral">
                <label for="chkEmail">
                    <input type="checkbox" id="chkEmail" name="chkEmail" checked="checked" />
                    Enviar e-mail de notificaci&oacute;n al Usuario
                </label>
                <div class="clearfloat"></div>
    		</div>
			<div id="divDefinirClaves" class="fila despliegueLateral">
    		   	<div class="fila">
    		        <label for="vcUsuPassword">Contrase&ntilde;a:</label>
    		       	<input name="vcUsuPassword" type="password" id="vcUsuPassword" <?=classRegValidation('vcUsuPassword')?>/>
    		    </div>
	            <div class="clearfloat"></div>
    		   	<div class="fila">
    		        <label for="vcUsuPassword2">Repetir Contrase&ntilde;a:</label>
    		       	<input name="vcUsuPassword2" type="password" id="vcUsuPassword2" <?=classRegValidation('vcUsuPassword2')?> />
    		    </div>
    	        <div class="clearfloat">&nbsp;</div>
    			<?php if (config_item('asunto_pin_enabled')): ?>
    		   	<div class="fila">
    		        <label for="vcUsuPIN">Pin:</label>
    		       	<input name="vcUsuPIN" type="password" maxlength="4" id="vcUsuPIN" <?=classRegValidation('vcUsuPIN')?>/>
    		    </div>
	            <div class="clearfloat"></div>
    		   	<div class="fila">
    		        <label for="vcUsuPIN2">Repetir Pin:</label>
    		       	<input name="vcUsuPIN2" type="password" maxlength="4" id="vcUsuPIN2" <?=classRegValidation('vcUsuPIN2')?>/>
    		    </div>
                <div class="clearfloat"></div>
    			<?php else: ?>
		       	<input name="vcUsuPIN" type="hidden" maxlength="4" id="vcUsuPIN" value="1111" />
		       	<input name="vcUsuPIN2" type="hidden" maxlength="4" id="vcUsuPIN2" value="1111" />
    			<?php endif; ?>
    		</div>
            <div class="clearfloat"></div>

	</fieldset>
    <br />
	<div class="buttons">
		<input type="submit" class="button guardar btn-accion<?= (empty($Reg['inIdUsuario'])?' btn-reset':''); ?>" value="Guardar"/>
		<a href="autenticacion/usuarios/listado" id="btn-cancelar" class="button cancelar btn-accion">Cancelar</a>
    </div>

    <input type="hidden" id="vcForm" name="vcForm" value="<?= $vcFormName; ?>" />
  
	</form> 
	<script type="text/javascript">
    	$('#divDefinirClaves').hide();
    	$('#divDefinirClaves input[type=password]').val('1111');
		$(document).ready(function(){
            $('#chkEmail').click(function(){
                if ($(this).attr('checked')=='checked') {
                	$('#divDefinirClaves').hide('fast', function(){
                    	$('#divDefinirClaves input[type=password]').val('1111');
                	});
                	$('#<?= $vcFormName; ?>').validationEngine('hide');
                } else {
                	$('#divDefinirClaves input[type=password]').val('');
                	$('#divDefinirClaves').show('fast');
                }
            });
    		$('#hideButtonPin').click(function(){
    			$('#avisoPin').hide('fast');
    			$('#avisoPin input[type=password]').val('');
    			$('#<?= $vcFormName; ?>').validationEngine('hide');
    	  	});
    		$('#showButtonPin').click(function(){
    			$('#avisoPin').show('fast');
    	  	});	
			$('#<?= $vcFormName; ?> input:first').focus();
		});
	</script>