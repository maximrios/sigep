/**
 * Clase gridviewHandler 1.0.0, jQuery
 * @author Marcelo Gutierrez
 * Permite la gestion de un Gridview de CI con controles asociados a un ABM y a un paginador.
 * Dependencias:
 *  - viaAjax 1.0.0, jQuery plugin , Copyright(c) 2011, Marcelo Gutierrez
 * 	- Inline Form Validation Engine 2.2.3, jQuery plugin, Copyright(c) 2010, Cedric Dugas
 * Licensed under the MIT License
 * 
 * Ejemplo de uso:
 * 
 * 
 * 0	Tener un controlador que haga uso de un paginador CI usando el patron de ABM 
 * 			listado-¬
 * 					 -- formulario agregar
 * 					 -- formulario modificar
 * 					 -- formulario eliminar
 * 					 -- buscador
 * 					 --	alguna otra accion mediante links o botones en formularios
 * 
 * 1	1 - dentro de un ready: $('#id_destino_del_listado').gridviewHandler(uri_controlador);
 * 		
 * 		2 - Añadir a todos los elementos que ejecuten acciones la class btn-accion (comportamiento por default) para obtener las respuestas viaAjax
 * 				> regla de link <a href="uri_controlador" target="[opcional destino_del_request]" class="btn-accion [otras_clases]">Link</a>
 * 				> regla de button o submit dentro de un form 
 * 					<form ... target="[opcional destino_del_request]" >
 * 						<input type="[button|submit]" class="btn-accion [otras_clases]" />
 * 					</form>
 * 			Las mismas reglas se aplican al plugin $.viaAjax()
 * 		
 * 		3 - Si se desea resetear el estado del listado entre requests agregar la clase modificadora btn-reset y el listado volvera a la configuracion inicial
 * 
 * 2	1 - Manejo de eventos:
 * 				> success: expone el evento succes del plugin viaAjax similar al $.ajax luego de cada request exitosa. Puede usarse para realizar ajustes posteriores a cada peticion realizada.
 * 				> beforeSend: similar al anterior pero ocurre antes de cada request.
 * 
 */
