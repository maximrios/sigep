<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Gridviev Class
 *
 * @package		base
 * @subpackage	Libraries
 * @category	Gridview
 * @author		Marcelo G
 * @copyright	2012-01-01
 * @link		
 */
class Gridview {
	/**
	 * Propiedad name del form que envuelve a la grilla html generada
     * @var string
	 * 
     */
    var $sName='gridview';
	
	/**
	 * Propiedad id del form que envuelve a la grilla html generada
     * @var string
	 * 
     */	
    var $sId='gridview';
    
    
    var $sDataKeyNames='';
    
	/**
	 * Cantidad total de registros totales recuperados en caso de paginación
     * @var int
	 * 
     */	
    var $iTotalRegs = 0;
	
	/**
	 * Cantidad de registros a mostrar por página en caso de paginación
     * @var int
	 * 
     */	
	var $iPerPage = 20;
    
	/**
	 * Especificacion de las columnas que serán generadas. Las columnas se agregan mediante los métodos addColumn, addControlName, addControl
     * @var array
	 * 
     */	
	var $aCols = null;
    
	/**
	 * Indica si la paginacion y toda la interaccion se realiza con AJAX
     * @var boolean
	 * 
     */
    var $bAjaxEnabled = true;
	
	/**
	 * Indica si se debe generar el paginador.
     * @var boolean
	 * 
     */	
    var $bEnablePaginator = false;
	
	/**
	 * Nombre del parametro de la paginacion, necesario para metodos POST, opcional para métodos GET
     * @var string
	 * 
     */	
	var $sPageParmName = 'page';
	
	/**
	 * Indica si se debe generar un formulario que envuelve al listado o la grilla.
     * @var boolean
	 * 
     */	
    var $bDoForm = true;
	
	/**
	 * URI indicando la uri del controlador que devuelve la grilla y todos sus componentes asociados.
     * @var boolean
	 * 
     */	
    var $sResponseUrl = '';
	
	/**
	 * Tipo de request de la grilla puede ser GET o POST, en caso de ser AJAX enabled funciona con POST.
     * @var string
	 * 
     */	
    var $sResponseType = 'POST';/* (GET|POST) */
   
	/**
	 * Propiedad Id del destino de las respuestas AJAX de las acciones que se ejecuten sobre el listado. Al Utilizar el client controller gridviewHandler, este id se establece en el cliente.
     * @var string
	 * 
     */  
    var $sResponseElementId = '';
    
	/**
	 * Indica si en los encabezados de la grilla se agerga algun control de ordenamiento sobre los datos obtenidos.
     * @var boolean
	 * 
     */	
    var $bOrder = TRUE;
	
	/**
	 * Tipo de orden a establecer para recuperar los datos expresado como notacion JSON, {"order":"fieldName","type":("ASC"|"DESC")}.
     * @var string
	 * 
     */		
    var $sOrder = '';/* coded {order:fieldName,type:(ASC|DESC)} */
	
	/**
	 * Especificacion el lenguaje javascript del comportamiento de las acciones de los controles de ordenamiento.
     * @var string
	 * 
     */   
    var $sOrderByClientController = '';
	
	/**
	 * Nombre del parámetro que se envia por POST o GET para indicar el tipo de ordenamiento.
     * @var string
	 * 
     */	
    var $sOrderParmName = 'order';
    
	/**
	 * Propiedades html del tag que se utilizara para indicar la lista, por defecto es un elemento <table> el que se utiliza para establecer el layout de la grilla.
     * @var string
	 * 
     */		
    var $sListProperties = '';

	/**
	 * Propiedades html del tag que se utilizara para indicar una fila de la lista, por defecto es un elemento <tr> el que se utiliza para establecer el layout de la grilla.
     * @var string
	 * 
     */	
    var $sRowProperties = 'class="registro"';
	
	/**
	 * Propiedades html del tag que se utilizara para indicar una fila alterna de la lista, por defecto es un elemento <tr> el que se utiliza para establecer el layout de la grilla.
     * @var string
	 * 
     */	
    var $sAltRowProperties = '';
	
	/**
	 * Frecuencia de la alternancia entre filas alternas, por defecto es dos, o sea filas pares e impares se comportan como alternas.
     * @var integer
	 * 
     */	
    var $iRowAltPaternRepeat = 1;
	
	/**
	 * Propiedades html del tag que se utilizara para indicar el elemento que actuará como pie del listado, por defecto es un elemento <div> que se genera en la parte inferior separado del listado.
     * @var string
	 * 
     */	
    var $sFootProperties = '';
	
