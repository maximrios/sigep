<?php
	$vcFormName = antibotHacerLlave();
	$vcMsjSrv = (!empty($vcMsjSrv))? $vcMsjSrv: '';
?>
<h3 style="margin:0 auto;text-align:center;margin-top:50px;">Iniciar Sesión</h3>
<div class="center-block" style="width:300px;">
	<form id="form-login-access" method="post" enctype="application/x-www-form-urlencoded" action="aut/autenticar" target="srv-resp">
		<div class="form-group">
			<label for="nombreUsuario">Usuario</label>
        	<input type="text" id="nombreUsuario" name="nombreUsuario" class="form-control" placeholder="Usuario" autofocus required>
    	</div>
    	<div class="form-group">
			<label for="passwordUsuario">Contaseña</label>
        	<input type="password" id="passwordUsuario" name="passwordUsuario" class="form-control" placeholder="Contraseña" required>
            <span class="pull-right" style="font-size:0.7em;"><a href="#">Recuperar contraseña</a></span>
    	</div>
    	<div class="checkbox">
	    	<label>
      			<input type="checkbox"> No cerrar sesión
    		</label>
  		</div>
    	<button type="submit" class="btn btn-primary">Ingresar</button>
    	<input type="hidden" id="vcForm" name="vcForm" value="<?=$vcFormName;?>">
	</form>	
</div>
<div class="row">
    <div class="container">
        <div id="srv-resp" class="center-block text-center">
            <?= $vcMsjSrv; ?>
        </div>
    </div>
</div>
<script type="text/javascript">
    $('document').ready(function() {
        var passField = $('#passwordUsuario')
        passField.bind('keyup', function(event){
            if(event.keyCode == '13') {
                $('#btnSubmit').click();
            }
        });
        $('#form-login-access').viaAjax({
            'prepVars': function() {
                if(passField.val()!='') {
                    passField.val($.md5(passField.val()));
                }
            }
        });
    });
</script>
