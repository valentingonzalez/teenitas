<?php if ( ! defined( 'ABSPATH' ) ) { die; } // Cannot access pages directly.
// ===============================================================================================
// -----------------------------------------------------------------------------------------------
// FRAMEWORK SETTINGS
// -----------------------------------------------------------------------------------------------
// ===============================================================================================
$settings = array(
	'menu_title'     => esc_html__( 'Theme Options', 'blance' ),
	'menu_parent'    => 'jws',
	'menu_type'      => 'menu',
	'menu_slug'      => 'jws-theme-options',
	'show_reset_all' => true,
	'ajax_save'      => true
);



// ===============================================================================================
// -----------------------------------------------------------------------------------------------
// FRAMEWORK OPTIONS
// -----------------------------------------------------------------------------------------------
// ===============================================================================================
$options = array();

// ----------------------------------------
// a option section for options layout    -
// ----------------------------------------
$options[] = array(
	'name'  => 'layout',
	'title' => esc_html__( 'Blance General Setting', 'blance' ),
	'icon'  => 'fa fa-newspaper-o',
	'fields' => array(
        array(
        	'id'      => 'golobal-enable-less',
        	'type'    => 'switcher',
        	'title'   => esc_html__( 'Enable Less For Theme', 'blance' ),
        	'default' =>  false,
        	),
         array(
        	'id'      => 'golobal-enable-page-title',
        	'type'    => 'switcher',
        	'title'   => esc_html__( 'Enable Page Titlebar', 'blance' ),
        	'default' =>  true,
        	),
            
         array(
        	'id'         => 'golobal-enable-page-title-bg',
        	'type'       => 'background',
        	'title'      => esc_html__( 'Page Titlebar Background', 'blance' ),
            'dependency' => array( 'golobal-enable-page-title', '==', true ),
        	),
	),
);


// ----------------------------------------
// a option section for options rr    -
// ----------------------------------------
$options[] = array(
	'name'  => 'header',
	'title' => esc_html__( 'Blance Header', 'blance' ),
	'icon'  => 'fa fa-header',
	'fields' => array(
		array(
			'id'    => 'header-layout',
			'type'  => 'image_select',
			'title' => esc_html__( 'Layout', 'blance' ),
			'radio' => true,
			'options' => array(
				'1' => CS_URI . '/assets/images/layout/Header-1.jpg',
				'2' => CS_URI . '/assets/images/layout/Header-2.jpg',
				'3' => CS_URI . '/assets/images/layout/Header-4.jpg',
				'4' => CS_URI . '/assets/images/layout/Header-3.jpg',
			),
			'default'    => '4',
			'attributes' => array(
				'data-depend-id' => 'header-layout',
			),
		),
	   array(
      'id'        => 'logo_st',
      'type'      => 'fieldset',
      'title'     => 'Logo And Favicon Setting',
      'un_array'  => true,
      'fields'    => array(
		array(
			'id'        => 'logo',
			'type'      => 'image',
			'title'     => esc_html__( 'Logo', 'blance' ),
			'add_title' => esc_html__( 'Add Logo', 'blance' ),
		),
        array(
			'id'        => 'favicon',
			'type'      => 'image',
			'title'     => esc_html__( 'Favicon Icon', 'blance' ),
			'add_title' => esc_html__( 'Add Favicon', 'blance' ),
		),
		array(
			'id'      => 'logo-max-width',
			'type'    => 'text',
			'title'   => esc_html__( 'Logo Width', 'blance' ),
			'default' => 135,
			'desc'    => esc_html__( 'Defined in pixels. Do not add the \'px\' unit.', 'blance' ),
		),
        array(
			'id'      => 'logo-light-height',
			'type'    => 'text',
			'title'   => esc_html__( 'Logo Line Height', 'blance' ),
			'default' => 80,
			'desc'    => esc_html__( 'Defined in pixels. Do not add the \'px\' unit.', 'blance' ),
		),
         array(
			'id'      => 'right-header-light-height',
			'type'    => 'text',
			'title'   => esc_html__( 'Right Header Height', 'blance' ),
			'default' => 80,
			'desc'    => esc_html__( 'Defined in pixels. Do not add the \'px\' unit.', 'blance' ),
		),
        )),
         array(
      'id'        => 'header_st',
      'type'      => 'fieldset',
      'title'     => 'Header Top Settings',
      'un_array'  => true,
      'fields'    => array(
		array(
			'id'         => 'header-top-left',
			'type'       => 'textarea',
			'title'      => esc_html__( 'Header left', 'blance' ),
			'desc'    => esc_html__( 'Add Html Or Shortcode Here', 'blance' ).'<p><a target="_blank" href="'.esc_url(  admin_url('/edit.php?post_type=visual_content') ).'">Link Content Shortcode</a></p>',
		),
		array(
			'id'         => 'header-top-center',
			'type'       => 'textarea',
			'title'      => esc_html__( 'Header center', 'blance' ),
			'desc'    => esc_html__( 'Add Html Or Shortcode Here', 'blance' ).'<p><a target="_blank" href="'.esc_url(  admin_url('/edit.php?post_type=visual_content') ).'">Link Content Shortcode</a></p>',
		),
		array(
			'id'         => 'header-top-right',
			'type'       => 'textarea',
			'title'      => esc_html__( 'Header right', 'blance' ),
			'desc'    => esc_html__( 'Add Html Or Shortcode Here', 'blance' ).'<p><a target="_blank" href="'.esc_url(  admin_url('/edit.php?post_type=visual_content') ).'">Link Content Shortcode</a></p>',
		),
        array(
			'id'         => 'cart-shipping',
			'type'       => 'text',
			'title'      => esc_html__( 'Add text shipping in here', 'blance' ),
		),
        array(
			'id'         => 'cart-shipping-emtry',
			'type'       => 'text',
			'title'      => esc_html__( 'Add text shipping emtry in here', 'blance' ),
		),
        )),
	),
);

