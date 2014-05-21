<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author Diego G
 * @copyright 2012
 * @category Helper
 */
function incluirjscss_linkjs($admin='') {
    $arr  = config_item('js_array'.$admin);
    $html = '<!-- ***** INCLUIR JS HELPER ***** //-->'."\n";
    if (config_item('js_css_unificar')) {
        $html.='<script src="bolsajscss/linkjs/javascript.js?rev='.config_item('js_css_revision').'"></script>'."\n";
    } 
    else {
        foreach($arr as $item) {
            $html.='<script src="'.$item.'"></script>'."\n";
        }
    }
    #$html.='<!-- ***** FIN INCLUIR JS HELPER ***** //-->';
    $html.="\n\n";
    return $html;
}
function incluirjscss_stylecss($admin='') {
    $arr  = config_item('css_array'.$admin);
    $html = '<!-- ***** INCLUIR CSS HELPER ***** //-->'."\n";
    if (config_item('js_css_unificar')) {
        $html.='<link href="bolsajscss/stylecss/styles.css?rev='.config_item('js_css_revision').'" rel="stylesheet" type="text/css"/>'."\n";
    } 
    else {
        foreach($arr as $item){
            $html.='<link href="'.$item.'" rel="stylesheet" type="text/css"/>'."\n";
        }
    }
    #$html.='<!-- ***** FIN INCLUIR CSS HELPER ***** //-->';
    $html.="\n\n";
    return $html;
}
