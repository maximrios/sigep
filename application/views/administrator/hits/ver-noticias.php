<?php 
iniciar_buffer_permisos();
if(count($aNovedades)>0): ?>
  <?php foreach($aNovedades as $itemNovedad): ?>
  <article class="noticias-home">
    <p class="texto-descripciones"><?=GetDateFromISO($itemNovedad['tsFechaInicio'])?></p>
    <h3><a href="inicio/novedades/<?=$itemNovedad['inIdNovedadesRol']?>"><?=$itemNovedad['vcNovTitulo']?></a></h3>
    <p class="texto-descripciones"><?=$itemNovedad['vcNovResumen']?><br />&nbsp;</p>
    <a class="button ok" href="inicio/novedades/<?=$itemNovedad['inIdNovedadesRol']?>">Ver novedad completa</a>
  </article>
  <?php endforeach; ?>
<?php else: ?>
  <article class="noticias-home">
    <p class="texto-descripciones">No hay <?=$esViaAjax?'m&aacute;s':''?> Novedades</p>
  </article>
<?php endif; ?>

<?php if($esViaAjax): ?>
<a href="javascript:void(0);" target="div-novedades-add" class="button <?=(count($aNovedades)>0?'agregar':'eliminar')?> btn-accion"><?=(count($aNovedades)>0?'Ver más novedades':'volver a las mas recientes')?></a>
<script language="JavaScript">
$(document).ready(function() {
	$('.btn-accion').viaAjax({url: 'inicio/vermas/<?=(count($aNovedades)>0?($pageNovedades+5):'0')?>'});
});
</script>
<?php endif;
filtrar_html_buffer();
// EOF contenido-novedades-ver.php