<?php
$vcHeaderLoginView = (!empty($vcHeaderLoginView))?$vcHeaderLoginView:'';
$vcBaseUrlAssets = (!empty($vcBaseUrlAssets))?$vcBaseUrlAssets: config_item('ext_base_url_assets');
$vcBaseUrlPlantillaElegida = (!empty($vcBaseUrlPlantillaElegida))?$vcBaseUrlPlantillaElegida: config_item('ext_base_url_plantilla_elegida');
$vcMenu = (!empty($vcMenu))? $vcMenu: '';
$vcMainContent = (!empty($vcMainContent))? $vcMainContent: '';
?>
<!DOCTYPE html>
<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="es"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="es"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="es"> <![endif]-->
<!--[if gt IE 8]><!-->
<html lang="es">
<!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <base href="<?= base_url(); ?>" />
    <title><?= $PanelInfo['titulo'].' - '.$PanelInfo['cliente']; ?></title>
    <meta name="description" content="<?= $PanelInfo['titulo'];?>">
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
    print incluirjscss_stylecss('_admin');
    print incluirjscss_linkjs('_admin');
?>
<!-- Scripts for any page -->

<!-- End Scripts for any page -->
</head>
<body>
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-vertical">
                    <span class="sr-only">Navegacion</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#"><?= $PanelInfo['titulo'];?></a>
                
            </div>
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $this->lib_autenticacion->apellidoPersona().', '.$this->lib_autenticacion->nombrePersona();?> <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="http://correo2.salta.gov.ar/webmail/" target="_blank"><span class="glyphicon glyphicon-cog"></span>&nbsp;&nbsp;Webmail</a></li>
                        <li class="divider"></li>
                        <li><a href="aut/logout"><span class="glyphicon glyphicon-off"></span>&nbsp;&nbsp;Cerrar Sesión</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
    <header>
    </header>
    <div id="wrapper" class="active">
        <div id="sidebar-wrapper" class="sidebar-holder">
            <ul id="sidebar_menu" class="sidebar-nav">
                <li class="sidebar-brand"><a id="menu-toggle" href="#">Menu<span id="main_icon" class="glyphicon glyphicon-align-justify"></span></a></li>
            </ul>
            <ul class="sidebar-nav" id="sidebar">     
                <li><a href="administrator/agentes">Agentes<span class="sub_icon glyphicon glyphicon-user"></span></a></li>
                <li><a href="administrator/formaciones">Formacion<span class="sub_icon glyphicon glyphicon-book"></span></a></li>
                <li><a href="administrator/cuadrocargos">Estructura<span class="sub_icon glyphicon glyphicon-tower"></span></a></li>
                <li><a href="administrator/cuadrocargosagentes">Cargos<span class="sub_icon glyphicon glyphicon-briefcase"></span></a></li>
                <li><a href="aut/logout">Cerrar Sesión<span class="sub_icon glyphicon glyphicon-off"></span></a></li>
            </ul>
        </div>
        <div id="page-content-wrapper">
            <div class="page-content inset">
                <br>
                <div class="row">
                    <div class="col-md-12" style="padding-top:5px;">
                        <?= $vcMainContent; ?>          
                    </div>
                </div>
            </div>
        </div>
    </div>
<script type="text/javascript">
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("active");
    });
</script>
</body>
</html>