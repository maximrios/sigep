<form>
	<li>
		<label></label>
		<input type="text" id="nombreCursoMaterial" name="nombreCursoMaterial" placeholder="Nombre completo del curso">
	</li>
	<li>
		<label>Tipo de Material</label>
		Modulo<input type="radio" name="tipo" value="1">
		Material<input type="radio" name="tipo" value="2">
	</li>
</form>

<script>
	/*var contenido = [];
   	$('#nombreCursoMaterial').typeahead({
   		
    	source: function(typeahead, query) {
     		$.ajax({
      			url: "administrator/materiales/obtenerPadres",
      			type: "post",
      			data: "search=" + query,
      			dataType: "json",
      			async: false,
      			success: function(data) {
      				var users = {};
					var userLabels = []; 
       	 			$.each( data, function( item, ix, list ){
                		if ( $.contains(users, item.label ) ){
                    		item.label = item.label + ' #' + item.value;
                		}
                		//add the label to the display array
                		userLabels.push( item.label );
                		//also store a mapping to get from label back to ID
                		users[ item.label ] = item.value;
            		});
            		//return the display array
            		contenido = userLabels;
        		}
        		
        			
			});
     		$.process(contenido);
    	}
   	});*/
</script>