	/**
	 * Propiedades html del tag que se utilizara para indicar el elemento que actuará como encabezado del listado, por defecto es un elemento <th>.
     * @var string
	 * 
     */	
    var $sHeadProperties = '';
    
	/**
	 * Array de formatos numericos para expresar los resultados obtenidos desde la BD.
     * @var array
	 * 
     */	
	var $aFormats = array();

    var $bSanitizeParms = FALSE;

    var $titulo = '';

    var $buscador = FALSE;

    var $identificador = '';

	protected $_CI; // Referencia al controlador actual.
	
    protected $_aTemplates; // Templates del listado, lista, filas, elementos, cabecera y pie.
    
    protected $_pager; // Ayudante Ext_Paginator extends CI_Paginator para ejecutar la paginacion.
    
    protected $_aParms; // Parametros a recordar entre request del servidor, p.e.: parámetros de la busqueda.
    
    function __construct($config = array())
    {
    	$this->_CI = & get_instance();
		
		if ( ! in_array('gridview_lang'.EXT, $this->_CI->lang->is_loaded, TRUE))
		{
			$this->_CI->lang->load('gridview');
		}
		
		$this->_CI->load->helper('text');	
		
		$this->aFormats = array(
			'double' => '%01.2f' // Número de punto flotante, dos decimales (consciente de la configuración regional).
			, 'money' => '%01.2f' // Número de punto flotante, dos decimales (consciente de la configuración regional).
			, 'int' => '%d' // Integer y presentado como un número decimal (con signo).
			, 'date' => 'd/m/Y' // Fecha notación francesa
			, 'datetime' => 'd/m/Y H:i:s' // Fecha hora notación francesa, hora en formato 24hrs.
			, 'time' => 'H:i:s' // Hora en formato 24hrs.
		);
		
		$this->setTemplates(array());
		
		if(count($config) > 0)
		{
			$this->initialize($config);
		}
    }

	/**
	 * Initialize the user preferences
	 *
	 * Accepts an associative array as input, containing display preferences
	 *
	 * @access	public
	 * @param	array	config preferences
	 * @return	void
	 */
	function initialize($config = array())
	{
		foreach ($config as $key => $val)
		{
			if (isset($this->$key))
			{
				$this->$key = $val;
			}
		}
		if(key_exists('sResponseUrl', $config) && key_exists('iTotalRegs', $config)) {
			$this->setPaginator($config);
		}
	}
    
	protected static function _objectToArray($object)
	{
        if( !is_object($object) && !is_array($object))
        {
            return $object;
        }
        if(is_object($object))
        {
            $object = get_object_vars( $object );
        }
        return array_map('self:_objectToArray', $object);		
	}
	
    protected static function _processMessageTemplate($sTemplate,$aParms)
	{
		
		if(sizeof($aParms)==0)
			return '';
        preg_match_all("/({\w+})/i",$sTemplate,$keys);
        if(sizeof($keys)==0)
            return $sTemplate;
        $keys = array_unique($keys[0]);
        $n = sizeof($keys);
        $sMsg = $sTemplate;
		
        foreach($keys as $val){
        	$val = str_replace('{','', $val);
			$val = str_replace('}','', $val);
        	$sMsg = str_replace('{'.$val.'}',$aParms[$val],$sMsg);
        }
        
		return $sMsg;
	}
	  
    protected function _doDataCell($dataRow, $key, $type, $stripTags=false, $numChars='')
    {
        switch($type)
        {
            case 'text':
				if($stripTags==TRUE){
					$cellContent = ellipsize($dataRow[$key],$numChars);
				} else {
					$cellContent = $dataRow[$key];
				}
				break;
            case 'int':
                $cellContent =  ((!empty($dataRow[$key])||$dataRow[$key]===0)? sprintf($this->aFormats[$type],(int)$dataRow[$key]):'');
				break;
            case 'double':
			case 'money':
                $cellContent =  ((!empty($dataRow[$key])||$dataRow[$key]===0)? sprintf($this->aFormats[$type],(double)$dataRow[$key]):'');
				break;
            case 'bool':
				$cellContent = '';
				switch($dataRow[$key]) {
					case $this->_CI->lang->line('gridview_true_dbval'):
						$cellContent = $this->_CI->lang->line('gridview_yes');
						break;
					case $this->_CI->lang->line('gridview_false_dbval'):
						$cellContent = $this->_CI->lang->line('gridview_no');
						break;
				}
				break;
            case 'date':
			case 'datetime':
            case 'time':
				$format = $this->_CI->lang->line('gridview_'.$type.'_format');
				if(!empty($format))
				{
					$date = trim($dataRow[$key]);
					if(!empty($date) && strtotime($date)!=''){
				        try
						{
							$oDt = new DateTime($date);	
						}
						catch(Exception $e)
						{
							$oDt = date_create($date);
						}
						$cellContent = $oDt->format($format);
					} else {
						$cellContent = '';
					}					
				} else {
					$cellContent = '!#ERROR NO LANGUAGE FOUND';
				}

                break;
            default:
                $cellContent = '!#ERROR';
                break;
        }
		
		return $cellContent;

    }
    