(function( $ ){
	var methods = {
		init: function(options) {
			var options = options || null;
			return this.each(function() {
				var self = $(this);
			  	options = self.gridviewHandler('_getOptions',self, options);
			  	if(!self.data('gvh') || self.data('gvh')==null) {
		  			self.data('gvh', options);
		  		}
				if(options.url) {
					self.gridviewHandler('list', options);
				} else {
					self.gridviewHandler('readyFunc', options);
				}
				// configurar el contenedor del state de la grilla
				self.parent().append(
					$('<form id="'+self.attr('id')+'-state"><input type="hidden" name="viewstate" id="viewstate" value=""/></form>')
				);
			});
		}
		, _getOptions: function(self, options) {
            var gvhDefaults = $.gridviewHandler.defaults;
			if(!self.data('gvh') || self.data('gvh')==null) {
		  		self.data('gvh', $.extend(true, {}, gvhDefaults, options));
		  	} else {
		  		gvhDefaults = $.extend(true, {}, gvhDefaults, self.data('gvh'));
		  	}
		  	options = $.extend(true, {}, gvhDefaults, options);
		  	return options;
		}
		, list: function(options) {
			var self = $(this);
			options = self.gridviewHandler('_getOptions',self, options);
			var action = options.url;
			var vars = self.gridviewHandler('getState', options);
			var vaxOptions = {
				'url': action
				, 'vars': vars
				, 'type': 'POST'
				, 'overwriteSuccess': false
				, 'success': function(data, textStatus, jqXHR) {
					self.gridviewHandler('readyFunc', options);
					$.isFunction( options.events.success ) && options.events.success.call(self, [data, textStatus, jqXHR]);
				}
				, 'beforeSend': function(jqXHR, settings) {
					$.isFunction( options.events.beforeSend ) && options.events.beforeSend.call(self, [jqXHR, settings]);
				}
			}
			self.viaAjax('send', vaxOptions);
		}
		, clearState: function(options) {
            $('#' + $(this).attr('id') + '-state input').val('');
		}
		, setState: function(options) {
			var self = $(this);
			options = self.gridviewHandler('_getOptions', self, options);
			var theForm = $('#'+options.grid.form);
			if(theForm.length > 0) {
                $('#' + self.attr('id') + '-state input').val(theForm.serialize());
			}
		}
		, getState: function(options){
			var self = $(this);
			options = self.gridviewHandler('_getOptions', self, options);
			return $('#' + self.attr('id')+'-state input').attr('value') || '';
		}
        , setResetButton: function (options) {
        }
		, readyFunc: function(options) {
			// buscar el destino de la respuesta
			var self = $(this);
			options = self.gridviewHandler('_getOptions', self, options);
			// Asigno la url para la cual se van a hacer consulta haciendo click sobre el registro
			// buscar y asignar acciones de la respuesta
			var vaxOptions = {
				'success': function(data, textStatus, jqXHR) {
					self.gridviewHandler('readyFunc',{'url': options.url});
					$.isFunction( options.events.success ) && options.events.success.call(self, [data, textStatus, jqXHR]);
					
				}
				, 'beforeSend': function(jqXHR, settings) {
					$.isFunction( options.events.beforeSend ) && options.events.beforeSend.call(self, [jqXHR, settings]);
				}
			}
            var theForm  = $('#' + options.grid.form);
            getStateOptions = self.gridviewHandler('getState',options);
            var qStr = (self.gridviewHandler('getState', options)).split('&');
			self.gridviewHandler('setState', options);
			$('#' + self.attr('id') + ' .' + options.grid.actionButons).each(function(idx, element) {
				var element = $(element);
				var vars = '';

				if(element.is('a')) {
					// definir el target de respuesta al mismo contenedor en caso de no estar especificado.
					if(!element.attr('target')) {
						element.attr('target',self.attr('id'));
					}
					
					if(!element.hasClass(options.grid.resetModifier)) {

						var rel = element.attr('rel');
						if(rel) {
	                        stcRel = 
                            varRel = 
                            malRel = element.attr('rel').toString();
	                        while (varRel.indexOf("'") != -1) {
	                            varRel = varRel.replace("'", '"');
	                        }
	                        while (malRel.indexOf('"') != -1) {
	                            malRel = malRel.replace('"', "'");
	                        }
                            if (stcRel == varRel) {
                                if (!window.console) console.log('por favor corrija el "rel" de los links: rel=\'' + stcRel + '\'');                                    
                            }
							try {
                                vars = $.param(jQuery.parseJSON(varRel));
							} catch(ex) {
								vars = self.gridviewHandler('getState',options);
							}
						} else {
							vars = self.gridviewHandler('getState',options);
						}
					}
					
					// setear las acciones mediante post "NO GET"
					vaxOptions = $.extend({}, vaxOptions, {
						'url': element.attr('href'),
                        'type':'POST',
                        'vars': vars
					});
				} else if(element.is('input[type=submit]') || element.is('input[type=button]')) {
					var sendForm = $('#' + element[0].form.id);
					
					if(!element.hasClass(options.grid.resetModifier)) {
						for(i=0; i<qStr.length;i++) {
							var comps = qStr[i].split('=');
							if(comps.length>1) {
								if($('#' + element[0].form.id + ' input[name='+comps[0]+']').length == 0) {
									$('<input>').attr({'type': 'hidden', 'name': comps[0]}).val(unescape(comps[1].replace(/\+/g,' '))).appendTo(sendForm);
								} else {
									$('#' + element[0].form.id + ' input[name='+comps[0]+']').val(comps[1]);
								}
							}
						}
					}
					element = sendForm;
					
					if(!element.attr('target')) {
						element.attr('target',self.attr('id'));	
					}
					
					vaxOptions = $.extend({}, vaxOptions, {
						'url': element.attr('action')
					});
				}
				/*$(element).on('click', function(e) {
					e.preventDefault();
					$.ajax({
						type: 'POST',
						url: vaxOptions.url,
						data: vaxOptions.vars,
						success: function(data) {
							$.fancybox(data);
						}
					});
				});*/
				$(element).viaAjax(vaxOptions);
			});
		 	$('#' + self.attr('id') + ' .' + options.grid.actionButonsFinder).each(function(idx, element) {
				var element = $(element);

				var vars = '';
				if(element.is('a')) {
					// definir el target de respuesta al mismo contenedor en caso de no estar especificado.
					
					if(!element.attr('target')) {
						element.attr('target',self.attr('id'));
					}
					
					if(!element.hasClass(options.grid.resetModifier)) {

						var rel = element.attr('rel');

						if(rel) {
	                        stcRel = 
                            varRel = 
                            malRel = element.attr('rel').toString();
	                        while (varRel.indexOf("'") != -1) {
	                            varRel = varRel.replace("'", '"');
	                        }
	                        while (malRel.indexOf('"') != -1) {
	                            malRel = malRel.replace('"', "'");
	                        }
                            if (stcRel == varRel) {
                                if (!window.console) console.log('por favor corrija el "rel" de los links: rel=\'' + stcRel + '\'');                                    
                            }
							try {
                                vars = $.param(jQuery.parseJSON(varRel));

							} catch(ex) {
								vars = self.gridviewHandler('getState',options);
							}
						} else {
							vars = self.gridviewHandler('getState',options);
						}
					}
					
					// setear las acciones mediante post "NO GET"
					vaxOptions = $.extend({}, vaxOptions, {
						'url': element.attr('href'),
                        'type':'POST',
                        'vars': vars
					});
					
				} else if(element.is('input[type=submit]') || element.is('input[type=button]')) {
					
					var sendForm = $('#' + element[0].form.id);
					
					if(!element.hasClass(options.grid.resetModifier)) {
						for(i=0; i<qStr.length;i++) {
							var comps = qStr[i].split('=');
							if(comps.length>1) {
								if($('#' + element[0].form.id + ' input[name='+comps[0]+']').length == 0) {
									$('<input>').attr({'type': 'hidden', 'name': comps[0]}).val(unescape(comps[1].replace(/\+/g,' '))).appendTo(sendForm);
								} else {
									$('#' + element[0].form.id + ' input[name='+comps[0]+']').val(comps[1]);
								}
							}
						}
					}
					element = sendForm;
					
					if(!element.attr('target')) {
						element.attr('target',self.attr('id'));	
					}
					
					vaxOptions = $.extend({}, vaxOptions, {
						'url': element.attr('action')
					});
				}
				$(element).viaAjax(vaxOptions);
			});
			// setear el comportamiento del paginador
			var consultar = function(id) {
				var url = $('#'+options.grid.form).attr('action').split('/');
				var url = url[0]+'/'+url[1]+'/consulta';
				$.fancybox({
		 			'width' : '75%',
		 			'height' : '75%',
		 			'autoScale' : false,
		 			'transitionIn' : 'none',
		 			'href' : url+'/'+id,
		 			'transitionOut' : 'none',
		 			'type' : 'iframe'
				});	
				//.href()
			}
			// función anonima para gestionar el click sobre los enlaces del paginador y el keydown del input ir a página
			var gotoPage = function(e) {
				if(e) {
					e.preventDefault();
					
					var theElement = $(e.currentTarget);
					
					var page = null;
					
					if(theElement.prev().is('input[type=text]') || theElement.is('input[type=text]')) {
						if(theElement.is('input[type=text]')) {
							page = theElement.attr('value').trim();
						} else {
							page = theElement.prev().attr('value').trim();
						}
						if(!(/^[0-9\ ]+$/.test(page)) || page=='0') {
							theElement.val('');
							theElement.focus();
							return;
						}
					} else {
						page = theElement.attr('href').split('/');
						page = (page.length>0)?page[page.length - 1]:0;
					}
					
					$('#' + options.grid.form + '-' + options.grid.pageParmId).val(page);
						
					$('#' + self.attr('id')+'-state input').val($('#'+options.grid.form).serialize());
					
					self.gridviewHandler('setState', options);

					self.gridviewHandler('list', options);
				}
				
			};
			
			var orderBy = function(e) {
				if(e) {
					e.preventDefault();
					var theElement = $(e.currentTarget);

					//var orderType = null;
					alert($(theElement).find('span').addClass('DESC'));
					if(self.find('#gridview-'+ options.grid.orderParmType).val() == 'DESC') {
						$('#' + options.grid.form + '-' + options.grid.orderParmType).val('ASC');
					}
					else {
						$('#' + options.grid.form + '-' + options.grid.orderParmType).val('DESC');
					}
					alert(self.find('#gridview-'+ options.grid.orderParmType).val());
					/*
					if(theElement.prev().is('input[type=text]') || theElement.is('input[type=text]')) {
						if(theElement.is('input[type=text]')) {
							page = theElement.attr('value').trim();
						} else {
							page = theElement.prev().attr('value').trim();
						}
						if(!(/^[0-9\ ]+$/.test(page)) || page=='0') {
							theElement.val('');
							theElement.focus();
							return;
						}
					} else {
						page = theElement.attr('href').split('/');
						page = (page.length>0)?page[page.length - 1]:0;
					}
					*/
					
					$('#' + self.attr('id')+'-state input').val($('#'+options.grid.form).serialize());
					self.gridviewHandler('setState', options);
					self.gridviewHandler('list', options);
				}
				
			};
			// el input ir a página x
			$('#' + options.grid.pager + ' input.item-ir').bind('keydown', function(event) {
		    	// que sea alguna tecla numérica o el enter
		    	if((/(13|48|49|50|51|52|53|54|55|56|57|96|97|98|99|100|101|102|103|104|105)/.test(event.keyCode))) {
					if (event.keyCode == '13') {
						gotoPage(event);
					}
		       	} else {
		       		event.preventDefault();
		       		return false;
		       	}
		    });
			
			// enlaces de paginas
			self.find('#' + options.grid.pager + ' a').bind('click', function(event){gotoPage(event)});
			self.find('.' + options.grid.order).bind('click', function(event){orderBy(event)});
			
			// dropdown list per_page
			self.find('#' + options.grid.pager + ' select').change(function(e) {
				e.preventDefault();
				self.gridviewHandler('setState', options);
				self.gridviewHandler('list',{'url': options.url});
			});

			//ejecutamos la funcion de consultar
			/*self.find('tr.'+options.grid.tr+' td').bind('click', function() {
				
				consultar($(this).attr('id'));
			})*/
			//$().on('click', consultar());

		}
	}
	
	$.fn.gridviewHandler = function(method) {
	    // logica de llamada a los metodos
	    if ( methods[method] ) {
	      return methods[ method ].apply( this, Array.prototype.slice.call( arguments, 1 ));
	    } else if ( typeof method === 'object' || ! method || $.isFunction(method)) {
	      	return methods.init.apply( this, arguments );
	    } else {
	      $.error( 'Method ' +  callback + ' does not exist on jQuery.gridviewHandler' );
	    }
	}
	
	$.gridviewHandler = {
		defaults: {
			grid: {
				stateDst: '' // id del lugar donde se generara el formulario de estado
				, form: 'gridview' // id del formilario que genera el Gridview
				, tr: 'registro' // clase de la fila para agregar funcion
 				, pager: 'pager-ajax' // id del contenedor del paginador que genera el Gridview
				, pageParmId: 'page' // nombre del parametro POST del paginador
				, order: 'th-order'
				, orderParmId: 'order' // nombre del parametro POST del ordenamiento
				, orderParmType: 'orderType' // nombre del parametro POST del ordenamiento
				, actionButons: 'btn-accion' // class que indica al gridviewHandler cuales elementos responden a acciones (Pueden ser enlaces <a> con un href definido o botones de un fornulario) para fancy.
				, actionButonsFinder: 'btn-buscar'
				, resetModifier: 'btn-reset' // class que indica un modificador de comportamiento al especificar en un acctionButtons este reseteara el gridviewstate o sea el estado de la grilla será reseteado
			}
			, events: {
				beforeSend: null // function(data, textStatus, jqXHR){ return this; }
				, success: null // function(jqXHR, settings){ return this; }
			}
		}
	}
})( jQuery );