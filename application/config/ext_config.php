<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*******************************************************************************************/
/**
 * Configuracion extendida para el sistema
 */
$config['ext_base_url'] = 'http://localhost/rosobe';
/**
 * Creando name spaces
 */
/**
 * Ubicación de recursos comunes
 */
// Planilla Elegida
$config['ext_base_url_plantilla_elegida'] = 'assets/themes/base/';
$config['ext_base_url_assets'] = 'assets/';
$config['ext_base_url_assets_js'] = 'assets/libraries/';

$config['ext_base_url_assets_css'] = 'assets/css/';
$config['ext_base_url_assets_images'] = 'assets/images/';

$config['ext_base_panel']['titulo'] = 'Sistema de Administracion de Recursos Humanos - Si.Ge.P.';
$config['ext_base_panel']['cliente'] = 'Sindicatura General de la Provincia';

/**
 * Especificos globales, a cada sistema o sitio
 */

$config['ext_base_img_bg'] = $config['ext_base_url_assets_images']. 'body-background.jpg';
$config['ext_base_favicon'] = $config['ext_base_url_assets_images']. 'favicon.ico';
$config['ext_base_logo_header'] = $config['ext_base_url_assets_images']. 'eltribuno.png';
$config['ext_base_logo_footer'] = $config['ext_base_url_assets_images']. 'logo-escudo-de-salta.png';


$config['ext_base_login_username']='nombre de usuario';
$config['ext_base_pie_desarrollo']='HITS - Soluciones Informáticas';
$config['ext_base_pie_resolucion']='Optimizado para 1024x768px o superior.';
$config['ext_base_pie_navegadores']='Mozilla Firefox 7 / Chrome 14 / Opera 11';

$config['ext_base_smtp_config']['useragent'] = "CodeIgniter";
$config['ext_base_smtp_config']['protocol'] = "smtp";
$config['ext_base_smtp_config'][ 'mailpath' ] = '' ;
$config['ext_base_smtp_config']['wordwrap'] = TRUE;
$config['ext_base_smtp_config']['wrapchars'] = 76;
$config['ext_base_smtp_config']['mailtype'] = "html";
$config['ext_base_smtp_config']['charset'] = "utf-8";
$config['ext_base_smtp_config']['priority'] = 3;
$config['ext_base_smtp_config']['newline'] = "\r\n";
$config['ext_base_smtp_config']['bcc_batch_mode'] = FALSE;
$config['ext_base_smtp_config']['bcc_batch_size'] = "200";
$config['ext_base_smtp_config']['bcc_batch_size'] = "200";

$config['ext_base_smtp_config']['asunto_crear_usuario'] = 'Cuenta de Usuario Creada';
$config['ext_base_smtp_config']['asunto_cambiar_contrasenia'] = 'Su Contraseña ha sido cambiada';
$config['ext_base_smtp_config']['asunto_cambiar_pin'] = 'Su Pin ha sido cambiado';
$config['ext_base_smtp_config']['asunto_cambiar_contrasenia_pin'] = 'Su Contraseña y Pin han sido cambiados';
$config['ext_base_smtp_config']['asunto_recuperar_contrasenia'] = 'Nueva Contraseña';

$config['asunto_pin_enabled'] = FALSE;

if ($config['asunto_pin_enabled']):

$config['ext_base_smtp_config']['contenido_email_pie'] = <<<EOT
-------------------------------------------------------------------------------------------------------------------------
Recuerde que:
 > Para acceder al sistema debe ingresar su Nro. de Documento y la contraseña que se le ha proporcionado.
 > Para efectuar algunas operaciones de suma importancia deberá ingresar el PIN suministrado.
 > Tambien le recomendamos que cambie su contraseña periodicamente, para ello, una vez en el sistema
   ingrese a las "Opciones de Usuario" y luego en "Cambiar mis datos"
   en la parte superior derecha de la pantalla.
-------------------------------------------------------------------------------------------------------------------------
 > NO RESPONDA ESTE MAIL, ES UNA RESPUESTA AUTOMATICA.
 > CONSERVE ESTE MAIL. CONTIENE DATOS SENSIBLES DE LA CUENTA DE USUARIO.
 > LA CLAVE DE ACCESO ES INSTRANSFERIBLE POR LO TANTO LE RECOMENDAMOS QUE "NO LA DIVULGUE".
 > EL PIN ES INSTRANSFERIBLE POR LO TANTO LE RECOMENDAMOS QUE "NO LO DIVULGUE".
-------------------------------------------------------------------------------------------------------------------------
 > La base de datos se encuentra registrada en la Direccion Nacional de Proteccion de Datos
   Personales, por lo que usted goza de la proteccion y derechos de las leyes
   argentinas N° 25.326 y 26.343.
-------------------------------------------------------------------------------------------------------------------------
EOT;

else:

$config['ext_base_smtp_config']['contenido_email_pie'] = <<<EOT
-------------------------------------------------------------------------------------------------------------------------
Recuerde que:
 > Para acceder al sistema debe ingresar su Nro. de Documento y la contraseña que se le ha proporcionado.
 > Tambien le recomendamos que cambie su contraseña periodicamente, para ello, una vez en el sistema
   ingrese a las "Opciones de Usuario" y luego en "Cambiar mis datos"
   en la parte superior derecha de la pantalla.
-------------------------------------------------------------------------------------------------------------------------
 > NO RESPONDA ESTE MAIL, ES UNA RESPUESTA AUTOMATICA.
 > CONSERVE ESTE MAIL. CONTIENE DATOS SENSIBLES DE LA CUENTA DE USUARIO.
 > LA CLAVE DE ACCESO ES INSTRANSFERIBLE POR LO TANTO LE RECOMENDAMOS QUE "NO LA DIVULGUE".
-------------------------------------------------------------------------------------------------------------------------
 > La base de datos se encuentra registrada en la Direccion Nacional de Proteccion de Datos
   Personales, por lo que usted goza de la proteccion y derechos de las leyes
   argentinas N° 25.326 y 26.343.
-------------------------------------------------------------------------------------------------------------------------
EOT;

endif;


/*******************************************************************************************/
// Tiempo en Milisegundos
// que se demora en confirmar un formulario a partir de que se lo recibe
$config['antibot_time_min'] = 6; // Milisegundos

$config['antibot_logout_alert'] = "Para su Seguridad no se permiten realizar operaciones tan rápidamente.\nPor favor debes leer los formularios antes de confirmarlos.\nMuchas Gracias!";

/*******************************************************************************************/




/* ------------------------------------------------------------------------------------------
 * lib_autenticacion config items
 * ------------------------------------------------------------------------------------------
 */

/*
 * Allowed configs availables
 * */
$config['lib_autenticacion'] = array('web_site_name','webmaster_email','deny_uri','login_uri','banned_uri','activate_uri','reset_password_uri','logout_uri','edit_profile_uri','login_success_uri','cli_pass_is_md5','error_blk_msg','error_err_msg','error_baj_msg','error_pas_msg','error_def_msg','menu_dir_uri', 'enable_multiple_users','alert_usuario_login_1','alert_usuario_login_2','chequear_permiso_de_uri','chequear_ubicacion');
/*
 * Permitir multiples accesos desde diferentes ubicaciones?
 */
$config['lib_autenticacion_enable_multiple_users'] = TRUE;
/*
 * Verificar ubicacion del usuario al realizar acciones en el sistema 
 */
$config['lib_autenticacion_chequear_ubicacion'] = FALSE;
/*
 * Configuraciones de scripts del cliente  
 */
$config['lib_autenticacion_cli_hash_key'] = ''; // llave/salto del hash
$config['lib_autenticacion_cli_use_hash'] = false; // los datos del post seran serializados en un hash sha1
$config['lib_autenticacion_cli_pass_is_md5'] = true; // la contraseña sera encriptada en el cliente

/*
|--------------------------------------------------------------------------
| URI
|--------------------------------------------------------------------------
|
| Determina las URI que seran utilizadas para redirigir en LI Autenticacion library.
| 'li_autenticacion_deny_uri' = URI Acceso denegado.
| 'li_autenticacion_login_uri' = URI Login form .
| 'li_autenticacion_activate_uri' =  URI Activar usuario.
| 'li_autenticacion_reset_password_uri' = URI Resetear password de usuario.
|
| These value can be accessed from lib_autenticacion library variable, by removing 'lib_autenticacion_' string.
| For example you can access 'lib_autenticacion_uri' by using $this->lib_autenticacion->deny_uri in controller.
|
*/

$config['lib_autenticacion_deny_uri'] = 'aut/denegado/';
$config['lib_autenticacion_login_uri'] = 'aut/login/';
$config['lib_autenticacion_banned_uri'] = 'aut/eliminado/';
$config['lib_autenticacion_activate_uri'] = 'aut/activar/';
$config['lib_autenticacion_reset_password_uri'] = 'aut/resetear_password/';
$config['lib_autenticacion_logout_uri'] = 'aut/logout/';
$config['lib_autenticacion_edit_profile_uri'] = 'autenticacion/perfilusuario';
$config['lib_autenticacion_login_success_uri'] = 'admin';
$config['lib_autenticacion_menu_dir_uri'] = 'menu/admin_%s';
/*
|--------------------------------------------------------------------------
| error messages
|--------------------------------------------------------------------------
|
 */
