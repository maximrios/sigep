<script type="text/javascript">
$(document).ready(function() {
    $('.jqzoom').jqzoom({
        zoomType: 'standard',
        lens: false,
        title: false,
        preloadImages: false,
        alwaysOn:false,
        showEffect: 'fadein',  
        hideEffect: 'fadeout'
    });
});
</script>
<section class="content wrap-content row">
	<div class="col-lg-2">
		<ul class="nav nav-panel">
            <li>
            	<label label-default="" class="tree-toggle nav-header">Aberturas</label>
            	<ul class="nav tree">
	            	<li><a href="#">Puertas</a></li>
                	<li><a href="#">Ventanas</a></li>
				</ul>
            </li>
            <li>
            	<label label-default="" class="tree-toggle nav-header">Muebles en placa</label>
                <ul class="nav tree">
                	<li><a href="#">Cocinas</a></li>
                    <li><a href="#">Comedores</a></li>
                    <li><a href="#">Dormitorios</a></li>
                    <li><a href="#">Placards</a></li>
				</ul>
			</li>
            <li>
				<label label-default="" class="tree-toggle nav-header">Rústicos</label>
                <ul class="nav tree">
                	<li><a href="#">Puertas</a></li>
					<li><a href="#">Ventanas</a></li>
					<li><a href="#">Cocinas</a></li>
					<li><a href="#">Comedores</a></li>
					<li><a href="#">Dormitorios</a></li>
                    <!--<li>
                    	<label label-default="" class="tree-toggle nav-header">Media Queries</label>
                        <ul class="nav tree">
                        	<li><a href="#">Text</a></li>
                            <li><a href="#">Images</a></li>
						</ul>
                    </li>-->
                </ul>
            </li>
		</ul>
	</div>
	<div class="col-lg-10 thumbs">
        <br>
        <div class="row">
            <div class="col-lg-6">
                <a href='<?=$imagenes[0]['pathProductoImagen']?>' class="jqzoom" rel='galeria<?=$producto['idProducto']?>'>
                    <img src="<?=$imagenes[0]['detailProductoImagen']?>" alt="<?=$producto['nombreProducto']?>" style="margin:0.5em;">
                </a>
                <div class="thumbs">
                    <ul id="thumblist">
                        <?php 
                        $i = 1;
                        foreach ($imagenes as $imagen) { 
                            if($i != 1) {?>
                                <a href="javascript:void(0);" id="imagen<?=$i?>" class="" rel="{gallery: 'galeria<?=$producto['idProducto']?>', smallimage: '<?=$imagen['detailProductoImagen']?>', largeimage: '<?=$imagen['pathProductoImagen']?>'}">
                                    <img src="<?=$imagen['thumbdetailProductoImagen']?>">
                                </a>
                            <?php
                            } 
                            $i++;
                        } ?>
                    </ul>
                </div>
            </div>
            <div class="col-lg-6">
                <h5><?=$producto['nombreProducto']?></h5>
                <p><?=$producto['descripcionProducto']?></p>
                <h5>Especificaciones</h5>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
            </div>
        </div>
        <hr>
        <h5>Productos Relacionados</h5>
        <ul>
            <?php foreach ($productos as $producto) { ?>
            <li class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                <figure style="text-align:center;padding: 0.4em 0;margin:0.3em;background:white;border: 1px solid #D9D9D9;min-height:180px;">
                    <a href="producto/<?=$producto['uriProducto']?>"><img width="170" src="<?=$producto['thumbProductoImagen']?>" alt="<?=$producto['nombreProducto']?>"></a>
                    <figcaption>
                        <label style="margin:0.5em 0;"><?=$producto['nombreProducto']?></label>
                    </figcaption>
                </figure>
            </li>
            <?php } ?>  
        </ul>
    </div>
</section>