    protected function _doControlCell($index,$dataRow, $name, $def)
    {
        // verificar que def sea consistente
        $tpl = $def['options']['face'];
        if(empty($tpl))
        {
            $def['type'] = 'text';
            return $this->_doCell($dataRow, $name, $def);
        }
        
        /* normalizar parametros de urls */
         
        $er ='/<a[\s]+[^>]*href\s*=\s*([\"\']+)([^>]+?)(\1|>)/i';
        preg_match_all($er, $tpl, $urls);
        
        
        for($i=0;$i<sizeof($urls[2]);$i++)
        {
            preg_match_all("/{\w+}/i",$urls[2][$i],$keys);
            $keys = array_unique($keys[0]);
            if(sizeof($keys)>0)
            {
                foreach($keys as $key)
                {
                    $sKey = substr($key,1,strlen($key)-2);
                    $dataRow[$sKey.'urlenc'] = urlencode(htmlspecialchars($dataRow[$sKey],ENT_COMPAT,'UTF-8'));
                    $nurl = str_ireplace($key,'{'.$sKey.'urlenc}',$urls[2][$i]);
                    $tpl = str_ireplace($urls[2][$i],$nurl,$tpl);
                }
            }
            
        }
        return self::_processMessageTemplate($tpl,$dataRow);
    }
    
    protected function _doFunctionCell($index,$dataRow, $name, $def)
    {
        // verificar que def sea consistente
        $tpl = $def['options']['functionName'];
        if(empty($tpl))
        {
            $def['type'] = 'text';
            return $this->_doCell($dataRow, $name, $def);
        }
        
		$parms = array();
		array_push($parms,$dataRow);
		foreach($def['options']['parms'] as $key => $val){
			array_push($parms,$val);
		}
		$sContent = call_user_func($def['options']['functionName'],$parms);
		if(!$sContent)
			$sContent = '#ERROR!';
		return $sContent;
    }
    
    protected function _doCell($index,$dataRow,$name,$def)
    {
        $cellContent = '';
        switch($def['type'])
        {
            case 'text':
            case 'int':
            case 'double':
            case 'money':
            case 'bool':
            case 'date':
            case 'datetime':
            case 'time':
                return $this->_doDataCell($dataRow,$name,$def['type'],$def['options']['stripTags'],$def['options']['numChars']);    
                break;
            case 'tinyText':
                //return $this->_doFunctionCell($index,$dataRow,$name,$def);
                //return wordwrap($dataRow[$name], 5);
                return word_limiter($dataRow[$name], 10);
                //return $dataRow[$name];
                break;
            case 'function':
                return $this->_doFunctionCell($index,$dataRow,$name,$def);
                break;
            case 'control':
                return $this->_doControlCell($index,$dataRow,$name,$def);
                break;
            default:
                $cellContent = '!#ERROR';
                break;
        }
        return $cellContent;
    }
    

    protected function _doRow($index,$dataRow)
    {
        if(sizeof($this->aCols)==0)
            return '';
        if(sizeof($dataRow)==0)
            return '';
        $sXHtml = '';
        
        $sCellContainerOp = (!empty($this->_aTemplates['cellElement']))?'<'.$this->_aTemplates['cellElement'].'%s>':''; 
        $sCellContainerCl = (!empty($this->_aTemplates['cellElement']))?'</'.$this->_aTemplates['cellElement'].'>':'';
        foreach($this->aCols as $name => $def)
        {
            $cellContent = $this->_doCell($index,$dataRow,$name,$def);
            $cellProperties = ' '. trim(implode(' '
                                    , array(
                                        (!empty($def['options']['style']))?'style="'.$def['options']['style'].'"':''
            				            ,(!empty($def['options']['class']))?'class="'.$def['options']['class'].'"':'')
                                    ));
            $sXHtml.= sprintf($sCellContainerOp,$cellProperties).$cellContent.$sCellContainerCl;
        }        
        $sRowProps = ($index%$this->iRowAltPaternRepeat==0)? ' '.$this->sRowProperties: ' '.$this->sAltRowProperties;
        $sRowContainerOp = (!empty($this->_aTemplates['rowElement']))?'<'.$this->_aTemplates['rowElement'].'%s %s>':''; 
        $sRowContainerCl = (!empty($this->_aTemplates['rowElement']))?'</'.$this->_aTemplates['rowElement'].'>':'';
        $idRow = ' id="'.$dataRow[$this->identificador].'" ';

        $sXHtml = sprintf($sRowContainerOp, $idRow, $sRowProps).$sXHtml.$sRowContainerCl;
        return $sXHtml;
    }
    
