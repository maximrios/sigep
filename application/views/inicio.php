<div class="content">
    <div id="slider" class="nivoSlider">
        <?php foreach ($slider as $imagen) { ?>
            <a href="<?=$imagen['linkSlider']?>" target="<?=$imagen['targetSlider']?>"><img src="<?=$imagen['pathSlider']?>" alt="<?=$imagen['tituloSlider']?>"/></a>
        <?php } ?>
    </div>
</div>
<section class="content">
    <div class="row" style="margin:0;">
        <div class="col-lg-12 anuncio" style="background:blue;padding:0;font-size: 1.4em;text-align:center;min-height:90px;">
            <div class="col-lg-9" style="background:#E36F35;min-height:90px;">
                <span>Muebles al por mayor en serie para mayoristas. La mejor calidad en el menor tiempo y costo.</span>
            </div>
            <div class="col-lg-3" style="background:#393737;color:#FFF;min-height:90px;">
                <span class="nuevo">Nuevo !!!</span>
            </div>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-lg-12">
        <h5>Productos destacados</h5>
        <br>
        <div class="col-lg-4"><span class="icono-atencion">Design</span>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nam, ullam, ea, minus, iure laboriosam voluptates amet omnis iusto quibusdam consequuntur sit doloribus expedita dolores? A aliquid aperiam quae asperiores molestiae.</div>
        <div class="col-lg-4"><span class="icono-atencion">Time</span>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolores, dignissimos iure ipsam sit odio pariatur amet asperiores in beatae rerum sunt aut. Quidem, quam, asperiores at architecto sint nisi laborum.</div>
        <div class="col-lg-4"><span class="icono-atencion">Gear</span>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eos, ipsa inventore totam atque modi quae quo vitae ullam consequuntur eaque repudiandae nobis saepe labore doloribus sint. Vel tenetur assumenda voluptas!</div>
        </div>
    </div>
    <hr>
    <div class="row" style="margin:0;margin-top:1em;">
        <h5>Productos destacados</h5>
        <ul>
            <?php foreach ($productos as $producto) { ?>
            <li class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
                <figure style="text-align:center;padding: 0.4em 0;margin:0.3em;background:white;border: 1px solid #D9D9D9;min-height:180px;">
                    <a href="producto/<?=$producto['uriProducto']?>" title="<?=$producto['nombreProducto']?>" alt="<?=$producto['nombreProducto']?>"><img width="170" src="<?=$producto['thumbProductoImagen']?>" alt="<?=$producto['nombreProducto']?>"></a>
                    <figcaption>
                        <label style="margin:0.5em 0;"><?=$producto['nombreProducto']?></label>
                    </figcaption>
                </figure>
            </li>
            <?php } ?>  
        </ul>
    </div>
    <hr>
    <div class="row" style="margin:2em 0!important;">
        <div class="col-lg-4">
            <h5>Productos para Mayoristas</h5>
            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
            tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
            quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo<br><br><br>
            <a href="" class="btn btn-warning pull-right" role="button">Ver mas</a>
        </div>
        <div class="col-lg-4 middle">
            <h5>Servicios</h5>
            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
            tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
            quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo<br><br>
            <a href="" class="btn btn-warning pull-right" role="button">Ver mas</a>
        </div>
        <div class="col-lg-4">
            <h5>Formas de Pago</h5>
            <img src="assets/images/formas-pago.png">
        </div>
    </div>
</section>
<script type="text/javascript">
//$(window).load(function() {
    $('#slider').nivoSlider({
        directionNav: false,             // Next & Prev navigation
        controlNav: false,
        effect: 'fade',               // 1,2,3... navigation
    });
//});
</script>