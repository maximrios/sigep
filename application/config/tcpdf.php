<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/************************************************************
 * TCPDF - CodeIgniter Integration
 * Configuration file
 * ----------------------------------------------------------
 * @author Jonathon Hill http://jonathonhill.net
 * @version 1.0
 * @package tcpdf_ci
 ***********************************************************/
/********************************************************************************************************************
	Esta parte fue escrita por mi para poder usar las sesiones en el footer y demas
********************************************************************************************************************/

	//$ci = &get_instance();
	//$config['impreso'] = $ci->session->userdata('nombrePersona');
	$config['impreso'] = '';
	$config['imagen_portrait'] = 'assets/images/reportes/header-portrait.jpg';
	$config['imagen_landscape'] = '';

/***************************************************************************
 * PATH CONFIGURATION PARAMETERS
 **************************************************************************/


	/************************************************************
	 * TCPDF installation directory
	 * ----------------------------------------------------------
	 * This is the base installation directory for your TCPDF
	 * package (the folder that contains tcpdf.php).
	 * 
	 * ADD TRAILING SLASH!
	 ***********************************************************/

	
	$config['base_directory'] = APPPATH.'third_party/tcpdf/';
	
	
	/************************************************************
	 * TCPDF installation directory URL
	 * ----------------------------------------------------------
	 * This is the URL path to the TCPDF base installation
	 * directory (the URL equivalent to the 'base_directory'
	 * option above).
	 * 
	 * ADD TRAILING SLASH!
	 ***********************************************************/
	
	//$config['base_url'] = 'http://localhost/sigepv1/application/third_party/tcpdf/';
	
	
	/************************************************************
	 * TCPDF fonts directory
	 * ----------------------------------------------------------
	 * This is the directory of the TCPDF fonts folder.
	 * Use $config['base_directory'].'fonts/old/' for old non-UTF8
	 * fonts.
	 * 
	 * ADD TRAILING SLASH!
	 ***********************************************************/

	
	//$config['fonts_directory'] = $config['base_directory'].'fonts/';
	
	
	/************************************************************
	 * TCPDF disk cache settings
	 * ----------------------------------------------------------
	 * Enable caching; Cache directory for TCPDF (make sure that
	 * it is writable by the webserver).
	 * 
	 * ADD TRAILING SLASH!
	 ***********************************************************/
	
	$config['enable_disk_cache'] = FALSE;
	$config['cache_directory'] = $config['base_directory'].'cache/';
	
	
	/************************************************************
	 * TCPDF image directory
	 * ----------------------------------------------------------
	 * This is the image directory for TCPDF. This is where you
	 * can store images to use in your PDF files.
	 * 
	 * ADD TRAILING SLASH!
	 ***********************************************************/
	
	$config['image_directory'] = 'http://localhost/sigep/assets/images/';
	
	
	/************************************************************
	 * TCPDF default (blank) image
	 * ----------------------------------------------------------
	 * This is the path and filename to the default (blank)
	 * image.
	 ***********************************************************/
	
	$config['blank_image'] = $config['image_directory'].'_blank.png';
	
	
	/************************************************************
	 * TCPDF language settings file
	 * ----------------------------------------------------------
	 * Directory and filename of the language settings file
	 ***********************************************************/
	
	$config['language_file'] = $config['base_directory'].'config/lang/eng.php';


    /***************************************************************************
 * DOCUMENT CONFIGURATION PARAMETERS
 **************************************************************************/
	
	
	/************************************************************
	 * TCPDF default page format
	 * ----------------------------------------------------------
	 * This is the default page size. Supported formats include:
	 * 
	 * 4A0, 2A0, A0, A1, A2, A3, A4, A5, A6, A7, A8, A9, A10, B0,
	 * B1, B2, B3, B4, B5, B6, B7, B8, B9, B10, C0, C1, C2, C3, 
	 * C4, C5, C6, C7, C8, C9, C10, RA0, RA1, RA2, RA3, RA4, 
	 * SRA0, SRA1, SRA2, SRA3, SRA4, LETTER, LEGAL, EXECUTIVE, 
	 * FOLIO
	 * 
	 * Or, you can optionally specify a custom format in the form
	 * of a two-element array containing the width and the height.
	 ************************************************************/
	
	$config['page_format'] = config_item('formato');
	
	
	/************************************************************
	 * TCPDF default page orientation
	 * ----------------------------------------------------------
	 * Default page layout.
	 * P = portrait, L = landscape
	 ***********************************************************/
	
	$config['page_orientation'] = config_item('orientacion');
	
	
	/************************************************************
	 * TCPDF default unit of measure
	 * ----------------------------------------------------------
	 * Unit of measure.
	 * mm = millimeters, cm = centimeters,
	 * pt = points, in = inches
	 * 
	 * 1 point = 1/72 in = ~0.35 mm
	 * 1 inch = 2.54 cm
	 ***********************************************************/

	$config['page_unit'] = 'mm';

	
	/************************************************************
	 * TCPDF auto page break
	 * ----------------------------------------------------------
	 * Enables automatic flowing of content to the next page if
	 * you run out of room on the current page. 
	 ***********************************************************/
	
	$config['page_break_auto'] = TRUE;
	
	
	/************************************************************
	 * TCPDF text encoding
	 * ----------------------------------------------------------
	 * Specify TRUE if the input text you will be using is
	 * unicode, and specify the default encoding.
	 ***********************************************************/
	
	$config['unicode'] = TRUE;
	$config['encoding'] = 'UTF-8';
	

	/************************************************************
	 * TCPDF default document creator and author strings
	 ***********************************************************/
	
	$config['creator'] = 'HITS - Soluciones Informaticas';
	$config['author'] = 'HITS - Soluciones Informaticas';
	
	
	/************************************************************
	 * TCPDF default page margin
	 * ----------------------------------------------------------
	 * Top, bottom, left, right, header, and footer margin
	 * settings in the default unit of measure.
	 ***********************************************************/
	
	if(config_item('header_on') == FALSE) {
		$config['margin_top']    = 10;	
	}
	else {
		$config['margin_top']    = 30;	
	}
	
	$config['margin_bottom'] = 25;
	$config['margin_left']   = 10;
	$config['margin_right']  = 10;
	
	
	/************************************************************
	 * TCPDF default font settings
	 * ----------------------------------------------------------
	 * Page font, font size, header and footer fonts,
	 * HTML <small> font size ratio
	 ***********************************************************/
	
	$config['page_font'] = 'arialunicid0';
	$config['page_font_size'] = 10;
	
	$config['small_font_ratio'] = 2/3;
	
	
	/************************************************************
	 * TCPDF header settings
	 * ----------------------------------------------------------
	 * Enable the header, set the font, default text, margin,
	 * description string, and logo
	 ***********************************************************/
	
	$config['header_on'] = TRUE;
	$config['header_font'] = $config['page_font'];
	$config['header_font_size'] = 10;
	$config['header_margin'] = 5;
	$config['header_title'] = 'Sistema a medida';
	$config['header_string'] = "by Andjelko Stopinsek";
	$config['header_logo'] = $config['image_directory'].'/header-portrait.jpg';
	$config['header_logo_width'] = 30;
	
	
	/************************************************************
	 * TCPDF footer settings
	 * ----------------------------------------------------------
	 * Enable the header, set the font, default text, and margin
	 ***********************************************************/
	
	$config['footer_on'] = TRUE;
	$config['footer_font'] = $config['page_font'];
	$config['footer_font_size'] = 8;
	$config['footer_margin'] = 10;
	
	
	/************************************************************
	 * TCPDF image scale ratio
	 * ----------------------------------------------------------
	 * Image scale ratio (decimal format).
	 ***********************************************************/
	
	$config['image_scale'] = 4;
	
	
	/************************************************************
	 * TCPDF cell settings
	 * ----------------------------------------------------------
	 * Fontsize-to-height ratio, cell padding
	 ***********************************************************/
	
	
	$config['cell_height_ratio'] = 1.25;
	$config['cell_padding'] = 0;