    protected function _doHeads()
    {
        if(sizeof($this->aCols)==0)
            return '';
        if(empty($this->_aTemplates['headElement']))
            return '';    
        
        $sXHtml = '';
        
        $sHeadContainerOp = (!empty($this->_aTemplates['headElement']))?'<'.$this->_aTemplates['headElement'].'>':''; 
        $sHeadContainerCl = (!empty($this->_aTemplates['headElement']))?'</'.$this->_aTemplates['headElement'].'>':'';
        $cant = count($this->aCols);
        foreach($this->aCols as $name => $def)
        {
            if(!$this->bOrder) {
                $sXHtml.=$sHeadContainerOp.$def['columnCaption'].$sHeadContainerCl;
            }
            else {
            	if(!empty($def['columnCaption'])&&$def['type']!='control'&&$def['options']['order']) {
            		$orderType = '';
            		if(!empty($_REQUEST[$this->sResponseType][$this->sOrderParmName])) {
            			$jsonParmsOrd = $_REQUEST[$this->sResponseType][$this->sOrderParmName];
	            		$aParmsOrd = json_decode($jsonParmsOrd);
						$orderTypeClass = 'th-order-'.strtolower($aParmsOrd['orderType']);
            		} else {
            			$jsonParmsOrd = urlencode(htmlspecialchars(json_encode(array('orderType'=>'asc','orderField'=>$name))));
                        //$jsonParmsOrd = json_encode(array('orderType'=>'asc','orderField'=>$name));
            		}
                    /*$sXHtml .= $sHeadContainerOp.<<<th
<a href="$def[id]" title="Ordenar por $def[columnCaption]" class="$orderType">$def[columnCaption]</a>
th
.$sHeadContainerCl;*/
                    $sHeadContainerOp = (!empty($this->_aTemplates['headElement']))?'<'.$this->_aTemplates['headElement'].' class="th-order">':''; 
                    $sXHtml .= $sHeadContainerOp.'<a href="'.$def['id'].'" title="Ordenar por '.$def['columnCaption'].'" class="'.$orderType.'">'.$def['columnCaption'].'</a><span class="glyphicon glyphicon-sort pull-right"></span>'.$sHeadContainerCl;
            	} else {
                    $sHeadContainerOp = (!empty($this->_aTemplates['headElement']))?'<'.$this->_aTemplates['headElement'].'>':''; 
            		$sXHtml.=$sHeadContainerOp.$def['columnCaption'].$sHeadContainerCl;
            	}
				
			}
                
        }
        if($this->_aTemplates['listElement']=='table'){
            if($this->buscador) {
                //$buscador = '<tr><th colspan="'.count($this->aCols).'"><div class="pull-right"><form id="frmBuscador" name="frmBuscador" action="administrator/agentes/listado" method="post" target="contenido-abm">Buscar&nbsp;&nbsp;<input id="txtvcBuscar" name="txtvcBuscar" type="text"/></form></div></th></tr>';
                $buscador = '<tr><th colspan="'.count($this->aCols).'"><form action="administrator/cuadrocargosagentes"><div class="pull-right"><div class="input-group"><span class="glyphicon glyphicon-search input-group-addon" style="padding:0em 1em;margin:0;"></span><input type="text" class="form-control" placeholder="Buscar..." style="padding:0 0.5em;"></div></div></form></th></tr>';
            }
        	$sXHtml = '<thead><tr><th colspan="'.count($this->aCols).'" class="hilite">'.$this->titulo.'</th></tr>'.$buscador.'<tr>'.$sXHtml.'</tr></thead>';

        }
        if($this->bOrder==TRUE){
			$this->addParm($this->sOrderParmName, '');
			$this->_set_client_order_by_controller();
        }
        return $sXHtml;
    }
    
    protected function _doFoot($sFootContent='',$iNumRegs='')
    {
    	if(empty($sFootContent))
    		$sFootContent = '<div class="paginator"><span class="info">'.$iNumRegs.' registro'.($iNumRegs>1?'s':'').' </span></div>';
		
    	
    	if(!$this->bDoForm && $this->bAjaxEnabled)
        {
            $sFootContent .= $this->_doParms();
            $sFootContent = $this->_wrapsInForm($sFootContent);
        }
        return self::_processMessageTemplate(
        	$this->_aTemplates['footTpl']
        	, array(
        		'idFoot' => 'footer-'.$this->sId
        		,'sFootProperties' => $this->sFootProperties
        		,'sFootContent'=>$sFootContent)
        	);
    }
    
