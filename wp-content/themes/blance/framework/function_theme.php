<?php 
    // **********************************************************************// 
    // ! Get config file
    // **********************************************************************// 
    
    if( ! function_exists( 'blance_get_config' ) ) {
    	function blance_get_config( $name ) {
    		// $allowed = array('selectors', 'versions', 'base-options', 'widgets-import', 'specific-options', 'product-hovers');
    		$path = ABS_PATH_FR . '/filed-shortcode/' . $name . '.php';
    		if( file_exists( $path ) ) { // && in_array($name, $allowed) 
    			return include $path;
    		} else {
    			return array();
    		}
    	}
    }
 // **********************************************************************// 
// ! Function to get HTML block content
// **********************************************************************// 

if( ! function_exists( 'blance_get_html_block' ) ) {
	function blance_get_html_block($id) {
		$content = get_post_field('post_content', $id);
		$content = do_shortcode($content);
		$shortcodes_custom_css = get_post_meta( $id, '_wpb_shortcodes_custom_css', true );
		if ( ! empty( $shortcodes_custom_css ) ) {
			$content .= '<style type="text/css" data-type="vc_shortcodes-custom-css">';
			$content .= $shortcodes_custom_css;
			$content .= '</style>';
		}
		return $content;
	}
}   
 /**
 * Add search modal to footer
 */
