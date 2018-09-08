<?php
class jwstheme_Post_List_Widget extends jwstheme_Widget {
	function __construct() {
		parent::__construct(
			'services-list', // Base ID
			__('Services List', 'blance'), // Name
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
            'services_cat' => array(
				'type'   => 'bt_taxonomy',
				'std'    => '',
				'label'  => __( 'Categories', 'blance' ),
			),
			'layout' => array(
				'type'  => 'select',
				'std'   => 'default',
				'label' => __( 'Layout', 'blance' ),
				'options' => array(
					'default'  => __( 'Default', 'blance' ),
					'layout2'  => __( 'Layout 2 - has thumbnail', 'blance' ),
                    'layout3'  => __( 'Layout 3 - has thumbnai footer', 'blance' ),
                    'layout4'  => __( 'Layout 4 - has thumbnai Click Show Content', 'blance' ),
				)
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
		$layout                 = sanitize_title( $instance['layout'] );
		$el_class               = sanitize_title( $instance['el_class'] );
		echo ''.$before_widget;
		if ( $title )
				echo ''.$before_title . $title . $after_title;
		$query_args = array(
			'posts_per_page' => $posts_per_page,
			'orderby' => $orderby,
			'order' => $order,
			'post_type' => 'services_spa',
			'post_status' => 'publish');
		if (isset($services_cat) && $services_cat != '') {
			$cats = explode(',', $services_cat);
			$services_cat = array();
			foreach ((array) $cats as $cat) :
			$services_cat[] = trim($cat);
			endforeach;
			$query_args['tax_query'] = array(
									array(
										'taxonomy' => 'services_cat',
										'field' => 'id',
										'terms' => $services_cat
									)
							);
		}
		$wp_query = new WP_Query($query_args);                
		if ($wp_query->have_posts()){
			?>
			<ul class="services-list <?php echo esc_attr( $layout ); ?>">
				<?php 
				while ($wp_query->have_posts()) { 
					$wp_query->the_post(); 
                    ?> <li class="item"> <?php 
					$params = array(
						'title' => get_the_title(),
						'link' => get_the_permalink(),
						'date' => get_the_date( 'M d - Y' ),
						'author' => get_the_author(),
						);
					echo call_user_func_array( 'jwsthemes_widget_post_list_' . $layout, array( $params ) );
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
function jwstheme_post_list_widget() {
    register_widget('jwstheme_Post_List_Widget');
}
add_action('widgets_init', 'jwstheme_post_list_widget');
/**
 * jwsthemes_widget_post_list_default
 *
 * @param [array] $params
 */
if( ! function_exists( 'jwsthemes_widget_post_list_default' ) ) :
	function jwsthemes_widget_post_list_default( $params )
	{
		extract( $params );
		$output = "
			<h6 class='bt-title bt-text-ellipsis'>
				<a href='{$link}'>{$title}</a>
                <i class='fa fa-caret-right' ></i>
			</h6>
            ";
		return $output;
	}
endif;
/**
 * jwsthemes_widget_post_list_layout2
 *
 * @param [array] $params
 */
if( ! function_exists( 'jwsthemes_widget_post_list_layout2' ) ) :
	function jwsthemes_widget_post_list_layout2( $params )
	{
		global $post;
		extract( $params );
		/* thumbnail */
		$thumbnail = '';
		if( has_post_thumbnail() ):
        ?> <a href="<?php the_permalink(); ?>"> <?php
            $thumbnail_data = the_post_thumbnail();
        	$thumbnail = $thumbnail_data[0];
            ?>  </a> <?php
        endif;
		$output = "
		<div class='item-inner'>
				<img class='post-thumb' src='{$thumbnail}' alt=''>
				<div class='info-meta'>
                    <span>{$date}</span>
					<div class='title'><a href='{$link}' title='{$title}' data-smooth-link>{$title}</a></div>
			</div>
		</div>";
		return $output;
	}
endif;
if( ! function_exists( 'jwsthemes_widget_post_list_layout3' ) ) :
	function jwsthemes_widget_post_list_layout3( $params )
	{
		global $post;
		extract( $params );
		/* thumbnail */
 	  $thumbnail = '';
		if( has_post_thumbnail() ):
            $thumbnail_data = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ) );
        	$thumbnail = $thumbnail_data[0];
        endif;
		$output = "
		<li class='item'>
			<div class='item-inner'>
				<img class='post-thumb' src='{$thumbnail}' alt=''>
				<div class='info-meta'>
                    <span>{$date}</span>
					<div class='title'><a href='{$link}' title='{$title}' data-smooth-link>{$title}</a></div>
				</div>
			</div>
		</li>";
		return $output;
	}
endif;
if( ! function_exists( 'jwsthemes_widget_post_list_layout4' ) ) :
	function jwsthemes_widget_post_list_layout4( $params )
	{
		global $post;
		extract( $params );
		/* thumbnail */
		$thumbnail = '';
		if( has_post_thumbnail() ):
        ?> <button type="button" class="thumbnail-click" data-toggle="modal" data-target="#myModal"> <?php
            $thumbnail_data = the_post_thumbnail('imge-crop-thumbnail-click-show-content');
        	$thumbnail = $thumbnail_data[0];
            ?>  </button>
            <div id="myModal" class="modal fade" role="dialog">
          <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
              </div>
              <div class="modal-body">
                <?php the_content(); ?>
              </div>
            </div>
          </div>
        </div>
        <?php
        endif;
		$output = "
		<div class='item-inner'>
				<img class='post-thumb' src='{$thumbnail}' alt=''>
				<div class='info-meta'>
					<div class='title'><a href='{$link}' title='{$title}' data-smooth-link>{$title}</a></div>
                    <span>{$date}</span>
			</div>
		</div>";
		return $output;
        ?>
        <?php
	}
endif;
