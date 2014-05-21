<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * menu_ul()
 * Genera una lista desordenada con la clase current en el elemento seleccionado.
 */
if ( ! function_exists('menu_ul')) {
    function menu_ul($sel = 'home') {
        $CI =& get_instance();
        $items = $CI->config->item('navigation');
        $important = 'mayoristas';
       // $menu = '<ul>'."\n";
        $menu = '';
        foreach($items as $item) {
            $current = (in_array($sel, $item)) ? ' class="active"' : '';
            $importante = (in_array($important, $item)) ? ' <span id="badge-important" class="badge badge-important">Nuevo</span>' : '';
            $id = (!empty($item['id'])) ? ' id="'.$item['id'].'"' : '';
            $menu .= '<li '.$current.'><a href="'.site_url($item['link']).'">'.$item['title'].$importante;
            $menu .= '</a></li>'."\n";
        }
        //$menu .= '</ul>'."\n";
        return $menu;
    }
}

// ------------------------------------------------------------------------

/**
 * menu_p
 * Genera un parrafo con la clase current en el elemento seleccionado
 */
if ( ! function_exists('menu_p'))
{
    function menu_p($sel = 'home', $separator = '')
   {
        $CI =& get_instance();
        $items = $CI->config->item('navigation');

        $count = count($items);
        $i = 0;
        $menu = "\n".'<p class="bottom_nav">';
        foreach($items as $item)
        {
            $current = (in_array($sel, $item)) ? ' class="current"' : '';
            $id = (!empty($item['id'])) ? ' id="'.$item['id'].'"' : '';
            $menu .= '<a'.$current.' href="'.$item['link'].'"'.$id.'>'.$item['title'].'</a>';
            $i++;
            if($count != $i)
            {
                $menu .= ' '.$separator.' ';
            }
        }
        $menu .= '</p>'."\n";
        return $menu;
    }
}


/* End of file navigation_helper.php */
/* Location: ./system/helpers/navigation_helper.php */