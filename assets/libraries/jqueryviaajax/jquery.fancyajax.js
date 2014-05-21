/*
 * Clase fancyAjax 1.0.0, jQuery plugin
 *
 * Copyright(c) 2011, Marcelo Gutierrez
 * @marceloaldo
 *
 * Permite la gestion del envio y recepcion de contenido ajax mediante una funcion simple.
 * Dependencias:  Inline Form Validation Engine 2.2.3, jQuery plugin, Copyright(c) 2010, Cedric Dugas
 * Licensed under the MIT License
 */
(function( $ ){
	var methods = {
		init: function(options, callback){
			var options = options || null;
		  	
	  		return this.each(function() {
	  			
				var self = $(this);
				var vaxDefaults = $.fancyAjax.defaults;
				
				if($.isFunction(options)) {
				  callback = options;
				}
				
				vaxDefaults.success = callback;
			  	options = $.extend({}, vaxDefaults, options);
			  	
			  	if(!self.data('jqvax') || self.data('jqvax')==null) {
			  		self.data('jqvax', options);
			  	}
				if(self.is('form')) {

					/*var validatorPI = options.plugInValidator;
					
					eval("$(self)."+validatorPI.validator+"('"+validatorPI.init+"');");*/
					
					self.submit(function(e){
						//if(!eval("$(self)."+validatorPI.validator+"('"+validatorPI.validate+"');"))
						//{
						//	return false;
						//}
						options.url = self.attr('action');
						
						// preparar los datos antes de enviar
						$.isFunction( options.prepVars ) && options.prepVars.call(self);
						
						options.vars = self.serialize();
						
						self.fancyAjax('send',options);
						
						e.preventDefault();
					});
					
					var resetButton = $('#' + self.attr('id') + ' :reset');
					if(resetButton.length == 0)
						resetButton = $('#' + self.attr('id') + ' .reset'); 
					
					resetButton.click(function(e){
						eval("$(self)."+validatorPI.validator+"('"+validatorPI.reset+"');");
						$('#' + self.attr('id')).each(function(){this.reset();this[0].focus();});
						e.preventDefault();
					});
					//$.fancybox.close();

				} else if(self.is('a')) {
					self.click(function(e){
						e.preventDefault();
						options.type = options.type || 'GET'; 
						if(options.url == null) {
							options.url = self.attr('href');
						} else if(options.url != self.attr('href')) {
							options.url = self.attr('href');
						}
						self.fancyAjax('send',options);
					});
				} else {
					// do nothing
				}
				
	  		});
		}
		, send: function(options, callback){
			var self = $(this);
			if(!self.data('jqvax') || self.data('jqvax') == null) {
                if (this.debug) console.log(options);
				self.fancyAjax('init', options, callback);
				options = self.data('jqvax');
			}
			
      		var dtxt = '#'+ (self.attr('target') || self.attr('rel') || self.attr('id'));
      		
			var dest = $(dtxt);
			 
			var beforeHtml = dest.html();
			
			if(options==undefined) {
				return false;
			}
			
			return $.ajax({
				type: options.type
				, url: options.url
				, data: options.vars
				/*, beforeSend: function(jqXHR, settings){
					$.isFunction( options.beforeSend ) && options.beforeSend.call(self, jqXHR, settings);
         			// Cerrar los Alerts de JQueryValidation
					var validatorPI = options.plugInValidator || $.fancyAjax.defaults.plugInValidator;
					eval("$(self)."+validatorPI.validator+"('"+validatorPI.reset+"');");
          			// Ocultar Contenido Activo
					dest.html($(options.progressIndicator || $.fancyAjax.defaults.progressIndicator));
				}*/
				, error: function(jqXHR, textStatus, errorThrown) {
					dest.html(beforeHtml);
					alert('0_o Hubo un error en la solicitud enviada.\n' + textStatus);
				}
				, success: function(data, textStatus, jqXHR){
					$.fancybox(data, {
						afterClose : function() {
							//$.fancybox.close();
							//setTimeout(function(){
							//	url = "http://taller-de-scripts.com.ar";
								//location.reload();
							//},2000);
							//location.reload();
							//alert('micoss');
						}
					});
					
					/*dest.animate(
						{'opacity': 0}
						, options.animateTime
						, function(){*/
							//if(!options.overwriteSuccess)
							//{
								//dest.html(data);
								// Hacer readonly="readonly" para los campos en Eliminar
								/*if(options.makeReadOnly) {
					                $(".readonly input[type=text], " +
					                  ".readonly input[type=password], " +
					                  ".readonly input[type=checkbox], " +
					                  ".readonly input[type=radio], " +
					                  ".readonly textarea, " +
					                  ".readonly select").attr('readonly', 'readonly')
					                                     .attr('disabled', 'disabled');								
								}
								// Hacer Trim al campo de Busqueda de la Grilla
								if(options.makeTrimSearch) {
                                    $('#'+options.idSearchForm).submit(function() {
                                    	var SearchText = $('#'+options.idSearchText);
                                    	if(SearchText.val()) {
                                    		SearchText.val(SearchText.val().trim());
                                    	}
                                    });
                                }*/
							//}

							//$.isFunction( options.success ) && options.success.call(self, [data, textStatus, jqXHR]);
							//dest.animate({'opacity': 1}, options.animateTime);
						//}
					//);

				}
				, complete: function(){
					//alert('mierda');
				}
			});
					
		}
	};

	$.fn.fancyAjax = function(method) {
	    // logica de llamada a los metodos
	    
	    if ( methods[method] ) {
	      return methods[ method ].apply( this, Array.prototype.slice.call( arguments, 1 ));
	    } else if ( typeof method === 'object' || ! method || $.isFunction(method)) {
	      if(typeof method === 'object' && !this.is('form') && !this.is('a')) {
	      	return methods.send.apply( this, arguments );
	      } else {
	      	return methods.init.apply( this, arguments );
	      }
	      
	    } else {
	      $.error( 'Method ' +  callback + ' does not exist on jQuery.fancyAjax' );
	    }
	};
	
	$.fancyAjax = {defaults: 
			{
				type: 'POST' // Tipo de request POST o GET
				, url: null // Url de respuesta, script o pagina del servidor que devuelve el contenido
				, vars: null // Variables que seran enviadas al servidor
				, progressIndicator: '<div id="waitplease"><span class="progress-small">Esperate unos segundos por favor...</span></div><div class="clearfloat"></div>'//'<span class="progress-small">&nbsp;Actualizando...</span>' // template del indicador de progreso mientras el envio es realizado
				, overwriteSuccess: false // Indica si se va a sobreescribir el comportamiento por defecto de la function success (true), por defecto la function de callback "success" se encadena al regresar el ajax.
				// Definicion del plugin de validacion
				, plugInValidator: {
					'validator': 'validationEngine' // nombre de la function JQ del validador
					, 'init': 'attach' // metodo de inicio
					, 'validate': 'validate' // metodo de validaci�n
					, 'reset': 'hideAll' // metodo de reseteo del validador
				}
				, makeReadOnly: true
				, readOnlyClass: 'readonly'
                , makeTrimSearch: true
                , idSearchForm : 'frmBuscador'
                , idSearchText : 'txtvcBuscar'
				// closure del evento success
				, success: null // function(data, textStatus, jqXHR){ return this; }
				// closure del evento beforeSend
				, beoreSend: null // function(jqXHR, settings){ return this; }
				// closure para preparar los datos que seran enviados.
				, prepVars: null // function() {return this; }
                , animateTime: 60
		  	}
		  };
})( jQuery );