// ----------------------------------------
// a option section for options footer    -
// ----------------------------------------
$options[] = array(
	'name'  => 'footer',
	'title' => esc_html__( 'Blance Footer', 'blance' ),
	'icon'  => 'fa fa-copyright',
	'fields' => array(
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
		array(
			'id'      => 'footer-copyright',
			'type'    => 'textarea',
			'title'   => esc_html__( 'Copyright Text', 'blance' ),
			'desc'    => esc_html__( 'Add Html Or Shortcode Here', 'blance' ).'<p><a target="_blank" href="'.esc_url(  admin_url('/edit.php?post_type=visual_content') ).'">Link Content Shortcode</a></p>',
			'default' => sprintf( wp_kses_post( 'Copyright @ Blance 2018. All Right Reserved.', 'blance' ), esc_url( home_url() ) )
		),
	),
);





// ----------------------------------------
// a option section for options typography-
// ----------------------------------------
$options[] = array(
	'name'  => 'typography',
	'title' => esc_html__( 'Blance Typography', 'blance' ),
	'icon'  => 'fa fa-font',
	'fields' => array(
    array(
      'id'        => 'font_family',
      'type'      => 'fieldset',
      'title'     => 'Blance Font Family',
      'un_array'  => true,
      'fields'    => array(
		array(
			'id'        => 'body-font',
			'type'      => 'typography',
			'title'     => esc_html__( 'Font Body Family', 'blance' ),
			'default'   => array(
				'family'  => 'Poppins',
				'font'    => 'google',
				'variant' => 'regular',
			),
		),
        array(
			'id'        => 'body-font-2',
			'type'      => 'typography',
			'title'     => esc_html__( 'Font Second Family', 'blance' ),
			'default'   => array(
				'family'  => 'Sacramento',
				'font'    => 'google',
				'variant' => 'regular',
			),
		),
        	array(
			'id'        => 'heading-font',
			'type'      => 'typography',
			'title'     => esc_html__( 'Font Heading Family', 'blance' ),
			'default'   => array(
				'family'  => 'Poppins',
				'font'    => 'google',
				'variant' => '600',
			),
		),
		)),
         array(
      'id'        => 'font_color',
      'type'      => 'fieldset',
      'title'     => 'Blance Font Size',
      'un_array'  => true,
      'fields'    => array(
        array(
			'id'      => 'body-font-size',
			'type'    => 'number',
			'title'   => esc_html__( 'Body', 'blance' ),
			'after'   => ' <i class="cs-text-muted">px</i>',
			'default' => 14
		),
		array(
			'id'      => 'h1-font-size',
			'type'    => 'number',
			'title'   => esc_html__( 'H1', 'blance' ),
			'after'   => ' <i class="cs-text-muted">px</i>',
			'default' => '48'
		),
		array(
			'id'      => 'h2-font-size',
			'type'    => 'number',
			'title'   => esc_html__( 'H2', 'blance' ),
			'after'   => ' <i class="cs-text-muted">px</i>',
			'default' => '36'
		),
		array(
			'id'      => 'h3-font-size',
			'type'    => 'number',
			'title'   => esc_html__( 'H3', 'blance' ),
			'after'   => ' <i class="cs-text-muted">px</i>',
			'default' => '24'
		),
		array(
			'id'      => 'h4-font-size',
			'type'    => 'number',
			'title'   => esc_html__( 'H4', 'blance' ),
			'after'   => ' <i class="cs-text-muted">px</i>',
			'default' => '21'
		),
		array(
			'id'      => 'h5-font-size',
			'type'    => 'number',
			'title'   => esc_html__( 'H5', 'blance' ),
			'after'   => ' <i class="cs-text-muted">px</i>',
			'default' => '18'
		),
		array(
			'id'      => 'h6-font-size',
			'type'    => 'number',
			'title'   => esc_html__( 'H6', 'blance' ),
			'after'   => ' <i class="cs-text-muted">px</i>',
			'default' => '16'
		),
        )),
	),
);

