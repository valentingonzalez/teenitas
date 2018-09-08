<?php if ( ! defined('URI_PATH')) exit('No direct script access allowed');

if( ! function_exists( 'blance_vc_extra_classes' ) ) {

	if( defined( 'VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG' ) ) {
		add_filter( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'blance_vc_extra_classes', 30, 3 );
	}

	function blance_vc_extra_classes( $class, $base, $atts ) {
		if( ! empty( $atts['blance_color_scheme'] ) ) {
			$class .= ' color-scheme-' . $atts['blance_color_scheme'];
		}

		if( ! empty( $atts['blance_parallax'] ) ) {
			$class .= ' container-in-full';
		}
        if( ! empty( $atts['jws_parallax'] ) ) {
			$class .= ' background-parallax';
		}
        if( ! empty( $atts['jws_100'] ) ) {
			$class .= ' container100 ';
		}

		return $class;
	}

}

if( ! function_exists( 'blance_vc_map_shortcodes' ) ) {

	add_action( 'vc_before_init', 'blance_vc_map_shortcodes' );

	function blance_vc_map_shortcodes() {

		/**
		 * ------------------------------------------------------------------------------------------------
		 * Parallax option
		 * ------------------------------------------------------------------------------------------------
		 */

		$attributes = array(
			'type' => 'checkbox',
			'heading' => __( 'Container In Full width', 'blance' ),
			'param_name' => 'blance_parallax',
			'value' => array( __( 'Yes, please', 'blance' ) => 1 )
		);
        $parallaxs = array(
			'type' => 'checkbox',
			'heading' => __( 'Parallax background', 'blance' ),
			'param_name' => 'jws_parallax',
			'value' => array( __( 'Yes, please', 'blance' ) => 1 )
		);
        $container100 = array(
			'type' => 'checkbox',
			'heading' => __( 'Container Width 100%', 'blance' ),
			'param_name' => 'jws_100',
			'value' => array( __( 'Yes, please', 'blance' ) => 1 )
		);
        vc_add_param( 'vc_row', $container100 );
        vc_add_param( 'vc_section', $container100 );
        vc_add_param( 'vc_row', $parallaxs );
        vc_add_param( 'vc_section', $parallaxs );
		vc_add_param( 'vc_row', $attributes );
		vc_add_param( 'vc_section', $attributes );
		vc_add_param( 'vc_column', $attributes );


		$target_arr = array(
			__( 'Same window', 'blance' ) => '_self',
			__( 'New window', 'blance' ) => "_blank"
		);

		$post_types_list = array();
		$post_types_list[] = array( 'post', __( 'Post', 'blance' ) );
		//$post_types_list[] = array( 'custom', __( 'Custom query', 'blance' ) );
		$post_types_list[] = array( 'ids', __( 'List of IDs', 'blance' ) );

		/**
		 * ------------------------------------------------------------------------------------------------
		 * Map blog shortcode
		 * ------------------------------------------------------------------------------------------------
		 */
		vc_map( array(
			'name' => 'Blog',
			'base' => 'blance_blog',
			'category' => __( 'Shortcode elements', 'blance' ),
			'description' => __( 'Show your blog posts on the page', 'blance' ),
			'params' => array(
				array(
					'type' => 'dropdown',
					'heading' => __( 'Data source', 'blance' ),
					'param_name' => 'post_type',
					'value' => $post_types_list,
					'description' => __( 'Select content type for your grid.', 'blance' )
				),
				array(
					'type' => 'autocomplete',
					'heading' => __( 'Include only', 'blance' ),
					'param_name' => 'include',
					'description' => __( 'Add posts, pages, etc. by title.', 'blance' ),
					'settings' => array(
						'multiple' => true,
						'sortable' => true,
						'groups' => true,
					),
					'dependency' => array(
						'element' => 'post_type',
						'value' => array( 'ids' ),
						//'callback' => 'vc_grid_include_dependency_callback',
					),
				),
				// Custom query tab
				array(
					'type' => 'textarea_safe',
					'heading' => __( 'Custom query', 'blance' ),
					'param_name' => 'custom_query',
					'description' => __( 'Build custom query according to <a href="http://codex.wordpress.org/Function_Reference/query_posts">WordPress Codex</a>.', 'blance' ),
					'dependency' => array(
						'element' => 'post_type',
						'value' => array( 'custom' ),
					),
				),
				array(
					'type' => 'autocomplete',
					'heading' => __( 'Narrow data source', 'blance' ),
					'param_name' => 'taxonomies',
					'settings' => array(
						'multiple' => true,
						// is multiple values allowed? default false
						// 'sortable' => true, // is values are sortable? default false
						'min_length' => 1,
						// min length to start search -> default 2
						// 'no_hide' => true, // In UI after select doesn't hide an select list, default false
						'groups' => true,
						// In UI show results grouped by groups, default false
						'unique_values' => true,
						// In UI show results except selected. NB! You should manually check values in backend, default false
						'display_inline' => true,
						// In UI show results inline view, default false (each value in own line)
						'delay' => 500,
						// delay for search. default 500
						'auto_focus' => true,
						// auto focus input, default true
						// 'values' => $taxonomies_for_filter,
					),
					'param_holder_class' => 'vc_not-for-custom',
					'description' => __( 'Enter categories, tags or custom taxonomies.', 'blance' ),
					'dependency' => array(
						'element' => 'post_type',
						'value_not_equal_to' => array( 'ids', 'custom' ),
					),
				),
                
                array(
					'type' => 'textfield',
					'heading' => __( 'Text Read More', 'blance' ),
					'param_name' => 'readmore_text',
					'description' => __( 'Add Text For Read More blog', 'blance' ),
					'value' => 'Read More',
				),
				array(
					'type' => 'textfield',
					'heading' => __( 'Items per page', 'blance' ),
					'param_name' => 'items_per_page',
					'description' => __( 'Number of items to show per page.', 'blance' ),
					'value' => '10',
				),
				array(
					'type' => 'dropdown',
					'heading' => __( 'Pagination', 'blance' ),
					'param_name' => 'pagination',
					'value' => array(
	                    '' => '', 
	                    'Pagination' => 'pagination', 
	                    '"Load more" button' => 'more-btn', 
					),
				),
				// Design settings
				array(
					'type' => 'dropdown',
					'heading' => __( 'Style', 'blance' ),
					'param_name' => 'blog_design',
					'value' => array(
	                    'Default' => 'default', 
	                    'Border Bottom' => 'border-bottom', 
                        'Blog On Menu' => 'blog-menu', 
					),
					'description' => __( 'You can use different design for your blog styled for the theme', 'blance' ),
					'group' => __( 'Design', 'blance' ),
				),
                	// Design settings
			
				array(
					'type' => 'textfield',
					'heading' => __( 'Images size', 'blance' ),
					'group' => __( 'Design', 'blance' ),
					'param_name' => 'img_size',
					'description' => __( 'Enter image size. Example: "thumbnail", "medium", "large", "full" or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height). Leave empty to use "thumbnail" size.', 'blance' )
				),
				array(
					'type' => 'dropdown',
					'heading' => __( 'Columns', 'blance' ),
					'param_name' => 'blog_columns',
					 "value" => array(
        					"6 column" => "6",
                            "4 column" => "4",
                            "3 column" => "3",
                            "2 column" => "2",
        					
                        ),
					'description' => __( 'Blog items columns', 'blance' ),
					'group' => __( 'Design', 'blance' ),
				),
				// Data settings
				array(
					'type' => 'dropdown',
					'heading' => __( 'Order by', 'blance' ),
					'param_name' => 'orderby',
					'value' => array(
						__( 'Date', 'blance' ) => 'date',
						__( 'Order by post ID', 'blance' ) => 'ID',
						__( 'Author', 'blance' ) => 'author',
						__( 'Title', 'blance' ) => 'title',
						__( 'Last modified date', 'blance' ) => 'modified',
						__( 'Post/page parent ID', 'blance' ) => 'parent',
						__( 'Number of comments', 'blance' ) => 'comment_count',
						__( 'Menu order/Page Order', 'blance' ) => 'menu_order',
						__( 'Meta value', 'blance' ) => 'meta_value',
						__( 'Meta value number', 'blance' ) => 'meta_value_num',
						// __('Matches same order you passed in via the 'include' parameter.', 'blance') => 'post__in'
						__( 'Random order', 'blance' ) => 'rand',
					),
					'description' => __( 'Select order type. If "Meta value" or "Meta value Number" is chosen then meta key is required.', 'blance' ),
					'group' => __( 'Data Settings', 'blance' ),
					'param_holder_class' => 'vc_grid-data-type-not-ids',
					'dependency' => array(
						'element' => 'post_type',
						'value_not_equal_to' => array( 'ids', 'custom' ),
					),
				),
				array(
					'type' => 'dropdown',
					'heading' => __( 'Sorting', 'blance' ),
					'param_name' => 'order',
					'group' => __( 'Data Settings', 'blance' ),
					'value' => array(
						__( 'Descending', 'blance' ) => 'DESC',
						__( 'Ascending', 'blance' ) => 'ASC',
					),
					'param_holder_class' => 'vc_grid-data-type-not-ids',
					'description' => __( 'Select sorting order.', 'blance' ),
					'dependency' => array(
						'element' => 'post_type',
						'value_not_equal_to' => array( 'ids', 'custom' ),
					),
				),
				array(
					'type' => 'textfield',
					'heading' => __( 'Meta key', 'blance' ),
					'param_name' => 'meta_key',
					'description' => __( 'Input meta key for grid ordering.', 'blance' ),
					'group' => __( 'Data Settings', 'blance' ),
					'param_holder_class' => 'vc_grid-data-type-not-ids',
					'dependency' => array(
						'element' => 'orderby',
						'value' => array( 'meta_value', 'meta_value_num' ),
					),
				),
				array(
					'type' => 'textfield',
					'heading' => __( 'Offset', 'blance' ),
					'param_name' => 'offset',
					'description' => __( 'Number of grid elements to displace or pass over.', 'blance' ),
					'group' => __( 'Data Settings', 'blance' ),
					'param_holder_class' => 'vc_grid-data-type-not-ids',
					'dependency' => array(
						'element' => 'post_type',
						'value_not_equal_to' => array( 'ids', 'custom' ),
					),
				),
				array(
					'type' => 'autocomplete',
					'heading' => __( 'Exclude', 'blance' ),
					'param_name' => 'exclude',
					'description' => __( 'Exclude posts, pages, etc. by title.', 'blance' ),
					'group' => __( 'Data Settings', 'blance' ),
					'settings' => array(
						'multiple' => true,
					),
					'param_holder_class' => 'vc_grid-data-type-not-ids',
					'dependency' => array(
						'element' => 'post_type',
						'value_not_equal_to' => array( 'ids', 'custom' ),
						'callback' => 'vc_grid_exclude_dependency_callback',
					),
				)

	      )
	
	    ) );

		// Necessary hooks for blog autocomplete fields
		add_filter( 'vc_autocomplete_blance_blog_include_callback',	'vc_include_field_search', 10, 1 ); // Get suggestion(find). Must return an array
		add_filter( 'vc_autocomplete_blance_blog_include_render',
			'vc_include_field_render', 10, 1 ); // Render exact product. Must return an array (label,value)

		// Narrow data taxonomies
		add_filter( 'vc_autocomplete_blance_blog_taxonomies_callback', 'vc_autocomplete_taxonomies_field_search', 10, 1 );
		add_filter( 'vc_autocomplete_blance_blog_taxonomies_render', 'vc_autocomplete_taxonomies_field_render', 10, 1 );

		// Narrow data taxonomies for exclude_filter
		add_filter( 'vc_autocomplete_blance_blog_exclude_filter_callback', 'vc_autocomplete_taxonomies_field_search', 10, 1 );
		add_filter( 'vc_autocomplete_blance_blog_exclude_filter_render', 'vc_autocomplete_taxonomies_field_render', 10, 1 );

		add_filter( 'vc_autocomplete_blance_blog_exclude_callback',	'vc_exclude_field_search', 10, 1 ); // Get suggestion(find). Must return an array
		add_filter( 'vc_autocomplete_blance_blog_exclude_render', 'vc_exclude_field_render', 10, 1 ); // Render exact product. Must return an array (label,value)


        /**
		 * ------------------------------------------------------------------------------------------------
		 * Map button shortcode
		 * ------------------------------------------------------------------------------------------------
		 */

		vc_map( array(
			'name' => __( 'Youtube Button', 'blance' ),
			'base' => 'jws_button_video',
			'category' => __( 'Shortcode elements', 'blance' ),
			'description' => __( 'Simple button in different theme styles', 'blance' ),
			'params' => array(
               array(
					'type' => 'attach_image',
					'heading' => __( 'Background Video', 'blance' ),
					'param_name' => 'img',
					'value' => '',
					'description' => __( 'Select image from media library.', 'blance' )
				),
				array(
					'type' => 'href',
					'heading' => __( 'Url Video', 'blance' ),
					'param_name' => 'link'
				),
                	array(
					'type' => 'textfield',
					'heading' => __( 'Width Video', 'blance' ),
					'param_name' => 'width'
				),
                	array(
					'type' => 'textfield',
					'heading' => __( 'Height Video', 'blance' ),
					'param_name' => 'height'
				),
                array(
					'type' => 'attach_image',
					'heading' => __( 'Button Video Image', 'blance' ),
					'param_name' => 'icon_play',
					'value' => '',
					'description' => __( 'Select image from media library.', 'blance' )
				),
			),
		));
	   

		/**
		 * ------------------------------------------------------------------------------------------------
		 * Map Google Map shortcode
		 * ------------------------------------------------------------------------------------------------
		 */
        vc_map(array(
            "name" => 'Google Maps V3',
            "base" => "maps",
            "category" => __('Shortcode elements', 'blance'),
        	"icon" => "tb-icon-for-vc",
            "description" => __('Google Maps API V3', 'blance'),
            "params" => array(
                array(
                    "type" => "textfield",
                    "heading" => __('API Key', 'blance'),
                    "param_name" => "api",
                    "value" => '',
                    "description" => __('Enter you api key of map, get key from (https://console.developers.google.com)', 'blance')
                ),
                array(
                    "type" => "textfield",
                    "heading" => __('Address', 'blance'),
                    "param_name" => "address",
                    "value" => 'New York, United States',
                    "description" => __('Enter address of Map', 'blance')
                ),
                array(
                    "type" => "textfield",
                    "heading" => __('Coordinate', 'blance'),
                    "param_name" => "coordinate",
                    "value" => '',
                    "description" => __('Enter coordinate of Map, format input (latitude, longitude)', 'blance')
                ),
                array(
                    "type" => "checkbox",
                    "heading" => __('Click Show Info window', 'blance'),
                    "param_name" => "infoclick",
                    "value" => array(
                        __("Yes, please", 'blance') => true
                    ),
                    "group" => __("Marker", 'blance'),
                    "description" => __('Click a marker and show info window (Default Show).', 'blance')
                ),
                array(
                    "type" => "textfield",
                    "heading" => __('Marker Coordinate', 'blance'),
                    "param_name" => "markercoordinate",
                    "value" => '',
                    "group" => __("Marker", 'blance'),
                    "description" => __('Enter marker coordinate of Map, format input (latitude, longitude)', 'blance')
                ),
                array(
                    "type" => "textfield",
                    "heading" => __('Marker Title', 'blance'),
                    "param_name" => "markertitle",
                    "value" => '',
                    "group" => __("Marker", 'blance'),
                    "description" => __('Enter Title Info windows for marker', 'blance')
                ),
                array(
                    "type" => "textarea",
                    "heading" => __('Marker Description', 'blance'),
                    "param_name" => "markerdesc",
                    "value" => '',
                    "group" => __("Marker", 'blance'),
                    "description" => __('Enter Description Info windows for marker', 'blance')
                ),
                array(
                    "type" => "attach_image",
                    "heading" => __('Marker Icon', 'blance'),
                    "param_name" => "markericon",
                    "value" => '',
                    "group" => __("Marker", 'blance'),
                    "description" => __('Select image icon for marker', 'blance')
                ),
                array(
                    "type" => "textarea_raw_html",
                    "heading" => __('Marker List', 'blance'),
                    "param_name" => "markerlist",
                    "value" => '',
                    "group" => __("Multiple Marker", 'blance'),
                    "description" => __('[{"coordinate":"41.058846,-73.539423","icon":"","title":"title demo 1","desc":"desc demo 1"},{"coordinate":"40.975699,-73.717636","icon":"","title":"title demo 2","desc":"desc demo 2"},{"coordinate":"41.082606,-73.469718","icon":"","title":"title demo 3","desc":"desc demo 3"}]', 'blance')
                ),
                array(
                    "type" => "textfield",
                    "heading" => __('Info Window Max Width', 'blance'),
                    "param_name" => "infowidth",
                    "value" => '200',
                    "group" => __("Marker", 'blance'),
                    "description" => __('Set max width for info window', 'blance')
                ),
                array(
                    "type" => "dropdown",
                    "heading" => __("Map Type", 'blance'),
                    "param_name" => "type",
                    "value" => array(
                        "ROADMAP" => "ROADMAP",
                        "HYBRID" => "HYBRID",
                        "SATELLITE" => "SATELLITE",
                        "TERRAIN" => "TERRAIN"
                    ),
                    "description" => __('Select the map type.', 'blance')
                ),
                array(
                    "type" => "dropdown",
                    "heading" => __("Style Template", 'blance'),
                    "param_name" => "style",
                    "value" => array(
                        "Default" => "",
                        "Subtle Grayscale" => "Subtle-Grayscale",
                        "Shades of Grey" => "Shades-of-Grey",
                        "Blue water" => "Blue-water",
                        "Pale Dawn" => "Pale-Dawn",
                        "Blue Essence" => "Blue-Essence",
                        "Apple Maps-esque" => "Apple-Maps-esque",
                    ),
                    "group" => __("Map Style", 'blance'),
                    "description" => 'Select your heading size for title.'
                ),
                array(
                    "type" => "textfield",
                    "heading" => __('Zoom', 'blance'),
                    "param_name" => "zoom",
                    "value" => '13',
                    "description" => __('zoom level of map, default is 13', 'blance')
                ),
                array(
                    "type" => "textfield",
                    "heading" => __('Width', 'blance'),
                    "param_name" => "width",
                    "value" => 'auto',
                    "description" => __('Width of map without pixel, default is auto', 'blance')
                ),
                array(
                    "type" => "textfield",
                    "heading" => __('Height', 'blance'),
                    "param_name" => "height",
                    "value" => '350px',
                    "description" => __('Height of map without pixel, default is 350px', 'blance')
                ),
                array(
                    "type" => "checkbox",
                    "heading" => __('Scroll Wheel', 'blance'),
                    "param_name" => "scrollwheel",
                    "value" => array(
                        __("Yes, please", 'blance') => true
                    ),
                    "group" => __("Controls", 'blance'),
                    "description" => __('If false, disables scrollwheel zooming on the map. The scrollwheel is disable by default.', 'blance')
                ),
                array(
                    "type" => "checkbox",
                    "heading" => __('Pan Control', 'blance'),
                    "param_name" => "pancontrol",
                    "value" => array(
                        __("Yes, please", 'blance') => true
                    ),
                    "group" => __("Controls", 'blance'),
                    "description" => __('Show or hide Pan control.', 'blance')
                ),
                array(
                    "type" => "checkbox",
                    "heading" => __('Zoom Control', 'blance'),
                    "param_name" => "zoomcontrol",
                    "value" => array(
                        __("Yes, please", 'blance') => true
                    ),
                    "group" => __("Controls", 'blance'),
                    "description" => __('Show or hide Zoom Control.', 'blance')
                ),
                array(
                    "type" => "checkbox",
                    "heading" => __('Scale Control', 'blance'),
                    "param_name" => "scalecontrol",
                    "value" => array(
                        __("Yes, please", 'blance') => true
                    ),
                    "group" => __("Controls", 'blance'),
                    "description" => __('Show or hide Scale Control.', 'blance')
                ),
                array(
                    "type" => "checkbox",
                    "heading" => __('Map Type Control', 'blance'),
                    "param_name" => "maptypecontrol",
                    "value" => array(
                        __("Yes, please", 'blance') => true
                    ),
                    "group" => __("Controls", 'blance'),
                    "description" => __('Show or hide Map Type Control.', 'blance')
                ),
                array(
                    "type" => "checkbox",
                    "heading" => __('Street View Control', 'blance'),
                    "param_name" => "streetviewcontrol",
                    "value" => array(
                        __("Yes, please", 'blance') => true
                    ),
                    "group" => __("Controls", 'blance'),
                    "description" => __('Show or hide Street View Control.', 'blance')
                ),
                array(
                    "type" => "checkbox",
                    "heading" => __('Over View Map Control', 'blance'),
                    "param_name" => "overviewmapcontrol",
                    "value" => array(
                        __("Yes, please", 'blance') => true
                    ),
                    "group" => __("Controls", 'blance'),
                    "description" => __('Show or hide Over View Map Control.', 'blance')
                )
            )
        ));
        vc_map(array(
        	"name" => __("Login Form", 'blance'),
        	"base" => "login_form",
        	"category" => __('Shortcode elements', 'blance'),
        	"icon" => "tb-icon-for-vc",
        	"params" => array(
        		array(
        			"type" => "textfield",
        			"class" => "",
        			"heading" => __("Link Facebook", 'blance'),
        			"param_name" => "link_facebook",
        			"value" => "",
        			"description" => __ ( "Enter Link Nextend Facebook Connect.", 'blance' )
        		),
        		array(
        			"type" => "textfield",
        			"class" => "",
        			"heading" => __("Link Twitter", 'blance'),
        			"param_name" => "link_twitter",
        			"value" => "",
        			"description" => __ ( "Enter Link Nextend Twitter Connect.", 'blance' )
        		),
                array(
        			"type" => "textfield",
        			"class" => "",
        			"heading" => __("Link Twitter", 'blance'),
        			"param_name" => "link_twitter",
        			"value" => "",
        			"description" => __ ( "Enter Link Nextend Twitter Connect.", 'blance' )
        		),
        		array(
        			"type" => "textfield",
        			"class" => "",
        			"heading" => __("Extra Class", 'blance'),
        			"param_name" => "el_class",
        			"value" => "",
        			"description" => __ ( "If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'blance' )
        		),
        	)
        ));
        /**
		 * ------------------------------------------------------------------------------------------------
		 * Map button shortcode
		 * ------------------------------------------------------------------------------------------------
		 */

		vc_map( array(
			'name' => __( 'Button', 'blance' ),
			'base' => 'blance_button',
			'category' => __( 'Shortcode elements', 'blance' ),
			'description' => __( 'Simple button in different theme styles', 'blance' ),
			'params' => array(
                array(
					'type' => 'attach_image',
					'heading' => __( 'Icon Image', 'blance' ),
					'param_name' => 'img',
					'value' => '',
					'description' => __( 'Select image from media library.', 'blance' )
				),
				array(
					'type' => 'href',
					'heading' => __( 'Link', 'blance' ),
					'param_name' => 'link'
				),
				array(
					'type' => 'dropdown',
					'heading' => __( 'Button color', 'blance' ),
					'param_name' => 'color',
					'value' => array(
						__( 'Default', 'blance' ) => 'default',
						__( 'Primary color', 'blance' ) => 'primary',
						__( 'Alternative color', 'blance' ) => 'alt',
						__( 'Black', 'blance' ) => 'black',
						__( 'White', 'blance' ) => 'white',
					),
				),
				array(
					'type' => 'dropdown',
					'heading' => __( 'Button style', 'blance' ),
					'param_name' => 'style',
					'value' => array(
						__( 'Default', 'blance' ) => 'default',
						__( 'Bordered', 'blance' ) => 'bordered',
						__( 'Link button', 'blance' ) => 'link',
						__( 'Rounded', 'blance' ) => 'round',
					),
				),
				array(
					'type' => 'dropdown',
					'heading' => __( 'Button size', 'blance' ),
					'param_name' => 'size',
					'value' => array(
						__( 'Default', 'blance' ) => 'default',
						__( 'Extra Small', 'blance' ) => 'extra-small',
						__( 'Small', 'blance' ) => 'small',
						__( 'Large', 'blance' ) => 'large',
						__( 'Extra Large', 'blance' ) => 'extra-large',
					),
				),
				array(
					'type' => 'dropdown',
					'heading' => __( 'Align', 'blance' ),
					'param_name' => 'align',
					'value' => array(
						'' => '',
						__( 'left', 'blance' ) => 'left',
						__( 'center', 'blance' ) => 'center',
						__( 'right', 'blance' ) => 'right',
					)
				),
				array(
					'type' => 'textfield',
					'heading' => __( 'Extra class name', 'blance' ),
					'param_name' => 'el_class',
					'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'blance' )
				)
			),
		));
        /**
		 * ------------------------------------------------------------------------------------------------
		 * Map Team Member Shortcode
		 * ------------------------------------------------------------------------------------------------
		 */


		vc_map( array(
			'name' => __( 'Team Member', 'blance' ),
			'base' => 'team_member',
			'category' => __( 'Shortcode elements', 'blance' ),
			'description' => __( 'Display information about some person', 'blance' ),
			'params' => array(
				array(
					'type' => 'textfield',
					'heading' => __( 'Name', 'blance' ),
					'param_name' => 'name',
					'value' => '',
					'description' => __( 'User name', 'blance' )
				),
				array(
					'type' => 'textfield',
					'heading' => __( 'Title', 'blance' ),
					'param_name' => 'position',
					'value' => '',
					'description' => __( 'User title', 'blance' )
				),
				array(
					'type' => 'attach_image',
					'heading' => __( 'User Avatar', 'blance' ),
					'param_name' => 'img',
					'value' => '',
					'description' => __( 'Select image from media library.', 'blance' )
				),
				array(
					'type' => 'textfield',
					'heading' => __( 'Image size', 'blance' ),
					'param_name' => 'img_size',
					'description' => __( 'Enter image size. Example: "thumbnail", "medium", "large", "full" or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height). Leave empty to use "thumbnail" size.', 'blance' )
				),
				array(
					'type' => 'dropdown',
					'heading' => __( 'Align', 'blance' ),
					'param_name' => 'align',
					'value' => array(
						__( 'Left', 'blance' ) => 'left',
						__( 'Center', 'blance' ) => 'center',
						__( 'Right', 'blance' ) => 'right',
					),
				),	
				blance_get_color_scheme_param(),
				array(
					'type' => 'textarea_html',
					'heading' => __( 'Text', 'blance' ),
					'param_name' => 'content',
					'description' => __( 'You can add some member bio here.', 'blance' )
				),
				array(
					'type' => 'textfield',
					'heading' => __( 'Email', 'blance' ),
					'param_name' => 'email',
				),
				array(
					'type' => 'textfield',
					'heading' => __( 'Facebook link', 'blance' ),
					'param_name' => 'facebook',
				),
				array(
					'type' => 'textfield',
					'heading' => __( 'Twitter link', 'blance' ),
					'param_name' => 'twitter',
				),
				array(
					'type' => 'textfield',
					'heading' => __( 'Google+ link', 'blance' ),
					'param_name' => 'google_plus',
				),
				array(
					'type' => 'textfield',
					'heading' => __( 'Linkedin link', 'blance' ),
					'param_name' => 'linkedin',
				),
				array(
					'type' => 'textfield',
					'heading' => __( 'Skype link', 'blance' ),
					'param_name' => 'skype',
				),
				array(
					'type' => 'textfield',
					'heading' => __( 'Instagram link', 'blance' ),
					'param_name' => 'instagram',
				),
				array(
					'type' => 'dropdown',
					'heading' => __( 'Social buttons size', 'blance' ),
					'param_name' => 'size',
					'value' => array(
						__( 'Default', 'blance' ) => '',
						__( 'Small', 'blance' ) => 'small',
						__( 'Large', 'blance' ) => 'large',
					),
				),
				array(
					'type' => 'dropdown',
					'heading' => __( 'Layout', 'blance' ),
					'param_name' => 'layout',
					'value' => array(
						__( 'Default', 'blance' ) => 'default',
						__( 'With hover', 'blance' ) => 'hover',
					),
				),	
				array(
					'type' => 'dropdown',
					'heading' => __( 'Social buttons style', 'blance' ),
					'param_name' => 'style',
					'value' => array(
						__( 'Default', 'blance' ) => '',
						__( 'Circle buttons', 'blance' ) => 'circle',
						__( 'Colored', 'blance' ) => 'colored',
						__( 'Colored alternative', 'blance' ) => 'colored-alt',
					),
				),
				array(
					'type' => 'textfield',
					'heading' => __( 'Extra class name', 'blance' ),
					'param_name' => 'el_class',
					'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'blance' )
				)
			),
		));




		/**
		 * ------------------------------------------------------------------------------------------------
		 * Map testimonial shortcode
		 * ------------------------------------------------------------------------------------------------
		 */
		vc_map( array(
			'name' => __( 'Testimonials', 'blance' ),
			'base' => 'testimonials',
			"as_parent" => array('only' => 'testimonial'),
			"content_element" => true,
			"show_settings_on_create" => false,
			'category' => __( 'Shortcode elements', 'blance' ),
			'description' => __( 'User testimonials slider or grid', 'blance' ),

			'params' => array(
				array(
					'type' => 'textfield',
					'heading' => __( 'Title', 'blance' ),
					'param_name' => 'title',
					'value' => '',
				),			
				array(
					'type' => 'dropdown',
					'heading' => __( 'Layout', 'blance' ),
					'param_name' => 'layout',
					'value' => array(
						__( 'Slider', 'blance' ) => 'slider',
						__( 'Grid', 'blance' ) => 'grid',
					),
				),	
				array(
					'type' => 'dropdown',
					'heading' => __( 'Style', 'blance' ),
					'param_name' => 'style',
					'value' => array(
						__( 'Standard', 'blance' ) => 'standard',
						__( 'Boxed', 'blance' ) => 'boxed',
					),
				),	
				array(
					'type' => 'dropdown',
					'heading' => __( 'Align', 'blance' ),
					'param_name' => 'align',
					'value' => array(
						__( 'Center', 'blance' ) => 'center',
						__( 'Left', 'blance' ) => 'left',
						__( 'Right', 'blance' ) => 'right',
					),
				),	
				array(
					'type' => 'dropdown',
					'heading' => __( 'Columns', 'blance' ),
					'param_name' => 'columns',
					'value' => array(
						1,2,3,4,5,6,7,8
					),
					'dependency' => array(
						'element' => 'layout',
						'value' => array( 'grid' ),
					),
				),
				array(
					'type' => 'dropdown',
					'heading' => __( 'Slides per view', 'blance' ),
					'param_name' => 'slides_per_view',
					'value' => array(
						1,2,3,4,5,6,7,8
					),
					'group' => 'Slider',
					'dependency' => array(
						'element' => 'layout',
						'value' => array( 'slider' ),
					),
					'description' => __( 'Set numbers of slides you want to display at the same time on slider\'s container for carousel mode.', 'blance' )
				),
				array(
					'type' => 'checkbox',
					'heading' => __( 'Slider autoplay', 'blance' ),
					'param_name' => 'autoplay',
					'description' => __( 'Enables autoplay mode.', 'blance' ),
					'value' => array( __( 'Yes, please', 'blance' ) => 'yes' ),
					'group' => 'Slider',
					'dependency' => array(
						'element' => 'layout',
						'value' => array( 'slider' ),
					),
				),
				array(
					'type' => 'textfield',
					'heading' => __( 'Slider speed', 'blance' ),
					'param_name' => 'speed',
					'value' => '5000',
					'description' => __( 'Duration of animation between slides (in ms)', 'blance' ),
					'group' => 'Slider',
					'dependency' => array(
						'element' => 'layout',
						'value' => array( 'slider' ),
					),
				),
                	array(
					'type' => 'textfield',
					'heading' => __( 'Space Item', 'blance' ),
					'param_name' => 'space',
					'value' => '15',
					'description' => __( 'Enter Space bewen item', 'blance' ),
					'group' => 'Slider',
					'dependency' => array(
						'element' => 'layout',
						'value' => array( 'slider' ),
					),
				),
				array(
					'type' => 'checkbox',
					'heading' => __( 'Hide pagination control', 'blance' ),
					'param_name' => 'hide_pagination_control',
					'description' => __( 'If "YES" pagination control will be removed', 'blance' ),
					'value' => array( __( 'Yes, please', 'blance' ) => 'yes' ),
					'group' => 'Slider',
					'dependency' => array(
						'element' => 'layout',
						'value' => array( 'slider' ),
					),
				),
				array(
					'type' => 'checkbox',
					'heading' => __( 'Hide prev/next buttons', 'blance' ),
					'param_name' => 'hide_prev_next_buttons',
					'description' => __( 'If "YES" prev/next control will be removed', 'blance' ),
					'value' => array( __( 'Yes, please', 'blance' ) => 'yes' ),
					'group' => 'Slider',
					'dependency' => array(
						'element' => 'layout',
						'value' => array( 'slider' ),
					),
				),
				array(
					'type' => 'checkbox',
					'heading' => __( 'Slider loop', 'blance' ),
					'param_name' => 'wrap',
					'description' => __( 'Enables loop mode.', 'blance' ),
					'value' => array( __( 'Yes, please', 'blance' ) => 'yes' ),
					'group' => 'Slider',
					'dependency' => array(
						'element' => 'layout',
						'value' => array( 'slider' ),
					),
				),
				array(
					'type' => 'textfield',
					'heading' => __( 'Extra class name', 'blance' ),
					'param_name' => 'el_class',
					'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'blance' )
				),
			),
		    "js_view" => 'VcColumnView'
		));

		vc_map( array(
			'name' => __( 'Testimonial', 'blance' ),
			'base' => 'testimonial',
			'class' => '',
			"as_child" => array('only' => 'testimonials'),
			"content_element" => true,
			'category' => __( 'Shortcode elements', 'blance' ),
			'description' => __( 'User testimonial', 'blance' ),
			'params' => array(
				array(
					'type' => 'textfield',
					'heading' => __( 'Name', 'blance' ),
					'param_name' => 'name',
					'value' => '',
					'description' => __( 'User name', 'blance' )
				),
				array(
					'type' => 'textfield',
					'heading' => __( 'Title', 'blance' ),
					'param_name' => 'title',
					'value' => '',
					'description' => __( 'User title', 'blance' )
				),
				array(
					'type' => 'attach_image',
					'heading' => __( 'User Avatar', 'blance' ),
					'param_name' => 'image',
					'value' => '',
					'description' => __( 'Select image from media library.', 'blance' )
				),
				array(
					'type' => 'textfield',
					'heading' => __( 'Image size', 'blance' ),
					'param_name' => 'img_size',
					'description' => __( 'Enter image size. Example: "thumbnail", "medium", "large", "full" or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height). Leave empty to use "thumbnail" size.', 'blance' )
				),
				array(
					'type' => 'textarea_html',
					'holder' => 'div',
					'heading' => __( 'Text', 'blance' ),
					'param_name' => 'content'
				),
				array(
					'type' => 'textfield',
					'heading' => __( 'Extra class name', 'blance' ),
					'param_name' => 'el_class',
					'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'blance' )
				)
			)
		));


	

		/**
		 * ------------------------------------------------------------------------------------------------
		 * Map instagram shortcode
		 * ------------------------------------------------------------------------------------------------
		 */

		vc_map(array(
			'name' => __( 'Instagram', 'blance' ),
			'base' => 'blance_instagram',
			'class' => '',
			'category' => __( 'Shortcode elements', 'blance' ),
			'description' => __( 'Instagram photos', 'blance' ),
			'params' =>  blance_get_instagram_params()
		));


		/**
		 * ------------------------------------------------------------------------------------------------
		 * Map Author Widget shortcode
		 * ------------------------------------------------------------------------------------------------
		 */

		vc_map(array(
			'name' => __( 'Author area', 'blance' ),
			'base' => 'author_area',
			'class' => '',
			'category' => __( 'Shortcode elements', 'blance' ),
			'description' => __( 'Widget for author information', 'blance' ),
			'params' =>  blance_get_author_area_params()
		));

		/**
		 * ------------------------------------------------------------------------------------------------
		 * Map promo banner shortcode
		 * ------------------------------------------------------------------------------------------------
		 */

		vc_map(array(
			'name' => __( 'Promo Banner', 'blance' ),
			'base' => 'promo_banner',
			'class' => '',
			'category' => __( 'Shortcode elements', 'blance' ),
			'description' => __( 'Promo image with text and hover effect', 'blance' ),
			'params' =>  blance_get_banner_params()
		));

		/**
		 * ------------------------------------------------------------------------------------------------
		 * Map banners carousel shortcode
		 * ------------------------------------------------------------------------------------------------
		 */
		vc_map( array(
			'name' => __( 'Banners carousel', 'blance' ),
			'base' => 'banners_carousel',
			"as_parent" => array('only' => 'promo_banner'),
			"content_element" => true,
			"show_settings_on_create" => true,
			'category' => __( 'Shortcode elements', 'blance' ),
			'description' => __( 'Show your banners as a carousel', 'blance' ),
			'params' => array(
				array(
					'type' => 'dropdown',
					'heading' => __( 'Slides per view', 'blance' ),
					'param_name' => 'slides_per_view',
					'value' => array(
						1,2,3,4,5,6,7,8
					),
					'description' => __( 'Set numbers of slides you want to display at the same time on slider\'s container for carousel mode.', 'blance' )
				),
				array(
					'type' => 'checkbox',
					'heading' => __( 'Slider autoplay', 'blance' ),
					'param_name' => 'autoplay',
					'description' => __( 'Enables autoplay mode.', 'blance' ),
					'value' => array( __( 'Yes, please', 'blance' ) => 'yes' ),
				),
				array(
					'type' => 'textfield',
					'heading' => __( 'Slider speed', 'blance' ),
					'param_name' => 'speed',
					'value' => '5000',
					'description' => __( 'Duration of animation between slides (in ms)', 'blance' ),
				),
				array(
					'type' => 'checkbox',
					'heading' => __( 'Hide pagination control', 'blance' ),
					'param_name' => 'hide_pagination_control',
					'description' => __( 'If "YES" pagination control will be removed', 'blance' ),
					'value' => array( __( 'Yes, please', 'blance' ) => 'yes' ),
				),
				array(
					'type' => 'checkbox',
					'heading' => __( 'Hide prev/next buttons', 'blance' ),
					'param_name' => 'hide_prev_next_buttons',
					'description' => __( 'If "YES" prev/next control will be removed', 'blance' ),
					'value' => array( __( 'Yes, please', 'blance' ) => 'yes' ),
				),
				array(
					'type' => 'checkbox',
					'heading' => __( 'Slider loop', 'blance' ),
					'param_name' => 'wrap',
					'description' => __( 'Enables loop mode.', 'blance' ),
					'value' => array( __( 'Yes, please', 'blance' ) => 'yes' ),
				),
				array(
					'type' => 'textfield',
					'heading' => __( 'Extra class name', 'blance' ),
					'param_name' => 'el_class',
					'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'blance' )
				),
			),
		    "js_view" => 'VcColumnView'
		));




		/**
		 * ------------------------------------------------------------------------------------------------
		 * Map images gallery shortcode
		 * ------------------------------------------------------------------------------------------------
		 */

		vc_map(array(
			'name' => __( 'Images gallery', 'blance' ),
			'base' => 'blance_gallery',
			'class' => '',
			'category' => __( 'Shortcode elements', 'blance' ),
			'description' => __( 'Images grid/carousel', 'blance' ),
			'params' => array(
				array(
					'type' => 'attach_images',
					'heading' => __( 'Images', 'blance' ),
					'param_name' => 'images',
					'value' => '',
					'description' => __( 'Select images from media library.', 'blance' )
				),
				array(
					'type' => 'textfield',
					'heading' => __( 'Image size', 'blance' ),
					'param_name' => 'img_size',
					'description' => __( 'Enter image size. Example: "thumbnail", "medium", "large", "full" or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height). Leave empty to use "thumbnail" size.', 'blance' )
				),
				array(
					'type' => 'dropdown',
					'heading' => __( 'View', 'blance' ),
					'value' => 4,
					'param_name' => 'view',
					'save_always' => true,
					'value' => array(
						'Default grid' => 'grid',
						'Masonry grid' => 'masonry',
						'Carousel' => 'carousel',
					)
				),
				array(
					'type' => 'dropdown',
					'heading' => __( 'Slides per view', 'blance' ),
					'param_name' => 'slides_per_view',
					'value' => array(
						1,2,3,4,5,6,7,8
					),
					'dependency' => array(
						'element' => 'view',
						'value' => array( 'carousel' ),
					),
					'description' => __( 'Set numbers of slides you want to display at the same time on slider\'s container for carousel mode.', 'blance' )
				),

				array(
					'type' => 'checkbox',
					'heading' => __( 'Hide prev/next buttons', 'blance' ),
					'param_name' => 'hide_prev_next_buttons',
					'description' => __( 'If "YES" prev/next control will be removed', 'blance' ),
					'value' => array( __( 'Yes, please', 'blance' ) => 'yes' ),
					'dependency' => array(
						'element' => 'view',
						'value' => array( 'carousel' ),
					),
				),
                array(
					'type' => 'checkbox',
					'heading' => __( 'Hide dots', 'blance' ),
					'param_name' => 'hide_dots',
					'description' => __( 'If "YES" dots control will be removed', 'blance' ),
					'value' => array( __( 'Yes, please', 'blance' ) => 'yes' ),
					'dependency' => array(
						'element' => 'view',
						'value' => array( 'carousel' ),
					),
				),
				array(
					'type' => 'checkbox',
					'heading' => __( 'Slider loop', 'blance' ),
					'param_name' => 'wrap',
					'description' => __( 'Enables loop mode.', 'blance' ),
					'value' => array( __( 'Yes, please', 'blance' ) => 'yes' ),
					'dependency' => array(
						'element' => 'view',
						'value' => array( 'carousel' ),
					),
				),
				array(
					'type' => 'dropdown',
					'heading' => __( 'Columns', 'blance' ),
					'value' => 3,
					'param_name' => 'columns',
					'save_always' => true,
					'description' => __( 'How much columns grid', 'blance' ),
					'value' => array(
						'1 column' => 12,
						'2 column' => 6,
						'3 column' => 4,
						'4 column' => 3,
						'6 column' => 2,
					),
					'dependency' => array(
						'element' => 'view',
						'value' => array( 'grid', 'masonry' ),
					),
				),
				array(
					'type' => 'checkbox',
					'heading' => __( 'Open large image on click', 'blance' ),
					'save_always' => true,
					'param_name' => 'lightbox',
					'value' => array( __( 'Yes, please', 'blance' ) => 'yes' ),
					'default' => 'yes'
				),
				array(
					'type' => 'textfield',
					'heading' => __( 'Extra class name', 'blance' ),
					'param_name' => 'el_class',
					'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'blance' )
				)
			)
		));

		/**
		 * ------------------------------------------------------------------------------------------------
		 * Map countdown timer
		 * ------------------------------------------------------------------------------------------------
		 */

		vc_map(array(
			'name' => __( 'Countdown timer', 'blance' ),
			'base' => 'blance_countdown_timer',
			'class' => '',
			'category' => __( 'Shortcode elements', 'blance' ),
			'description' => __( 'Shows countdown timer', 'blance' ),
			'params' => array(
				array(
					'type' => 'textfield',
					'heading' => __( 'Date', 'blance' ),
					'param_name' => 'date',
					'description' => __( 'Final date in the format Y/m/d. For example 2017/12/12', 'blance' )
				),
				blance_get_color_scheme_param(),
				array(
					'type' => 'dropdown',
					'heading' => __( 'Size', 'blance' ),
					'param_name' => 'size',
					'value' => array(
						'' => '',
						__( 'Small', 'blance' ) => 'small',
						__( 'Medium', 'blance' ) => 'medium',
						__( 'Large', 'blance' ) => 'large',
					)
				),
				array(
					'type' => 'dropdown',
					'heading' => __( 'Align', 'blance' ),
					'param_name' => 'align',
					'value' => array(
						'' => '',
						__( 'left', 'blance' ) => 'left',
						__( 'center', 'blance' ) => 'center',
						__( 'right', 'blance' ) => 'right',
					)
				),
				array(
					'type' => 'dropdown',
					'heading' => __( 'Style', 'blance' ),
					'param_name' => 'style',
					'value' => array(
						'' => '',
						__( 'Standard', 'blance' ) => 'standard',
						__( 'Transparent', 'blance' ) => 'transparent',
					)
				),
				array(
					'type' => 'textfield',
					'heading' => __( 'Extra class name', 'blance' ),
					'param_name' => 'el_class',
					'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'blance' )
				)
			)
		));

		/**
		 * ------------------------------------------------------------------------------------------------
		 * Information box with image (icon)
		 * ------------------------------------------------------------------------------------------------
		 */

		vc_map(array(
			'name' => __( 'Information box', 'blance' ),
			'base' => 'blance_info_box',
			'class' => '',
			'category' => __( 'Shortcode elements', 'blance' ),
			'description' => __( 'Show some brief information', 'blance' ),
			'params' => array(
            	array(
					'type' => 'textfield',
					'heading' => __( 'Icon', 'blance' ),
					'param_name' => 'icon',
					'description' => __( 'Add Class icon form http://fontawesome.io Example: comment-o  ', 'blance' )
				),
				array(
					'type' => 'attach_image',
					'heading' => __( 'Image', 'blance' ),
					'param_name' => 'image',
					'value' => '',
					'description' => __( 'Select image from media library.', 'blance' )
				),
				array(
					'type' => 'textfield',
					'heading' => __( 'Image size', 'blance' ),
					'param_name' => 'img_size',
					'description' => __( 'Enter image size. Example: "thumbnail", "medium", "large", "full" or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height). Leave empty to use "thumbnail" size.', 'blance' )
				),
				array(
					'type' => 'href',
					'heading' => __( 'Link', 'blance'),
					'param_name' => 'link',
					'description' => __( 'Enter URL if you want this box to have a link.', 'blance' )
				),
				array(
					'type' => 'dropdown',
					'heading' => __( 'Link target', 'blance' ),
					'param_name' => 'link_target',
					'value' => $target_arr
				),
				array(
					'type' => 'textfield',
					'heading' => __( 'Button text', 'blance' ),
					'param_name' => 'btn_text',
				),
				array(
					'type' => 'dropdown',
					'heading' => __( 'Button style', 'blance' ),
					'param_name' => 'btn_position',
					'value' => array(
						__( 'Show on hover', 'blance' ) => 'hover',
						__( 'Static', 'blance' ) => 'static',
					)
				),
				array(
					'type' => 'textarea_html',
					'holder' => 'div',
					'heading' => __( 'Brief content', 'blance' ),
					'param_name' => 'content',
					'description' => __( 'Add here few words to your banner image.', 'blance' )
				),
				array(
					'type' => 'dropdown',
					'heading' => __( 'Text alignment', 'blance' ),
					'param_name' => 'alignment',
					'value' => array(
						__( 'Align left', 'blance' ) => '',
						__( 'Align right', 'blance' ) => 'right',
						__( 'Align center', 'blance' ) => 'center'
					),
					'description' => __( 'Select image alignment.', 'blance' )
				),
				array(
					'type' => 'dropdown',
					'heading' => __( 'Image position', 'blance' ),
					'param_name' => 'image_alignment',
					'value' => array(
						__( 'Top', 'blance' ) => 'top',
						__( 'Left', 'blance' ) => 'left',
						__( 'Right', 'blance' ) => 'right'
					)
				),
				array(
					'type' => 'dropdown',
					'heading' => __( 'Box style', 'blance' ),
					'param_name' => 'style',
					'value' => array(
						__( 'Base', 'blance' ) => 'base',
						__( 'Bordered', 'blance' ) => 'border',
						__( 'Shadow', 'blance' ) => 'shadow',
					)
				),
				array(
					'type' => 'checkbox',
					'heading' => __( 'New CSS structure', 'blance' ),
					'param_name' => 'new_styles',
					'description' => __( 'Use improved version with CSS flexbox that was added in 2.9 version.', 'blance' ),
					'value' => array( __( 'Yes, please', 'blance' ) => 'yes' ),
				),
				blance_get_color_scheme_param(),
				array(
					'type' => 'css_editor',
					'heading' => __( 'CSS box', 'blance' ),
					'param_name' => 'css',
					'group' => __( 'Design Options', 'blance' )
				),
				array(
					'type' => 'textfield',
					'heading' => __( 'Extra class name', 'blance' ),
					'param_name' => 'el_class',
					'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'blance' )
				)
			)
		));

		/**
		 * ------------------------------------------------------------------------------------------------
		 * Add options to columns and text block 
		 * ------------------------------------------------------------------------------------------------
		 */

		add_action( 'init', 'blance_update_vc_column');

		if( ! function_exists( 'blance_update_vc_column' ) ) {
			function blance_update_vc_column() {
				if(!function_exists('vc_map')) return;
				vc_remove_param( 'vc_column', 'el_class' );
				
		        vc_add_param( 'vc_column', blance_get_color_scheme_param() ); 
				
		        vc_add_param( 'vc_column', array(
		            'type' => 'textfield',
		            'heading' => __( 'Extra class name', 'blance' ),
		            'param_name' => 'el_class',
		            'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'blance' )
		        ) ); 

				vc_remove_param( 'vc_column_text', 'el_class' );
				
		        vc_add_param( 'vc_column_text', blance_get_color_scheme_param() ); 
				
		        vc_add_param( 'vc_column_text', array(
		            'type' => 'textfield',
		            'heading' => __( 'Extra class name', 'blance' ),
		            'param_name' => 'el_class',
		            'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'blance' )
		        ) ); 
			}
		}


		/**
		 * ------------------------------------------------------------------------------------------------
		 * Add new element to VC: Categories [blance_categories]
		 * ------------------------------------------------------------------------------------------------
		 */


		$order_by_values = array(
			'',
			__( 'Date', 'blance' ) => 'date',
			__( 'ID', 'blance' ) => 'ID',
			__( 'Author', 'blance' ) => 'author',
			__( 'Title', 'blance' ) => 'title',
			__( 'Modified', 'blance' ) => 'modified',
			__( 'Random', 'blance' ) => 'rand',
			__( 'Comment count', 'blance' ) => 'comment_count',
			__( 'Menu order', 'blance' ) => 'menu_order',
			__( 'As IDs or slugs provided order', 'blance' ) => 'include',
		);

		$order_way_values = array(
			'',
			__( 'Descending', 'blance' ) => 'DESC',
			__( 'Ascending', 'blance' ) => 'ASC',
		);

		vc_map( array(
			'name' => __( 'Product categories', 'blance' ),
			'base' => 'blance_categories',
			'class' => '',
			'category' => __( 'Shortcode elements', 'blance' ),
			'description' => __( 'Product categories grid', 'blance' ), 
			'params' => array(
				array(
					'type' => 'textfield',
					'heading' => __( 'Title', 'blance' ),
					'param_name' => 'title',
				),
				array(
					'type' => 'textfield',
					'heading' => __( 'Number', 'blance' ),
					'param_name' => 'number',
					'description' => __( 'The `number` field is used to display the number of categories.', 'blance' ),
				),
				array(
					'type' => 'dropdown',
					'heading' => __( 'Order by', 'blance' ),
					'param_name' => 'orderby',
					'value' => $order_by_values,
					'save_always' => true,
					'description' => sprintf( __( 'Select how to sort retrieved categories. More at %s.', 'blance' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' )
				),
				array(
					'type' => 'dropdown',
					'heading' => __( 'Sort order', 'blance' ),
					'param_name' => 'order',
					'value' => $order_way_values,
					'save_always' => true,
					'description' => sprintf( __( 'Designates the ascending or descending order. More at %s.', 'blance' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' )
				),
				array(
					'type' => 'dropdown',
					'heading' => __( 'Layout', 'blance' ),
					'value' => 4,
					'param_name' => 'style',
					'save_always' => true,
					'description' => __( 'Try out our creative styles for categories block', 'blance' ),
					'value' => array(
						'Default' => 'default',
						'Carousel' => 'carousel',
					)
				),
				array(
					'type' => 'dropdown',
					'heading' => __( 'Categories design', 'blance' ),
					'description' => __( 'Overrides option from Theme Settings -> Shop', 'blance' ),
					'param_name' => 'categories_design',
					'value' => array_merge( array( 'Inherit' => '' ), array_flip( blance_get_config( 'categories-designs' ) ) ),
				),
				array(
					'type' => 'dropdown',
					'heading' => __( 'Slides per view', 'blance' ),
					'param_name' => 'slides_per_view',
					'value' => array(
						1,2,3,4,5,6,7,8
					),
					'dependency' => array(
						'element' => 'style',
						'value' => array( 'carousel' ),
					),
					'description' => __( 'Set numbers of slides you want to display at the same time on slider\'s container for carousel mode.', 'blance' )
				),
				array(
					'type' => 'checkbox',
					'heading' => __( 'Hide pagination control', 'blance' ),
					'param_name' => 'hide_pagination_control',
					'description' => __( 'If "YES" pagination control will be removed', 'blance' ),
					'value' => array( __( 'Yes, please', 'blance' ) => 'yes' ),
					'dependency' => array(
						'element' => 'style',
						'value' => array( 'carousel' ),
					),
				),
				array(
					'type' => 'checkbox',
					'heading' => __( 'Hide prev/next buttons', 'blance' ),
					'param_name' => 'hide_prev_next_buttons',
					'description' => __( 'If "YES" prev/next control will be removed', 'blance' ),
					'value' => array( __( 'Yes, please', 'blance' ) => 'yes' ),
					'dependency' => array(
						'element' => 'style',
						'value' => array( 'carousel' ),
					),
				),
				array(
					'type' => 'checkbox',
					'heading' => __( 'Slider loop', 'blance' ),
					'param_name' => 'wrap',
					'description' => __( 'Enables loop mode.', 'blance' ),
					'value' => array( __( 'Yes, please', 'blance' ) => 'yes' ),
					'dependency' => array(
						'element' => 'style',
						'value' => array( 'carousel' ),
					),
				),
				array(
					'type' => 'textfield',
					'heading' => __( 'Hide empty', 'blance' ),
					'param_name' => 'hide_empty',
					'description' => __( 'Hide empty', 'blance' ),
				),
				array(
					'type' => 'autocomplete',
					'heading' => __( 'Categories', 'blance' ),
					'param_name' => 'ids',
					'settings' => array(
						'multiple' => true,
						'sortable' => true,
					),
					'save_always' => true,
					'description' => __( 'List of product categories', 'blance' ),
				)
			)
		) );

		//Filters For autocomplete param:
		//For suggestion: vc_autocomplete_[shortcode_name]_[param_name]_callback
		add_filter( 'vc_autocomplete_blance_categories_ids_callback', 'blance_productCategoryCategoryAutocompleteSuggester', 10, 1 ); // Get suggestion(find). Must return an array
		add_filter( 'vc_autocomplete_blance_categories_ids_render', 'blance_productCategoryCategoryRenderByIdExact', 10, 1 ); 

		if( ! function_exists( 'blance_productCategoryCategoryAutocompleteSuggester' ) ) {
			function blance_productCategoryCategoryAutocompleteSuggester( $query, $slug = false ) {
				global $wpdb;
				$cat_id = (int) $query;
				$query = trim( $query );
				$post_meta_infos = $wpdb->get_results(
					$wpdb->prepare( "SELECT a.term_id AS id, b.name as name, b.slug AS slug
								FROM {$wpdb->term_taxonomy} AS a
								INNER JOIN {$wpdb->terms} AS b ON b.term_id = a.term_id
								WHERE a.taxonomy = 'product_cat' AND (a.term_id = '%d' OR b.slug LIKE '%%%s%%' OR b.name LIKE '%%%s%%' )",
						$cat_id > 0 ? $cat_id : - 1, stripslashes( $query ), stripslashes( $query ) ), ARRAY_A );

				$result = array();
				if ( is_array( $post_meta_infos ) && ! empty( $post_meta_infos ) ) {
					foreach ( $post_meta_infos as $value ) {
						$data = array();
						$data['value'] = $slug ? $value['slug'] : $value['id'];
						$data['label'] = __( 'Id', 'blance' ) . ': ' .
						                 $value['id'] .
						                 ( ( strlen( $value['name'] ) > 0 ) ? ' - ' . __( 'Name', 'blance' ) . ': ' .
						                                                      $value['name'] : '' ) .
						                 ( ( strlen( $value['slug'] ) > 0 ) ? ' - ' . __( 'Slug', 'blance' ) . ': ' .
						                                                      $value['slug'] : '' );
						$result[] = $data;
					}
				}

				return $result;
			}
		}
		if( ! function_exists( 'blance_productCategoryCategoryRenderByIdExact' ) ) {
			function blance_productCategoryCategoryRenderByIdExact( $query ) {
				global $wpdb;
				$query = $query['value'];
				$cat_id = (int) $query;
				$term = get_term( $cat_id, 'product_cat' );

				return blance_productCategoryTermOutput( $term );
			}
		}

		if( ! function_exists( 'blance_productCategoryTermOutput' ) ) {
			function blance_productCategoryTermOutput( $term ) {
				$term_slug = $term->slug;
				$term_title = $term->name;
				$term_id = $term->term_id;

				$term_slug_display = '';
				if ( ! empty( $term_sku ) ) {
					$term_slug_display = ' - ' . __( 'Sku', 'blance' ) . ': ' . $term_slug;
				}

				$term_title_display = '';
				if ( ! empty( $product_title ) ) {
					$term_title_display = ' - ' . __( 'Title', 'blance' ) . ': ' . $term_title;
				}

				$term_id_display = __( 'Id', 'blance' ) . ': ' . $term_id;

				$data = array();
				$data['value'] = $term_id;
				$data['label'] = $term_id_display . $term_title_display . $term_slug_display;

				return ! empty( $data ) ? $data : false;
			}
		}

		/**
		 * ------------------------------------------------------------------------------------------------
		 * Add new element to VC: Posts [blance_posts]
		 * ------------------------------------------------------------------------------------------------
		 */

		vc_map( array(
			'name' => __( 'Posts carousel', 'blance' ),
			'base' => 'blance_posts',
			'class' => '',
			'category' => __( 'Shortcode elements', 'blance' ),
			'description' => __( 'Animated carousel with posts', 'blance' ), 
			'params' => array(
				array(
					'type' => 'textfield',
					'heading' => __( 'Slider title', 'blance' ),
					'param_name' => 'title',
				),
				array(
					'type' => 'loop',
					'heading' => __( 'Carousel content', 'blance' ),
					'param_name' => 'posts_query',
					'settings' => array(
						'size' => array( 'hidden' => false, 'value' => 10 ),
						'post_type' => array( 'value' => 'post' ),
						'order_by' => array( 'value' => 'date' )
					),
					'description' => __( 'Create WordPress loop, to populate content from your site.', 'blance' )
				),
				array(
					'type' => 'textfield',
					'heading' => __( 'Images size', 'blance' ),
					'param_name' => 'img_size',
					'description' => __( 'Enter image size. Example: "thumbnail", "medium", "large", "full" or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height). Leave empty to use "thumbnail" size.', 'blance' )
				),
				array(
					'type' => 'textfield',
					'heading' => __( 'Slider speed', 'blance' ),
					'param_name' => 'speed',
					'value' => '5000',
					'description' => __( 'Duration of animation between slides (in ms)', 'blance' )
				),
                	array(
					'type' => 'textfield',
					'heading' => __( 'Space Item', 'blance' ),
					'param_name' => 'space',
					'value' => '15',
					'description' => __( 'Enter Space bewen item', 'blance' ),
				),
				array(
					'type' => 'dropdown',
					'heading' => __( 'Slides per view', 'blance' ),
					'param_name' => 'slides_per_view',
					'value' => array(
						1,2,3,4,5,6,7,8
					),
					'description' => __( 'Set numbers of slides you want to display at the same time on slider\'s container for carousel mode. Also supports for "auto" value, in this case it will fit slides depending on container\'s width. "auto" mode doesn\'t compatible with loop mode.', 'blance' )
				),
				array(
					'type' => 'checkbox',
					'heading' => __( 'Scroll per page', 'blance' ),
					'param_name' => 'scroll_per_page',
					'description' => __( 'Scroll per page not per item. This affect next/prev buttons and mouse/touch dragging.', 'blance' ),
					'value' => array( __( 'Yes, please', 'blance' ) => 'yes' )
				),
				array(
					'type' => 'checkbox',
					'heading' => __( 'Slider autoplay', 'blance' ),
					'param_name' => 'autoplay',
					'description' => __( 'Enables autoplay mode.', 'blance' ),
					'value' => array( __( 'Yes, please', 'blance' ) => 'yes' )
				),
				array(
					'type' => 'checkbox',
					'heading' => __( 'Hide pagination control', 'blance' ),
					'param_name' => 'hide_pagination_control',
					'description' => __( 'If "YES" pagination control will be removed', 'blance' ),
					'value' => array( __( 'Yes, please', 'blance' ) => 'yes' )
				),
				array(
					'type' => 'checkbox',
					'heading' => __( 'Hide prev/next buttons', 'blance' ),
					'param_name' => 'hide_prev_next_buttons',
					'description' => __( 'If "YES" prev/next control will be removed', 'blance' ),
					'value' => array( __( 'Yes, please', 'blance' ) => 'yes' )
				),
				array(
					'type' => 'checkbox',
					'heading' => __( 'Slider loop', 'blance' ),
					'param_name' => 'wrap',
					'description' => __( 'Enables loop mode.', 'blance' ),
					'value' => array( __( 'Yes, please', 'blance' ) => 'yes' )
				),
				array(
					'type' => 'dropdown',
					'heading' => __( 'Layout Blog Slider', 'blance' ),
					'param_name' => 'blog_layout',
					'value' => array(
						' Layout 1' => 1,
						'Layout 2' => 2,
						' Layout 3' => 3,
						'Layout 4' => 4,
						'Layout 6' => 6,
					),
				),
				array(
					'type' => 'textfield',
					'heading' => __( 'Extra class name', 'blance' ),
					'param_name' => 'el_class',
					'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'blance' )
				),
                array(
					'type' => 'textfield',
					'heading' => __( 'Read More Text', 'blance' ),
					'param_name' => 'readmore_text',
				),
			)
		) );

		/**
		 * ------------------------------------------------------------------------------------------------
		 * Add new element to VC: Products [blance_products]
		 * ------------------------------------------------------------------------------------------------
		 */

		vc_map( blance_get_products_shortcode_map_params() );

		// Necessary hooks for blog autocomplete fields
		add_filter( 'vc_autocomplete_blance_products_include_callback',	'vc_include_field_search', 10, 1 ); // Get suggestion(find). Must return an array
		add_filter( 'vc_autocomplete_blance_products_include_render',
			'vc_include_field_render', 10, 1 ); // Render exact product. Must return an array (label,value)

		// Narrow data taxonomies
		add_filter( 'vc_autocomplete_blance_products_taxonomies_callback', 'vc_autocomplete_taxonomies_field_search', 10, 1 );
		add_filter( 'vc_autocomplete_blance_products_taxonomies_render', 'vc_autocomplete_taxonomies_field_render', 10, 1 );

		// Narrow data taxonomies for exclude_filter
		add_filter( 'vc_autocomplete_blance_products_exclude_filter_callback', 'vc_autocomplete_taxonomies_field_search', 10, 1 );
		add_filter( 'vc_autocomplete_blance_products_exclude_filter_render', 'vc_autocomplete_taxonomies_field_render', 10, 1 );

		add_filter( 'vc_autocomplete_blance_products_exclude_callback',	'vc_exclude_field_search', 10, 1 ); // Get suggestion(find). Must return an array
		add_filter( 'vc_autocomplete_blance_products_exclude_render', 'vc_exclude_field_render', 10, 1 ); // Render exact product. Must return an array (label,value)




		/**
		 * ------------------------------------------------------------------------------------------------
		 * Map products tabs shortcode
		 * ------------------------------------------------------------------------------------------------
		 */
		vc_map( array(
			'name' => __( 'AJAX Products tabs', 'blance' ),
			'base' => 'products_tabs',
			"as_parent" => array('only' => 'products_tab'),
			"content_element" => true,
			"show_settings_on_create" => true,
			'category' => __( 'Shortcode elements', 'blance' ),
			'description' => __( 'Product tabs for your marketplace', 'blance' ),
			'params' => array(
				array(
					'type' => 'textfield',
					'heading' => __( 'Title', 'blance' ),
					'param_name' => 'title',
				),
				array(
					'type' => 'attach_image',
					'heading' => __( 'Icon image', 'blance' ),
					'param_name' => 'image',
					'value' => '',
					'description' => __( 'Select image from media library.', 'blance' )
				),
				array(
					'type' => 'colorpicker',
					'heading' => __( 'Tabs color', 'blance' ),
					'param_name' => 'color'
				),
				array(
					'type' => 'textfield',
					'heading' => __( 'Extra class name', 'blance' ),
					'param_name' => 'el_class',
					'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'blance' )
				)
			),
		    "js_view" => 'VcColumnView'
		));

		$blance_prdoucts_params = vc_map_integrate_shortcode( blance_get_products_shortcode_map_params(), '', '', array(
			'exclude' => array(
			),
		));

		vc_map( array(
			'name' => __( 'Products tab', 'blance' ),
			'base' => 'products_tab',
			'class' => '',
			"as_child" => array('only' => 'products_tabі'),
			"content_element" => true,
			'category' => __( 'Shortcode elements', 'blance' ),
			'description' => __( 'Products block', 'blance' ),
			'params' => array_merge( array(
				array(
					'type' => 'textfield',
					'heading' => __( 'Title for the tab', 'blance' ),
					'param_name' => 'title',
					'value' => '',
				)
			), $blance_prdoucts_params )
		));

		// Necessary hooks for blog autocomplete fields
		add_filter( 'vc_autocomplete_products_tab_include_callback',	'vc_include_field_search', 10, 1 ); // Get suggestion(find). Must return an array
		add_filter( 'vc_autocomplete_products_tab_include_render',
			'vc_include_field_render', 10, 1 ); // Render exact product. Must return an array (label,value)

		// Narrow data taxonomies
		add_filter( 'vc_autocomplete_products_tab_taxonomies_callback', 'vc_autocomplete_taxonomies_field_search', 10, 1 );
		add_filter( 'vc_autocomplete_products_tab_taxonomies_render', 'vc_autocomplete_taxonomies_field_render', 10, 1 );

		// Narrow data taxonomies for exclude_filter
		add_filter( 'vc_autocomplete_products_tab_exclude_filter_callback', 'vc_autocomplete_taxonomies_field_search', 10, 1 );
		add_filter( 'vc_autocomplete_products_tab_exclude_filter_render', 'vc_autocomplete_taxonomies_field_render', 10, 1 );

		add_filter( 'vc_autocomplete_products_tab_exclude_callback',	'vc_exclude_field_search', 10, 1 ); // Get suggestion(find). Must return an array
		add_filter( 'vc_autocomplete_products_tab_exclude_render', 'vc_exclude_field_render', 10, 1 ); // Render exact product. Must return an array (label,value)



		/**
		 * ------------------------------------------------------------------------------------------------
		 * Update images carousel parameters
		 * ------------------------------------------------------------------------------------------------
		 */
		add_action( 'init', 'blance_update_vc_images_carousel');

		if( ! function_exists( 'blance_update_vc_images_carousel' ) ) {
			function blance_update_vc_images_carousel() {
				if(!function_exists('vc_map')) return;
				vc_remove_param( 'vc_images_carousel', 'mode' );
				vc_remove_param( 'vc_images_carousel', 'partial_view' );
				vc_remove_param( 'vc_images_carousel', 'el_class' );
				
		        vc_add_param( 'vc_images_carousel', array(
					'type' => 'checkbox',
					'heading' => __( 'Add spaces between images', 'blance' ),
					'param_name' => 'spaces',
					'value' => array( __( 'Yes, please', 'blance' ) => 'yes' )
				) ); 
				
		        vc_add_param( 'vc_images_carousel', array(
					'type' => 'dropdown',
					'heading' => __( 'Specific design', 'blance' ),
					'param_name' => 'design',
		            'description' => __( 'With this option your gallery will be styled in a different way, and sizes will be changed.', 'blance' ),
					'value' => array(
						'' => 'none',
						__( 'Iphone', 'blance' ) => 'iphone',
						__( 'MacBook', 'blance' ) => 'macbook',
					)
				) ); 

		        vc_add_param( 'vc_images_carousel', array(
		            'type' => 'textfield',
		            'heading' => __( 'Extra class name', 'blance' ),
		            'param_name' => 'el_class',
		            'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'blance' )
		        ) ); 
			}
		}

	}
}


if( ! function_exists( 'blance_get_products_shortcode_params' ) ) {
	function blance_get_products_shortcode_map_params() {
		return array(
			'name' => __( 'Products (grid or carousel)', 'blance' ),
			'base' => 'blance_products',
			'class' => '',
			'category' => __( 'Shortcode elements', 'blance' ),
			'description' => __( 'Animated carousel with posts', 'blance' ),
			'params' => blance_get_products_shortcode_params() 
		);
	}
}

if( ! function_exists( 'blance_get_products_shortcode_params' ) ) {
	function blance_get_products_shortcode_params() {
		return apply_filters( 'blance_get_products_shortcode_params', array(
				array(
					'type' => 'dropdown',
					'heading' => __( 'Grid or carousel', 'blance' ),
					'param_name' => 'layout',
					'value' =>  array(
						array( 'grid', __( 'Grid', 'blance' ) ),
						array( 'carousel', __( 'Carousel', 'blance' ) ),

					),
					'description' => __( 'Show products in standard grid or via slider carousel', 'blance' )
				),
				array(
					'type' => 'dropdown',
					'heading' => __( 'Data source', 'blance' ),
					'param_name' => 'post_type',
					'value' =>  array(
						array( 'product', __( 'All Products', 'blance' ) ),
						array( 'featured', __( 'Featured Products', 'blance' ) ),
						array( 'sale', __( 'Sale Products', 'blance' ) ),
						array( 'bestselling', __( 'Bestsellers', 'blance' ) ),
						array( 'ids', __( 'List of IDs', 'blance' ) )

					),
					'description' => __( 'Select content type for your grid.', 'blance' )
				),
				array(
					'type' => 'autocomplete',
					'heading' => __( 'Include only', 'blance' ),
					'param_name' => 'include',
					'description' => __( 'Add products by title.', 'blance' ),
					'settings' => array(
						'multiple' => true,
						'sortable' => true,
						'groups' => true,
					),
					'dependency' => array(
						'element' => 'post_type',
						'value' => array( 'ids' ),
						//'callback' => 'vc_grid_include_dependency_callback',
					),
				),
				// Custom query tab
				array(
					'type' => 'textarea_safe',
					'heading' => __( 'Custom query', 'blance' ),
					'param_name' => 'custom_query',
					'description' => __( 'Build custom query according to <a href="http://codex.wordpress.org/Function_Reference/query_posts">WordPress Codex</a>.', 'blance' ),
					'dependency' => array(
						'element' => 'post_type',
						'value' => array( 'custom' ),
					),
				),
				array(
					'type' => 'autocomplete',
					'heading' => __( 'Categories or tags', 'blance' ),
					'param_name' => 'taxonomies',
					'settings' => array(
						'multiple' => true,
						// is multiple values allowed? default false
						// 'sortable' => true, // is values are sortable? default false
						'min_length' => 1,
						// min length to start search -> default 2
						// 'no_hide' => true, // In UI after select doesn't hide an select list, default false
						'groups' => true,
						// In UI show results grouped by groups, default false
						'unique_values' => true,
						// In UI show results except selected. NB! You should manually check values in backend, default false
						'display_inline' => true,
						// In UI show results inline view, default false (each value in own line)
						'delay' => 500,
						// delay for search. default 500
						'auto_focus' => true,
						// auto focus input, default true
					),
					'param_holder_class' => 'vc_not-for-custom',
					'description' => __( 'Enter categories, tags or custom taxonomies.', 'blance' ),
					'dependency' => array(
						'element' => 'post_type',
						'value_not_equal_to' => array( 'ids', 'custom' ),
					),
				),
				array(
					'type' => 'textfield',
					'heading' => __( 'Items per page', 'blance' ),
					'param_name' => 'items_per_page',
					'description' => __( 'Number of items to show per page.', 'blance' ),
					'value' => '10',
				),
				array(
					'type' => 'dropdown',
					'heading' => __( 'Pagination', 'blance' ),
					'param_name' => 'pagination',
					'value' => array(
	                    '' => '', 
	                    '"Load more" button' => 'more-btn', 
	                    'Arrows' => 'arrows', 
					),
					'dependency' => array(
						'element' => 'layout',
						'value' => array( 'grid' ),
					),
				),
				array(
					'type' => 'dropdown',
					'heading' => __( 'Columns', 'blance' ),
					'param_name' => 'columns',
					'value' => array(
						1,2, 3, 4, 5 , 6
					),
					'description' => __( 'Columns', 'blance' ),
					'group' => __( 'Design', 'blance' ),
					'dependency' => array(
						'element' => 'layout',
						'value' => array( 'grid' ),
					),
				),
				array(
					'type' => 'textfield',
					'heading' => __( 'Images size', 'blance' ),
					'group' => __( 'Design', 'blance' ),
					'param_name' => 'img_size',
					'description' => __( 'Enter image size. Example: "thumbnail", "medium", "large", "full" or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height). Leave empty to use "thumbnail" size.', 'blance' )
				),
				array(
					'type' => 'checkbox',
					'heading' => __( 'Sale countdown', 'blance' ),
					'description' => __( 'Countdown to the end sale date will be shown. Be sure you have set final date of the product sale price.', 'blance' ),
					'param_name' => 'sale_countdown',
					'value' => 1,
					'group' => __( 'Design', 'blance' ),
				),
				// Carousel settings
				array(
					'type' => 'textfield',
					'heading' => __( 'Slider speed', 'blance' ),
					'param_name' => 'speed',
					'value' => '5000',
					'description' => __( 'Duration of animation between slides (in ms)', 'blance' ),
					'group' => __( 'Carousel Settings', 'blance' ),
					'dependency' => array(
						'element' => 'layout',
						'value' => array( 'carousel' ),
					),
				),
				array(
					'type' => 'dropdown',
					'heading' => __( 'Slides per view', 'blance' ),
					'param_name' => 'slides_per_view',
					'value' => array(
						1,2,3,4,5,6,7,8
					),
					'description' => __( 'Set numbers of slides you want to display at the same time on slider\'s container for carousel mode. Also supports for "auto" value, in this case it will fit slides depending on container\'s width. "auto" mode doesn\'t compatible with loop mode.', 'blance' ),
					'group' => __( 'Carousel Settings', 'blance' ),
					'dependency' => array(
						'element' => 'layout',
						'value' => array( 'carousel' ),
					),
				),
				array(
					'type' => 'checkbox',
					'heading' => __( 'Off Slider autoplay', 'blance' ),
					'param_name' => 'autoplay',
					'description' => __( 'Enables autoplay mode.', 'blance' ),
					'value' => array( __( 'Yes, please', 'blance' ) => 'yes' ),
					'group' => __( 'Carousel Settings', 'blance' ),
					'dependency' => array(
						'element' => 'layout',
						'value' => array( 'carousel' ),
					),
				),
				array(
					'type' => 'checkbox',
					'heading' => __( 'Hide pagination control', 'blance' ),
					'param_name' => 'hide_pagination_control',
					'description' => __( 'If "YES" pagination control will be removed', 'blance' ),
					'value' => array( __( 'Yes, please', 'blance' ) => 'yes' ),
					'group' => __( 'Carousel Settings', 'blance' ),
					'dependency' => array(
						'element' => 'layout',
						'value' => array( 'carousel' ),
					),
				),
				array(
					'type' => 'checkbox',
					'heading' => __( 'Hide prev/next buttons', 'blance' ),
					'param_name' => 'hide_prev_next_buttons',
					'description' => __( 'If "YES" prev/next control will be removed', 'blance' ),
					'value' => array( __( 'Yes, please', 'blance' ) => 'yes' ),
					'group' => __( 'Carousel Settings', 'blance' ),
					'dependency' => array(
						'element' => 'layout',
						'value' => array( 'carousel' ),
					),
				),

                
				array(
					'type' => 'checkbox',
					'heading' => __( 'Off Slider loop', 'blance' ),
					'param_name' => 'wrap',
					'description' => __( 'Off loop mode.', 'blance' ),
					'value' => array( __( 'Yes, please', 'blance' ) => 'yes' ),
					'group' => __( 'Carousel Settings', 'blance' ),
					'dependency' => array(
						'element' => 'layout',
						'value' => array( 'carousel' ),
					),
				),
				// Data settings
				array(
					'type' => 'dropdown',
					'heading' => __( 'Order by', 'blance' ),
					'param_name' => 'orderby',
					'value' => array(
						__( 'Date', 'blance' ) => 'date',
						__( 'Order by post ID', 'blance' ) => 'ID',
						__( 'Author', 'blance' ) => 'author',
						__( 'Title', 'blance' ) => 'title',
						__( 'Last modified date', 'blance' ) => 'modified',
						__( 'Number of comments', 'blance' ) => 'comment_count',
						__( 'Menu order/Page Order', 'blance' ) => 'menu_order',
						__( 'Meta value', 'blance' ) => 'meta_value',
						__( 'Meta value number', 'blance' ) => 'meta_value_num',
						__( 'Matches same order you passed in via the include parameter.', 'blance') => 'post__in',
						__( 'Random order', 'blance' ) => 'rand',
						__( 'Price', 'blance' ) => 'price',
					),
					'description' => __( 'Select order type. If "Meta value" or "Meta value Number" is chosen then meta key is required.', 'blance' ),
					'group' => __( 'Data Settings', 'blance' ),
					'param_holder_class' => 'vc_grid-data-type-not-ids',
					'dependency' => array(
						'element' => 'post_type',
						'value_not_equal_to' => array( 'custom' ),
					),
				),
				array(
					'type' => 'dropdown',
					'heading' => __( 'Sorting', 'blance' ),
					'param_name' => 'order',
					'group' => __( 'Data Settings', 'blance' ),
					'value' => array(
						__( 'Descending', 'blance' ) => 'DESC',
						__( 'Ascending', 'blance' ) => 'ASC',
					),
					'param_holder_class' => 'vc_grid-data-type-not-ids',
					'description' => __( 'Select sorting order.', 'blance' ),
					'dependency' => array(
						'element' => 'post_type',
						'value_not_equal_to' => array( 'ids', 'custom' ),
					),
				),
				array(
					'type' => 'textfield',
					'heading' => __( 'Meta key', 'blance' ),
					'param_name' => 'meta_key',
					'description' => __( 'Input meta key for grid ordering.', 'blance' ),
					'group' => __( 'Data Settings', 'blance' ),
					'param_holder_class' => 'vc_grid-data-type-not-ids',
					'dependency' => array(
						'element' => 'orderby',
						'value' => array( 'meta_value', 'meta_value_num' ),
					),
				),
				array(
					'type' => 'textfield',
					'heading' => __( 'Offset', 'blance' ),
					'param_name' => 'offset',
					'description' => __( 'Number of grid elements to displace or pass over.', 'blance' ),
					'group' => __( 'Data Settings', 'blance' ),
					'param_holder_class' => 'vc_grid-data-type-not-ids',
					'dependency' => array(
						'element' => 'post_type',
						'value_not_equal_to' => array( 'ids', 'custom' ),
					),
				),
				array(
					'type' => 'autocomplete',
					'heading' => __( 'Exclude', 'blance' ),
					'param_name' => 'exclude',
					'description' => __( 'Exclude posts, pages, etc. by title.', 'blance' ),
					'group' => __( 'Data Settings', 'blance' ),
					'settings' => array(
						'multiple' => true,
					),
					'param_holder_class' => 'vc_grid-data-type-not-ids',
					'dependency' => array(
						'element' => 'post_type',
						'value_not_equal_to' => array( 'ids', 'custom' ),
						'callback' => 'vc_grid_exclude_dependency_callback',
					),
				)
			)
		);
	}
}


if( ! function_exists( 'blance_get_color_scheme_param' ) ) {
	function blance_get_color_scheme_param() {
		return apply_filters( 'blance_get_color_scheme_param', array(
			'type' => 'dropdown',
			'heading' => __( 'Content Position', 'blance' ),
			'param_name' => 'blance_color_scheme',
			'value' => array(
				__( 'Content Position Left', 'blance' ) => 'left',
                __( 'Content Position Center', 'blance' ) => 'center',
				__( 'Content Position Right', 'blance' ) => 'right',
			),
		) );
	}
}


if( ! function_exists( 'blance_get_user_panel_params' ) ) {
	function blance_get_user_panel_params() {
		return apply_filters( 'blance_get_user_panel_params', array(
			array(
				'type' => 'textfield',
				'heading' => __( 'Title', 'blance' ),
				'param_name' => 'title',
			)
		));
	}
}

if( ! function_exists( 'blance_get_author_area_params' ) ) {
	function blance_get_author_area_params() {
		return apply_filters( 'blance_get_author_area_params', array(
			array(
				'type' => 'textfield',
				'heading' => __( 'Title', 'blance' ),
				'param_name' => 'title',
			),
			array(
				'type' => 'attach_image',
				'heading' => __( 'Image', 'blance' ),
				'param_name' => 'image',
				'value' => '',
				'description' => __( 'Select image from media library.', 'blance' )
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Image size', 'blance' ),
				'param_name' => 'img_size',
				'description' => __( 'Enter image size. Example: "thumbnail", "medium", "large", "full" or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height). Leave empty to use "thumbnail" size.', 'blance' )
			),
			array(
				'type' => 'textarea_html',
				'holder' => 'div',
				'heading' => __( 'Author bio', 'blance' ),
				'param_name' => 'content',
				'description' => __( 'Add here few words to your author info.', 'blance' )
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Text alignment', 'blance' ),
				'param_name' => 'alignment',
				'value' => array(
					__( 'Align left', 'blance' ) => '',
					__( 'Align right', 'blance' ) => 'right',
					__( 'Align center', 'blance' ) => 'center'
				),
				'description' => __( 'Select image alignment.', 'blance' )
			),
			array(
				'type' => 'href',
				'heading' => __( 'Author link', 'blance'),
				'param_name' => 'link',
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Link text', 'blance'),
				'param_name' => 'link_text',
			),
			blance_get_color_scheme_param(),
			array(
				'type' => 'textfield',
				'heading' => __( 'Extra class name', 'blance' ),
				'param_name' => 'el_class',
				'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'blance' )
			)
		));
	}
}


if( ! function_exists( 'blance_get_banner_params' ) ) {
	function blance_get_banner_params() {
		return apply_filters( 'blance_get_banner_params', array(
			array(
				'type' => 'attach_image',
				'heading' => __( 'Image', 'blance' ),
				'param_name' => 'image',
				'value' => '',
				'description' => __( 'Select image from media library.', 'blance' )
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Image size', 'blance' ),
				'param_name' => 'img_size',
				'description' => __( 'Enter image size. Example: "thumbnail", "medium", "large", "full" or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height). Leave empty to use "thumbnail" size.', 'blance' )
			),
			array(
				'type' => 'href',
				'heading' => __( 'Banner link', 'blance'),
				'param_name' => 'link',
				'description' => __( 'Enter URL if you want this banner to have a link.', 'blance' )
			),
			array(
				'type' => 'textarea_html',
				'holder' => 'div',
				'heading' => __( 'Banner content', 'blance' ),
				'param_name' => 'content',
				'description' => __( 'Add here few words to your banner image.', 'blance' )
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Text alignment', 'blance' ),
				'param_name' => 'alignment',
				'value' => array(
					__( 'Align left', 'blance' ) => '',
					__( 'Align right', 'blance' ) => 'right',
					__( 'Align center', 'blance' ) => 'center'
				),
				'description' => __( 'Select image alignment.', 'blance' )
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Content vertical alignment', 'blance' ),
				'param_name' => 'vertical_alignment',
				'value' => array(
					__( 'Top', 'blance' ) => '',
					__( 'Middle', 'blance' ) => 'middle',
					__( 'Bottom', 'blance' ) => 'bottom'
				)
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Hover effect', 'blance' ),
				'param_name' => 'hover',
				'value' => array(
					__( 'Default', 'blance' ) => '',
					__( 'Zoom image', 'blance' ) => '1',
					__( 'Bordered', 'blance' ) => '2',
					__( 'Content animation', 'blance' ) => '3',
					__( 'Translate and scale', 'blance' ) => '4',
				),
				'description' => __( 'Set beautiful hover effects for your banner.', 'blance' )
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Content style', 'blance' ),
				'param_name' => 'style',
				'value' => array(
					__( 'Default', 'blance' ) => '',
					__( 'Color mask', 'blance' ) => '2',
					__( 'Mask with border', 'blance' ) => '3',
					__( 'Content with line background', 'blance' ) => '1',
					__( 'Content with rectangular background', 'blance' ) => '5',
					//__( 'Style 4', 'blance' ) => '4',
					//__( 'Style 5', 'blance' ) => '5',
				),
				'description' => __( 'You can use some of our predefined styles for your banner content.', 'blance' )
			),
			blance_get_color_scheme_param(),
			array(
				'type' => 'textfield',
				'heading' => __( 'Extra class name', 'blance' ),
				'param_name' => 'el_class',
				'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'blance' )
			)
		));
	}
}

if( ! function_exists( 'blance_get_instagram_params' ) ) {
	function blance_get_instagram_params() {
		return apply_filters( 'blance_get_instagram_params', array(
			array(
				'type' => 'textfield',
				'heading' => __( 'Title', 'blance' ),
				'param_name' => 'title',
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Username', 'blance' ),
				'param_name' => 'username',
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Number of photos', 'blance' ),
				'param_name' => 'number',
			),
            array(
					'type' => 'dropdown',
					'heading' => __( 'Slides per view', 'blance' ),
					'param_name' => 'slides_per_view',
					'value' => array(
						1,2,3,4,5,6,7,8
					),
					'description' => __( 'Set numbers of slides you want to display at the same time on slider\'s container for carousel mode. Also supports for "auto" value, in this case it will fit slides depending on container\'s width. "auto" mode doesn\'t compatible with loop mode.', 'blance' )
				),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Photo size', 'blance' ),
				'param_name' => 'size',
				'value' => array(
					__( 'Thumbnail', 'blance' ) => 'thumbnail',
    	           __( 'Medium', 'blance' ) => 'medium',
					__( 'Large', 'blance' ) => 'large',
				),
			),
		));
	}
}

// A must for container functionality, replace Wbc_Item with your base name from mapping for parent container
if(class_exists('WPBakeryShortCodesContainer')){
    class WPBakeryShortCode_testimonials extends WPBakeryShortCodesContainer {
 
    }
}
 
// Replace Wbc_Inner_Item with your base name from mapping for nested element
if(class_exists('WPBakeryShortCode')){
    class WPBakeryShortCode_testimonial extends WPBakeryShortCode {
 
    }
}

if(class_exists('WPBakeryShortCodesContainer')){
    class WPBakeryShortCode_banners_carousel extends WPBakeryShortCodesContainer {
 
    }
}

// A must for container functionality, replace Wbc_Item with your base name from mapping for parent container
if(class_exists('WPBakeryShortCodesContainer')){
    class WPBakeryShortCode_pricing_tables extends WPBakeryShortCodesContainer {
 
    }
}
 
// Replace Wbc_Inner_Item with your base name from mapping for nested element
if(class_exists('WPBakeryShortCode')){
    class WPBakeryShortCode_pricing_plan extends WPBakeryShortCode {
 
    }
}

// A must for container functionality, replace Wbc_Item with your base name from mapping for parent container
if(class_exists('WPBakeryShortCodesContainer')){
    class WPBakeryShortCode_products_tabs extends WPBakeryShortCodesContainer {
 
    }
}
 
// Replace Wbc_Inner_Item with your base name from mapping for nested element
if(class_exists('WPBakeryShortCode')){
    class WPBakeryShortCode_products_tab extends WPBakeryShortCode {
 
    }
}

// A must for container functionality, replace Wbc_Item with your base name from mapping for parent container
if(class_exists('WPBakeryShortCodesContainer')){
    class WPBakeryShortCode_blance_carousel extends WPBakeryShortCodesContainer {}
}
 
// Replace Wbc_Inner_Item with your base name from mapping for nested element
if(class_exists('WPBakeryShortCode')){
    class WPBakeryShortCode_blance_carousel_item extends WPBakeryShortCode {}
}


// A must for container functionality, replace Wbc_Item with your base name from mapping for parent container
if(class_exists('WPBakeryShortCodesContainer')){
    class WPBakeryShortCode_blance_google_map extends WPBakeryShortCodesContainer {
 
    }
}