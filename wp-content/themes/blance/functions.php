<?php

    
	/* Define THEME */
	if (!defined('URI_PATH')) define('URI_PATH', get_template_directory_uri());
	if (!defined('ABS_PATH')) define('ABS_PATH', get_template_directory());
	if (!defined('URI_PATH_FR')) define('URI_PATH_FR', URI_PATH.'/framework');
	if (!defined('ABS_PATH_FR')) define('ABS_PATH_FR', ABS_PATH.'/framework');
	if (!defined('URI_PATH_ADMIN')) define('URI_PATH_ADMIN', URI_PATH_FR.'/admin');
	if (!defined('ABS_PATH_ADMIN')) define('ABS_PATH_ADMIN', ABS_PATH_FR.'/admin');
	/* Frameword functions */

	/* Theme Options */
    if (!function_exists('jws_theme_filtercontent')) {
	function jws_theme_filtercontent($variable){
		return $variable;
	}
    }
    require_once ABS_PATH_FR . '/function_theme.php';
    require_once ABS_PATH . '/framework_option/cs-framework.php';
    require_once (ABS_PATH_ADMIN.'/index.php');
    /* Function for Framework */
	require_once ABS_PATH_FR . '/includes.php';
/* Function for OCDI */
	function _blance_filter_fw_ext_backups_demos($demos)
	{
		$demos_array = array(
			'blance' => array(
				'title' => esc_html__('Blance Demo', 'blance'),
				'screenshot' => 'http://gavencreative.com/import_demo/blance/screenshot.jpg',
				'preview_link' => 'http://blance.jwsuperthemes.com',
			),
		);
        $download_url = 'http://gavencreative.com/import_demo/blance/download-script/';
		foreach ($demos_array as $id => $data) {
			$demo = new FW_Ext_Backups_Demo($id, 'piecemeal', array(
				'url' => $download_url,
				'file_id' => $id,
			));
			$demo->set_title($data['title']);
			$demo->set_screenshot($data['screenshot']);
			$demo->set_preview_link($data['preview_link']);

			$demos[$demo->get_id()] = $demo;

			unset($demo);
		}

		return $demos;
	}
	add_filter('fw:ext:backups-demo:demos', '_blance_filter_fw_ext_backups_demos');
	/* Register Sidebar */
	if (!function_exists('jwstheme_RegisterSidebar')) {
		function jwstheme_RegisterSidebar(){
			global $jwstheme_options;
			register_sidebar(array(
			'name' => __('Footer Form Email', 'blance'),
			'id' => 'jws-email-sidebar',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h4 class="widget-title">',
			'after_title' => '</h4>',
			));
            register_sidebar(array(
			'name' => __('Footer Location', 'blance'),
			'id' => 'jws-location-sidebar',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h4 class="widget-title">',
			'after_title' => '</h4>',
			));
            register_sidebar(array(
			'name' => __('Footer Infomation', 'blance'),
			'id' => 'jws-infomation-sidebar',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h4 class="widget-title">',
			'after_title' => '</h4>',
			));
            register_sidebar(array(
			'name' => __('Footer Instagram', 'blance'),
			'id' => 'jws-instagram-sidebar',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h4 class="widget-title">',
			'after_title' => '</h4>',
			));
            register_sidebar(array(
			'name' => __('Footer Help', 'blance'),
			'id' => 'jws-help-sidebar',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h4 class="widget-title">',
			'after_title' => '</h4>',
			));
            register_sidebar(array(
			'name' => __('Sidebar Top Menu', 'blance'),
			'id' => 'jws-menu-sidebar',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h4 class="widget-title">',
			'after_title' => '</h4>',
			));
            register_sidebar(array(
			'name' => __('Sidebar Bottom Menu', 'blance'),
			'id' => 'jws-menu-bottom-sidebar',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h4 class="widget-title">',
			'after_title' => '</h4>',
			));
            register_sidebar(array(
			'name' => __('Sidebar Filter Shop Top', 'blance'),
			'id' => 'jws-filter-shhop-color',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h4 class="widget-title">',
			'after_title' => '</h4>',
			));
            register_sidebar(array(
			'name' => __('Sidebar Filter Shop Left And Right', 'blance'),
			'id' => 'jws-filter-shhop-left-right',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h4 class="widget-title">',
			'after_title' => '</h4>',
			));
            register_sidebar(array(
			'name' => __('Sidebar Blog', 'blance'),
			'id' => 'jws-sidebar-blog',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h4 class="widget-title">',
			'after_title' => '</h4>',
			));
            register_sidebar(array(
			'name' => __('Sidebar Remove Filter', 'blance'),
			'id' => 'jws-sidebar-remove',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h4 class="widget-title">',
			'after_title' => '</h4>',
			));
            register_sidebar(array(
			'name' => __('Sidebar Shop Detail', 'blance'),
			'id' => 'jws-sidebar-shop-detail',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h4 class="widget-title">',
			'after_title' => '</h4>',
			));
		}
	}
	add_action( 'widgets_init', 'jwstheme_RegisterSidebar' );
    /**
     * Get all registered sidebars.
     *
     * @return  array
     */
        function jws_get_sidebars() {
        	global $wp_registered_sidebars;
        
        	// Get custom sidebars.
        	$custom_sidebars = get_option( 'blance_custom_sidebars' );
        
        	// Prepare output.
        	$output = array();
        
        	$output[] = esc_html__( 'Select a sidebar', 'blance' );
        
        	if ( ! empty( $wp_registered_sidebars ) ) {
        		foreach ( $wp_registered_sidebars as $sidebar ) {
        			$output[ $sidebar['id'] ] = $sidebar['name'];
        		}
        	}
        
        	if ( ! empty( $custom_sidebars ) ) {
        		foreach ( $custom_sidebars as $sidebar ) {
        			$output[ $sidebar['id'] ] = $sidebar['name'];
        		}
        	}
        
        
        	return $output;
       }
	/* Enqueue Script */
	function jwstheme_enqueue_scripts() {
		/* Start Css jws */   
       
        wp_enqueue_style( 'jws_normalize_css', URI_PATH.'/assets/css/theme.css', false );
         wp_enqueue_style( 'jwss_preset', URI_PATH.'/assets/css/presets/default.css', false );
        /* End Css jws */
		wp_enqueue_style( 'jws-blance-style', get_stylesheet_uri() );
		wp_add_inline_style( 'jws-blance-style', jws_theme_custom_css() );
        $script_name = 'wc-add-to-cart-variation';
    	if ( wp_script_is( $script_name, 'registered' ) && ! wp_script_is( $script_name, 'enqueued' ) ) {
    		wp_enqueue_script( $script_name );
    	}
        // Google font
    	wp_enqueue_style( 'jws-font-google', jws_blance_google_font_url() );
        wp_enqueue_script( 'image-lazy', 'https://cdnjs.cloudflare.com/ajax/libs/jquery.lazyload/1.9.1/jquery.lazyload.min.js', array('jquery'), '', true  );
        wp_enqueue_script( 'photo_ui', URI_PATH.'/assets/js/js_jws/plugin.js', array('jquery'), '', true  );
        wp_enqueue_script( 'ajax-theme-js2', URI_PATH.'/assets/js/js_jws/start-ajax.js', array('jquery'), '', true  );
        wp_enqueue_script( 'ajax-theme-js', URI_PATH.'/assets/js/js_jws/script.js', array('jquery'), '', true  );
        //wp_enqueue_script('jquery');
        wp_localize_script( 'jquery', 'MS_Ajax', array(
            'ajaxurl'       => admin_url( 'admin-ajax.php' ),
            'nextNonce'     => wp_create_nonce( 'myajax-next-nonce' ))
        );
        if( is_singular() && comments_open() && ( get_option( 'thread_comments' ) == 1) ) {
        wp_enqueue_script( 'comment-reply', 'wp-includes/js/comment-reply', array(), false, true );
        }
	}
	add_action( 'wp_enqueue_scripts', 'jwstheme_enqueue_scripts' );
    add_filter('style_loader_tag', 'myplugin_remove_type_attr', 10, 2);
    add_filter('script_loader_tag', 'myplugin_remove_type_attr', 10, 2);
    
    function myplugin_remove_type_attr($tag, $handle) {
        return preg_replace( "/type=['\"]text\/(javascript|css)['\"]/", '', $tag );
    }
	/* Init Functions */
	function jwstheme_init() {
			require_once ABS_PATH_FR.'/presets.php';
	}
    $less = cs_get_option('golobal-enable-less');
     if($less == "1") {
       add_action( 'init', 'jwstheme_init' ); 
     }
	/* Widgets */
	require_once ABS_PATH_FR.'/widgets/abstract-widget.php';
	require_once ABS_PATH_FR.'/widgets/widgets.php';
    /* Add Field To Admin User */
    function modify_contact_methods($profile_fields) {
    	// Add new fields
    	$profile_fields['twitter'] = 'Twitter URL';
    	$profile_fields['facebook'] = 'Facebook URL';
    	$profile_fields['gplus'] = 'Google+ URL';
        $profile_fields['mail'] = 'Mail URL';
    	return $profile_fields;
    }
    add_filter('user_contactmethods', 'modify_contact_methods'); 
        /* Search Resault */
    // Display 7 products per page. Goes in functions.php
    add_filter( 'loop_shop_per_page', create_function( '$cols', 'return 8;' ), 20 );
    add_action( 'init', 'gp_register_taxonomy_for_object_type' );
    function gp_register_taxonomy_for_object_type() {
        register_taxonomy_for_object_type( 'post_tag', 'portfolio' );
    };
    /* Woo commerce function */
    if (class_exists('Woocommerce')) {
    require_once ABS_PATH . '/woocommerce/wc-template-function.php';
    require_once ABS_PATH . '/woocommerce/wc-template-hooks.php';
    }
    // **********************************************************************// 
    // ! Get portfolio taxonomies dropdown
    // **********************************************************************// 
    
    if( ! function_exists( 'blance_get_projects_cats_array') ) {
    	function blance_get_projects_cats_array() {
    		$return = array('All' => '');
    
    		if( ! post_type_exists( 'portfolio' ) ) return array();
    
    		$cats = get_terms( 'project-cat' );
    
    		foreach ($cats as $key => $cat) {
    			$return[$cat->name] = $cat->term_id;
    		}
    
    		return $return;
    	}
    }
    add_filter( 'wp_calculate_image_srcset', '__return_false' );