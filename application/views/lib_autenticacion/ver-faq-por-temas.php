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
?>
</br>
<h4><a>Seleccione un tema:</a></h4>
<!-- Muestro por orden de temas -->
<div id="faq">
    <ul>
        <?php foreach ($aTemas as $tema) : ?>
            <?php if ($tema['bActivo'] == 1) : ?>
                <li style="cursor: pointer;"><h4 title="<?= $tema['vcTemaDesc']; ?>"><?= $tema['vcTemaFaq']; ?> &raquo;</h4>
                    <?php foreach ($aFaq as $faq) : ?>
                        <?php if (($faq['inIdTemaFaq'] == $tema['inIdTemaFaq']) && ($faq['bActivo'] == 1)) : ?>
                            <ul>
                                <li><a class="texto-descripciones2">&raquo; <?= $faq['vcPregunta']; ?>:</a></li>
                        <li style="list-style-type: none;"><p class="texto-descripciones"><?= $faq['vcRespuesta']; ?></p></li>
                    </ul>
                <?php endif; ?>
            <?php endforeach; ?>
        </li>
    <?php endif; ?>
<?php endforeach; ?>
</ul>
</div>

<script lang="javascript" type="text/javascript">
    //Funciones para las vistas por tema
    //Si se ordena por temas el script muestra/oculta el tema seleccionado(en la vista por temas) -revisar al hacer click sobre una pregunta/respuesta se muestra y se oculta
    $('#faq ul li ul li').hide();
    $('#faq ul li').click(function(){
        $('#faq ul li ul > li').unbind();
        $('#faq ul li:hover ul li').toggle('slow');
    });
</script>