// ------------------------------------------
// a option section for options color_scheme-
// ------------------------------------------
$options[] = array(
	'name'  => 'color_scheme',
	'title' => esc_html__( 'Blance Color Theme', 'blance' ),
	'icon'  => 'fa fa-paint-brush',
	'fields' => array(
        
     array(
      'id'        => 'main-color',
      'type'      => 'fieldset',
      'title'     => 'Main Color',
      'un_array'  => true,
      'fields'    => array(
      
		array(
			'id'      => 'primary-color',
			'type'    => 'color_picker',
			'title'   => esc_html__( 'Primary Color', 'blance' ),
			'desc'    => esc_html__( 'Main Color Scheme', 'blance' ),
			'default' => '#252525',
		),
		array(
			'id'      => 'secondary-color',
			'type'    => 'color_picker',
			'title'   => esc_html__( 'Secondary Color', 'blance' ),
			'desc'    => esc_html__( 'Secondary Color Scheme', 'blance' ),
			'default' => '#222',
		),
        array(
			'id'      => 'three-color',
			'type'    => 'color_picker',
			'title'   => esc_html__( 'Three Color', 'blance' ),
			'desc'    => esc_html__( 'Three Color Scheme', 'blance' ),
			'default' => '#878787',
		),
        array(
			'id'      => 'four-color',
			'type'    => 'color_picker',
			'title'   => esc_html__( 'Four Color', 'blance' ),
			'desc'    => esc_html__( 'Four Color Scheme', 'blance' ),
			'default' => '#39b54a',
		),
        array(
			'id'      => 'five-color',
			'type'    => 'color_picker',
			'title'   => esc_html__( 'Five Color', 'blance' ),
			'desc'    => esc_html__( 'Five Color Scheme', 'blance' ),
			'default' => '#38c2b8',
		),
      
      
      ) ),
            
        
	 array(
      'id'        => 'section-color',
      'type'      => 'fieldset',
      'title'     => 'Body Color',
      'un_array'  => true,
      'fields'    => array(	
		array(
			'id'      => 'body-background-color',
			'type'    => 'color_picker',
			'title'   => esc_html__( 'Body Background Color', 'blance' ),
			'default' => '#ffffff',
		),
		array(
			'id'      => 'body-color',
			'type'    => 'color_picker',
			'title'   => esc_html__( 'Body Color', 'blance' ),
			'default' => '#878787',
		),
		array(
			'id'      => 'heading-color',
			'type'    => 'color_picker',
			'title'   => esc_html__( 'Heading Color', 'blance' ),
			'default' => '#252525',
		),
        )),
        
        
        	 array(
      'id'        => 'header-color',
      'type'      => 'fieldset',
      'title'     => 'Header Color',
      'un_array'  => true,
      'fields'    => array(	

		array(
			'id'    => 'header-background',
			'type'  => 'color_picker',
			'title' => esc_html__( 'Header Background Color', 'blance' ),
            'default' => '#ffffff',
		),
		array(
			'id'    => 'header-top-background',
			'type'  => 'color_picker',
			'title' => esc_html__( 'Header Top Background Color', 'blance' ),
            'default' => '#000000',
		),
		array(
			'id'    => 'header-top-color',
			'type'  => 'color_picker',
			'title' => esc_html__( 'Header Top Color', 'blance' ),
			'default' => '#878787',
		),



        )),
        
        
    
        
        array(
      'id'        => 'menu-color',
      'type'      => 'fieldset',
      'title'     => 'Menu Color',
      'un_array'  => true,
      'fields'    => array(	
		array(
			'id'    => 'top_menu',
			'type'  => 'color_picker',
			'title' => esc_html__( 'Top Menu Color', 'blance' ),
            'default' => '#464646',
		),
		array(
			'id'    => 'sub_menu',
			'type'  => 'color_picker',
			'title' => esc_html__( 'Sub Color', 'blance' ),
            'default' => '#959595',
		),
        )),
         array(
      'id'        => 'footer-color',
      'type'      => 'fieldset',
      'title'     => 'Footer Color',
      'un_array'  => true,
      'fields'    => array(	
		array(
			'id'      => 'footer-background',
			'type'    => 'color_picker',
			'title'   => esc_html__( 'Footer Background Color', 'blance' ),
			'default' => '#000000'
		),
        array(
			'id'      => 'footer-bottom-background',
			'type'    => 'color_picker',
			'title'   => esc_html__( 'Footer Bottom Background Color', 'blance' ),
			'default' => '#ffffff'
		),
        array(
			'id'      => 'footer-heading-color',
			'type'    => 'color_picker',
			'title'   => esc_html__( 'Footer Heading Color', 'blance' ),
			'default' => '#ffffff'
		),
         array(
			'id'      => 'footer-bottom-color',
			'type'    => 'color_picker',
			'title'   => esc_html__( 'Footer Bottom Color', 'blance' ),
			'default' => '#252525'
		),
		array(
			'id'      => 'footer-color',
			'type'    => 'color_picker',
			'title'   => esc_html__( 'Footer Primary Color', 'blance' ),
			'default' => '#878787'
		),
		array(
			'id'      => 'footer-link-color',
			'type'    => 'color_picker',
			'title'   => esc_html__( 'Footer Link Color', 'blance' ),
			'default' => '#878787'
		),
		array(
			'id'      => 'footer-link-hover-color',
			'type'    => 'color_picker',
			'title'   => esc_html__( 'Footer Link Hover Color', 'blance' ),
			'default' => '#252525'
		),
        )),
	),
);
// ----------------------------------------
// a option section for 404    -
// ----------------------------------------
$options[] = array(
	'name'  => '404',
	'title' => esc_html__( '404 Page', 'blance' ),
	'icon'  => 'fa fa-globe',
	'fields' => array(
       
				array(
                  'id'        => 'image_404',
                  'type'      => 'image',
                  'title'     => 'Image Background 404',
                  'add_title' => 'Add Image 404',
                ),
		
	),
);
// ----------------------------------------
// a option section for options woocommerce-
// ----------------------------------------
if ( class_exists( 'WooCommerce' ) ) {
	$attributes = array();
	$attributes_tax = wc_get_attribute_taxonomies();
	foreach ( $attributes_tax as $attribute ) {
		$attributes[ $attribute->attribute_name ] = $attribute->attribute_label;
	}
	$options[]  = array(
		'name'  => 'woocommerce',
		'title' => esc_html__( 'Blance Shop', 'blance' ),
		'icon'  => 'fa fa-shopping-cart',
		'sections' => array(



			// Product Listing Setting
			array(
				'name'   => 'wc_list_setting',
				'title'  => esc_html__( 'Shop Page', 'blance' ),
				'icon'   => 'fa fa-minus',
				'fields' => array(
					array(
						'type'    => 'heading',
						'content' => esc_html__( 'Shop Page Setting', 'blance' ),
					),
                      array(
                      'id'        => 'woo_title_bar',
                      'type'      => 'fieldset',
                      'title'     => 'Title Bar',
                      'un_array'  => true,
                      'fields'    => array(
    	           array(
						'id'      => 'wc-enable-page-title',
						'type'    => 'switcher',
						'title'   => esc_html__( 'Enable Page Title', 'blance' ),
						'default' =>  true,
					),
					array(
						'id'         => 'wc-pagehead-bg',
						'type'       => 'background',
						'title'      => esc_html__( 'Page Title Background', 'blance' ),
						'dependency' => array( 'wc-enable-page-title', '==', true ),
					),
                    )),
					array(
                      'id'        => 'woo_layout',
                      'type'      => 'fieldset',
                      'title'     => 'Layout',
                      'un_array'  => true,
                      'fields'    => array(
					array(
						'id'    => 'wc-style',
						'type'  => 'image_select',
						'title' => esc_html__( 'Layout', 'blance' ),
						'desc'  => esc_html__( 'Display product listing as grid or masonry or metro', 'blance' ),
						'radio' => true,
						'options' => array(
							'grid'    => CS_URI . '/assets/images/layout/left-sidebar.jpg',
							'masonry' => CS_URI . '/assets/images/layout/masonry-2.jpg',
							'metro'   => CS_URI . '/assets/images/layout/masonry-1.jpg'
						),
						'default' => 'grid',
					),
                    array(
						'id'    => 'wc-layout',
						'type'  => 'image_select',
						'title' => esc_html__( 'Sidebar Or Non Sidebar', 'blance' ),
						'radio' => true,
						'options' => array(
							'left-sidebar'  => CS_URI . '/assets/images/layout/left-sidebar.jpg',
							'no-sidebar'    => CS_URI . '/assets/images/layout/3-col.jpg',
							'right-sidebar' => CS_URI . '/assets/images/layout/right-sidebar.jpg',
						),
						'default' => 'no-sidebar'
					),
                    	array(
						'id'    => 'wc-column',
						'type'  =>'image_select',
						'title' => esc_html__( 'Number Column', 'blance' ),
						'desc'  => esc_html__( 'Display number of product per row', 'blance' ),
						'radio' => true,
						'options' => array(
							'6' => CS_URI . '/assets/images/layout/2-col.jpg',
							'4' => CS_URI . '/assets/images/layout/3-col.jpg',
							'3' => CS_URI . '/assets/images/layout/4-col.jpg',
                            '20' => CS_URI . '/assets/images/layout/5-col-wide.jpg',
							'2' => CS_URI . '/assets/images/layout/6-col-wide.jpg',
						),
						'default' => '4'
					),
                    array(
						'id'      => 'wc-layout-full',
						'type'    => 'switcher',
						'title'   => esc_html__( 'Enable Full-Width', 'blance' ),
						'default' => false,
					),
                    )),
                    array(
                      'id'        => 'woo_orther',
                      'type'      => 'fieldset',
                      'title'     => 'Orther Setting',
                      'un_array'  => true,
                      'fields'    => array(
					array(
						'id'         => 'wc-pagination',
						'type'       => 'select',
						'title'      => esc_html__( 'Pagination Style', 'blance' ),
						'options' => array(
							'number'   => esc_html__( 'Number', 'blance' ),
							'loadmore' => esc_html__( 'Load More', 'blance' ),
						),
						'default' => 'number'
					),
                    array(
						'id'      => 'wc-action-columns',
						'type'    => 'switcher',
						'title'   => esc_html__( 'On / Off Filter Columns', 'blance' ),
						'default' => false,
					),
					array(
                      'id'        => 'shop-column-filter',
                      'type'      => 'fieldset',
                      'title'     => 'Shop Columns Filter',
                      'dependency' => array( 'wc-action-columns', '==', true ),
                      'fields'    => array(
                       array(
						'id'      => 'wc-2',
						'type'    => 'switcher',
						'title'   => esc_html__( 'Turn On 2 columns', 'blance' ),
						'default' => false,
                        'dependency' => array( 'wc-action-columns', '==', true ),
					   ),
                       array(
						'id'      => 'wc-3',
						'type'    => 'switcher',
						'title'   => esc_html__( 'Turn On 3 columns', 'blance' ),
						'default' => false,
                        'dependency' => array( 'wc-action-columns', '==', true ),
					   ),
                       array(
						'id'      => 'wc-4',
						'type'    => 'switcher',
						'title'   => esc_html__( 'Turn On 4 columns', 'blance' ),
						'default' => false,
                        'dependency' => array( 'wc-action-columns', '==', true ),
					   ),
                       array(
						'id'      => 'wc-5',
						'type'    => 'switcher',
						'title'   => esc_html__( 'Turn On 5 columns', 'blance' ),
						'default' => false,
                        'dependency' => array( 'wc-action-columns', '==', true ),
					   ),
                       array(
						'id'      => 'wc-6',
						'type'    => 'switcher',
						'title'   => esc_html__( 'Turn On 6 columns', 'blance' ),
						'default' => false,
                        'dependency' => array( 'wc-action-columns', '==', true ),
					   ),
                    
                      ),
                    ),
                    array(
						'id'      => 'wc-action-filter',
						'type'    => 'switcher',
						'title'   => esc_html__( 'On / Off Filter Product', 'blance' ),
						'default' => false,
					),
                     array(
						'id'         => 'wc-filter-topbar-columns',
						'type'       => 'select',
                        'options'        => array(
                            '1'          => '1 Columns',
                            '2'     => '2 Columns',
                            '3'         => '3 Columns',
                            '4'         => '4 Columns',
                            '5'         => '5 Columns',
                            '6'         => '6 Columns',
                          ),
						'title'      => esc_html__( 'Select Sidebar', 'blance' ),
						'dependency' => array( 'wc-action-filter', '==', true ),
					),
					array(
						'id'      => 'wc-number-per-page',
						'type'    => 'number',
						'title'   => esc_html__( 'Per Page', 'blance' ),
						'desc'    => esc_html__( 'How much items per page to show (-1 to show all products)', 'blance' ),
						'default' => '12',
					),
					array(
						'id'         => 'wc-sidebar',
						'type'       => 'select',
                        'options'    => jws_get_sidebars(),
						'title'      => esc_html__( 'Select Sidebar', 'blance' ),
						'dependency' => array( 'wc-layout_no-sidebar', '==', false ),
					),
                    array(
						'id'      => 'wc-flip-thumb',
						'type'    => 'switcher',
						'title'   => esc_html__( 'Flip Product Thumbnail', 'blance' ),
						'default' => false,
					),
						array(
						'id'      => 'content-inner',
						'type'    => 'switcher',
						'title'   => esc_html__( 'Layout Content Inner', 'blance' ),
						'default' => false,
					),
					array(
						'id'      => 'wc-attr',
						'type'           => 'select',
						'title'   => esc_html__( 'Enable Products Attribute On Product List', 'blance' ),
						'options' => $attributes,
					),
                    )),
				)
			),
			// Product Detail Setting
			array(
				'name'   => 'wc_detail_setting',
				'title'  => esc_html__( 'Shop Single', 'blance' ),
				'icon'   => 'fa fa-minus',
				'fields' => array(
					array(
						'type'    => 'heading',
						'content' => esc_html__( 'Shop Single Setting', 'blance' ),
					),
                    array(
                      'id'        => 'woodt_title_bar',
                      'type'      => 'fieldset',
                      'title'     => 'Title Bar Setting',
                      'un_array'  => true,
                      'fields'    => array(
                     array(
						'id'      => 'wc-detail-enable-page-title',
						'type'    => 'switcher',
						'title'   => esc_html__( 'Enable Page Title', 'blance' ),
						'default' =>  false,
					),
                    array(
						'id'         => 'wc-pagehead-single-bg',
						'type'       => 'background',
						'title'      => esc_html__( 'Page Title Background', 'blance' ),
                        'dependency' => array( 'wc-detail-enable-page-title', '==', true ),
					),
                    )),
                    array(
                      'id'        => 'woodt_layout',
                      'type'      => 'fieldset',
                      'title'     => 'Layout Setting',
                      'un_array'  => true,
                      'fields'    => array(
					array(
						'id'      => 'wc-single-style',
						'type'    => 'image_select',
						'title'   => esc_html__( 'Shop Single Layout', 'blance' ),
						'radio'   => true,
						'options' => array(
							'1' => CS_URI . '/assets/images/layout/thumbnail-bottom.jpg',
							'2' => CS_URI . '/assets/images/layout/layout-1.jpg',
							'3' => CS_URI . '/assets/images/layout/layout-2.jpg',
							'4' => CS_URI . '/assets/images/layout/layout-3.jpg',
						),
						'default' => '1'
					),
                    array(
						'id'      => 'wc-thumbnail-position',
						'type'    => 'image_select',
					       'title'      => esc_html__( 'Thumbnail Gallery Position', 'blance' ),
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
						'id'      => 'wc-detail-full',
						'type'    => 'switcher',
						'title'   => esc_html__( 'Enable Full Width', 'blance' ),
						'default' => false,
					),

                    )),
                     array(
                      'id'        => 'woodt_orther',
                      'type'      => 'fieldset',
                      'title'     => 'Orther Setting',
                      'un_array'  => true,
                      'fields'    => array(
						array(
						'id'      => 'enble-sidebar',
						'type'    => 'switcher',
						'title'   => esc_html__( 'Enble sidebar', 'blance' ),
						'default' => false,
                        'dependency' => array( 'wc-single-style_1', '==', true ),
					),
					array(
						'type'    => 'subheading',
						'content' => esc_html__( 'Other', 'blance' ),
					),
					array(
						'id'    => 'wc-single-size-guide',
						'title' => esc_html__( 'Size Guide Default', 'blance' ),
						'type'  => 'upload',
					),
                    array(
						'id'    => 'wc-single-banner',
						'title' => esc_html__( 'Banner Product', 'blance' ),
						'type'  => 'upload',
					),
                    array(
					'title' => esc_html__( 'Link Banner','blance'),
					'id'    => 'wc-single-banner-link',
					'type'  => 'text',
					'info'  => sprintf( __( 'Add Link banner', 'blance' ), esc_url( admin_url( 'admin.php?page=jws-theme-options' ) ) ),
				    ),
                    array(
						'id'    => 'wc-shortcode-title',
						'title' => esc_html__( 'Add Content title Product Related', 'blance' ),
						'type'  => 'textarea',
						'desc'    => esc_html__( 'Add Html Or Shortcode Here', 'blance' ).'<p><a target="_blank" href="'.esc_url(  admin_url('/edit.php?post_type=visual_content') ).'">Link Content Shortcode</a></p>',
					),
					array(
                          'id'       => 'shipping-tabs',
                          'type'     => 'wysiwyg',
                          'title'    => 'Tabs Shiping',
                          'desc'    => esc_html__( 'Add Html Or Shortcode Here', 'blance' ).'<p><a target="_blank" href="'.esc_url(  admin_url('/edit.php?post_type=visual_content') ).'">Link Content Shortcode</a></p>',
                        ),
                        )),	
				)
			),
		),
	);
}

