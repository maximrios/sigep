<?php
$vcBaseUrlAssets = (!empty($vcBaseUrlAssets))?$vcBaseUrlAssets: config_item('ext_base_url_assets');
?>
<nav>
	<ul id="topnav">
		<li class="itemSup"><a href="inicio" class="nav-button" style="text-transform: uppercase;" >Inicio</a></li>
		<li class="itemSup"><a  class="nav-button" style="text-transform: uppercase;" >Administración</a>
			<div class="sub">
				<ul>
					<li><a href="autenticacion/modulos">Modulos del Sistema</a></li>
					<li><a href="autenticacion/roles">Tipos de Roles</a></li>
					<li><a href="autenticacion/estados">Estados de Usuarios</a></li>
					<li><a href="autenticacion/configuracion">Configuraciones</a></li>
					<li><a href="autenticacion/rolesmodulos">Asignación de Permisos por Rol</a></li>
					<li><a href="autenticacion/usuarios">Usuarios</a></li>
					<li><a href="autenticacion/faq">Preguntas Frecuentes</a></li>
				</ul>
			</div>
		</li>
		<li class="itemSup"><a  class="nav-button" style="text-transform: uppercase;" >Datos</a>
			<div class="sub">
				<ul>
					<li><h3>Parámetros</h3></li>
					<li><a href="sistema/localidades">Localidades</a></li>
					<li><a href="sistema/paises">Países</a></li>
					<li><a href="sistema/departamentos">Departamentos</a></li>
					<li><a href="configuracion/personas">Personas</a></li>
					<li><a href="sistema/provincias">Provincias</a></li>
					<li><h3>Entidades</h3></li>
					<li><h3>Organismos Publicos</h3></li>
					<li><a href="organismos/org">Organismos</a></li>
				</ul>
			</div>
		</li>
		<li class="itemSup"><a href="autenticacion/novedadesrol" class="nav-button" style="text-transform: uppercase;" >Novedades</a></li>
	</ul>
</nav>
<div class="clearfloat">&nbsp;</div>