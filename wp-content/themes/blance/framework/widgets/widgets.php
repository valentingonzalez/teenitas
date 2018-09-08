<?php
require_once 'socials.php';
require_once 'services_list.php';
require_once 'recent-posts-widget-with-thumbnails.php';
require_once 'catgory.php';
require_once 'search-jws.php';
require_once 'search-sidebar.php';
require_once 'instagram.php';
require_once 'testimonial-slider.php';
require_once 'post_list.php';
require_once 'product-sort-by.php';
if (class_exists('Woocommerce')) {
	require_once 'minicart-widget.php';
    require_once 'widget_price_woo.php';
    require_once 'contact-header-top.php';
    require_once 'widget_filter_atribute.php';
    require_once 'widget_filter_pric_ajax.php';
     require_once 'product-cat.php';
    
}
/**
 * Register widgets
 *
 * @since  1.0
 *
 * @return void
 */


function blance_register_widgets() {
	if ( class_exists( 'WC_Widget' ) ) {
    	register_widget( 'blance_Widget_Attributes_Filter' );
	   register_widget( 'blance_Price_Filter_List_Widget' );
       register_widget( 'WC_Widget_Product_Categories2' );
	}
    register_widget( 'blance_Product_SortBy_Widget' );
}

add_action( 'widgets_init', 'blance_register_widgets' );