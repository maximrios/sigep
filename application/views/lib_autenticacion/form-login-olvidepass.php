<?php
$vcFormName = antibotHacerLlave();
?>
<script type="text/javascript">
<!--
// Obligar a Minimizado
$.cookie("navStatus","Minimizado",{path:'/'});
//-->
</script>

  <form id="form-login-access-olvidepass" method="post" enctype="application/x-www-form-urlencoded" action="aut/olvidepassenviar" target="srv-resp">

<?php
	$vcMsjSrv = (!empty($vcMsjSrv))? $vcMsjSrv: '';
?>
<div id="srv-resp">
    <?= $vcMsjSrv; ?>
    <input type="hidden" id="vcForm" name="vcForm" value="<?= $vcFormName; ?>" />
</div>
<style type="text/css" media="all">
#waitplease{
margin-left:110px !important;
padding-left:20px !important;
padding-right:20px !important;
background-color:#f0f0f0 !important;
border-radius: 0.5em;
-o-border-radius: 0.5em;
-ms-border-radius: 0.5em;
-moz-border-radius: 0.5em;
-webkit-border-radius: 0.5em;
}
</style>
<div class="clearfloat">&nbsp;</div>

<div class="loginH2-olvidepass">
    <h2><?=config_item('ext_base_bienvenida_sistema')?></h2>
    <div class="clearfloat">&nbsp;</div>
    <div id="fondoCandado-olvidepass">
      <div id="login-access-olvidepass">
       <div id="login-access-lt">
          <label for="txtLogin" class="login-label"><?=config_item('ext_base_login_username')?>:</label>
          <input tabindex="1" name="txtLogin" id="txtLogin" type="text" placeholder="Ingrese su <?=config_item('ext_base_login_username')?>" class="validate[required,custom[integer],maxSize[50],goTrim] login-input-olvidepass" value="<?=$txtLogin?>" />
          <label for="txtEmail" class="login-label">Email:</label>
          <input tabindex="2" id="txtEmail" name="txtEmail" type="text" placeholder="Ingrese su Email" class="validate[required,custom[email],maxSize[256],goTrim] login-input-olvidepass" value="<?=$txtEmail?>" />
          <label class="login-label">&nbsp;</label>
          <input tabindex="3" type="submit" name="btnSubmit" name="submit" value="Enviar Email" class="login-button" />
          <a id="lnkOlvidePass-olvidepass" class="login-button" href="aut/login" title="aut/login">Volver al Inicio</a>
          <label class="login-label">&nbsp;</label>
        </div>
      </div>
      <div id="login-leyenda-olvidepass">
         <p>Para recuperar su contrase&ntilde;a ingrese su <?=config_item('ext_base_login_username')?> y el Email proporcionado al administrador cuando se creo su cuenta.<br />Luego presione el boton Enviar y su nueva contrase&ntilde;a ser&aacute; enviada a la cuenta de Email proporcionada.</p>
      </div>
      <div class="clearfloat">&nbsp;</div>
    </div>
    <div class="clearfloat">&nbsp;</div>
</div>
<div class="clearfloat">&nbsp;</div>

  </form>

<script type="text/javascript">
$('document').ready(function() {
	$('#login-access-olvidepass input:first').focus();
    $('#lnkOlvidePass-olvidepass').bind("mousedown", function(){
      $('#lnkOlvidePass-olvidepass').attr('href',$('#lnkOlvidePass-olvidepass').attr('title')+'/'+$('#txtLogin').val());
    });
	var passField = $('#sbmLogin')
	passField.bind('keyup', function(event){
		if(event.keyCode == '13') {
			$('#btnSubmit').click();
		}
	});
	$('#form-login-access-olvidepass').viaAjax({
		'prepVars': function() {
			if(passField.val()!='') {
				passField.val($.md5(passField.val()));
			}
		}
	});
});
</script>