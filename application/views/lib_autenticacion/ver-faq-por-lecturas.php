<?php
/**
 * @author  Nacho Fassini
 * @version 1.0.0
 * @copyright 2011-12
 * @package base
 */
$vcNombreList = (!empty($vcNombreList)) ? $vcNombreList : 'Preguntas Frecuentes';
$vcMsjSrv = (!empty($vcMsjSrv)) ? $vcMsjSrv : '';
$btnVerMas = (!empty($btnVerMas)) ? $btnVerMas : '';
$cantMostrar = (!empty($cantMostrar)) ? $cantMostrar : 5;
?>
<!-- Verifico si el array de datos no esta vacio -->
<?php if (count($aFaq) > 0): ?>
    <div id="faq">
            <!-- Muesto por cantidad de lecturas -->
            <?php foreach ($aFaq as $faq) : ?>
                <article class="noticias-home">
                    <p class="texto-descripciones">Tema: <?= $faq['vcTemaFaq'] ?></p>
                    <h3><a style="cursor: pointer" title="Click para ver la respuesta" id="<?= $faq['inIdFaq'] ?>"><?= $faq['vcPregunta']; ?></a></h3>
                    <div class="texto-descripciones respuestas" id="r<?= $faq['inIdFaq'] ?>">
                        <?= $faq['vcRespuesta']; ?>
                        <br />&nbsp;<br />
                    </div>
                    <div class="button marcar" id="b<?= $faq['inIdFaq'] ?>"><?= $faq['inCantLecturas']; ?> Lecturas</div>
                    <div id="l<?= $faq['inIdFaq'] ?>" class="vacia"></div>
                </article>
                <div class="clearfloat"></div>
            <?php endforeach; ?>
    <br>
    </div>

<!-- Mje en caso de que no hayan datos para mostrar -->
<?php else: ?>
    <article class="noticias-home">
        <p class="texto-descripciones">No hay datos para su consulta.</p>
    </article>
<?php endif; ?>

<!-- Se cargan los botones de las opciones -->
    <div class="buttons">
        <a href="javascript:void(0)" id="ver-mas" class="button buscar">Ver Mas</a>
    </div>

<script type="text/javascript">
    $(document).ready(function(){
        //Funciones para la vista por cantidad de lecturas
        //Ocultar todas las respuestas en la vista por cantidad de lecturas al cargar la pagina(para la vista por lecturas) -ok
        $('.respuestas').hide();
        //Ocultar el boton ver mas si no hay mas datos que mostrar(en la vista por cantidad de lecturas) -ok
        if ((<?= $cantMostrar ?> != <?= sizeof($aFaq) ?>) || (<?= sizeof($aFaq) ?> == 0) ) { $('#ver-mas').hide(); }
        //Al hacer click en una preguta mostrar/ocultar su respuesta(en la vista por cantidad de lecturas) -ok
        $('h3 a').click(function(){
            $('#r'+($(this).attr('id'))).toggle();
        });
        //Script para sumar 1 a cada pregunta leida y ocultar el contador de lectura(en la vista por cantidad de lecturas) -ok
        $('h3 a').one('click',function(){
            $('#l'+($(this).attr('id'))).viaAjax('send',{ url : 'autenticacion/faq/sumarLectura/'+$(this).attr('id')});
            $('#b'+($(this).attr('id'))).hide();
        });
        //Script para cargar mas preguntas(en la vista por cantidad de lecturas) -ok
        $('#ver-mas').one('click',function(){
            $('#faq').viaAjax({'type':'POST' , 'url' : 'autenticacion/faq/verPorLecturas/<?= ($cantMostrar + 5); ?>'});
            $('#ver-mas').hide();
        });
    });
</script>