    protected function _doEmpty()
    {
        return $this->_aTemplates['emptyTpl'];
    }
    
    protected function _wrapsInForm($sContent)
    {
    	$sParms = $this->_doParms();
    	$sXHtml = <<<sXHtml
<form id="$this->sId" name="$this->sName" method="$this->sResponseType" action="$this->sResponseUrl" accept-charset="utf-8" enctype="application/x-www-form-urlencoded" onsubmit="javascript:return false;">
$sContent
$sParms
</form>
sXHtml;
		return $sXHtml;
    }
    
    protected function _doParms()
    {
    	if(!empty($this->sOrderParmName)&&!empty($this->sOrderByClientFunction)) {
    		$keyName = explode($this->sDataKeyNames);
    		$keyName = (sizeof($keyName)>0)? $keyName[0]:'';
    		$sOrder = (!empty($_REQUEST[$this->sResponseType][$this->sOrderParmName]))?
    			$_REQUEST[$this->sResponseType][$this->sOrderParmName]
    			: '{order:\''.$keyName.'\',type:DESC}';
    		$this->addParm($this->sOrderParmName,$sOrder);
    	}
        $sOrder = (!empty($_REQUEST[$this->sResponseType][$this->sOrderParmName]))?
                $_REQUEST[$this->sResponseType][$this->sOrderParmName]
                : '{order:\'order\',type:DESC}';
        $this->addParm('orderType', '');
    	
        if($this->bEnablePaginator) {
    		$page = (int)(!empty($_REQUEST[$this->sResponseType][$this->_pager->query_string_segment]))?
    					$_REQUEST[$this->sResponseType][$this->_pager->query_string_segment]
    					: $this->_pager->cur_page;
    		$this->addParm($this->_pager->query_string_segment,$page);
    	}
    	$sXHtml = '';
    	if(sizeof($this->_aParms)>0) {
    		foreach($this->_aParms as $key => $value) {
				$sXHtml .= <<<sTpl
<input type="hidden" id="{$this->sId}-{$key}" name="$key" value="{$value}"/>
sTpl;
			}
    	}
		return $sXHtml;    	
    }
    
    /**
     * cgridview::addColumn()
     * Especificacion de una columna a generar.
     * @param string $name: Nombre de la columna
     * @param string $type: Tipo
     *          (int
     *          | double
     *          | money
     *          | text
     *          | bool
     *          | date
     *          | datetime
     *          | function
     *          | control)
     * @param mixed $options: array de opciones variables de generacion de los datos de la columna
     *      - stripTags: (true| false) eliminar tags html
     *      - numChars: cantidad de caracteres a truncar
     *      - style: propiedad style de la celda a generar
     *      - class: propiedad class de la celda a generar
     *      - function: nombre y parametros de la funcion a ejecutar
     *      	{functionName: nombre de la funcion, parms:array() array de parametros fijos de la funcion, se agregara a la lista como 1º parametro al registro de la fila actual}
     *      - control: especificacion del control
     *          {face: cara del control en formato de template}
     * @return void
     */
    public function addColumn($name,$columnCaption,$type='text',$options=null)
    {
        if(empty($this->aCols))
            $this->aCols = array();
        if(!key_exists($name,$this->aCols))
        {
        	
        	$optDef = array(
        		'stripTags' => false
        		, 'numChars' => ''
        		, 'style' => ''
        		, 'class' => ''
                , 'order' => false
        		, 'function' => array('functionName'=>'','parms'=>array())
        		, 'control'=>array('face'=>'','actionType'=>'')
        	);
        	if(!is_array($options)||$options==null)
                $options = array();
            $this->aCols[$name] = array(
                'columnCaption' => $columnCaption
                , 'type' => $type
                , 'options' => array_merge($optDef,$options)
                , 'id' => $name
            );
            return true;
        }
        return false;
    }
    
