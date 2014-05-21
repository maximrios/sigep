<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bolsajscss extends CI_Controller {
    function __construct() {
		parent::__construct();
        $this->load->helper('file');
	}
	public function linkjs($file='') {
        $js='';
        if ($file=='javascript.js') {
            // Activando el Cache
            header("Cache-Control: must-revalidate");
            header("Expires: " . gmdate("D, d M Y H:i:s", time() + (60 * config_item('js_css_gzip_cache_min'))) . " GMT");
            header("Content-type: text/javascript");
            // config.jscss.php
            $arr=config_item('js_array');
            // config.jscss.php // js_css_gzip = TRUE/FALSE
            if (config_item('js_css_gzip')) ob_start("ob_gzhandler");
            foreach($arr as $item){
                #$js.="/* bolsajscss.php # file: ".$item." */\n";
                $js.=read_file($item)."\n\n";
            }
        }
        // config.jscss.php // js_css_gzip = TRUE/FALSE
        if (config_item('js_css_gzip')) $js=$this->minify_js($js);
        die($js);
	}
	public function stylecss($file='') {
        $css='';
        if ($file=='styles.css') {
            // Activando el Cache
            header("Cache-Control: must-revalidate");
            header("Expires: " . gmdate("D, d M Y H:i:s", time() + (60 * config_item('js_css_gzip_cache_min'))) . " GMT");
            header("Content-type: text/css");
            // config.jscss.php
            $arr=config_item('css_array');
            // config.jscss.php // js_css_gzip = TRUE/FALSE
            if (config_item('js_css_gzip')) ob_start("ob_gzhandler");
            foreach($arr as $item) {
                #$css.="/* bolsajscss.php # file: ".$item." */\n";
                $contenidodelarchivo=read_file($item)."\n\n";
                $arrBuscar=array(
                    "url(../",
                    "url('../"
                );
                $arrReemplazar=array(
                    "url(../../".config_item('ext_base_url_plantilla_elegida'),
                    "url('../../".config_item('ext_base_url_plantilla_elegida')
                );
                $contenidodelarchivo=str_replace($arrBuscar, $arrReemplazar, $contenidodelarchivo);
                $css.=$contenidodelarchivo;
            }
        }
        // config.jscss.php // js_css_gzip = TRUE/FALSE
        if (config_item('js_css_gzip')) $css=$this->minify_css($css);
        die($css);
	}
    public function minify_css($css) {
        $css = preg_replace('#\s+#', ' ', $css);
        $css = preg_replace('#/\*.*?\*/#s', '', $css);
        $css = str_replace('; ', ';', $css);
        $css = str_replace(': ', ':', $css);
        $css = str_replace(' {', '{', $css);
  	    $css = str_replace('{ ', '{', $css);
        $css = str_replace(', ', ',', $css);
        $css = str_replace('} ', '}', $css);
        $css = str_replace(';}', '}', $css);
        while (strpos($css, '  ')!==false) {
    	   $css = str_replace('  ', ' ', $css);
        }
        while (strpos($css, '	')!==false) {
    	   $css = str_replace('	', ' ', $css);
        }
        return trim($css);
    }
    public function minify_js($js) {
        $js = str_replace('; ', ';', $js);
        $js = str_replace(' {', '{', $js);
        $js = str_replace('{ ', '{', $js);
        $js = str_replace(', ', ',', $js);
        $js = str_replace('} ', '}', $js);
        $js = str_replace(' == ', '==', $js);
        while (strpos($js, '  ')!==false) {
            $js = str_replace('  ', ' ', $js);
        }
        while (strpos($js, '	')!==false) {
    	   $js = str_replace('	', ' ', $js);
        }
        while (strpos($js, "\n ")!==false) {
        	$js = str_replace("\n ", "\n", $js);
        }
        while (strpos($js, "\r ")!==false) {
        	$js = str_replace("\r ", "\r", $js);
        }
        return trim($js);
    }
}