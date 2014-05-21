<?php
    $vcHeaderLoginView = (!empty($vcHeaderLoginView))?$vcHeaderLoginView:'';
    $vcBaseUrlAssets = (!empty($vcBaseUrlAssets))?$vcBaseUrlAssets: config_item('ext_base_url_assets');
    $vcBaseUrlPlantillaElegida = (!empty($vcBaseUrlPlantillaElegida))?$vcBaseUrlPlantillaElegida: config_item('ext_base_url_plantilla_elegida');
    //$vcMenu = (!empty($vcMenu))? $vcMenu: '';
    $vcMainContent = (!empty($vcMainContent))? $vcMainContent: '';
?>
<!DOCTYPE html>
<!--[if lt IE 7]> <html class                                       ="no-js ie6 oldie" lang="es"> <![endif]-->
<!--[if IE 7]>    <html class                                       ="no-js ie7 oldie" lang="es"> <![endif]-->
<!--[if IE 8]>    <html class                                       ="no-js ie8 oldie" lang="es"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" lang="es">
    <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <base href="<?= base_url(); ?>" />
        <title><?=$SiteInfo['title']; ?></title>
        <meta name="description" content="<?= $SiteInfo['descriptions'];?>">
        <meta name="author" content="<?= $SiteInfo['author'];?>">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <link rel="shortcut icon" href="./assets/images/favicon.png" type="image/x-icon">
        <!--<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>-->
        <?php
            # Para garantizar que los archivos CSS se descarguen en paralelo,
            # incluya siempre los recursos CSS externos antes que los recursos JavaScript externos
            print incluirjscss_stylecss();
            print incluirjscss_linkjs();
        ?>
        <!-- Scripts for any page -->
        <?= $vcIncludesGlobales; ?>
        <!-- End Scripts for any page -->
        <style type="text/css">
        .lavalamp-object {
            top: -10px!important;
            border-bottom: 2px solid orange;
        }
        #nav-primary li:hover a {
            color: orange!important;
        }
        </style>
    </head>
    <body>
        <!--<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/es_LA/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>-->

        <section class="container header">
            <header class="content">
                <h1 id="logo">
                    <a href="http://www.industriasrosobe.com.ar" alt="<?=config_item('ext_base_nombre_sitio');?>" title="<?=config_item('ext_base_nombre_sitio');?>">Industrias RoSoBe</a>
                </h1>
                <div class="div-40 like">
                    <ul class="">
                        <div class="fb-like" data-href="http://www.industriasrosobe.com.ar" data-layout="button_count" data-action="like" data-show-faces="false" data-share="false"></div>
                    </ul>
                </div>
                
                <ul class="datas">
                    <li>(0387) 4010107 - 4290826</li>
                    <li><a href="mailto:info@industriasrosobe.com.ar" title="Industrias Ro.So.Be.">info@industriasrosobe.com.ar</a></li>
                    <li>Av. Ex Combatientes de Malvinas 6201</li>
                    <li>Salta - Argentina</li>
                </ul>
            </header>
        </section>
        <!--<section class="container nav">-->
        <section>
            <!--<nav class="content">-->
            <!--<?=$vcMenu;?>-->
            <!--</nav>-->
            <nav class="navbar" role="navigation">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                            <span class="sr-only">Menú</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                    </div>
                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <ul id="nav-primary" class="nav navbar-nav wrap-nav nav-primary" style="width:100%;margin:0 auto!important;">
                            <?php
                            echo $vcMenu;
                            ?>
                            <!--<li><a href="#">Inicio</a></li>
                            <li><a href="#">Quienes Somos</a></li>
                            <li><a href="#">Mayoristas<span class="badge badge-important">Nuevo</span></a></li>
                            <li><a href="inicio/productos">Productos</a></li>
                            
                            <li><a href="#">Servicios</a></li>
                            <li><a href="#">Galeria</a></li>
                            <li><a href="inicio/contacto">Contacto</a></li>-->
                        </ul>
                    </div>
                </div>
            </nav>

            
        </section>
        <section class="container">
            <?=$vcMainContent; ?>
        </section>
        <section class="container footer" style="background:#E36F35;">
            <footer class="content">
                <div class="col-lg-2">
                    <h5>MENU</h5>
                    <ul>
                    <?=$vcMenu;?>
                    </ul>
                </div>
                <div class="col-lg-3">
                    <h5>OFICINA EN SALTA</h5>
                    <ul>
                        <li>(0387) 4010107 - 4290826</li>
                        <li><a href="mailto:info@industriasrosobe.com.ar" title="Industrias y Servicios Ro.So.Be.">info@industriasrosobe.com.ar</a></li>
                        <li>Av. Ex Comb. de Malvinas 6201</li>
                        <li>Salta - Argentina</li>
                    </ul>
                </div>
                <div class="col-lg-3">
                    <h5>OFICINA EN CORDOBA</h5>
                    <ul>
                        <li>(0387) 4010107 - 4290826</li>
                        <li><a href="mailto:info@industriasrosobe.com.ar" title="Industrias y Servicios Ro.So.Be.">info@industriasrosobe.com.ar</a></li>
                        <li>Av. Ex Comb. de Malvinas 6201</li>
                        <li>Cordoba - Argentina</li>
                    </ul>
                </div>
                <div class="col-lg-3">
                    <h5>REDES SOCIALES</h5>
                    <ul class="sociales">
                        <li><a href="#" class="redes_sociales facebook"></a></li>
                        <li><a href="#" class="redes_sociales twitter"></a></li>
                        <li><a href="#" class="redes_sociales flickr"></a></li>
                    </ul>
                </div>
                <div class="col-lg-1" style="text-align:center;">
                    <img src="assets/themes/base/img/fiscal.png" alt="" width="75">
                </div>
            </footer>
        </section>
        <div class="col-lg-12" style="background:#393737;padding:0.9em 0;text-align:center;font-size:0.8em;color:#FFF;">
            Industrias y Servicios Ro.So.Be. - Todos los derechos reservados &copy; 2014
        </div>
        <script>
            jQuery(document).ready(function(){
    $(".dropdown").hover(
        function() { $('.dropdown-menu', this).fadeIn("fast");
        },
        function() { $('.dropdown-menu', this).fadeOut("fast");
    });
});
            $('#nav-primary').lavalamp({
                easing: 'easeOutBack'
            });
            $('#badge-important').animate({
                'margin-top':'-25px',
                'margin-top':'5px'
            },1500);
        </script>
    </body>
</html>