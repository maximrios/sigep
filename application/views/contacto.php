<section class="content wrap-content">
<div class="div-50">
	<h4>Formulario de contacto</h4>
	<?=$vcMsjSrv;?>
	<form action="consultar.html" method="post" class="contacto" accept-charset="utf-8">
		<li>
			<label for="txtnombre">Nombres</label>
			<input id="nombre" type="text" name="txtnombre" tabindex="1" title="Ingrese el nombre completo" placeholder="Nombre completo" required>
		</li>
		<li>
			<label for="txttel">Telefono</label>
			<input id="tel" type="tel" name="txttelefono" value="" tabindex="2" placeholder="03874290011. Solo números" required>
		</li>
		<li>
			<label for="textemail">Correo Electronico</label>
			<input id="email" type="email" name="txtemail" value="" tabindex="3" placeholder="ejemplo@servidor.com" required>
		</li>
		<li>
			<label for="textmensaje">Mensaje</label>
			<textarea id="txtmensaje" name="txtmensaje" rows="9" tabindex="4" placeholder="Mensaje" required></textarea>
		</li>
		<li>
			<button name="btnenviar" type="submit">Enviar</button>
			<input type="hidden" id="form" name="form" value="1">
		</li>
	</form>
</div>
<div class="div-50">
	<h4>Encontranos en este mapa</h4>
	<?php 
		echo $map['js'];
		echo $map['html'];
	?>
</div>
</section>