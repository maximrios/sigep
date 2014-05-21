<?php
	$route['nosotros'] = "inicio/nosotros";
	$route['mayoristas'] = "inicio/mayoristas";
	$route['productos'] = "inicio/productos";
	//$route['producto'] = "inicio/producto";
	
	$route['servicios'] = "inicio/servicios";
	$route['galeria'] = "inicio/galeria";
	$route['contacto'] = "inicio/contacto";
	$route['consultar'] = "inicio/consultar";

	$route['producto/([a-z-]+)'] = 'inicio/producto/$1';
?>