$config['lib_autenticacion_error_blk_msg'] = 'La cuenta con la cual intenta acceder, ha sido Bloqueada por razones administrativas. Ante cualquier duda consulte con el Administrador del Sistema.';
$config['lib_autenticacion_error_err_msg'] = 'La cuenta con la cual intenta acceder, ha superado la cantidad de intentos fallidos, debe solicitar el desbloqueo.';
$config['lib_autenticacion_error_baj_msg'] = 'La cuenta con la cual intenta acceder, ha sido dada de Baja por razones administrativas.';
$config['lib_autenticacion_error_pas_msg'] = 'Usuario y/o clave incorreta. Verifique los datos ingresados. Le restan %s intentos.';
$config['lib_autenticacion_error_def_msg'] = 'El Usuario no existe. Verifique los datos ingresados.';
$config['lib_autenticacion_alert_usuario_login_1'] = 'Ha iniciado sesión en varias ubicaciones y/o navegadores por favor reintente nuevamente!';
$config['lib_autenticacion_alert_usuario_login_2'] = 'Ha iniciado sesión en varias ubicaciones y/o navegadores por favor reintente nuevamente!';

/*
 * End lib_autenticacion config items
 */

/*******************************************************************************************/
/* JS CSS Optimización */

// Comprimir GZIP: TRUE/FALSE
$config['js_css_gzip'] = TRUE;
// Unificar archivos JS y CSS en 2 Archivos finales: TRUE/FALSE
$config['js_css_unificar'] = FALSE;
// Número de Revisión/Modificación de un JS o CSS (Incrementar en caso de modificar un JS o CSS)
$config['js_css_revision'] = 1;
// Número de Minutos que permanece en Caché 0,1,2,...,60,...,N
$config['js_css_gzip_cache_min'] = 60 * 24 * 10; // 60 min * 24 hs * 10 dias
$config['js_array_admin'] = array(
    'assets/themes/base/js/jquery.js',
    'assets/themes/base/js/bootstrap.js',
    'assets/themes/base/js/bootstrap-switch.js',
    'assets/libraries/jqueryvalidation/js/languages/jquery.validationEngine-es.js',
    'assets/libraries/jqueryvalidation/js/jquery.validationEngine.js',
    'assets/libraries/jqueryviaajax/jquery.viaajax.js',
    //'assets/libraries/jqueryviaajax/upload.js',
    'assets/libraries/jquery.md5/jquery.md5.js',
    'assets/libraries/jquery.gridhandler/jquery.gridhandler.js',
    'assets/libraries/bootstrap-datepicker.js',
    
    /*'assets/themes/base/js/bootstrap.fileupload.js',
    'assets/libraries/jquery.file.upload/jquery.ui.widget.js',
    'assets/libraries/jquery.file.upload/load-image.min.js',
    'assets/libraries/jquery.file.upload/canvas-to-blob.min.js',
    'assets/libraries/jquery.file.upload/jquery.iframe-transport.js',
    'assets/libraries/jquery.file.upload/jquery.fileupload.js',
    'assets/libraries/jquery.file.upload/jquery.fileupload-process.js',
    'assets/libraries/jquery.file.upload/jquery.fileupload-image.js',*/
);
$config['css_array_admin'] = array(
    $config['ext_base_url_plantilla_elegida'].'css/bootstrap.css',
    $config['ext_base_url_plantilla_elegida'].'css/bootstrap-switch.css',
    $config['ext_base_url_plantilla_elegida'].'css/bootstrap-datepicker.css',
    $config['ext_base_url_plantilla_elegida'].'css/hits.css',
    $config['ext_base_url_plantilla_elegida'].'css/notificaciones.css',
    $config['ext_base_url_plantilla_elegida'].'css/jqueryvalidation-validationEngine.jquery.css',
    $config['ext_base_url_plantilla_elegida'].'css/jquery.fileupload.css',
);
// Array de JS
$config['js_array'] = array(
    'assets/themes/base/js/jquery.js',

    'assets/themes/base/js/jquery.scrollUp.min.js',
    'assets/themes/base/js/bootstrap.js',
    'assets/themes/base/js/jquery.placeholder.min.js',
    'assets/libraries/jquery.easing.1.3.js',
    'assets/libraries/jquery.lavalamp.min.js',
    'assets/themes/base/js/jquery.nivo.slider.pack.js',
    'assets/themes/base/js/jquery.prettyPhoto.js',
    'assets/themes/base/js/jquery.jqzoom-core.js',
);

// Array de CSS
$config['css_array'] = array(
    $config['ext_base_url_plantilla_elegida'].'css/bootstrap.css',
    $config['ext_base_url_plantilla_elegida'].'css/main-parallax.css',
    $config['ext_base_url_plantilla_elegida'].'css/rosobe.css',
    $config['ext_base_url_plantilla_elegida'].'css/nivo-slider.css',
    $config['ext_base_url_plantilla_elegida'].'css/prettyPhoto.css',
    $config['ext_base_url_plantilla_elegida'].'css/jquery.jqzoom.css',
);
