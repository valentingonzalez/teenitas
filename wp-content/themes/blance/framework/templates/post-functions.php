<?php

/* Post gallery */
if (!function_exists('jwstheme_grab_ids_from_gallery')) {

    function jwstheme_grab_ids_from_gallery() {
        global $post;
        $gallery = jwstheme_get_shortcode_from_content('gallery');
        $object = new stdClass();
        $object->columns = '3';
        $object->link = 'post';
        $object->ids = array();
        if ($gallery) {
            $object = jwstheme_extra_shortcode('gallery', $gallery, $object);
        }
        return $object;
    }

}
/* Extra shortcode */
if (!function_exists('jwstheme_extra_shortcode')) {
    function jwstheme_extra_shortcode($name, $shortcode, $object) {
        if ($shortcode && is_object($object)) {
            $attrs = str_replace(array('[', ']', '"', $name), null, $shortcode);
            $attrs = explode(' ', $attrs);
            if (is_array($attrs)) {
                foreach ($attrs as $attr) {
                    $_attr = explode('=', $attr);
                    if (count($_attr) == 2) {
                        if ($_attr[0] == 'ids') {
                            $object->$_attr[0] = explode(',', $_attr[1]);
                        } else {
                            $object->$_attr[0] = $_attr[1];
                        }
                    }
                }
            }
        }
        return $object;
    }
}
/* Get Shortcode Content */
if (!function_exists('jwstheme_get_shortcode_from_content')) {

    function jwstheme_get_shortcode_from_content($param) {
        global $post;
        $pattern = get_shortcode_regex();
        $content = $post->post_content;
        if (preg_match_all('/' . $pattern . '/s', $content, $matches) && array_key_exists(2, $matches) && in_array($param, $matches[2])) {
            $key = array_search($param, $matches[2]);
            return $matches[0][$key];
        }
    }

}
/* Remove Shortcode */
if (!function_exists('jwstheme_remove_shortcode_gallery')) {
	function jwstheme_remove_shortcode_gallery() {
		return null;
	}
}

/*Author*/
if ( ! function_exists( 'jwstheme_author_render' ) ) {
	function jwstheme_author_render() {
		ob_start();
		?>
		<?php if ( is_sticky() && is_home() && ! is_paged() ) { ?>
			<span class="featured-post"> <?php _e( 'Sticky', 'blance' ); ?></span>
		<?php } ?>
		<div class="bt-about-author clearfix">
			<div class="bt-author-avatar"><?php echo get_avatar( get_the_author_meta( 'ID' ), 170 ); ?></div>
			<div class="bt-author-info">
                <div class="icon-author">
                    <a href="<?php echo get_the_author_meta('facebook'); ?>"><i class="fa fa-facebook"></i></a>
                    <a href="<?php echo get_the_author_meta('twitter'); ?>"><i class="fa fa-twitter"></i></a>
                    <a href="<?php echo get_the_author_meta('gplus'); ?>"><i class="fa fa-google-plus"></i></a>
                </div>
				<h6 class="bt-name"><span class="aubout"><?php echo __('About The ', 'blance'); ?></span></span><?php the_author(); ?></h6>
				<p class="description"><?php the_author_meta('description'); ?></p>
			</div>
		</div>
		<?php
		return  ob_get_clean();
	} 
}

/*Author*/
if ( ! function_exists( 'jwstheme_tag_social' ) ) {
	function jwstheme_tag_social() {
		ob_start(); ?>
		    <div class="tags-and-social-bar">
                    <div class="tags">
                           <ul>
                            <?php
                                $custom_post_tags = get_the_tags();
                                if ( $custom_post_tags ) {
                                         foreach( $custom_post_tags as $tag ) {
                                            $tags_arr[] = $tag -> name;
                                            }
                                         }
                                         if( isset($tags_arr)) {
                                         $uniq_tags_arr = array_unique( $tags_arr );
                                         foreach( $uniq_tags_arr as $tag ) {
                                         // LIST ALL THE TAGS FOR DESIRED POST TYPE
                                         $sanitizeTag =  sanitize_title($tag);
                                         $tag_link = get_term_by('name', $tag, 'post_tag');
                                         echo '<li><a href="'. get_tag_link($tag_link->term_id).'">' .$tag. '</a></li>';
                                                }
                                         }else{
                                            echo "<span>"."Not Tags"."</span>";
                                         }
                            ?>
                        </ul>
                    </div>
                    <?php 
                    $content = '<!-- Go to www.addthis.com/dashboard to customize your tools -->
 			        <div class="clearfix vg-share-link single-event-social-bar text-right">
            			  <ul>
            
            			    <li><a class="addthis_button_facebook"><i class="fa fa-facebook"></i></a></li>
            
            			    <li><a class="addthis_button_twitter"><i class="fa fa-twitter"></i></a></li>
            
            			    <li><a class="addthis_button_google_plusone_share"><i class="fa fa-google-plus"></i></a></li>
            
            			    <li><a class="addthis_button_pinterest_share"><i class="fa fa-pinterest"></i></a></li>
            
            			    <li><a class="addthis_button_more"><i class="fa fa-plus"></i></a></li>
            
            			  </ul>
            
          		    </div>';
                echo wp_kses_post($content); ?>
                </div>
        <?php        
		return  ob_get_clean();
	} 
}
