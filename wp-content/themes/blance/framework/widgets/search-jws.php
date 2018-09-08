<?php
class JWStheme_Search_Widget extends WP_Widget {
    function __construct() {
        parent::__construct(
                'jws_search_widget', // Base ID
                __('Search jws', 'blance'), // Name
                array('description' => __('Search Widget', 'blance'),) // Args
        );
    }
    function widget($args, $instance) {
        extract($args);
		$title = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base );
        $el_class = !empty($instance['el_class']) ? $instance['el_class'] : "";
        $icon_social_ = array();
        $link_social_ = array();
        for ($i = 1; $i <= 6; $i++) {
            $icon_social[$i] = !empty($instance['icon_social_' . $i]) ? esc_attr($instance['icon_social_' . $i]) : '';
            $link_social[$i] = !empty($instance['link_social_' . $i]) ? esc_url($instance['link_social_' . $i]) : '';
        }
        
		// no 'class' attribute - add one with the value of width
        if (strpos($before_widget, 'class') === false) {
            $before_widget = str_replace('>', 'class="' . esc_attr($el_class) . '"', $before_widget);
        }
        // there is 'class' attribute - append width value to it
        else {
            $before_widget = str_replace('class="', 'class="' . esc_attr($el_class) . ' ', $before_widget);
        }
		
        ob_start();
		
        echo $before_widget;
		if ( $title )
				echo ''.$before_title . $title . $after_title;  
        ?>
        <div class="search-form-overlay"></div>
        <a class="search-form-trigger" href="#search-form">Search<span></span></a>
        <div id="search-form" class="search-form-jws">
            <form  role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" >
                <input type="text" value="<?php echo get_search_query(); ?>" name="s" id="s" placeholder="Search...">
            </form>
        </div>
        <?php
        echo $after_widget;
        echo ob_get_clean();
    }

    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        for ($i = 1; $i <= 6; $i++) {
            $instance['icon_social_' . $i] = $new_instance['icon_social_' . $i];
            $instance['link_social_' . $i] = $new_instance['link_social_' . $i];
        }
        $instance['title'] = $new_instance['title'];
        $instance['el_class'] = $new_instance['el_class'];
        return $instance;
    }

    function form($instance) {
        $icon_social = array();
        $link_social = array();
        for ($i = 1; $i <= 6; $i++) {
           $icon_social[$i] = isset($instance['icon_social_' . $i]) ? esc_attr($instance['icon_social_' . $i]) : '';
            $link_social[$i] = isset($instance['link_social_' . $i]) ? esc_attr($instance['link_social_' . $i]) : '';
        }
        $title = isset($instance['title']) ? esc_attr($instance['title']) : 'Social';
        $el_class = isset($instance['el_class']) ? esc_attr($instance['el_class']) : '';
		?>
		<p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php _e('Title:', 'blance'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" value="<?php echo $title; ?>" />
        </p>
        <?php
        for ($i = 1; $i <= 6; $i++) {
            ?>
            <p>
                <label for="<?php echo esc_url($this->get_field_id('icon_social_' . $i)); ?>"><?php _e('Social Icon:', 'blance');
            echo $i; ?></label>
                <input class="widefat" id="<?php echo esc_attr($this->get_field_id('icon_social_' . $i)); ?>" name="<?php echo esc_attr($this->get_field_name('icon_social_' . $i)); ?>" type="text" value="<?php echo esc_attr($icon_social[$i]); ?>" />
            </p>
            <p>
                <label for="<?php echo esc_url($this->get_field_id('link_social_' . $i)); ?>"><?php _e('Social Link:', 'blance');
            echo $i; ?></label>
                <input class="widefat" id="<?php echo esc_attr($this->get_field_id('link_social_' . $i)); ?>" name="<?php echo esc_attr($this->get_field_name('link_social_' . $i)); ?>" type="text" value="<?php echo esc_attr($link_social[$i]); ?>" />
            </p>
        <?php } ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('el_class')); ?>"><?php _e('Extra Class:', 'blance'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('el_class')); ?>" name="<?php echo esc_attr($this->get_field_name('el_class')); ?>" value="<?php echo $el_class; ?>" />
        </p>
        <?php
    }
}
/**
 * Class JWStheme_Search_Widget
 */
function jwstheme_register_search_widget() {
    register_widget('JWStheme_Search_Widget');
}
add_action('widgets_init', 'jwstheme_register_search_widget');
?>