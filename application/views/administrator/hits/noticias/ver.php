<style>
.tituloSeccion {
	margin: 2em 0 0 0;
	padding-bottom: 0;
	margin-bottom: 0;
}
hr {
	margin-top: 0.5em;
}
.comentarios {
	clear: both;
	width: 100%;
}
div#comentario {
	display: block;
}
p.comentario {
	font-size: 1.1em;
	color: #888;
}
#agregarComentario figure, #listadoComentarios figure {
	text-align: center;
	width: 10em;
}
#agregarComentario figure figcaption, #listadoComentarios figure figcaption {
	font-size: 0.8em;
	font-weight: bold;
}
#agregarComentario .formularioComentario {
	width: 65em;
}
#agregarComentario figure, #agregarComentario .formularioComentario, #listadoComentarios figure, #listadoComentarios .formularioComentario {
	display: inline-block;
	vertical-align: top;
}
#agregarComentario .formularioComentario textarea {
	resize: none;
	width: 100%;
}
#agregarComentario .formularioComentario button {
	float: right;
}
#listadoComentarios {
	margin-top: 2em;
	margin-left: 10em;
	width: 65em;
}
</style>
<div id="noticia" class="noticia">
	<h4><?php echo $noticia['nombreTipoNoticia'];?></h4>
    <h5><?php echo $noticia['tituloNoticia'];?></h5>
	<span><?php echo 'Publicado '.GetDateFromISO($noticia['inicioNoticia']).' por '.$noticia['nombrePersona']?></span>
	<p><?php echo html_entity_decode($noticia['descripcionNoticia']);?></p>
</div>
<div class="comentarios">
	<h4 class="tituloSeccion">Comentarios</h4>
	<hr>
	<div id="agregarComentario">
		<figure>
			<img src="assets/images/personas/<?php echo $this->lib_autenticacion->dniPersona();?>-75-75.jpg">
			<figcaption><?php echo $this->lib_autenticacion->apellidoPersona().' '.$this->lib_autenticacion->nombrePersona();?></figcaption>
		</figure>
		<div class="formularioComentario">
			<form id="form-agregarComentario" name="form-agregarComentario" method="post" action="administrator/noticias/comentar">
				<textarea id="textoNoticiaComentario" name="textoNoticiaComentario" rows="3" placeholder="Escribe un comentario..."></textarea>
				<button id="btn-agregarComentario" class="btn btn-primary"><i class="icon-retweet icon-white"></i>&nbsp;&nbsp;Enviar Comentario</button>
				<input type="hidden" id="idNoticia" name="idNoticia" value="<?php echo $noticia['idNoticia']?>">
				<input type="hidden" id="idPersona" name="idPersona" value="<?php echo $this->lib_autenticacion->idPersona();?>">
			</form>
		</div>
	</div>
	<div id="listadoComentarios">
		<?php foreach ($comentarios as $comentario) { ?>
		<div id="comentario">
			<figure>
				<img src="assets/images/personas/<?php echo $comentario['dniPersona'];?>-75-75.jpg">
				<figcaption><?php echo $comentario['completoPersona'];?></figcaption>
			</figure>
			<div class="formularioComentario">
				<?php echo GetDateTimeFromISO($comentario['fechaNoticiaComentario']);?>
				<p class="comentario">" <?php echo $comentario['textoNoticiaComentario'];?> "</p>
				<input type="hidden" id="idComentario" name="idComentario" value="0">
			</div>
			<hr>
		</div>
		<?php } ?>
	</div>
</div>
<script>
	var agregarComentarioListado = function() {
		$('#listadoComentarios').prepend('<figure><img src="assets/images/personas/-75-75.jpg"><figcaption>aca el nombre</figcaption></figure><div class="formularioComentario"><p class="comentario">aca el contenido</p></div>');
	}
	var agregarComentario = function(event) {
		event.preventDefault();
		var formName = $(this).attr('id').replace('btn-','form-');
		$form = $('#'+formName);
		$.ajax({
			url: $form.attr('action'),
			type: $form.attr('method'),
			data: $form.serialize(),
			dataType: 'json',
			success: function(comentario) {
				$('#listadoComentarios').prepend('<figure><img src="assets/images/personas/'+comentario['dniPersona']+'-75-75.jpg"><figcaption>'+comentario['completoPersona']+'</figcaption></figure><div class="formularioComentario">'+comentario['fechaNoticiaComentario']+'<p class="comentario">'+comentario['textoNoticiaComentario']+'</p></div><hr>');
				$("#textoNoticiaComentario").val('');
			}
			//success: agregarComentarioListado(datos),
		});
	}
	$('#btn-agregarComentario').on('click', agregarComentario);
</script>
