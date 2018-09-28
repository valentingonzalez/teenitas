<?php

/**
* Skin: Lookbook
*/

// Exit if accessed directly

if (!defined('ABSPATH')) { 
	exit;
}


$tg_el = The_Grid_Elements();

$format    = $tg_el->get_item_format();
$permalink = $tg_el->get_the_permalink();
$target    = $tg_el->get_the_permalink_target();
$projLink  = $tg_el->grid_item['meta_data']['projLink'];


$output = $tg_el->get_media_wrapper_start();

    $output .= $tg_el->get_media();
    

	$output .= $tg_el->get_overlay();

	$output .= '<div class="tg-item-content">';

		$output .= $tg_el->get_center_wrapper_start();	

			$output .= ($projLink) ? '<a class="tg-item-link" href="'. $projLink .'" target="'.$target.'"></a>' : null;

			$output .= '<h2 class="tg-item-title"><a href="'. $projLink .'" target="_self">'.$tg_el->grid_item['title'].'</a></h2>';

			$output .= $tg_el->get_media_button();

            $output .= '<a class="tg-link-button" href="'. $projLink .'" target="'. $target .'"><i class="tg-icon-link"></i></a>';

		$output .= $tg_el->get_center_wrapper_end();

	$output .= '</div>';	

$output .= $tg_el->get_media_wrapper_end();

		

return $output;