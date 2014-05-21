<!--
/*
* Libreria para manejo de usuarios
* creada por @guillermo_lc
* www.convirtiendote.pro y @convirtiendoteP
*/
-->
<div>
    <div>
        <?
            if (isset($error)) echo $error;
            print form_open_multipart('social/insert');
        ?>
<p>
<label>Titulo</label>
<input type="text" name="titulo" id="firstname2" />
</p>
<p>
<label>Imagenes:</label>
<div style="margin: 0 0 30px 300px">
<span id="addImg">Agregar Uno</span>
<br>
</div>

<div id="img_soruce"></div>
<div class="input-append">
<div class="span6">
<input type="file" name="imagen0" class="img_uploader">
</div>
</div>
<br></br>
</p>

<p>
<button class="btn btn-primary guardar btn-accion">Enviar</button>
</p>
</form>
</div>
</div>
<script type="text/javascript">
(function() {
jQuery("#addImg").on('click',addSource);
})();

function addSource(){
var numItems = jQuery('.img_uploader').length;
var template = '<div class="field ">'+
'<div class="input-append">'+
'<div class="span6">'+
'<input type="file" name="imagen'+numItems+'" class="img_uploader">'+
'</div>'+
'</div>'+
'</div>';
jQuery(template).appendTo('#img_soruce');
console.log(numItems);
}
</script>