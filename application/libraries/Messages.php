<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Pagination Class
 *
 * @package		base
 * @subpackage	Libraries
 * @category	Messages
 * @author		Marcelo G
 * @link	
 * Tipos de mensajes: info, alert, error, success	
 */
class Messages {
	public $message = '';
	public $id = 'notify-message';
	public $container_props = '';
	public $type = 'info';
	protected $_client_controller = '';
	/**
	 * Constructor
	 *
	 * @access	public
	 * @param	array	initialization parameters
	 */
	function __construct($params = array()){
		$this->initialize($params);
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
	}
	/**
	 * Crea el controlador javascript
	 *
	 * @access	protected
	 */	
	protected function _set_client_controller()
	{
		$this->_client_controller = <<<ClientTemplate
<script type="text/javascript">
	\$(document).ready(function(){
	  //var posTop = \$('#{$this->id}').position().top - 6;
		var posTop = \$('#{$this->id}').position();
    if (posTop < \$('html, body').scrollTop()){
      \$('html, body').animate({scrollTop: posTop}, 'slow');
    }
		\$('#{$this->id} div.notif-lft').animate({'margin-left': "10px"}, { duration: 1000, queue: false });
		\$('#{$this->id} a.icon-notif').click(function(e){
				\$(this).parent().slideUp();
				e.preventDefault();			
			});
		});
</script>
ClientTemplate;
	}
	
	public function do_message($options=array()){
		$this->initialize($options);
		$this->_set_client_controller();
		$message = <<<ClientTemplate
          <div id="{$this->id}" class="notif-container-{$this->type}">
			<div class="notif-lft">
{$this->message}
			</div>
			<a class="icon-notif">&nbsp;</a><div class="clearfloat">&nbsp;</div>
          </div>
ClientTemplate;
		return $message.$this->_client_controller;

	}

}