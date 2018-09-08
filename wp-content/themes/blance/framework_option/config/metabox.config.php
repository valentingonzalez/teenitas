<?php if ( ! defined( 'ABSPATH' ) ) { die; } // Cannot access pages directly.
// ===============================================================================================
// -----------------------------------------------------------------------------------------------
// METABOX OPTIONS
// -----------------------------------------------------------------------------------------------
// ===============================================================================================
$options = array();

if ( isset( $_GET['post'] ) && $_GET['post'] == get_option( 'page_for_posts' ) ) return;

// -----------------------------------------
// Page Metabox Options                    -
// -----------------------------------------
$options[] = array(
	'id'        => '_custom_page_options',
	'title'     => esc_html__( 'Page Layout Options','blance'),
	'post_type' => 'page',
	'context'   => 'normal',
	'priority'  => 'high',
	'sections'  => array(
		array(
			'name'  => 's1',
			'fields' => array(
                	array(
        			'id'    => 'header-layout',
        			'type'  => 'image_select',
        			'title' => esc_html__( 'Layout Header', 'blance' ),
        			'radio' => true,
        			'options' => array(
        				'1' => CS_URI . '/assets/images/layout/Header-1.jpg',
        				'2' => CS_URI . '/assets/images/layout/Header-2.jpg',
        				'3' => CS_URI . '/assets/images/layout/Header-4.jpg',
        				'4' => CS_URI . '/assets/images/layout/Header-3.jpg',
        			),
        			'default'    => '3',
        			'attributes' => array(
        				'data-depend-id' => 'header-layout',
        			),
        		),
                	array(
        			'id'    => 'footer-layout',
        			'type'  => 'image_select',
        			'title' => esc_html__( 'Layout Footer', 'blance' ),
        			'radio' => true,
        			'options' => array(
        				'1' => CS_URI . '/assets/images/layout/Footer-1.jpg',
				        '2' => CS_URI . '/assets/images/layout/Footer-2.jpg',
        			),
        			'default'    => '1',
        			'attributes' => array(
        				'data-depend-id' => 'footer-layout',
        			),
        		),
			),
		),
	),
);

// -----------------------------------------
// Post Metabox Options                    -
// -----------------------------------------

