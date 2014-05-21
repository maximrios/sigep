<section class="content wrap-content row">
	<div class="col-lg-3">
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
	<div class="col-lg-9">
		<h4>Productos destacados</h4>
		<ul class="row" style="display:inline-block;">
			<li style="display:inline-block;">
			<?php
			$i = 1;
			for($i=1;$i<=3;$i++) { ?>
				<img src="assets/images/productos/imagen<?=$i?>_thumb.jpg" style="margin: 0.4em;" width="">
			<?php } ?>
			</li>
		</ul>
		<h5>Aberturas / Ventanas</h5>
		<div class="row">
			<ul>
				<?php foreach ($productos as $producto) { ?>
				<li class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
					<figure style="text-align:center;padding: 0.4em 0;margin:0.3em;background:white;border: 1px solid #D9D9D9;min-height:330px;">
						<a href="producto/<?=$producto['uriProducto']?>"><img width="170" src="<?=$producto['thumbProductoImagen']?>" alt="<?=$producto['nombreProducto']?>"></a>
						<figcaption>
							<label style="font-size:1em;margin:0.5em 0;"><?=$producto['nombreProducto']?></label>
							<p style="font-size:0.9em;"><?=$producto['descripcionProducto']?>.</p>
						</figcaption>
					</figure>
				</li>
				<?php } ?>	
			</ul>
		</div>
	</div>
</section>
<script type="text/javascript">
$('.tree-toggle').click(function () {
	$(this).parent().children('ul.tree').toggle(200);
});
$("a[rel^='prettyPhoto']").prettyPhoto();
</script>