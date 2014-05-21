<?php
$vcHeaderLoginView = (!empty($vcHeaderLoginView))?$vcHeaderLoginView:'';

$vcBaseUrlAssets = (!empty($vcBaseUrlAssets))?$vcBaseUrlAssets: config_item('ext_base_url_assets');

$vcBaseUrlPlantillaElegida = (!empty($vcBaseUrlPlantillaElegida))?$vcBaseUrlPlantillaElegida: config_item('ext_base_url_plantilla_elegida');

$vcMenu = (!empty($vcMenu))? $vcMenu: '';
$vcMainContent = (!empty($vcMainContent))? $vcMainContent: '';

?><!doctype html>
<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="es"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="es"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="es"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" lang="es">
<!--<![endif]-->
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <base href="<?= base_url(); ?>" />
  <title><?= $SiteInfo['title']; ?></title>
  <meta name="description" content="<?= $SiteInfo['descriptions'];?>">
  <meta name="author" content="<?= $SiteInfo['author'];?>">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link rel="shortcut icon" href="./assets/images/favicon.ico" type="image/x-icon">

  <!--[if lt IE 9]>
  <script type="text/javascript">
    var e = ("abbr,article,aside,audio,canvas,datalist,details,figure,footer,header,hgroup,mark,menu,meter,nav,output,progress,section,time,video").explode(',');
    for (var i=0; i<e.length; i++) {
    document.createElement(e[i]);
  }
  </script>
  <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
  <script type="text/javascript" src="<?=$vcBaseUrlAssets;?>libraries/ie-textshadow/jquery.textshadow.js"></script>
  <![endif]-->

  <!--[if lt IE 7 ]>
    <script src="http://ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
    <script>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
  <![endif]-->

<?php
# Para garantizar que los archivos CSS se descarguen en paralelo,
# incluya siempre los recursos CSS externos antes que los recursos JavaScript externos
  print incluirjscss_stylecss();
  print incluirjscss_linkjs();
?>
  <!-- Scripts for any page -->
<?= $vcIncludesGlobales; ?>
  <!-- End Scripts for any page -->
</head>
<body background="<?=$vcBaseUrlAssets?>images/body-background.jpg">
  <div id="container">    
    <!-- Menu principal y login view -->
  <header>
    <script language="javascript" type="text/javascript">
    <!--
    // Aumenta la velocidad al ocultar el header por no estar en document.ready, permite quitar un movimiento visual en cada click del men� principal
    if ($.cookie("navStatus")=="Maximizado") {
      $('header').hide();
      $('#container').attr('style','width:100%');};
    // -->
    </script>
    <div class="header-rt">
	  <?= $vcHeaderLoginView; ?>
    </div>
    <div id="header-lt">
      <hgroup>
        <img src="<?=config_item('ext_base_logo_header');?>" width="74" alt="<?=config_item('ext_base_nombre_sistema');?>" />
        <h1><?=config_item('ext_base_nombre_sistema');?></h1>
      </hgroup>
    </div>
    <div class="clearfloat">&nbsp;</div>
  </header>
  <?= $vcMenu; ?>
    <div id="main" role="main">
    	<?= $vcMainContent; ?>		
      	<div class="clearfloat">&nbsp;</div>
    </div><!--! end of #main -->
  </div> <!--! end of #container -->
  <div class="clearfloat">&nbsp;</div>
  <footer>
    <div class="footer-inner">
      <div class="footer-inner-fullizq">
        <a href="<?=$SiteInfo['uri_propiedad']?>" target="_blank"><img src="<?=config_item('ext_base_logo_footer');?>" class="h1" alt="Logo <?=$SiteInfo['propiedad']?>" /></a>
        <div class="h1"><?=$SiteInfo['propiedad']?></div>
      </div>
      <div class="footer-inner-der">
        <h6 class="texto-pie-titulo1">Datos del Sitio Web</h6>
        <p class="texto-pie-normal1">Desarrollo: <span class="texto-pie-destacado1"><a href="<?=$SiteInfo['uri_propiedad']?>"><?=config_item('ext_base_pie_desarrollo')?></a></span></p>
        <p class="texto-pie-normal1">Resoluci&oacute;n: <span class="texto-pie-destacado1"><?=config_item('ext_base_pie_resolucion')?></span></p>
        <p class="texto-pie-normal1">Browsers Recomendados: <span class="texto-pie-destacado1"><?=config_item('ext_base_pie_navegadores')?></span></p>
      </div>
      <div class="clearfloat">&nbsp;</div>
    </div>
  </footer>
  <script type="text/javascript">
  <?php 
  	$ci = &get_instance();
  	$vcUriVP = '';
	$aSegs = $ci->uri->segment_array();
	$vcClass = strtolower(get_class($ci));
	$idx = array_search($vcClass, $aSegs);
	
	
	if ($idx!==FALSE) {
		for($i=1;$i<=$idx;$i++) {
			$vcUriVP .= $aSegs[$i].'/';
		}
	} else {
		$vcUriVP = 'inicio/';
	}
	
	$vcUriVP .= 'verificarPermisos';
	
  ?>
  	$(document).ready(function() {
  		
  		var getUris = function(element, parentContext) {
  			var uri = [];
  			
  			$(element).find('a, form').each(function(){
  				
  				var uriToCompare = '';
  				
  				if($(this).is('a')) {
  					uriToCompare = $(this).attr('href');
  				} else if($(this).is('form')) {
  					uriToCompare = $(this).attr('action');
  				}
  				if(jQuery.trim(uriToCompare)!='') {
  					uri.push(uriToCompare);
  				}
  			});
  			
  			$.ajax({
				'url': '<?= $vcUriVP; ?>'
				, 'type': 'post'
				, 'data': 'uris=' + uri.toString()
				, 'success': function(xmlResponse){
					var data = $( "uri", xmlResponse ).map(function() {
						return $(this).text();
					});
					parentContext = parentContext || element;
					$('a, form', $(parentContext)).each(function(){
						var $este = $(this);
		  				if($este.is('a')) {
		  					if(jQuery.inArray($este.attr('href'),data) < 0) {
		  						if($este.hasClass('button') || $este.hasClass('btn-accion')) {
		  							$este.remove();
		  						} else {
		  							$este.removeAttr('href');
		  						}
		  					}
		  				} else if($este.is('form')) {
		  					if(jQuery.inArray($este.attr('action'),data) < 0) {
		  						$('input, select, checkbox, radio, label', $este).remove();
		  					}
		  				}
					});
				}
			});
  			return uri;
  		};
		// getUris($('#main'));
  		$('#container').ajaxComplete(function(event, XMLHttpRequest, ajaxOptions){
  			// algo para hacer al devolver ajax sobre el container principal
  			/**/
  			if(ajaxOptions.url!='<?= $vcUriVP; ?>') {
  				window.setTimeout(function(){
  					// getUris($(XMLHttpRequest.responseText), $('#main'))
  				}, 500);
  				// var uri = getUris($(XMLHttpRequest.responseText));
  			}
  		});
  	});
  </script>
</body>
</html>