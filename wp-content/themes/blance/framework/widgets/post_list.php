<?php
class jwstheme_Post2_List_Widget extends jwstheme_Widget {
	function __construct() {
		parent::__construct(
			'post-list', // Base ID
			__('Post List', 'blance'), // Name
			array('description' => __('Display a list of your posts on your site.', 'blance'),) // Args
        );
		$this->settings           = array(
			'title'  => array(
				'type'  => 'text',
				'std'   => __( 'Post List', 'blance' ),
				'label' => __( 'Title', 'blance' )
			),
			'posts_per_page' => array(
				'type'  => 'number',
				'step'  => 1,
				'min'   => 1,
				'max'   => '',
				'std'   => 3,
				'label' => __( 'Number of posts to show', 'blance' )
			),
			'orderby' => array(
				'type'  => 'select',
				'std'   => 'none',
				'label' => __( 'Order by', 'blance' ),
				'options' => array(
					'none'   => __( 'None', 'blance' ),
					'comment_count'  => __( 'Comment Count', 'blance' ),
					'title'  => __( 'Title', 'blance' ),
					'date'   => __( 'Date', 'blance' ),
					'ID'  => __( 'ID', 'blance' ),
				)
			),
			'order' => array(
				'type'  => 'select',
				'std'   => 'none',
				'label' => __( 'Order', 'blance' ),
				'options' => array(
					'none'  => __( 'None', 'blance' ),
					'asc'  => __( 'ASC', 'blance' ),
					'desc' => __( 'DESC', 'blance' ),
				)
			),
            'category' => array(
				'type'   => 'bt_taxonomy',
				'std'    => '',
				'label'  => __( 'Categories', 'blance' ),
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
		ob_start();
		global $post;
		extract( $args );
		$title                  = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base );
		$services_cat              = isset($instance['services_cat'])? $instance['services_cat'] : '';
		$posts_per_page         = absint( $instance['posts_per_page'] );
		$orderby                = sanitize_title( $instance['orderby'] );
		$order                  = sanitize_title( $instance['order'] );
		$el_class               = sanitize_title( $instance['el_class'] );
		echo ''.$before_widget;
		if ( $title )
				echo ''.$before_title . $title . $after_title;
		$query_args = array(
			'posts_per_page' => $posts_per_page,
			'orderby' => $orderby,
			'order' => $order,
			'post_type' => 'post',
			'post_status' => 'publish');
		if (isset($category) && $category != '') {
			$cats = explode(',', $category);
			$category = array();
			foreach ((array) $cats as $cat) :
			$category[] = trim($cat);
			endforeach;
			$query_args['tax_query'] = array(
									array(
										'taxonomy' => 'category',
										'field' => 'id',
										'terms' => $category
									)
							);
		}
		$wp_query = new WP_Query($query_args);                
		if ($wp_query->have_posts()){
			?>
			<ul class="post-list">
				<?php 
				while ($wp_query->have_posts()) { 
					$wp_query->the_post(); 
                    ?> <li class="item"> <?php 
					$params = array(
						'title' => get_the_title(),
						'link' => get_the_permalink(),
						'date' => get_the_date( 'M d, Y' ),
						'author' => get_the_author(),
						);
					echo call_user_func_array( 'jwsthemes_widget_post2_list_default', array( $params ) );
				?> </li> <?php
                } 
				?>
			</ul>
		<?php 
		}
		wp_reset_postdata();
		echo ''.$after_widget;
		$content = ob_get_clean();
		echo ''.$content;
	}
}
/* Class jwstheme_Post_List_Widget */
function jwstheme_post_list2_widget() {
    register_widget('jwstheme_Post2_List_Widget');
}
add_action('widgets_init', 'jwstheme_post_list2_widget');
/**
 * jwsthemes_widget_post_list_default
 *
 * @param [array] $params
 */
if( ! function_exists( 'jwsthemes_widget_post2_list_default' ) ) :
	function jwsthemes_widget_post2_list_default( $params )
	{
		extract( $params );
		$output = "
			<h6 class='bt-title'>
				<a href='{$link}'>{$title}</a>
                <div class='date'>{$date}</div>
			</h6>
            ";
		return $output;
	}
endif;