function jws_search_modal() {


	?>
	<div id="search-modal" class="search-modal" tabindex="-1" role="dialog">
		<div class="modal-content">
			<div class="container">
				<form method="get" class="instance-search" action="<?php echo esc_url( home_url( '/' ) ); ?>">
					<?php
					$number = apply_filters( 'jws_product_cats_search_number', 4 );
					$args   = array(
						'number'       => $number,
						'orderby'      => 'count',
						'order'        => 'desc',
						'hierarchical' => false,
						'taxonomy'     => 'product_cat'
					);
					$cats   = get_terms( $args );
					?>
					<?php if ( $cats && ! is_wp_error( $cats ) ) : ?>
						<div class="product-cats">
							<label>
								<input type="radio" name="product_cat" value="" checked="checked">
								<span class="line-hover"><?php esc_html_e( 'All', 'blance' ) ?></span>
							</label>

							<?php foreach ( $cats as $cat ) : ?>
								<label>
									<input type="radio" name="product_cat" value="<?php echo esc_attr( $cat->slug ); ?>">
									<span class="line-hover"><?php echo esc_html( $cat->name ); ?></span>
								</label>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>
                    <div class="loading">
					</div>
					<div class="search-fields">
						<input type="text" name="s" placeholder="<?php esc_attr_e( 'Search . . .', 'blance' ); ?>" class="search-field" autocomplete="off">
						<input type="hidden" name="post_type" value="product">
						<span class="search-submit">
                        <input type="submit" class="btn-submit">
						</span>
					</div>
				</form>

				<div class="search-results">
					<div class="woocommerce"></div>
				</div>
			</div>
		</div>
		<div class="modal-footer">
			<a href="#" class="close-modal"><?php esc_html_e( 'Close', 'blance' ) ?></a>
		</div>
        <div class="moal-overlay"></div>
	</div>
	<?php
}
if( ! function_exists( 'blance_mobi_menu' ) ) {
	function blance_mobi_menu() {
		?>
			<div class="mobile_menu">
                <div class="logo-center">
                            <?php jws_blance_logo(); ?>
                </div>
			     <div class="mobile_inner">
						<?php
                        $local = '';
                        if ( has_nav_menu( 'mobile_navigation' ) ) { 
                          $local = 'mobile_navigation';  
                        }else {
                          $local = 'main_navigation';  
                        }
						$attr = array(
                            'theme_location' => ''.$local.'',
							'menu_id' => 'nav_mobile',
							'menu' => '',
                            'container' => '',
							'container_class' => 'hidden-xs hidden-sm ',
							'menu_class'      => ' nav navbar-nav cl-effect-11',
							'echo'            => true,
							'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
							'depth'           => 0,
                            
						);
                        
                        wp_nav_menu( $attr );
                        
                        ?>
                    </div>
			</div>
		<?php
	}
}
add_action( 'wp_footer', 'blance_mobi_menu' );
add_action( 'wp_footer', 'jws_search_modal' );
    if( ! function_exists( 'blance_header_block_search' ) ) {
	function blance_header_block_search() {
		?>
			<div class="search-button>
				<a href="#">
					<i class="fa fa-search"></i>
				</a>
				<div class="blance-search-wrapper">
					<div class="blance-search-inner">
						<span class="blance-close-search"><?php esc_html_e('close', 'blance'); ?></span>
						<?php blance_header_block_search_extended( false, true, array('thumbnail' => 1, 'price' => 1, 'count' => 4), false ); ?>
					</div>
				</div>
			</div>
		<?php
	}
}
if( ! function_exists( 'query_pagination' ) ) {
	function query_pagination($pages = '', $range = 2) {  
	     $showitems = ($range * 2)+1;  

	     global $paged;
	     
	     if(empty($paged)) $paged = 1;

	     if($pages == '')
	     {
	         global $wp_query;
	         $pages = $wp_query->max_num_pages;
	         if(!$pages)
	         {
	             $pages = 1;
	         }
	     }   

	     if(1 != $pages)
	     {
	         echo "<div class='blance-pagination'>";
	         if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<a href='".get_pagenum_link(1)."'>&laquo;</a>";
	         if($paged > 1 && $showitems < $pages) echo "<a href='".get_pagenum_link($paged - 1)."'>&lsaquo;</a>";

	         for ($i=1; $i <= $pages; $i++)
	         {
	             if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
	             {
	                 echo ($paged == $i)? "<span class='current'>".$i."</span>":"<a href='".get_pagenum_link($i)."' class='inactive' >".$i."</a>";
	             }
	         }

	         if ($paged < $pages && $showitems < $pages) echo "<a href='".get_pagenum_link($paged + 1)."'>&rsaquo;</a>";  
	         if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) echo "<a href='".get_pagenum_link($pages)."'>&raquo;</a>";
	         echo "</div>\n";
	     }
	}
}
if( ! function_exists( 'blance_header_block_search_extended' ) ) {
	function blance_header_block_search_extended( $show_categories = true, $ajax = true, $ajax_args = array(), $wrap = true ) {
		$data  = '';



		$defaults = array(
			'thumbnail' => true,
			'price' => true,
			'count' => 5
		);


		/**
		 * Parse incoming $args into an array and merge it with $defaults
		 */ 
		$ajax_args = wp_parse_args( $ajax_args, $defaults );

		if( $ajax ) {
			foreach ($ajax_args as $key => $value) {
				$data .= ' data-' . $key . '="' . $value . '"';
			}
		}

	
		?>
			<form role="search" method="get" id="searchform" class="searchform  blance-ajax-search" action="<?php echo esc_url( home_url( '/' ) ); ?>" <?php echo $data; ?>>
				<div>
					<label class="screen-reader-text" for="s"><?php _x( 'Search for:', 'label', 'blance' ); ?></label>
					<input type="text" placeholder="<?php echo esc_attr_x( 'Search for products', 'submit button', 'blance' ); ?>" value="<?php echo get_search_query(); ?>" name="s" id="s" />
					<input type="hidden" name="post_type" id="post_type" value="product">
					<button type="submit" id="searchsubmit"><?php echo esc_attr_x( 'Search', 'submit button', 'blance' ); ?></button>
				</div>
			</form>
			<div class="search-results-wrapper"><div class="blance-search-results"></div></div>
		<?php
	
	}
    }
    /**
     * Get current page URL for layered nav items.
     * @return string
     */
    function blance_get_page_base_url() {
    	if ( defined( 'SHOP_IS_ON_FRONT' ) ) {
    		$link = home_url();
    	} elseif ( is_post_type_archive( 'product' ) || is_page( wc_get_page_id( 'shop' ) ) ) {
    		$link = get_post_type_archive_link( 'product' );
    	} elseif ( is_product_category() ) {
    		$link = get_term_link( get_query_var( 'product_cat' ), 'product_cat' );
    	} elseif ( is_product_tag() ) {
    		$link = get_term_link( get_query_var( 'product_tag' ), 'product_tag' );
    	} else {
    		$queried_object = get_queried_object();
    		$link           = get_term_link( $queried_object->slug, $queried_object->taxonomy );
    	}
    
    	return $link;
    }
    if ( ! function_exists( 'jwstheme_setup' ) ) {
	function jwstheme_setup() {

        
		load_theme_textdomain( 'jwsthemes', get_template_directory() . '/languages' );
		// Add Custom Header.
		add_theme_support('custom-header');
		// Add RSS feed links to <head> for posts and comments.
		add_theme_support( 'automatic-feed-links' );

		// Enable support for Post Thumbnails, and declare sizes.
		add_theme_support( 'post-thumbnails' );
		//Enable support for Title Tag
		 add_theme_support( "title-tag" );
		
		// This theme uses wp_nav_menu() in locations.
		register_nav_menus( array(
			'main_navigation'   => __( 'Main Navigation','blance' ),
            'mobile_navigation'   => __( 'Mobile Navigation','blance' ),
		) );
		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
		) );

		/*
		 * Enable support for Post Formats.
		 * See http://codex.wordpress.org/Post_Formats
		 */
		add_theme_support( 'post-formats', array(
			'video', 'audio', 'quote', 'link', 'gallery',
		) );

		// This theme allows users to set a custom background.
		add_theme_support( 'custom-background', apply_filters( 'jwstheme_custom_background_args', array(
			'default-color' => 'f5f5f5',
		) ) );

		// Add support for featured content.
		add_theme_support( 'featured-content', array(
			'featured_content_filter' => 'jwstheme_get_featured_posts',
			'max_posts' => 6,
		) );
		
		// This theme uses its own gallery styles.
		add_filter( 'use_default_gallery_style', '__return_false' );
        add_image_size( 'jws-imge-minicart',65,83, true ); 
        add_image_size( 'jws-imge-crop-thumbnail-blog-siderbar',180,180, true );
        add_image_size( 'jws-imge-crop-thumbnail-blog-classic',1170,580, true );
        add_image_size( 'jws-imge-crop-thumbnail-blog-related',740,480, true );
        add_image_size( 'portfolio-grid',600,600, true );
        add_image_size( 'jws_portfolio_metro',900,900, true );
        add_image_size( 'jws_portfolio_metro_x1',450,938, true );
        add_image_size( 'attachment-60x60',160,160, true );
        add_image_size( 'size-270x340',270,340, true );
        add_theme_support( 'wc-product-gallery-zoom' );
        add_theme_support( 'wc-product-gallery-lightbox' );
    	new blance_WooCommerce;
    	}
}
add_action( 'after_setup_theme', 'jwstheme_setup' );