    /**
     * cgridview::addControl()
     * Agrega un control a la grilla, especificado mediante un template HTML. 
     * @param string $name: Nombre de la columna
     * @param mixed $options: array de opciones variables de generacion de los datos de la columna
     *      - stripTags: (true| false) eliminar tags html
     *      - numChars: cantidad de caracteres a truncar
     *      - style: propiedad style de la celda a generar
     *      - class: propiedad class de la celda a generar
     *      - function: nombre y parametros de la funcion a ejecutar
     *      	{functionName: nombre de la funcion, parms:array() array de parametros fijos de la funcion, se agregara a la lista como 1º parametro al registro de la fila actual}
     *      - control: especificacion del control
     *          {face: cara del control en formato de template}
	 * @param string $title: Titulo de la columna del control.
     * @return void
     */
	public function addControl($name, $faceTpl, $title = '')
	{
		$options = array();
		if(is_array($faceTpl))
        { $options = $faceTpl; } 
        else
        { $options =  array('face'=>$faceTpl); }
		$this->addColumn($name, $title, 'control', $options);
	}
	
	/**
     * Agrega un parametro para ser recordado entre requests.
     * 
     * @param string $name: Nombre del parámetro, es el mismo que será asignado a la vble. POST o GET
     * @param string $value: Valor actual del parámetro a recordar.
     * @return void
    */
    public function addParm($key, $value)
    {
    	if(!isset($this->_aParms)||empty($this->_aParms))
    		$this->_aParms = array();
    	if(!array_key_exists($key,$this->_aParms)) {
            if($this->bSanitizeParms==FALSE) {
               $this->_aParms[$key] = htmlspecialchars($value, ENT_COMPAT, 'UTF-8');			   
            } else {
                $this->_aParms[$key] = $value;
            }
            
    	}
    	return $this->_aParms;
    }

	/**
     * Asigna los templates necesarios para generar el listrado del gridview
     * 
     * @param mixed $aTemplates: array de templates.
     * @return void
    */	
    public function setTemplates($aTemplates)
    {
      	$this->_CI->load->library('messages');      
    	$baseTemplate = array(
            'listElement' => 'table'
            , 'rowElement' => 'tr'
            , 'cellElement' => 'td'
            , 'headElement' => 'th'
            , 'footTpl' => '<div id="{idFoot}"{sFootProperties}>{sFootContent}</div>'
            , 'emptyTpl' => $this->_CI->messages->do_message(array('message'=>'No se encontraron resultados','type'=> 'info'))            
            , 'containerElement' => 'div');

        if(!is_array($aTemplates) || $aTemplates==null){
        	$aTemplates = array();
        }
		
		if(sizeof($aTemplates) > 0) {
			foreach($baseTemplate as $k => $v) {
				if(key_exists($k, $aTemplates)) {
					$baseTemplate[$k] = $aTemplates[$k];
				}
			}
		}
		
		$this->_aTemplates = $baseTemplate;
    }

	/**
     * Instanciacion de los parametros del paginador.
     * 
     * @param mixed $aTemplates: array de parametros de config de. Paginator.
     * @return void
    */	
    public function setPaginator($config=array())
    {
    	$this->iPerPage = ($this->iPerPage > 0)?$this->iPerPage: 1;

		$config = array_merge(array(
			'base_url' => $this->sResponseUrl
			, 'total_rows' => $this->iTotalRegs
			, 'per_page' => $this->iPerPage
			, 'is_ajax_enabled' => $this->bAjaxEnabled
		), $config);

    	$this->bEnablePaginator = true;
    	/**
		 * colocar el nombre del parametro de paginacion
		 */
    	if($this->sPageParmName!=''){
    		$config['prefix'] = $this->sPageParmName.'/';
    	} elseif($config['prefix']!='') {
			$this->sPageParmName = str_replace('/', '', $config['prefix']);
		} else {
			$this->sPageParmName = 'page';
			$config['prefix'] = 'page/';
		}
		
		/*
		 * Detectar del uri_segment el parametro del numero de pagina, o al menos intentar :(
		 */
		$parmsUri = $this->_CI->uri->uri_to_assoc();
		if(array_key_exists($this->sPageParmName, $parmsUri)){
			$this->addParm($this->sPageParmName, $parmsUri[$this->sPageParmName]);
		}
		
		$this->bAjaxEnabled = $this->bAjaxEnabled || $config['is_ajax_enabled'];
		$config['is_ajax_enabled'] = $this->bAjaxEnabled;
		
		if(empty($config['query_string_segment'])){
			$config['query_string_segment'] = $this->sPageParmName;
		} else {
			$this->sPageParmName = $config['query_string_segment'];
		}
		
		if(empty($config['base_url'])){
			$config['base_url'] = $this->sResponseUrl;
		} else {
			$this->sResponseUrl = $config['base_url'];
		}
		
    	$pagerName = $this->sId.'_pager';

    	$this->_CI->load->library('pagination', $config, $pagerName);
		$ov = get_object_vars($this->_CI);
		$this->_pager = $ov[$pagerName];
		$this->_set_client_pagination_controller();
    }
	
	
	/**
     * Obtiene el estado actual de la paginacion para establecer el offset de la query a la BD.
     * 
     * @return integer
    */		
	public function getLimit1()
	{
		$limit1 = 0;
		if(method_exists($this->_pager, 'get_limit1')){
			$limit1 = $this->_pager->get_limit1();
		}
		else {
			$this->_pager->cur_page = ($this->_pager->cur_page==0)? 1: $this->_pager->cur_page;
			$limit1 = ($this->_pager->cur_page * $this->_pager->per_page) - $this->_pager->per_page;			
		}
		return $limit1;
	}

