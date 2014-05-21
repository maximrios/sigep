<?php

# override the default TCPDF config file
if(!defined('K_TCPDF_EXTERNAL_CONFIG')) {	
	define('K_TCPDF_EXTERNAL_CONFIG', TRUE);
}
	
# include TCPDF
require(APPPATH.'config/tcpdf'.EXT);
require_once(APPPATH.'third_party/tcpdf/tcpdf.php');



/************************************************************
 * TCPDF - CodeIgniter Integration
 * Library file
 * ----------------------------------------------------------
 * @author Jonathon Hill http://jonathonhill.net
 * @version 1.0 
 * @package tcpdf_ci
 ***********************************************************/
class Pdf extends TCPDF {
	
	
	/**
	 * TCPDF system constants that map to settings in our config file
	 *
	 * @var array
	 * @access private
	 */
	private $cfg_constant_map = array(
		'K_PATH_MAIN'	=> 'base_directory',
		'K_PATH_URL'	=> 'base_url',
		'K_PATH_FONTS'	=> 'fonts_directory',
		'K_PATH_CACHE'	=> 'cache_directory',
		'K_PATH_IMAGES'	=> 'image_directory',
		'K_BLANK_IMAGE' => 'blank_image',
		'K_SMALL_RATIO'	=> 'small_font_ratio',
	);
	
	
	/**
	 * Settings from our APPPATH/config/tcpdf.php file
	 *
	 * @var array
	 * @access private
	 */
	private $_config = array();
	
	
	/**
	 * Initialize and configure TCPDF with the settings in our config file
	 *
	 */
	function __construct($config) {
		$ci = &get_instance();
		# load the config file
		//$this->_config = $ci->config->tcpdf;
		//require(APPPATH.'config/tcpdf'.EXT);
		
		//$this->_config = $tcpdf;
		
		//unset($tcpdf);
		
		# set the TCPDF system constants
		/*foreach($this->cfg_constant_map as $const => $cfgkey) {
			if(!defined($const)) {
				define($const, $ci->config->item($cfgkey));
				echo sprintf("Defining: %s = %s\n<br />", $const, $ci->config->item($cfgkey));
			}
		}*/
		define('K_PATH_CACHE', 'cache_directory');
		
		# initialize TCPDF		
		parent::__construct(
			$ci->config->item('page_orientation'), 
			$ci->config->item('page_unit'), 
			$ci->config->item('page_format'), 
			$ci->config->item('unicode'), 
			$ci->config->item('encoding'), 
			$ci->config->item('enable_disk_cache'),
			$ci->config->item('header_on'),
			$ci->config->item('footer_on')
		);
		$this->page_orientation = $ci->config->item('page_orientation');
		# language settings
		if(is_file($ci->config->item('language_file'))) {
			include($ci->config->item('language_file'));
			$this->setLanguageArray($l);
			unset($l);
		}
		
		# margin settings
		$this->SetMargins($ci->config->item('margin_left'), $ci->config->item('margin_top'), $ci->config->item('margin_right'));
		
		# header settings
		

		$this->imagen = $ci->config->item('imagen_portrait');
		$this->print_header = (isset($config['header_on']))? $config['header_on'] : config_item('header_on');
		if($this->print_header == TRUE) {
			$this->print_header = TRUE; 
			$this->setHeaderFont(array($ci->config->item('header_font'), '', $ci->config->item('header_font_size')));
			$this->setHeaderMargin($ci->config->item('header_margin'));
			$this->SetHeaderData(
				$ci->config->item('header_logo'), 
				$ci->config->item('header_logo_width'), 
				$ci->config->item('header_title'), 
				$ci->config->item('header_string')
			);	
		}
		else {
			$this->setTopMargin(20);
		}
		
		# footer settings
		$this->print_footer = (isset($config['footer_on']))? $config['footer_on'] : config_item('footer_on');
		if($this->print_footer == TRUE) {
			$this->print_footer = $ci->config->item('footer_on');
			$this->setFooterFont(array($ci->config->item('footer_font'), '', $ci->config->item('footer_font_size')));
			$this->setFooterMargin($ci->config->item('footer_margin'));	
		}
		
		
		# page break
		$this->SetAutoPageBreak($ci->config->item('page_break_auto'), $ci->config->item('footer_margin'));
		
		# cell settings
		$this->cMargin = $ci->config->item('cell_padding');
		$this->setCellHeightRatio($ci->config->item('cell_height_ratio'));
		
		# document properties
		$this->author = $ci->config->item('author');
		$this->creator = $ci->config->item('creator');
		
		# font settings
		$this->SetFont($ci->config->item('page_font'), '', $ci->config->item('page_font_size'));
		
		# image settings
		$this->imgscale = $ci->config->item('image_scale');
		
	}
	
	//Page header
    public function Header() {
        // Logo
        //$image_file = K_PATH_IMAGES.'logo-gobierno-salta.jpg';
        //$image_file = K_PATH_IMAGES.'resoluciones.jpg';
        if($this->page_orientation == 'P') {
        	$this->Image($this->imagen, 19, 5.5, 190, '', 'JPG', '', 'T', true, 300, '', false, false, 0, false, false, false);	
        }
        else {
        	$this->Image($this->imagen, 19, 5.5, 190, '', 'JPG', '', 'T', true, 300, '', false, false, 0, false, false, false);	
        }
    }

    // Page footer
    public function Footer() {
        //Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $this->Cell(50, 10, 'Usuario : '.config_item('impreso'), 0, false, 'L', 0, '', 0, false, 'T', 'M');
        $this->Cell(90, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
        $this->Cell(50, 10, 'Fecha y Hora de impresión : '.date('d-m-Y H:i:s'), 0, false, 'R', 0, '', 0, false, 'T', 'M');
    }
	
	
	
}