// ----------------------------------------
// a option section for options portfolio-
// ----------------------------------------
	$options[]  = array(
		'name'  => 'portfolio',
		'title' => esc_html__( 'portfolio', 'blance' ),
		'icon'  => 'fa fa-user-plus',
		'sections' => array(

			// General Setting
			array(
				'name'   => 'pp_general_setting',
				'title'  => esc_html__( 'General Setting', 'blance' ),
				'icon'   => 'fa fa-minus',
				'fields' => array(
					array(
						'type'    => 'heading',
						'content' => esc_html__( 'General Setting', 'blance' ),
					),
					array(
						'id'      => 'pp-enable-page-title',
						'type'    => 'switcher',
						'title'   => esc_html__( 'Enable Page Title', 'blance' ),
						'default' => true,
					),
					array(
						'id'         => 'pp-pagehead-bg',
						'type'       => 'background',
						'title'      => esc_html__( 'Page Title Background', 'blance' ),
						'dependency' => array( 'pp-enable-page-title', '==', true ),
					),
				)
			),

			// Portfolio Listing Setting
			array(
				'name'   => 'pp_list_setting',
				'title'  => esc_html__( 'Archive Setting', 'blance' ),
				'icon'   => 'fa fa-minus',
				'fields' => array(
					array(
						'type'    => 'heading',
						'content' => esc_html__( 'Archive Setting', 'blance' ),
					),
					array(
						'id'    => 'pp-style',
						'type'  => 'image_select',
						'title' => esc_html__( 'Style', 'blance' ),
						'desc'  => esc_html__( 'Display Portfolio listing as grid or masonry or metro', 'blance' ),
						'radio' => true,
						'options' => array(
							'grid'    => CS_URI . '/assets/images/layout/3-col.jpg',
							'masonry' => CS_URI . '/assets/images/layout/masonry-2.jpg',
							'metro'   => CS_URI . '/assets/images/layout/masonry-1.jpg'
						),
						'default' => 'grid',
					),
					array(
						'id'    => 'pp-column',
						'type'  =>'image_select',
						'title' => esc_html__( 'Number Of Column', 'blance' ),
						'desc'  => esc_html__( 'Display number of portfolio per row', 'blance' ),
						'radio' => true,
						'options' => array(
							'6' => CS_URI . '/assets/images/layout/2-col.jpg',
							'4' => CS_URI . '/assets/images/layout/3-col.jpg',
							'3' => CS_URI . '/assets/images/layout/4-col.jpg',
                            '20' => CS_URI . '/assets/images/layout/5-col-wide.jpg',
							'2' => CS_URI . '/assets/images/layout/6-col-wide.jpg',
						),
						'default' => '4'
					),
                    array(
						'id'      => 'pp-layout-full',
						'type'    => 'switcher',
						'title'   => esc_html__( 'Enable Full-Width', 'blance' ),
						'default' => false,
					),
					array(
						'id'      => 'pp-number-per-page',
						'type'    => 'number',
						'title'   => esc_html__( 'Per Page', 'blance' ),
						'desc'    => esc_html__( 'How much items per page to show (-1 to show all Portfolio)', 'blance' ),
						'default' => '12',
					),
				)
			),
		),
	);

