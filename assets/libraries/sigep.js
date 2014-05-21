/*var gestionUsuarios = function() {
	event.preventDefault();
	$(this).fancybox({
		'autoScale' : true,
		'autoDimensions': false,
		'type' : 'ajax'
	});
}
var mensajesNuevos = function() {
	$.ajax({
		url: 'administrator/mensajes/obtenerMensajesNuevos',
		type: 'post',
		data: 'color',
		success: function() {
			alert('llegan');
		}
	});
}


var mensajeNuevo = function(event) {
	event.preventDefault();
	$(this).fancybox({
		'autoScale' : true,
		'autoDimensions': false,
		'type' : 'ajax'
	});
}
var guardarMensaje = function(event) {
	event.preventDefault();
	$form = $(this.form);
	$.ajax({
		url: $form.attr('action'),
		type: $form.attr('method'),
		data: $form.serialize(),
		success: function() {
			$.fancybox.close();
		}
	});
}
var enviarFancybox = function(event) {
	event.preventDefault();
	$form = $(this.form);
	$.ajax({
		url: $form.attr('action'),
		type: $form.attr('method'),
		data: $form.serialize(),
		success: function() {
			$.fancybox.close();
			location.reload();
		}
	});

}
var enLinea = function(event) {
	event.preventDefault();
	$(this).fancybox({
		'autoScale' : true,
		'autoDimensions': false,
		'type' : 'ajax'
	});
}
var enviarData = function(event) {
	event.preventDefault();
}


function cumpleano() {
	$('.disfancy').fancybox({
		 'autoScale' : true,
		 'autoDimensions': false,
		 //'transitionIn' : 'none',
		 //'transitionOut' : 'none',
		 'type' : 'ajax'
	 });
}
function perfil() {
	$('.perfil').fancybox({
		'autoDimensions': false,
		 'autoScale' : false,
		 'width' : 700,
		 'height' : 300,
		 
		 //'transitionIn' : 'none',
		 //'transitionOut' : 'none',
		 'type' : 'ajax'
	 });
}
function pass() {
	$('.pass').fancybox({
		 'width' : '300',
		 'height' : '300',
		 //'autoScale' : true,
		 //'transitionIn' : 'none',
		 //'transitionOut' : 'none',
		 'type' : 'ajax'
	 });
}

function agregarComision() {
	$("#agregarComision").fancybox({
		 'width' : '75%',
		 'height' : '75%',
		 'autoScale' : false,
		 'transitionIn' : 'none',
		 'transitionOut' : 'none',
		 'type' : 'ajax'
	});	
}

var mostrarM = function (event) {
	event.preventDefault();
	malRel = $(this).attr('rel').toString();
	while (varRel.indexOf("'") != -1) {
		varRel = varRel.replace("'", '"');
	}
	vars = $.param(jQuery.parseJSON(varRel));
	$.ajax({
		url: $(this).attr('href'),
		type: 'POST',
		data: vars,
		success: function() {
			
		}
	});
	$.fancybox(this, {
		'autoScale' : true,
		'autoDimensions': false,
		'type' : 'ajax'
	});
}

	//ACA le asigno el evento click a cada boton de la clase bt_plus y llamo a la funcion addField
		
 
 
function agregarArticulo(){
	// ID del elemento div quitandole la palabra "div_" de delante. Pasi asi poder aumentar el número. Esta parte no es necesaria pero yo la utilizaba ya que cada campo de mi formulario tenia un autosuggest , así que dejo como seria por si a alguien le hace falta.
 	var clickID = parseInt($(this).parent('li').attr('id').replace('articulo_',''));
 	// Genero el nuevo numero id
	var newID = (clickID + 1);
 	// Creo un clon del elemento div que contiene los campos de texto
	$newClone = $('#articulo_'+clickID).clone(true);
 	//Le asigno el nuevo numero id
	$newClone.attr("id",'articulo_'+newID);
	//Asigno nuevo id al primer campo input dentro del div y le borro cualquier valor que tenga asi no copia lo ultimo que hayas escrito.(igual que antes no es necesario tener un id)
	$newClone.children('label').eq(0).html('Articulo N° '+newID);
	$newClone.children("textarea").eq(0).attr("id",'textarea_articulo_'+newID).val('');
	//Borro el valor del segundo campo input(este caso es el campo de cantidad)
	//$newClone.children("input").eq(1).val('');
 
	//Asigno nuevo id al boton
	//$newClone.children("input").eq(2).attr("id",newID)
 
	//Inserto el div clonado y modificado despues del div original

	$newClone.insertAfter($('#articulo_'+clickID));
	//Cambio el signo "+" por el signo "-" y le quito el evento addfield
	//$("#articulo_"+clickID).val('-').unbind("click",addField);

	//$("#articulo_"+clickID).children('a').eq(0).unbind("click",agregarArticulo);
	$("#articulo_"+clickID).children('a').remove();
	return false;
	//Ahora le asigno el evento delRow para que borre la fial en caso de hacer click
	//$("#"+clickID).bind("click",delRow);					

}
 
 
function delRow() {
// Funcion que destruye el elemento actual una vez echo el click
$(this).parent('div').remove();
 
}
*/
function probada() {
	alert('ahora');
}