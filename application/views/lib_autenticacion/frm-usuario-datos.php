<?php
/**
 * 
 *
 * @author Marcelo Gutierrez
 * @version 1.0.0
 * @copyright 2011-12
 * @package base30
 */
$vcMsjSrv = (!empty($vcMsjSrv))? $vcMsjSrv: '';
$vcNombreFrm = (!empty($vcNombreFrm))? $vcNombreFrm: '';
$vcAccion = (!empty($vcAccion))? $vcAccion: 'Editar';
$vcFormName = antibotHacerLlave();
$vcFrmAction = (!empty($vcFrmAction))? $vcFrmAction: '';
?>
<div class="main-content">
	<section id="secttion-opts" class="box-normal-100">          
		<span class="ico-subtitulo identificacion-30">&nbsp;</span>
		<h2 class="fontface-arimo-subtitulo"><?= ($vcAccion. '&nbsp;'. $vcNombreFrm); ?><span id="operacion-sel"></span></h2>
        <p class="texto-descripciones"><?= $Reg['vcRolNombre']; ?>, &uacute;ltimo inicio de sesi&oacute;n: <?=  getStringResolved($Reg['tsUsuFechaUltimoLogin']).' ('. GetDateTimeFromISO($Reg['tsUsuFechaUltimoLogin']).')'; ?></p>
        <div class="clearfloat">&nbsp;</div>
        <br />
        <br />
        <div id="toolbar" class="toolbar-rgt-sb-der">
        	<a id="modif-perfil" href="autenticacion/perfilusuario/formularioperfil" class="button editar" rel="contenido-edit">Editar Perfil</a>
        	<a id="modif-pass" href="autenticacion/perfilusuario/formulariomodifpass" class="button llave" rel="contenido-edit">Modificar Contrase&ntilde;a</a>
            <?php if (config_item('asunto_pin_enabled')): ?>
        	<a id="modif-pin" href="autenticacion/perfilusuario/formulariomodifpin" class="button llave-ir" rel="contenido-edit">Modificar PIN</a>
        		<a id="desbloq-pin" href="autenticacion/perfilusuario/formulariodesbloqpin" class="button candado-abierto" rel="contenido-edit" <?php if(((bool)$Reg['boUsuPINActivo'])==FALSE) {
        	?> style="display:none; visibility: hidden;" <?php
        	} ?> >Desbloquear mi PIN</a>
            <?php endif; ?>
        </div>
    </section>
    <div class="clearfloat">&nbsp;</div>
    <div id="contenido-edit"><?= $vcMsjSrv; ?></div>
</div>
<div class="sidebar">
		<section class="box-normal-100">
			<span class="ico-subtitulo agenda-30">&nbsp;</span>
			<h2 class="fontface-arimo-subtitulo">Informaci&oacute;n de la Cuenta</h2>
			<br />
			<p class="texto-descripciones1">Rol: <?= $Reg['vcRolNombre']; ?></p>
			<p class="texto-descripciones1">&Uacute;ltimo inicio de sesi&oacute;n: <?= GetDateTimeFromISO($Reg['tsUsuFechaUltimoLogin']); ?></p>
			<p class="texto-descripciones1">Nombre completo: <?= $Reg['vcPerNombre']; ?></p>
			<p class="texto-descripciones1">Estado de PIN: <?= (((bool)$Reg['boUsuPINActivo'])==FALSE)? 'BLOQUEADO': 'ACTIVO'; ?></p>
		</section>
</div>
<div class="clearfloat">&nbsp;</div>	
<script type="text/javascript">
	var onSuccess = function() {
		onClickCancelar();
	};
    var onClickCancelar = function() {
		$('#contenido-edit a.cancelar').click(function(event) {
			event.preventDefault();
			$('#operacion-sel').html('');
			$('#contenido-edit').html('');
		});
    };
	$(document).ready(function() {
		$('#<?= $vcFormName; ?> input:first').focus();
      	$('#toolbar a.button').viaAjax({'success': function() { onSuccess(); }});
        onClickCancelar();
	});
</script>