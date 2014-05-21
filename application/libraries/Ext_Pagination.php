<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Pagination Class
 *
 * @package		base
 * @subpackage	Libraries
 * @category	Pagination
 * @author		Marcelo G
 * @link
 * @copyright	2012-01-01
 */
class Ext_Pagination extends CI_Pagination{
	
	public $id_pager = 'pager-ajax'; // el id del elemento contenedor del paginador
	public $is_ajax_enabled = false; // establece si el paginador permite ajax
	public $client_controller = ''; // especificacion del controlador javascript desde el cliente
	public $response_element_selector = '';

	public $per_page_options = '10,25,50,100'; // elementos del dropdown para seleccionar la cantidad de registros a mostrar.
	public $empty_first_element = '<strong>&lt;</strong>';
    public $empty_last_element = '<strong>&gt;</strong>';

	/**
	 * Constructor
	 *
	 * @access	public
	 * @param	array	initialization parameters
	 */
	function __construct($params = array()){
		parent::__construct($params);
		/*
		$this->is_ajax_enabled = (key_exists('is_ajax_enabled', $params))? $params['is_ajax_enabled']: false;
		$this->id_pager = (key_exists('id_pager', $params))? $params['id_pager']:$this->id_pager;
		 * */

		if($this->is_ajax_enabled)
		{
			if($this->full_tag_open=='')
			{
				
				$this->full_tag_open = '<div>';
				$this->full_tag_close = '</div>';
			}
		}
	}
	/**
	 * Initialize Preferences
	 *
	 * @access	public
	 * @param	array	initialization parameters
	 * @return	void
	 */
	function initialize($params = array())
	{
		
		if (count($params) > 0)
		{
			foreach ($params as $key => $val)
			{
				if (isset($this->$key))
				{
					$this->$key = $val;
				}
			}
		}
		$this->_set_per_page();
	}
	
	protected function _set_per_page() {
		
		$CI =& get_instance();
		
		$perPageOpts = explode(',', $this->per_page_options);
		if(sizeof($perPageOpts) == 0) {
			return;
		}
		if(!in_array($this->per_page, $perPageOpts)) {
			$this->per_page = $perPageOpts[0];
		}
	}
	
