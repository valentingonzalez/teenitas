<?php
/**
 * @package   The_Grid
 * @author    Themeone <themeone.master@gmail.com>
 * @copyright 2015 Themeone
 *
 * Skin: Maren
 *
 */

// Exit if accessed directly
if (!defined('ABSPATH')) { 
	exit;
}

$tg_el = The_Grid_Elements();

$format = $tg_el->get_item_format();
$colors = $tg_el->get_colors();
$image  = $tg_el->get_attachment_url();

$com_args = array(
	'icon' => '<i class="tg-icon-chat"></i>'
);

$author_args = array(
	'prefix' => __( 'By', 'tg-text-domain' ).' ',
);

$readmore_args = array(
	'text' => __( 'Read More', 'tg-text-domain' ).'<i class="tg-icon-arrow-next-thin"></i>',
);

$terms_args = array(
	'color' => 'color',
	'separator' => ', '
);

$author = preg_replace('/(<a\b[^><]*)>/i', '$1 style="color:'.$colors['content']['span'].'">', $tg_el->get_the_author($author_args));

if ($format == 'quote' || $format == 'link') {
		
	$output  = ($image) ? '<div class="tg-item-image" style="background-image: url('.esc_url($image).')"></div>' : null;
	$output .= $tg_el->get_content_wrapper_start();
		$output .= '<i class="tg-'.$format.'-icon tg-icon-'.$format.'" style="color:'.$colors['content']['title'].'"></i>';
		$output .= $tg_el->get_the_date();
		$output .= ($format == 'quote') ? $tg_el->get_the_quote_format() : $tg_el->get_the_link_format();
		$output .= '<div class="tg-item-footer">';
			$output .= $author;
			$output .= $tg_el->get_the_comments_number($com_args);
		$output .= '</div>';
	$output .= $tg_el->get_content_wrapper_end();
	
	return $output;
		
} else {
	
	$output = null;
	$media_content = $tg_el->get_media();

	if ($media_content) {
		$output .= $tg_el->get_media_wrapper_start();
			$output .= $media_content;
			if ($image || in_array($format, array('gallery', 'video'))) {
				$output .= $tg_el->get_overlay();
				$output .= $tg_el->get_center_wrapper_start();
					$output .= $tg_el->get_media_button();
					$output .= $tg_el->get_link_button();
				$output .= $tg_el->get_center_wrapper_end();
			}
		$output .= $tg_el->get_media_wrapper_end();
	}
	
	$output .= $tg_el->get_content_wrapper_start();
		$output .= $tg_el->get_the_date();
		$output .= $tg_el->get_the_terms($terms_args);
		$output .= $tg_el->get_the_title();
		$output .= $tg_el->get_the_excerpt();
		$output .= $tg_el->get_read_more_button($readmore_args);
		$output .= '<div class="tg-item-footer">';
			$output .= $author;
			$output .= $tg_el->get_the_comments_number($com_args);
		$output .= '</div>';
	$output .= $tg_el->get_content_wrapper_end();
	
	return $output;

}