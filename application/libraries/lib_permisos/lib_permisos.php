<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Lib_Permisos Class
 * 
 * Libreria de autenticacion de usuarios
 *
 * @package		base
 * @subpackage	Libraries
 * @category	Permisos
 * @author		
 * @link		
 */

class Lib_Permisos
{
    private $ci;
    
    public function __construct()
    {
        $this->ci =& get_instance();
        $this->ci->load->model('mysqli/lib_permisos/permisos_model','objModel');
    }
    
	/**
	 * Lib_Permisos::uriPermitida()
	 * 
	 * @param mixed $vcUri
	 * @param mixed $inIdRol
	 * @return Recibe una cadena uri y inIdRol y retorna true o false segun si la uri tiene permiso o no segun el rol.-
	 */
	public function uriPermitida($vcUri, $inIdRol) 
    {
        $urls = $this->ci->objModel->uriPermitida($vcUri, $inIdRol);
        return $urls;
    }
	
	/**
	 * Lib_Permisos::obtenerPermisosPorRol()
	 * 
	 * @param mixed $vcUri
	 * @param mixed $inIdRol
	 * @return Recibe una cadena de uri separadas por comas y inIdRol y retorna un array con las uri permitidas segun el rol.-
	 */
	public function obtenerPermisosPorRol($vcUri, $inIdRol)
    {
        $urls = $this->ci->objModel->obtenerPermisosPorRol($vcUri, $inIdRol);
        return $urls;
    }
	
	public function filtrarPermisosPorRol($vcXHtml, $inIdRol) {
		$dom = new DOMDocument();
		
		@$dom->loadHTML(utf8_decode($vcXHtml));
		
		$compareTags = array(
			'a' =>	array(
				'url' => 'href'
				, 'class_regexp_white_list'=> '/(button)|(btn-accion)|(verif-permisos)/'
			)
			,'form'=> array(
				'url' => 'action'
				, 'class_regexp_white_list'=>''
			)
		);

		$remove = array();
		$uri = array();
		
		foreach($compareTags as $tag => $options) {
			$a = $dom->getElementsByTagName($tag);
			$n = $a->length;
			
			for($i=0; $i<$n; $i++) {
				$uri[] = $a->item($i)->getAttribute($options['url']);
				$remove[$tag][] = $a->item($i);
			}
		}
		
		$uri = implode(',', $uri);
		
		$permisos = $this->ci->objModel->obtenerPermisosPorRol($uri, $inIdRol);
		
		$permisos = explode(',', preg_replace('/\\{\\}/', '', $permisos));
		asort($permisos);
		$n = sizeof($compareTags);
		
		foreach($compareTags as $tag => $options) {
			if(!key_exists($tag, $remove)) {
				continue;
			}
			foreach($remove[$tag] as $el) {
				if(!in_array($el->getAttribute($options['url']), $permisos)) {
					if(!empty($options['class_regexp_white_list']) and $el->hasAttribute('class')) {
						if(preg_match($options['class_regexp_white_list'], $el->getAttribute('class'))) {
							$el->parentNode->removeChild($el);
						} else {
							$el->removeAttribute($options['url']);
						}
					} else {
						if($el->tagName=='a') {
							$el->removeAttribute($options['url']);
						} else {
							$el->parentNode->removeChild($el);
						}
					}
				}
			}
		}
		
		$vcRet = preg_replace('/^<!DOCTYPE.+?>/', '', str_replace( array('<html>', '</html>', '<body>', '</body>'), array('', '', '', ''), $dom->saveHTML())); 
		
		return $vcRet;
	}
}
