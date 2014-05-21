<h3>Subir fotos</h3>
         
        <p>
            <input id="files" name="files" type="file" />
        </p>
        <p>
            <button class="button" id="subirFotos"><span>Subir fotograf&iacute;as</span></button>
        </p>
         
        <script type="text/javascript" charset="utf-8">
            // <![CDATA[
            $(document).ready(function() {
                $("button#subirFotos").click(function() {
                    // Hay archivos por subir?
                    if ($('#files').uploadifySettings('queueSize') > 0) {
                        $('#files').uploadifyUpload();
                    }
         
                    // Return false para evitar cualquier accion en el boton
                    return false;
                });
         
                $('#files').uploadify({
                    'uploader'          : 'assets/libraries/uploadify/uploadify.swf',
                    'script'                : 'administrator/agentes/upload',
                    'cancelImg'         : 'assets/libraries/uploadify/cancel.png',
                    'auto'              : true,
                    'folder'                : 'assets/libraries/uploadify/',
                    'queueSizeLimit'    : '10',
                    'multi'             : true,
                    'fileDesc'          : '.jpg, .png, .gif, .jpeg',
                    'fileExt'           : '*.jpg;*.jpeg;*.png;*gif',
                    'auto'              : false,
                    'buttonText'        : 'SELECCIONAR'
                });
            });
            // ]]>
        </script>