// ----------------------------------------
// a option section for options blog      -
// ----------------------------------------
$options[] = array(
	'name'  => 'blog',
	'title' => esc_html__( 'Blog Single', 'blance' ),
	'icon'  => 'fa fa-id-card',
	'fields' => array(
        array(
        	'id'      => 'post-single-style',
        	'type'    => 'image_select',
        	'title'   => esc_html__( 'Post Detail Style', 'blance' ),
        	'radio'   => true,
        	'options' => array(
        	'1' => CS_URI . '/assets/images/layout/left-sidebar.jpg',
        	'2' => CS_URI . '/assets/images/layout/3-col.jpg',
        	'3' => CS_URI . '/assets/images/layout/right-sidebar.jpg',
        	),
        	'default' => '1'
        	),
		array(
			'id'      => 'blog-thumbnail',
			'type'    => 'switcher',
			'title'   => esc_html__( 'Enable Blog Thumbnail', 'blance' ),
			'default' => false,
		),
        array(
			'id'      => 'blog-title',
			'type'    => 'switcher',
			'title'   => esc_html__( 'Enable Blog title', 'blance' ),
			'default' => false,
		),
        array(
			'id'      => 'blog-meta',
			'type'    => 'switcher',
			'title'   => esc_html__( 'Enable Blog Meta ', 'blance' ),
			'default' => false,
		),
        array(
			'id'      => 'blog-tag',
			'type'    => 'switcher',
			'title'   => esc_html__( 'Enable Blog Tags ', 'blance' ),
			'default' => false,
		),
        array(
			'id'      => 'blog-social',
			'type'    => 'switcher',
			'title'   => esc_html__( 'Enable Blog Social ', 'blance' ),
			'default' => false,
		),
        array(
			'id'      => 'blog-author',
			'type'    => 'switcher',
			'title'   => esc_html__( 'Enable Blog Author ', 'blance' ),
			'default' => false,
		),
        array(
			'id'      => 'blog-related',
			'type'    => 'switcher',
			'title'   => esc_html__( 'Enable Blog Post Related ', 'blance' ),
			'default' => false,
		),
		array(
			'id'         => 'blog-sidebar',
			'type'       => 'select',
            'options'    => jws_get_sidebars(),
			'title'      => esc_html__( 'Select Sidebar', 'blance' ),
		),
        array(
		'id'    => 'blog-content-before-footer',
		'title' => esc_html__( 'Add Content Before Footer', 'blance' ),
		'type'  => 'textarea',
		'desc'  => esc_html__( 'Your please add content for page before footer', 'blance' ),
		),	
	),
);
// ------------------------------
// backup                       -
// ------------------------------
$options[]   = array(
	'name'     => 'backup_section',
	'title'    => 'Backup',
	'icon'     => 'fa fa-shield',
	'fields'   => array(
		array(
			'type'    => 'notice',
			'class'   => 'warning',
			'content' => esc_html__( 'You can save your current options. Download a Backup and Import.', 'blance' ),
		),
		array(
			'type'    => 'backup',
		),
  	)
);
CSFramework::instance( $settings, $options );