// -----------------------------------------
// Product Metabox Options                    -
// -----------------------------------------
$attributes = array();
	if ( function_exists( 'wc_get_attribute_taxonomies' ) ) {
	$attributes_tax = wc_get_attribute_taxonomies();
	foreach ( $attributes_tax as $attribute ) {
	$attributes[ $attribute->attribute_name ] = $attribute->attribute_label;	
	}
}	
$options[] = array(
	'id'        => '_custom_wc_options',
	'title'     => esc_html__( 'Product Detail Layout Options', 'blance'),
	'post_type' => 'product',
	'context'   => 'normal',
	'priority'  => 'high',
	'sections'  => array(
		array(
			'name'  => 's2',
			'fields' => array(
				array(
					'id'    => 'wc-single-style',
					'type'  => 'image_select',
					'title' => esc_html__( 'Product Detail Style', 'blance' ),
					'options' => array(
						    '1' => CS_URI . '/assets/images/layout/thumbnail-bottom.jpg',
							'2' => CS_URI . '/assets/images/layout/layout-1.jpg',
							'3' => CS_URI . '/assets/images/layout/layout-2.jpg',
							'4' => CS_URI . '/assets/images/layout/layout-3.jpg',
					),
				),
				array(
					   'id'      => 'wc-thumbnail-position',
						'type'    => 'image_select',
					       'title'      => esc_html__( 'Thumbnail Position', 'blance' ),
                            'options' => array(
                            'left'    => CS_URI . '/assets/images/layout/thumbnail-left.jpg',
							'bottom'  => CS_URI . '/assets/images/layout/thumbnail-bottom-right-sidebar.jpg',
							'right'   => CS_URI . '/assets/images/layout/thumbnail-right.jpg',
							'outside' => CS_URI . '/assets/images/layout/thumbnail-outside.jpg',
						),
						'default'    => 'left',
						'dependency' => array( 'wc-single-style_1', '==', true ),
				),
                	array(
						'id'      => 'enble-sidebar',
						'type'    => 'switcher',
						'title'   => esc_html__( 'Enble sidebar', 'blance' ),
						'default' => false,
                        'dependency' => array( 'wc-single-style_1', '==', true ),
					),
                    array(
						'id'         => 'wc-sidebar-detail',
						'type'       => 'select',
                        'options'    => jws_get_sidebars(),
						'title'      => esc_html__( 'Select Sidebar', 'blance' ),
						'dependency' => array( 'enble-sidebar', '==', true ),
					),
				array(
					'id'         => 'wc-single-video-url',
					'type'       => 'text',
					'title'      => esc_html__( 'Video Thumbnail Link', 'blance' ),
				),
				array(
					'title' => esc_html__( 'Size Guide Image','blance'),
					'id'    => 'wc-single-size-guide',
					'type'  => 'upload',
				),
                array(
					'title' => esc_html__( 'Banner Product','blance'),
					'id'    => 'wc-single-banner',
					'type'  => 'upload',
				),
                array(
					'title' => esc_html__( 'Link Banner','blance'),
					'id'    => 'wc-single-banner-link',
					'type'  => 'text',
				),
                array(
                  'id'          => 'gallery_2',
                  'type'        => 'gallery',
                  'title'       => 'Image 360',
                  'add_title'   => 'Add Images',
                  'edit_title'  => 'Edit Images',
                  'clear_title' => 'Remove Images',
                ),
                array(
					'id'         => 'wc-count-down',
					'type'       => 'text',
					'title'      => esc_html__( 'Add time count down for product  example: 2018/12/12 ', 'blance' ),
				),
                array(
						'id'      => 'wc-attr',
						'type'    => 'checkbox',
						'title'   => esc_html__( 'Enable Products Attribute On Product List', 'blance' ),
						'options' => $attributes,
				),
                array(
                          'id'       => 'shipping-tabs',
                          'type'     => 'wysiwyg',
                          'title'    => 'Tabs Shiping',
                ),	
               	array(
					'id'      => 'wc-thumbnail-size',
					'type'    => 'switcher',
					'title'   => esc_html__( 'Enable Large Thumbnail', 'blance' ),
					'desc'    => esc_html__( 'Apply for Product Layout Metro only', 'blance' ),
					'default' => false
				),
			),
		),
	),
);
// -----------------------------------------
// Product Metabox Options                    -
// -----------------------------------------
$options[] = array(
	'id'        => '_custom_post_options',
	'title'     => esc_html__( 'Post Detail Layout Options', 'blance'),
	'post_type' => 'post',
	'context'   => 'normal',
	'priority'  => 'high',
	'sections'  => array(
		array(
			'name'  => 's2',
			'fields' => array(
				array(
					'id'    => 'post-single-style',
					'type'  => 'image_select',
					'title' => esc_html__( 'Post Detail Style', 'blance' ),
					'info'  => sprintf( __( 'Change layout for only this post. You can setup global for all post page layout', 'blance' ), esc_url( admin_url( 'admin.php?page=jws-theme-options' ) ) ),
					'options' => array(
						  '1'  => CS_URI . '/assets/images/layout/left-sidebar.jpg',
							'2'    => CS_URI . '/assets/images/layout/3-col.jpg',
							'3' => CS_URI . '/assets/images/layout/right-sidebar.jpg',
					),
				),
			),
		),
	),
);
// -----------------------------------------
// Product Metabox Options                    -
// -----------------------------------------
$options[] = array(
	'id'        => '_custom_pp_options',
	'title'     => esc_html__( 'Portfolio Detail Layout Options', 'blance'),
	'post_type' => 'portfolio',
	'context'   => 'normal',
	'priority'  => 'high',
	'sections'  => array(
		array(
			'name'  => 's2',
			'fields' => array(
            array(
    			'id'       => 'sub-content',
    			'type'     => 'textarea',
    			'title'    => esc_html__( 'Description on dowm title ', 'blance' ),
    			'desc'     => esc_html__( 'Add content here', 'blance' ),
    			'sanitize' => 'html'
    		),
            array(
    			'id'       => 'shortcode-before-ft',
    			'type'     => 'textarea',
    			'title'    => esc_html__( 'Add content before footer ', 'blance' ),
    			'sanitize' => 'html'
    		)  ,     
             array(
					'id'      => 'enable-sidebar',
					'type'    => 'switcher',
					'title'   => esc_html__( 'Enable Sidebar', 'blance' ),
					'default' => false
				), 
            array(
					'id'      => 'wc-thumbnail-size',
					'type'    => 'switcher',
					'title'   => esc_html__( 'Enable Large Thumbnail', 'blance' ),
					'desc'    => esc_html__( 'Apply for Product Layout Metro only', 'blance' ),
					'default' => false
				),      
			),
		),
	),
);
CSFramework_Metabox::instance( $options );