	/**
     * Obtiene el estado actual de la paginacion para establecer el limit de la query a la BD.
     * 
     * @return integer
    */	
	public function getLimit2()
	{
		$limit2 = 0;
		if(method_exists($this->_pager, 'get_limit2')){
			$limit2 = $this->_pager->get_limit2();
		}
		else{
			$base_page_num = floor($this->_pager->total_rows/$this->_pager->per_page);
			$extra_page_num = $this->_pager->total_rows - ($base_page_num * $this->_pager->per_page);
			
			$limit2 =  ($this->_pager->cur_page==$base_page_num + 1)? $extra_page_num: $this->_pager->per_page;
		}
		return $limit2;
	}
	
	public function curPage()
	{
		return (!$this->_pager)? 0: $this->_pager;
	}
	
    public function getPaginationState()
    {
		if(!$this->_pager) {
			return false;
		} else {
			
        	return array(
	            'page' => (int)$this->_pager->cur_page // número de pagina actual
	            , 'limit1' => (int)$this->getLimit1() // para que el metodo de acceso a datos asigne su valor inicial
	            , 'limit2' => (int)$this->getLimit2() // para que el metodo de acceso a datos asigne su valor final
	        );
		}
    }
    
	public function getOrderBy(){
		if(!empty($_REQUEST[$this->sResponseType][$this->sOrderParmName])) {
			$jsonParmsOrd = $_REQUEST[$this->sResponseType][$this->sOrderParmName];
			$aParmsOrd = json_decode($jsonParmsOrd);
			$orderTypeClass = 'th-order-'.strtolower($aParmsOrd['orderType']);
		} else {
			$jsonParmsOrd = urlencode(htmlspecialchars(json_encode(array('orderType'=>'asc','orderField'=>$name))));
		}
	}
	
    public function doXHtml($aRegs)
    {
    	$sXHtml = '';
    	if(sizeof($aRegs)==0) {
    		return ($this->bDoForm==FALSE)? $this->_doEmpty(): $this->_wrapsInForm($this->_doEmpty());
    	}
    	
    	$i=0;
    	foreach ($aRegs as $Reg)
    		$sXHtml .= $this->_doRow($i++,$Reg);
    	
    	$sContainerOp = (!empty($this->_aTemplates['listElement']))?'<'.$this->_aTemplates['listElement'].' %s>':''; 
        $sContainerCl = (!empty($this->_aTemplates['listElement']))?'</'.$this->_aTemplates['listElement'].'>':'';	
		
        if($this->_aTemplates['listElement']=='table')
            $sXHtml = '<tbody>'.$sXHtml.'</tbody>';
        
        $sXHtml = sprintf($sContainerOp,$this->sListProperties)
        	. $this->_doHeads()
        	. $sXHtml
        	. $sContainerCl;
			
        $sFootContent = '';
		
		$sContainerOp = (!empty($this->_aTemplates['containerElement']))?'<'.$this->_aTemplates['containerElement'].' %s>':''; 
        $sContainerCl = (!empty($this->_aTemplates['containerElement']))?'</'.$this->_aTemplates['containerElement'].'>':'';
		
		if($sContainerOp!=''&&$sContainerCl!=''){
			$containerId = 'container-'.$this->sId;
		}
		
		if(!empty($this->_pager)){
			$this->_pager->response_element_selector = '#'.$containerId;
			$sFootContent = $this->_pager->do_links();
		}
		
		$sFootContent .= $this->sOrderByClientController;
		
    	$sXHtml .= $this->_doFoot($sFootContent,sizeof($aRegs));
    	
    	if($this->bDoForm)
    		$sXHtml = $this->_wrapsInForm($sXHtml);

    	$sContainerOp = (!empty($this->_aTemplates['containerElement']))?'<'.$this->_aTemplates['containerElement'].' %s>':''; 
        $sContainerCl = (!empty($this->_aTemplates['containerElement']))?'</'.$this->_aTemplates['containerElement'].'>':'';
    	
    	$sXHtml = sprintf($sContainerOp,'id="container-'.$this->sId.'"').$sXHtml.$sContainerCl;

        $sXHtml.= "<script type=\"text/javascript\">
//<![CDATA[
$(document).ready(function () {
    i = Math.round(Math.random()*999999999999999999);
    $('th').parent().parent().parent().each(function(){

        // Verificar si tiene ID, sino tiene crear uno.
        if (!$(this).attr('id')) {
            $(this).attr('id', 'myTableColumn' + i);
            i++;
        }
        var tableID = $(this).attr('id');

        // Verificar si tiene colgroup
        var createColGroup = $('table#' + tableID + ' colgroup').get(0);
        if (typeof createColGroup == 'undefined') {
            // Si no tiene colgroup agregarlo
            $('table#' + tableID).prepend('<colgroup></colgroup>');
            
            // Agregar los <col> segun cantidad de columnas
            var j = 1;
            $('table#' + tableID + ' th').each(function() {
                var colg = $('table#' + tableID + ' colgroup');
                colg.html(colg.html() + '<col>' + j + '</col>');
                j++;
            });
        }

        // Agregar Eventos para remarcar las columnas
        $('table#' + tableID + ' th').hover(function(){
            var col = $(this).index();
            $($('table#' + tableID + ' th')[col]).addClass('hilite');
            $('table#' + tableID + ' tr').each(function() {
                $($(this).find('td')[col]).addClass('hilite');
            });
        }, function(){
            var col = $(this).index();
            $($('table#' + tableID + ' th')[col]).removeClass('hilite');
            $('table#' + tableID + ' tr').each(function() {
                $($(this).find('td')[col]).removeClass('hilite');
            });
        });

    });
});
//]]>
</script>";
    	
    	return $sXHtml;
    }
	