/*Custom comment list*/
function jws_theme_custom_comment($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment;
	extract($args, EXTR_SKIP);

	if ( 'div' == $args['style'] ) {
		$tag = 'div';
		$add_below = 'comment';
	} else {
		$tag = 'li';
		$add_below = 'div-comment';
	}
?>
	<<?php echo wp_kses_post($tag) ?> <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ) ?> id="comment-<?php comment_ID() ?>">
		<?php if ( 'div' != $args['style'] ) : ?>
			<div id="div-comment-<?php comment_ID() ?>" class="comment-body">
		<?php endif; ?>
			<div class="comment-avatar">
				<?php if ( $args['avatar_size'] != 0 ) echo get_avatar( $comment, $args['avatar_size'] ); ?>
			</div>
			<div class="comment-info">
				
				<div class="comment-header-info">
                    <div class="comment-date">
							<?php
							printf( esc_html__('%1$s %3$s %2$s ','blance'), get_comment_date('M d Y'),   get_comment_time('g:i A')  , __('at' , 'blance') ); ?>
					</div>
					<div class="comment-author vcard">
						<?php printf( esc_html__( '%s','blance' ), get_comment_author_link() ); ?>
                        
					</div>
					
					
				</div>
				
				<?php if ( $comment->comment_approved == '0' ) : ?>
					<em class="comment-awaiting-moderation"><?php esc_html_e( 'Your comment is awaiting moderation.', 'blance' ); ?></em>
					<br />
				<?php endif; ?>

				<?php comment_text(); ?>
                <div class="reply">
						<?php comment_reply_link( array_merge( $args, array( 'add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
				</div>
				
			</div>
			
	<?php if ( 'div' != $args['style'] ) : ?>
		</div>
	<?php endif; ?>
<?php
}
    /**
 * Render google font link
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'jws_blance_google_font_url' ) ) {
	function jws_blance_google_font_url() {
		// Google font
		$fonts = $font_parse = array();

		// Font default
		$fonts['Poppins'] = array(
			'300',
			'400',
			'500',
			'600',
			'700',
		);
		$fonts['Libre Baskerville'] = array( '400italic' );

		// Body font
		$body_font    = cs_get_option( 'body-font' );
		$heading_font = cs_get_option( 'heading-font' );

		if ( $body_font ) {
			$font_family = esc_attr( $body_font['family'] );
			if ( '100italic' == $body_font['variant'] ) {
				$font_weight = array( '100' );
			} elseif ( '300italic' == $body_font['variant'] ) {
				$font_weight = array( '300' );
			} elseif ( '400italic' == $body_font['variant'] ) {
				$font_weight = array( '400' );
			} elseif ( '700italic' == $body_font['variant'] ) {
				$font_weight = array( '700' );
			} elseif ( '900italic' == $body_font['variant'] ) {
				$font_weight = array( '900' );
			} elseif ( 'regular' == $body_font['variant'] ) {
				$font_weight = array( '400' );
			} else {
				$font_weight = array( $body_font['variant'] );
			}

			// Merge array and delete values duplicated
			$fonts[$font_family] = isset( $fonts[$font_family] ) ? array_unique( array_merge( $fonts[$font_family], $font_weight ) ) : $font_weight;
		}

		if ( $heading_font ) {
			$font_family = esc_attr( $heading_font['family'] );
			if ( '100italic' == $heading_font['variant'] ) {
				$font_weight = array( '100' );
			} elseif ( '300italic' == $heading_font['variant'] ) {
				$font_weight = array( '300' );
			} elseif ( '400italic' == $heading_font['variant'] ) {
				$font_weight = array( '400' );
			} elseif ( '700italic' == $heading_font['variant'] ) {
				$font_weight = array( '700' );
			} elseif ( '900italic' == $heading_font['variant'] ) {
				$font_weight = array( '900' );
			} elseif ( 'regular' == $heading_font['variant'] ) {
				$font_weight = array( '400' );
			} else {
				$font_weight = array( $heading_font['variant'] );
			}

			// Merge array and delete values duplicated
			$fonts[$font_family] = isset( $fonts[$font_family] ) ? array_unique( array_merge( $fonts[$font_family], $font_weight ) ) : $font_weight;
		}

		// Parse array to string for url Google fonts
		foreach ( $fonts as $font_name => $font_weight ) {
			$font_parse[] = $font_name . ':'. implode( ',' , $font_weight );
		}

		$query_args = array(
			'family' => urldecode( implode( '|', $font_parse ) ),
			'subset' => urlencode( 'latin,latin-ext' ),
		);

		$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );

		return esc_url_raw( $fonts_url );
	}
}
    /**
     * Render logo.
     *
     * @return string
     */
    if ( ! function_exists( 'jws_blance_logo' ) ) {
    	function jws_blance_logo() {
    		$output = '';
    
    		$output .= '<div class="jws-branding ts__05">';
    			$output .= '<a class="logo-blance" href="' . esc_url( home_url( '/' ) ) . '">';
    				if ( ! cs_get_option( 'header-transparent' ) ) {
    					if ( cs_get_option( 'logo' ) ) {
    						$logo = wp_get_attachment_image_src( cs_get_option( 'logo' ), 'full', true );
    
    						$output .= '<img class="regular-logo" src="' . esc_url( $logo[0] ) . '" width="' . esc_attr( $logo[1] ) . '" height="' . esc_attr( $logo[2] ) . '" alt="' . get_bloginfo( 'name' ) . '" />';
    					} else {
    						$output .= '<img class="regular-logo" src="' . URI_PATH . '/assets/images/logo.png' . '" width="96" height="29" alt="' . get_bloginfo( 'name' ) . '" />';
    					}
    				} else {
    					if ( cs_get_option( 'logo-transparent' ) ) {
    						$logo = wp_get_attachment_image_src( cs_get_option( 'logo-transparent' ), 'full', true );
    
    						$output .= '<img class="regular-logo" src="' . esc_url( $logo[0] ) . '" width="' . esc_attr( $logo[1] ) . '" height="' . esc_attr( $logo[2] ) . '" alt="' . get_bloginfo( 'name' ) . '" />';
    					} else {
    						$output .= '<img class="regular-logo" src="' . URI_PATH . '/assets/images/logo.png' . '" width="96" height="29" alt="' . get_bloginfo( 'name' ) . '" />';
    					}
    
    					if ( cs_get_option( 'logo-transparent-retina' ) ) {
    						$logo_retina = wp_get_attachment_image_src( cs_get_option( 'logo-transparent-retina' ), 'full', true );
    
    						$output .= '<img class="retina-logo" src="' . esc_url( $logo_retina[0] ) . '" width="' . esc_attr( $logo_retina[1] ) . '/2" height="' . esc_attr( $logo_retina[2] ) . '/2" alt="' . get_bloginfo( 'name' ) . '" />';
    					} else {
    						$output .= '<img class="retina-logo" src="' . URI_PATH . '/assets/images/logo-2x.png' . '" width="96" height="29" alt="' . get_bloginfo( 'name' ) . '" />';
    					}
    				}
    			$output .= '</a>';
    		$output .= '</div>';
    
    		echo apply_filters( 'jws_blance_logo', $output );
    	}
    }
    /**
     * Render header layout.
     *
     * @return string
     */
    if ( ! function_exists( 'jws_blance_header' ) ) {
    	function jws_blance_header() {
    	    $layout = get_post_meta( get_the_ID(), '_custom_page_options', true );
            if(!isset($layout['header-layout'])) {
             $layout_in = cs_get_option( 'header-layout' ) ? cs_get_option( 'header-layout' ) : 3;   
            }else {
              $layout_in = $layout['header-layout'];  
            }
    		ob_start();
    	    get_template_part( 'framework/headers/header', $layout_in );
    		$output = ob_get_clean();
    
    		echo apply_filters( 'jws_blance_header', $output );
    	}
    }
    /**
     * Render header layout.
     *
     * @return string
     */
    if ( ! function_exists( 'jws_blance_footer' ) ) {
    	function jws_blance_footer() {
    	    $layout = get_post_meta( get_the_ID(), '_custom_page_options', true );
            if(!isset($layout['footer-layout'])) {
             $layout_in = cs_get_option( 'footer-layout' ) ? cs_get_option( 'footer-layout' ) : 2;   
            }else {
              $layout_in = $layout['footer-layout'];  
            }
    		ob_start();
    	    get_template_part( 'framework/footers/footer', $layout_in );
    		$output = ob_get_clean();
    
    		echo apply_filters( 'jws_blance_footer', $output );
    	}
       
    }
/*Author*/
if ( ! function_exists( 'jwstheme_social' ) ) {
	function jwstheme_social() {
		ob_start(); ?>
		    <div class="social-bar">
                    <?php 
                    $content = '<!-- Go to www.addthis.com/dashboard to customize your tools -->
 			        <div class="clearfix vg-share-link single-event-social-bar">
                          <span>Share this post</span>  
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
/**
 * Render related post based on post tags.
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'jws_related_post' ) ) {
	function jws_related_post() {
		global $post;
        // Get page options
        $options = get_post_meta( get_the_ID(), '_custom_post_options', true );
        
        // Get product single style
        $style = ( is_array( $options ) && $options['post-single-style'] ) ? $options['post-single-style'] : ( cs_get_option( 'post-single-style' ) ? cs_get_option( 'post-single-style' ) : '1' );
		// Get post's tags
		$tags = wp_get_post_tags( $post->ID );

		if ( $tags ) {
			// Get id for all tags
			$tag_ids = array();

			foreach ( $tags as $tag ) {
				$tag_ids[] = $tag->term_id;
			}

			// Build arguments to query for related posts
			$args = array(
				'tag__in'             => $tag_ids,
				'post__not_in'        => array( $post->ID ),
				'posts_per_page'      => -1,
				'ignore_sticky_posts' => 1,
				'orderby'             => 'rand',
			);

			// Get related post
			$related = new wp_query( $args );

			?>
			<div class="post-related blance-blog-holder">
				<h4 class="tt"><?php esc_html_e( 'Related Post', 'blance' )  ?></h4>
				<div class="jws-carousel row" data-slick='{"slidesToShow": <?php if($style == "1" || $style == "2") {echo "2";}else{echo "3";} ?> ,"slidesToScroll": 1, "margin": "30px", "responsive":[{"breakpoint": 960,"settings":{"slidesToShow": 2}},{"breakpoint": 480,"settings":{"slidesToShow": 1}}]}'>
					<?php
                    while ( $related->have_posts() ):
						$related->the_post();
                        $num_comments = get_comments_number();
            			?>
                            <div class="post-item layout-2 col-md-3 col-sm-6 col-xs-12">
                            <div class="bog-image">
                            <img src="<?php echo get_the_post_thumbnail_url('' , 'jws-imge-crop-thumbnail-blog-related'); ?>" alt="image-blog" />
                            </div>
                            <div class="content-blog">
                            <div class="content-inner">
                                <div class="title">
                                    <h5><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
                                </div>
                                <div class="blog-excrept">
                                    <?php the_excerpt(); ?>
                                </div>
                                <div class="blog-link"><a class="read-more" href="<?php the_permalink(); ?>"><?php esc_html_e("Read More" , "blance") ?></a><span class="right-link"><span class="comment"><i class=" fa fa-comment-o"></i><span class="child"></span><?php echo $num_comments?></span></span></div>
                            </div>
                            </div>
                            </div>
		            <?php   
					endwhile;
                    ?>
				</div>	
			</div>
			<?php
			// Reset global query object
			wp_reset_postdata();
		}
	}
}
/*Author*/
if ( ! function_exists( 'jwstheme_author_render' ) ) {
	function jwstheme_author_render() {
		ob_start();
		?>
		
		<div class="blog-about-author clearfix">
        <h4 class="title-author"><?php esc_html_e('Author' , 'blance') ?></h4>
			<div class="blog-author-avatar"><?php echo get_avatar( get_the_author_meta( 'ID' ), 170 ); ?></div>
			<div class="blog-author-info">
                <h6 class="at-name"><?php the_author(); ?></h6>
				<p class="description"><?php the_author_meta('description'); ?></p>
                <div class="icon-author">
                    <a href="<?php echo get_the_author_meta('facebook'); ?>"><i class="fa fa-facebook"></i></a>
                    <a href="<?php echo get_the_author_meta('twitter'); ?>"><i class="fa fa-twitter"></i></a>
                    <a href="<?php echo get_the_author_meta('gplus'); ?>"><i class="fa fa-google-plus"></i></a>
                    <a href="<?php echo get_the_author_meta('mail'); ?>"><i class="fa fa-envelope"></i></a>
                </div>
			</div>
		</div>
		<?php
		return  ob_get_clean();
	} 
}
 /**
 * Render post tags.
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'jws_blance_get_tags' ) ) :
	function jws_blance_get_tags() {
		$output = '';

		// Get the tag list
		$tags_list = get_the_tag_list( '', esc_html__( ', ', 'blance' ) );
		if ( $tags_list ) {
			$output .= sprintf( '<div class="post-tags"><span> '.esc_html('Tags:' , 'blance').'</span> ' . esc_html__( '%1$s', 'blance' ) . '</div>', $tags_list );
		}
		return apply_filters( 'jws_blance_get_tags', $output );
	}
endif;

/**
 * ------------------------------------------------------------------------------------------------
 * Get post image
 * ------------------------------------------------------------------------------------------------
 */

if ( ! function_exists( 'blance_get_post_thumbnail' ) ) {
	function blance_get_post_thumbnail( $size = 'medium', $attach_id = false ) {
		global $post, $blance_loop;

		if ( has_post_thumbnail() ) {

			if( function_exists( 'wpb_getImageBySize' ) ) {
				if( ! $attach_id ) $attach_id = get_post_thumbnail_id();
				if( ! empty( $blance_loop['img_size'] ) ) $size = $blance_loop['img_size'];
				
				$img = wpb_getImageBySize( array( 'attach_id' => $attach_id, 'thumb_size' => $size, 'class' => 'attachment-large wp-post-image' ) );
				$img = $img['thumbnail'];

			} else {
				$img = get_the_post_thumbnail( $post->ID, $size );
			}

			return $img;
		}
	}
}
// **********************************************************************// 
// ! owl carousel init function
// **********************************************************************// 

if( ! function_exists( 'blance_owl_carousel_init' ) ) {
	function blance_owl_carousel_init( $atts = array() ) {
		extract( shortcode_atts( blance_get_owl_atts(), $atts ) );

		$func_name = 'carousel_' . $carousel_id;
		$func_name = function() use( $carousel_id, $slides_per_view, $autoplay, $autoheight, $speed, $hide_dots, $hide_prev_next_buttons, $scroll_per_page, $wrap , $space ) {
			
			$items = array();
			$items['desktop'] = ($slides_per_view > 0) ? $slides_per_view : 1;
			$items['desktop_small'] = ($items['desktop'] > 1) ? $items['desktop'] - 1 : 1;
			$items['tablet'] = ($items['desktop_small'] > 1) ? $items['desktop_small'] : 1;
			$items['mobile'] = ($items['tablet'] > 2) ? $items['tablet'] - 2 : 1;

			if($items['mobile'] > 2) {
				$items['mobile'] = 2;
			}

			?>

			<script type="text/javascript">
				jQuery( document ).ready(function( $ ) {

	                var owl = $("#<?php echo esc_js( $carousel_id ); ?> .owl-carousel");

					$( window ).bind( "vc_js", function() {
						owl.trigger('refresh.owl.carousel');
					} );

					var options = {
					    
	            		rtl: $('body').hasClass('rtl'),
			            items: <?php echo esc_js( $items['desktop'] ); ?>, 
			            responsive: {
			            	979: {
			            		items: <?php echo esc_js( $items['desktop'] ); ?>
			            	},
			            	768: {
			            		items: <?php echo esc_js( $items['desktop_small'] ); ?>
			            	},
			            	479: {
			            		items: <?php echo esc_js( $items['tablet'] ); ?>
			            	},
			            	0: {
			            		items: <?php echo esc_js( $items['mobile'] ); ?>
			            	}
			            },
			            autoplay: <?php echo ($autoplay == 'no') ? 'true' : 'true'; ?>,
			            autoplayTimeout: <?php echo $speed; ?>,
			            dots: <?php echo ($hide_dots == 'yes') ? 'false' : 'true'; ?>,
			            nav: <?php echo ($hide_prev_next_buttons == 'yes') ? 'false' : 'true'; ?>,
			            autoheight: <?php echo ($autoheight == 'yes') ? 'false' : 'true'; ?>,
			            slideBy:  <?php echo ($scroll_per_page == 'yes') ? '\'page\'' : 1; ?>,
			            navText:['<span class="ti-angle-left"></span>','<span class="ti-angle-right"></span>'],
			            loop: <?php echo ($wrap == 'yes') ? 'true' : 'false'; ?>,
                        margin: <?php echo $space; ?>,
			            onRefreshed: function() {
			            	$(window).resize();
			            }
					};

	                owl.owlCarousel(options);

				});
			</script>

			<?php
		};

		if( $carousel_js_inline == 'yes' ) {
			$func_name();
		} else {
			add_action( 'blance_after_footer', $func_name );
		}
	}
}
if( ! function_exists( 'blance_get_owl_atts' ) ) {
	function blance_get_owl_atts() {
		return array(
			'carousel_id' => '5000',
			'speed' => '5000',
			'slides_per_view' => '1',
			'wrap' => '',
			'autoplay' => 'yes',
            'loop' => 'yes',
			'autoheight' => 'no',
			'hide_dots' => '',
			'hide_prev_next_buttons' => '',
			'carousel_js_inline' => 'yes',
			'scroll_per_page' => 'yes',
            'space' => 15
		);
	}
}
/**
 * The archive title
 *
 * @since  1.0
 *
 * @param  array $title
 *
 * @return mixed
 */
function blance_the_archive_title( $title ) {
	if ( is_search() ) {
		$title = sprintf( esc_html__( 'Search Results', 'blance' ) );
	} elseif ( is_404() ) {
		$title = sprintf( esc_html__( 'Page Not Found', 'blance' ) );
	} elseif ( is_page() ) {
		$title = get_the_title();
	} elseif ( is_home() && is_front_page() ) {
		$title = esc_html__( 'The Latest Posts', 'blance' );
	} elseif ( is_home() && ! is_front_page() ) {
		$title = get_the_title( get_option( 'page_for_posts' ) );
	} elseif ( function_exists( 'is_shop' ) && is_shop() ) {
		$title = get_the_title( get_option( 'woocommerce_shop_page_id' ) );
	} elseif ( function_exists( 'is_product' ) && is_product() ) {
		$title = get_the_title();
	} elseif ( is_single() ) {
		$title = get_the_title();
	} elseif ( is_post_type_archive( 'portfolio_project' ) ) {
		$title = get_the_title( get_option( 'drf_portfolio_page_id' ) );
	} elseif ( is_tax() || is_category() ) {
		$title = single_term_title( '', false );
	}

	if ( get_option( 'woocommerce_shop_page_id' ) ) {
		if ( is_front_page() && ( get_option( 'woocommerce_shop_page_id' ) == get_option( 'page_on_front' ) ) ) {
			$title = get_the_title( get_option( 'woocommerce_shop_page_id' ) );
		}
	}


	return $title;
}

add_filter( 'get_the_archive_title', 'blance_the_archive_title', 30 );
/**
 * Display breadcrumbs for posts, pages, archive page with the microdata that search engines understand
 *
 * @see http://support.google.com/webmasters/bin/answer.py?hl=en&answer=185417
 *
 * @param array|string $args
 */
function jws_breadcrumbs( $args = '' ) {
	$args = wp_parse_args( $args, array(
		'separator'         => '<span class="sep">/</span>',
		'home_class'        => 'home',
		'before'            => '<span class="before">' . esc_html__( 'You are here: ', 'blance' ) . '</span>',
		'before_item'       => '',
		'after_item'        => '',
		'taxonomy'          => 'category',
		'display_last_item' => true,
		'show_on_front'     => true,
		'labels'            => array(
			'home'      => esc_html__( 'Home', 'blance' ),
			'archive'   => esc_html__( 'Archives', 'blance' ),
			'blog'      => esc_html__( 'Blog', 'blance' ),
			'search'    => esc_html__( 'Search results for', 'blance' ),
			'not_found' => esc_html__( 'Not Found', 'blance' ),
			'portfolio' => esc_html__( 'Portfolio', 'blance' ),
			'author'    => esc_html__( 'Author:', 'blance' ),
			'day'       => esc_html__( 'Daily:', 'blance' ),
			'month'     => esc_html__( 'Monthly:', 'blance' ),
			'year'      => esc_html__( 'Yearly:', 'blance' ),
		),
	) );

	$args = apply_filters( 'jws_breadcrumbs_args', $args );

	if ( is_front_page() && ! $args['show_on_front'] ) {
		return;
	}

	$items = array();

	// HTML template for each item
	$item_tpl      = $args['before_item'] . '
		<span itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
			<a href="%s" itemprop="url"><span itemprop="title"> %s </span></a>
		</span>
	' . $args['after_item'];
	$item_text_tpl = $args['before_item'] . '
		<span itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
			<span  itemprop="title"> %s </span>
		</span>
	' . $args['after_item'];

	// Home
	if ( ! $args['home_class'] ) {
		$items[] = sprintf( $item_tpl, get_home_url(), $args['labels']['home'] );
	} else {
		$items[] = sprintf(
			'%s<span itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
				<a class="%s" href="%s" itemprop="url"><span itemprop="title"> %s </span></a>
			</span>%s',
			$args['before_item'],
			$args['home_class'],
			get_home_url(),
			$args['labels']['home'],
			$args['after_item']
		);
	}

	// Front page
	if ( is_front_page() ) {
		$items   = array();
		$items[] = sprintf( $item_text_tpl, $args['labels']['home'] );
	}
	// Blog
	elseif ( is_home() && ! is_front_page() ) {
		$items[] = sprintf(
			$item_text_tpl,
			get_the_title( get_option( 'page_for_posts' ) )
		);
	}
	// Single
	elseif ( is_single() ) {
		// Terms

		$taxonomy = $args['taxonomy'];

		if( is_singular( 'portfolio_project' ) ) {
			$taxonomy = 'portfolio_category';
		}

		if( is_singular( 'portfolio_project' ) ) {
			$taxonomy = 'portfolio_category';
		}

		$terms   = get_the_terms( get_the_ID(),  $taxonomy );
		if( $terms ) {
			$term    = current( $terms );
			$terms   = jws_get_term_parents( $term->term_id, $taxonomy );
			$terms[] = $term->term_id;

			foreach ( $terms as $term_id ) {
				$term    = get_term( $term_id, $taxonomy );
				$items[] = sprintf( $item_tpl, get_term_link( $term, $taxonomy ), $term->name );
			}
		}

		if ( $args['display_last_item'] ) {
			$items[] = sprintf( $item_text_tpl, get_the_title() );
		}
	}
	// Page
	elseif ( is_page() ) {
		if( (function_exists( 'is_cart' ) && is_cart() ) || (function_exists( 'is_checkout' ) && is_checkout()) ) {
			if( $page_id = get_option( 'woocommerce_shop_page_id' ) )
			$items[] = sprintf( $item_tpl, esc_url(get_permalink( $page_id )), get_the_title( $page_id ) );

		} else {
			$pages = jws_get_post_parents( get_queried_object_id() );
			foreach ( $pages as $page )
			{
				$items[] = sprintf( $item_tpl, esc_url(get_permalink( $page )), get_the_title( $page ) );
			}
		}

		if ( $args['display_last_item'] )
			$items[] = sprintf( $item_text_tpl, get_the_title() );
	} elseif ( function_exists( 'is_shop' ) && is_shop() ) {
		$title = get_the_title( get_option( 'woocommerce_shop_page_id' ) );
		if ( $args['display_last_item'] ) {
			$items[] = sprintf( $item_text_tpl, $title );
		}
	} elseif ( is_tax() || is_category() || is_tag() ) {
		$current_term = get_queried_object();
		$terms        = jws_get_term_parents( get_queried_object_id(), $current_term->taxonomy );

		if( $terms ) {
			foreach ( $terms as $term_id )
			{
				$term    = get_term( $term_id, $current_term->taxonomy );
				$items[] = sprintf( $item_tpl, get_term_link( $term, $current_term->taxonomy ), $term->name );
			}
		}

		if ( $args['display_last_item'] )
			$items[] = sprintf( $item_text_tpl, $current_term->name );
	}
	elseif ( is_post_type_archive( 'portfolio_project' ) ) {
		$items[] = sprintf( $item_text_tpl, $args['labels']['portfolio'] );
	}
	// Search
	elseif ( is_search() ) {
		$items[] = sprintf( $item_text_tpl, $args['labels']['search'] . ' &quot;' . get_search_query() . '&quot;' );
	}
	// 404
	elseif ( is_404() ) {
		$items[] = sprintf( $item_text_tpl, $args['labels']['not_found'] );
	}
	// Author archive
	elseif ( is_author() ) {
		// Queue the first post, that way we know what author we're dealing with (if that is the case).
		the_post();
		$items[] = sprintf(
			$item_text_tpl,
			$args['labels']['author'] . ' <span class="vcard"><a class="url fn n" href="' . get_author_posts_url( get_the_author_meta( 'ID' ) ) . '" title="' . esc_attr( get_the_author() ) . '" rel="me">' . get_the_author() . '</a></span>'
		);
		rewind_posts();
	}
	// Day archive
	elseif ( is_day() ) {
		$items[] = sprintf(
			$item_text_tpl,
			sprintf( esc_html__( '%s %s', 'blance' ), $args['labels']['day'], get_the_date() )
		);
	}
	// Month archive
	elseif ( is_month() ) {
		$items[] = sprintf(
			$item_text_tpl,
			sprintf( esc_html__( '%s %s', 'blance' ), $args['labels']['month'], get_the_date( 'F Y' ) )
		);
	}
	// Year archive
	elseif ( is_year() ) {
		$items[] = sprintf(
			$item_text_tpl,
			sprintf( esc_html__( '%s %s', 'blance' ), $args['labels']['year'], get_the_date( 'Y' ) )
		);
	}
	// Archive
	else {
		$items[] = sprintf(
			$item_text_tpl,
			$args['labels']['archive']
		);
	}

	echo $args['before'] . implode( $args['separator'], $items );
}
/**
 * Get breadcrumbs
 *
 * @since  1.0.0
 *
 * @return string
 */
function jws_get_breadcrumbs() {
	ob_start();
	?>
	<nav class="breadcrumbs">
		<?php
		jws_breadcrumbs(
			array(
				'before'   => '',
				'taxonomy' => function_exists( 'is_woocommerce' ) && is_woocommerce() ? 'product_cat' : 'category',
			)
		);
		?>
	</nav>
	<?php
	echo ob_get_clean();
}
/**
 * Searches for term parents' IDs of hierarchical taxonomies, including current term.
 * This function is similar to the WordPress function get_category_parents() but handles any type of taxonomy.
 * Modified from Hybrid Framework
 *
 * @param int|string    $term_id  The term ID
 * @param object|string $taxonomy The taxonomy of the term whose parents we want.
 *
 * @return array Array of parent terms' IDs.
 */
function jws_get_term_parents( $term_id = '', $taxonomy = 'category' ) {
	// Set up some default arrays.
	$list = array();

	// If no term ID or taxonomy is given, return an empty array.
	if ( empty( $term_id ) || empty( $taxonomy ) ) {
		return $list;
	}

	do {
		$list[] = $term_id;

		// Get next parent term
		$term    = get_term( $term_id, $taxonomy );
		$term_id = $term->parent;
	} while ( $term_id );

	// Reverse the array to put them in the proper order for the trail.
	$list = array_reverse( $list );
	array_pop( $list );

	return $list;
}

/**
 * Gets parent posts' IDs of any post type, include current post
 * Modified from Hybrid Framework
 *
 * @param int|string $post_id ID of the post whose parents we want.
 *
 * @return array Array of parent posts' IDs.
 */
function jws_get_post_parents( $post_id = '' ) {
	// Set up some default array.
	$list = array();

	// If no post ID is given, return an empty array.
	if ( empty( $post_id ) ) {
		return $list;
	}

	do {
		$list[] = $post_id;

		// Get next parent post
		$post    = get_post( $post_id );
		$post_id = $post->post_parent;
	} while ( $post_id );

	// Reverse the array to put them in the proper order for the trail.
	$list = array_reverse( $list );
	array_pop( $list );

	return $list;
}
	