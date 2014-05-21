<?php
	$vcHeaderLoginView = (!empty($vcHeaderLoginView))?$vcHeaderLoginView:'';
	$vcBaseUrlAssets = (!empty($vcBaseUrlAssets))?$vcBaseUrlAssets: config_item('ext_base_url_assets');
	$vcBaseUrlPlantillaElegida = (!empty($vcBaseUrlPlantillaElegida))?$vcBaseUrlPlantillaElegida: config_item('ext_base_url_plantilla_elegida');
	$vcMenu = (!empty($vcMenu))? $vcMenu: '';
	$vcMainContent = (!empty($vcMainContent))? $vcMainContent: '';
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<base href="<?= base_url(); ?>" />
	<title><?= $PanelInfo['titulo'].' - '.$PanelInfo['cliente']; ?></title>
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<link rel="shortcut icon" href="./assets/images/favicon.png" type="image/x-icon">
	<?php
  		print incluirjscss_stylecss('_admin');
  		print incluirjscss_linkjs('_admin');
	?>
</head>
<body>
	<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <a class="navbar-brand" href="#"><?= $PanelInfo['titulo'];?></a>
            </div>
        </div>
	</nav>
    <div class="page-content inset">
		<div class="col-lg-12" style="padding-top:15px;">
        	<?= $vcMainContent; ?>          
        </div>
	</div>
</body>
</html>