	public function get_client_extender($idViewContainer) {
		return <<<ClientTemplate
<script type="text/javascript">
//<![CDATA[
		$(document).ready(function(){
			// \$('#{$idViewContainer}').gridviewHandler({'url': '{$idViewContainer}'});
		});
//]]>
</script>
ClientTemplate;
	}
	
	/**
	 * 
	 */
	/**
	 * Crea el controlador javascript del paginador
	 *
	 * @access	protected
	 */	
	protected function _set_client_pagination_controller()
	{
		if($this->bEnablePaginator==FALSE){
			return '';
		}
		if($this->bAjaxEnabled == TRUE) {
			$response_element_id = '#container-'.$this->sId;
			
			$page_ini = 0;
			$num_pages = ceil($this->_pager->total_rows / $this->_pager->per_page);
			$page_selected = ($this->_pager->cur_page==0)? 1: $this->_pager->cur_page;
			
			$this->_pager->client_controller = <<<ClientTemplate
<script type="text/javascript">
//<![CDATA[
		\$(document).ready(function(){
			// \$('${response_element_id}').gridviewHandler();
		});
//]]>
</script>
ClientTemplate;
		} else {
			// modo submit aqui!
		}
	}

	protected function _set_client_order_by_controller()
	{
		if($this->bOrder==TRUE){
			return '';
		}
		if($this->bAjaxEnabled==TRUE){
			$response_element_id = '#container-'.$this->sId;
			
			$head_selector = $response_element_id. ((!empty($this->_aTemplates['listElement']))? ' '.$this->_aTemplates['listElement']:'').((!empty($this->_aTemplates['headElement']))? ' '.$this->_aTemplates['headElement']: ''). '';
			
			$this->sOrderByClientController = <<<ClientTemplate
<script type="text/javascript">
//<![CDATA[
		\$(document).ready(function(){
		
			\$('$head_selector').click(function(e){
                /*if(\$('#ordertype').val() == 'DESC') {
                    \$('#ordertype').val('');
                }*/
				var formAct = \$('${response_element_id} form');
				//\$('#gridview-order').val(\$(this).find('a').attr('href'));
				\$.ajax({
					type: formAct.attr('method')
					, url: formAct.attr('action')
					, data: formAct.serialize()
					, beforeSend: function(){
						
					}
					, error: function(jqXHR, textStatus, errorThrown){
						alert('Hubo un error en la solicitud enviada.');
					}
					, success: function(data, textStatus, jqXHR){
						var \$kids = \$(data).children('{$response_element_id}');
						var parent = \$(\$('{$response_element_id}').parent().parents('div'))[\$kids.length -1] || \$('{$response_element_id}').parent();
						\$(parent).html(data);
					}
					, complete: function(){
						
					}
				});
				
				e.preventDefault();			
			});	
		});
//]]>
</script>
ClientTemplate;
		} else {
			// modo submit aqui
		}

	}
}