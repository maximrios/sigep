<?php
/**
 * @author Nacho Fassini
 * @version 1.0.0
 * @copyright 2011-12
 * @package base
 */
$vcMsjSrv = (!empty($vcMsjSrv))? $vcMsjSrv: '';
?>
      <div class="full-content">
        <div class="box-normal-100">
          <span class="ico-titulo mensajes-40">&nbsp;</span>
          <h2 class="fontface-arimo-titulo">Administraci&oacute;n de Preguntas Frecuentes del Sistema Base</h2>
          <p>En esta secci&oacute;n podr&aacute; administrar las preguntas frecuentes y sus respuestas.</p>
        </div>
        <ul id="ulSubMenuTab" class="ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all">
            <li class="ui-state-default ui-corner-top ui-tabs-selected ui-state-active">
                <a href="autenticacion/faq/listado"><span>Preguntas Frecuentes</span></a>
            </li>
            <li class="ui-state-default ui-corner-top ui-tabs-selected ui-state-active">
                <a href="autenticacion/faq/listadotemas"><span>Temas</span></a>
            </li>
        </ul>
		<section class="box-normal-100">
		  <?= $vcMsjSrv; ?>
          <div id="contenido-abm" class="container-gridview"></div>
        </section>
      </div>
      <div class="clearfloat">&nbsp;</div>
      <script type="text/javascript">
		$(document).ready(function(){
            $('#ulSubMenuTab a').click(function(event){
                event.preventDefault();
                $('#clearBoxEveryClick').html('<div id="contenido-abm" class="container-gridview"></div>');
                $('#ulSubMenuTab li').attr('class', 'ui-state-default ui-corner-top');
                $(this).parent().attr('class', 'ui-state-default ui-corner-top ui-tabs-selected ui-state-active');
                $('#contenido-abm').gridviewHandler({'url': $(this).attr('href')});
            });
            $('#ulSubMenuTab a:first').click();
		});
      </script>