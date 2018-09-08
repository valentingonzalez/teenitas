<?php
class jwsthemes_ComboWidgets_Widget extends jwstheme_Widget {
	function __construct() {
		parent::__construct(
			'bt_combowigets', // Base ID
			__( 'Combo Widgets', 'blance' ), // Name
			array( 'description' => __( 'Display a list icon: Search, Cart, ...', 'blance') ) // Args
        );
		
		$this->settings = array(
			'title'  => array(
				'type'  => 'text',
				'std'   => __( 'Combo Widgets', 'blance' ),
				'label' => __( 'Title', 'blance' )
			),
			'shortcode'  => array(
				'type'  => 'text',
				'std'   => __( '[btwg_search] [btwg_cart]', 'blance' ),
				'label' => __( 'Shortcode', 'blance' )
			),
			'el_class'  => array(
				'type'  => 'text',
				'std'   => '',
				'label' => __( 'Extra Class', 'blance' )
			)
		);
		add_action('admin_enqueue_scripts', array($this, 'widget_scripts'));
	}
        
	function widget_scripts() {
		wp_enqueue_script('widget_scripts', URI_PATH . '/framework/widgets/widgets.js');
	}

	function widget( $args, $instance ) {
		global $post;
		extract( $args );
                
		$title 		= apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base );
		$el_class 	= sanitize_title( $instance['el_class'] );
		$_title		= ( $title ) ? "{$before_title} {$title} {$after_title}" : '';
		$shortcode 	= do_shortcode( $instance['shortcode'] );

		$output 	= "
		{$before_widget}
			{$_title}
			<div class='combo-widgets-shortcode-wrap'>{$shortcode}</div>
		{$after_widget}";

		echo $output;
	}
}
/* Class jwsthemes_ComboWidgets_Widget */
function jwstheme_combowidgets_widget() {
    register_widget('jwsthemes_ComboWidgets_Widget');
}

add_action('widgets_init', 'jwstheme_combowidgets_widget');