	/**
	 * Crea el controlador javascript del paginador
	 *
	 * @access	protected
	 */	
	protected function _set_client_controller()
	{
			$data_to_send = array();
			
			$CI =& get_instance();
			
			foreach ($_POST as $key => $value) {
				$data_to_send[$key] = $CI->input->post($key);
			}
			
			$response_element_id = $this->response_element_selector;
			
			if(empty($response_element_id)){
				return '';
			}
			
			$data_to_send = json_encode($data_to_send);
			
			$this->client_controller = <<<ClientTemplate
<script type="text/javascript">
//<![CDATA[
		\$(document).ready(function(){
			\$('#{$this->id_pager} a').click(function(e){
				
				var urlRes = \$(this).attr('href');
				\$.ajax({
					type: 'POST'
					, url: urlRes
					, data: {$data_to_send}
					, beforeSend: function(){
						
					}
					, error: function(jqXHR, textStatus, errorThrown){
						alert('Hubo un error en la solicitud enviada.');
					}
					, success: function(data, textStatus, jqXHR){
						\$('{$response_element_id}').html(data);
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
		
	}
	
	protected function _set_limit1() {
		// Determine the current page number.
		$CI =& get_instance();
		if($CI->input->post($this->query_string_segment)!=0){
			$this->cur_page = $CI->input->post($this->query_string_segment);
			
			// Prep the current page - no funny business!
			$this->cur_page = (int) $this->cur_page;
		} else {
			if ($CI->config->item('enable_query_strings') === TRUE OR $this->page_query_string === TRUE)
			{
				if ($CI->input->get($this->query_string_segment) != 0)
				{
					$this->cur_page = $CI->input->get($this->query_string_segment);
	
					// Prep the current page - no funny business!
					$this->cur_page = (int) $this->cur_page;
				}
			}
			else
			{
				if ($CI->uri->segment($this->uri_segment) != 0)
				{
					$this->cur_page = $CI->uri->segment($this->uri_segment);
	
					// Prep the current page - no funny business!
					$this->cur_page = (int) $this->cur_page;
				}
			}
		}
		// ajuste de validación:
		// Si el cur_page excede la cantidad de registros volver al ultimo posible, es decir a la max_page_number
		if(($this->cur_page * $this->per_page) - $this->per_page > $this->total_rows) {
			$this->cur_page = floor($this->total_rows/$this->per_page) + 1;
		}
	}
	
	/**
	 * Obtiene el primer limite de paginacion a partir del numero de pagina actual, para indicar el offset de la paginacion en la query de la BD.
	 *
	 * @access	public
	 * @return	int
	*/
	public function get_limit1() {
		
		if(empty($this->cur_page)) {
			$this->_set_limit1();
		}
		$this->cur_page = ($this->cur_page==0)? 1: $this->cur_page;

		return ($this->cur_page * $this->per_page) - $this->per_page;
	}

	/**
	 * Obtiene el segundo limite de paginacion a partir del numero de pagina actual, para indicar el limit de la paginacion en la query de la BD.
	 *
	 * @access	public
	 * @return	int
	*/
	public function get_limit2() {
		$base_page_num = floor($this->total_rows/$this->per_page);
		$extra_page_num = $this->total_rows - ($base_page_num * $this->per_page);
		
		return ($this->cur_page==$base_page_num + 1)? $extra_page_num: $this->per_page;
	}
	
	/**
	 * Obtiene el elemento informacion del paginador formato #### Regs. Pág. x de Y
	 *
	 * @access	public
	 * @return	string
	*/
	public function get_info_item() {
		$num_pages = ceil($this->total_rows / $this->per_page);
		$vcXHtml = '<span class="item-contenedor">Cantidad total de registros '. $this->total_rows.'</span>'.
               '<span class="item-separador">&nbsp;</span>'.
               '<span class="item-contenedor">Mostrando página '.$this->cur_page.' de '.$num_pages.'</span><span class="item-separador">&nbsp;</span>';
		return $vcXHtml;
	}
	
	/**
	 * Obtiene el elemento ir a página del paginador
	 *
	 * @access	public
	 * @return	string
	*/
	public function get_goto_item() {
		$num_pages = ceil($this->total_rows / $this->per_page);
		/*
		if($num_pages < 1) {
			return '';
		}
		*/
		$vcXHtml = //'<span class="item-separador">&nbsp;</span>'.
               //'<input class="item-ir" type="text" value=""/>'.
               //'<a href="'.$this->base_url.'">Ir &raquo;</a>&nbsp;'.
               '<span class="item-separador">&nbsp;</span>';
		return $vcXHtml;
	}
	/**
	 * Obtiene el elemento ir a página del paginador
	 *
	 * @access	public
	 * @return	string
	*/
	public function get_per_page_item() {
		
		$perPageOpts = explode(',',$this->per_page_options);
		
		if(sizeof($perPageOpts)==0){
			return '';
		}
		$perPageOpts = array_unique($perPageOpts);
		
		sort($perPageOpts);
		
		$options = array();
		$perPageOpts2 = array();
		
		for($i=0; $i < sizeof($perPageOpts); $i++) {
			if(preg_match('/^[0-9]+$/', $perPageOpts[$i])) {
				$perPageOpts2[] = $perPageOpts[$i];
			}
		}
		
		$perPageOpts = $perPageOpts2;

		for($i=0; $i < sizeof($perPageOpts) && $perPageOpts[$i] <= $this->total_rows; $i++) {
			$options[$perPageOpts[$i]] = $perPageOpts[$i].' Elementos';
		}

		if(sizeof($options) == 0) {
			return '';
		}
		
		if($i < sizeof($perPageOpts) && $perPageOpts[$i-1] < $this->total_rows) {
			$options[$perPageOpts[$i]] = $perPageOpts[$i].' Elementos';
		}
		
		if(sizeof($options) < 2) {
			return '';
		}
		
		$select = form_dropdown('per_page',$options, $this->per_page, 'id="" class="por-pag input-medium"');
		
		$vcXHtml = '<span class="item-contenedor">Mostrar: </span>'.$select;
		
		return $vcXHtml;
	}
			
	/**
	 * Generate the pagination links
	 *
	 * @access	public
	 * @return	string
	 */	
	public function do_links() {
		// If our item count or per-page total is zero there is no need to continue.
		if ($this->total_rows == 0 OR $this->per_page == 0)
		{
			return '';
		}

		// Calculate the total number of pages
		$num_pages = ceil($this->total_rows / $this->per_page);
		$this->_set_limit1();
		
		// Is there only one page? Hm... nothing more to do here then.
		if ($num_pages > 1)
		{


		// Determine the current page number.
		
		
		$CI =& get_instance();
		
		$this->num_links = (int)$this->num_links;

		if ($this->num_links < 1)
		{
			show_error('Your number of links must be a positive number.');
		}

		if ( ! is_numeric($this->cur_page))
		{
			$this->cur_page = 0;
		}

		// Is the page number beyond the result range?
		// If so we show the last page
		if ($this->cur_page > $this->total_rows)
		{
			$this->cur_page = ($num_pages - 1) * $this->per_page;
		}

		$uri_page_number = $this->cur_page;
		$this->cur_page = floor(($this->cur_page/$this->per_page) + 1);
		
		$this->cur_page = $uri_page_number;
		$page_selected = ($this->cur_page==0)? 1: $this->cur_page;
		
		// Calculate the start and end numbers. These determine
		// which number to start and end the digit links with
		$start = (($page_selected - $this->num_links) > 0) ? $page_selected - ($this->num_links - 1) : 1;
		$end   = (($page_selected + $this->num_links) < $num_pages) ? $page_selected + $this->num_links : $num_pages;

		
		
		// Is pagination being used over GET or POST?  If get, add a per_page query
		// string. If post, add a trailing slash to the base URL if needed
		if ($CI->config->item('enable_query_strings') === TRUE OR $this->page_query_string === TRUE)
		{
			$this->base_url = rtrim($this->base_url).'&amp;'.$this->query_string_segment.'=';
		}
		else
		{
			$this->base_url = rtrim($this->base_url, '/') .'/';
		}
		

		// And here we go...
		$output = '';
        /*
		// Render the "First" link
		if  ($this->first_link !== FALSE AND $page_selected > ($this->num_links + 1))
		{
			$first_url = ($this->first_url == '') ? $this->base_url : $this->first_url;
			$output .= $this->first_tag_open.'<a '.$this->anchor_class.'href="'.$first_url.'">'.$this->first_link.'</a>'.$this->first_tag_close;
		}
        */
		// Render the "previous" link
		if  ($this->prev_link !== FALSE AND $page_selected > 1)
		{
			$i = $uri_page_number - 1;

			if ($i == 0 && $this->first_url != '')
			{
				$output .= $this->prev_tag_open.'<a '.$this->anchor_class.'href="'.$this->first_url.'">'.$this->prev_link.'</a>'.$this->prev_tag_close;
			}
			else
			{
				$i = ($i == 0) ? '' : $this->prefix.$i.$this->suffix;
				$output .= $this->prev_tag_open.'<a '.$this->anchor_class.'href="'.$this->base_url.$i.'">'.$this->prev_link.'</a>'.$this->prev_tag_close;
			}
		} else {
		  $output .= $this->empty_first_element;
;
		}

		// Render the pages
		
		
		if ($this->display_pages !== FALSE)
		{
			// Write the digit links
			for ($loop = $start ; $loop <= $end; $loop++)
			{
				$i = $loop ;
				if ($i >= 0)
				{
					if ($page_selected == $loop)
					{
						$output .= $this->cur_tag_open.$loop.$this->cur_tag_close; // Current page
					}
					else
					{
						$n = ($i == 0) ? '' : $i;

						if ($n == '' && $this->first_url != '')
						{
							$output .= $this->num_tag_open.'<a '.$this->anchor_class.'href="'.$this->first_url.'">'.$loop.'</a>'.$this->num_tag_close;
						}
						else
						{
							$n = ($n == '') ? '' : $this->prefix.$n.$this->suffix;

							$output .= $this->num_tag_open.'<a '.$this->anchor_class.'href="'.$this->base_url.$n.'">'.$loop.'</a>'.$this->num_tag_close;
						}
					}
				}
			}
		}

		// Render the "next" link
		if ($this->next_link !== FALSE AND $page_selected < $num_pages)
		{
			$output .= $this->next_tag_open.'<a '.$this->anchor_class.'href="'.$this->base_url.$this->prefix.($page_selected + 1).$this->suffix.'">'.$this->next_link.'</a>'.$this->next_tag_close;
		}
        elseif($page_selected >= $num_pages)
        {
            $output .= $this->empty_last_element;
        }
        /*
		// Render the "Last" link
		if ($this->last_link !== FALSE AND ($page_selected + $this->num_links) < $num_pages)
		{
			$i = $num_pages;
			$output .= $this->last_tag_open.'<a '.$this->anchor_class.'href="'.$this->base_url.$this->prefix.$i.$this->suffix.'">'.$this->last_link.'</a>'.$this->last_tag_close;
		}
        */
		$output = $this->get_info_item()
			. $output
			. $this->get_goto_item()
			. $this->get_per_page_item();
		} else {
			$output = $this->get_info_item()
				. $this->get_per_page_item();
		}
		
		
		if($this->is_ajax_enabled)
		{
			if($this->full_tag_open=='')
			{

				$this->full_tag_open = '<div>';
				$this->full_tag_close = '</div>';
			}
			if($this->client_controller=='')
			{
				$this->_set_client_controller();
			}
			$this->full_tag_open = str_ireplace('>', ' id='.$this->id_pager. '>', $this->full_tag_open);
		}
		
		// Kill double slashes.  Note: Sometimes we can end up with a double slash
		// in the penultimate link so we'll kill all double slashes.
		$output = preg_replace("#([^:])//+#", "\\1/", $output);
		// Add the wrapper HTML if exists
		$output = $this->full_tag_open
			. $output
			. $this->full_tag_close.$this->client_controller;
		
		return $output;
	}
}