<?php if ( ! defined('ABSPATH')) exit('No direct script access allowed');

/**
* ------------------------------------------------------------------------------------------------
* Section title shortcode
* ------------------------------------------------------------------------------------------------
*/

if( ! function_exists( 'blance_shortcode_title' ) ) {
	function blance_shortcode_title( $atts ) {
		extract( shortcode_atts( array(
			'title' 	 => 'Title',
			'subtitle' 	 => '',
			'after_title'=> '',
			'link' 	 	 => '',
			'color' 	 => 'default',
			'style'   	 => 'default',
			'size' 		 => 'default',
			'subtitle_font' => 'default',
			'align' 	 => 'center',
			'el_class' 	 => '',
			'css'		 => ''
		), $atts) );

		$output = $attrs = '';

		$title_class = '';

		$title_class .= ' blance-title-color-' . $color;
		$title_class .= ' blance-title-style-' . $style;
		$title_class .= ' blance-title-size-' . $size;
		$title_class .= ' text-' . $align;

		$separator = '<span class="title-separator"><span></span></span>';

		if( function_exists( 'vc_shortcode_custom_css_class' ) ) {
			$title_class .= ' ' . vc_shortcode_custom_css_class( $css );
		}

		if( $el_class != '' ) {
			$title_class .= ' ' . $el_class;
		}

		$output .= '<div class="title-wrapper ' . $title_class . '">';

			if( $subtitle != '' ) {
				$output .= '<span class="title-subtitle font-'. esc_attr( $subtitle_font ) .'">' . $subtitle . '</span>';
			}

			$output .= '<div class="liner-continer"> <span class="left-line"></span> <span class="title">' . $title . $separator . '</span> <span class="right-line"></span> </div>';

			if( $after_title != '' ) {
				$output .= '<span class="title-after_title">' . $after_title . '</span>';
			}

		$output .= '</div>';

		return $output;

	}

	add_shortcode( 'blance_title', 'blance_shortcode_title' );
}


/**
* ------------------------------------------------------------------------------------------------
* Buttons shortcode
* ------------------------------------------------------------------------------------------------
*/
if( ! function_exists( 'blance_shortcode_button' ) ) {
	function blance_shortcode_button( $atts ) {
		extract( shortcode_atts( array(
			'img' 	 => '',
			'link' 	 	 => '',
			'color' 	 => 'default',
			'style'   	 => 'default',
			'size' 		 => 'default',
			'align' 	 => 'center',
			'el_class' 	 => '',
		), $atts) );
		$output = $attrs = '';

		$btn_class = 'action-popup-url';

		$btn_class .= ' btn-color-' . $color;
		$btn_class .= ' btn-style-' . $style;
		$btn_class .= ' btn-size-' . $size;

		if( $el_class != '' ) {
			$btn_class .= ' ' . $el_class;
		}

		if( $link != '' ) {
			$attrs .= ' href="' . esc_attr( $link ) . '"';
		}
		$output .= '<div class="blance-button-wrapper video-popup text-' . esc_attr( $align ) . '"><a class="'.$btn_class.'"' . $attrs . '>'. wp_get_attachment_image($img, 'full').  '</a></div>';

		return $output;

	}

	add_shortcode( 'blance_button', 'blance_shortcode_button' );
}
/**
* ------------------------------------------------------------------------------------------------
* Buttons shortcode
* ------------------------------------------------------------------------------------------------
*/
if( ! function_exists( 'blance_shortcode_button_video' ) ) {
	function blance_shortcode_button_video( $atts ) {
		extract( shortcode_atts( array(
			'img' 	 => '',
			'link' 	 	 => '',
			'icon_play' => '',
            'width' => '100%',
            'height' => '433',
			'el_class' 	 => '',
		), $atts) );
        ob_start();
		?>
        <div class="video-container">
        <div class="blance-video">
        <div class="video-background" style="background-image:url(<?php echo wp_get_attachment_image_url($img , 'full'); ?>)"></div>
        <div class="button-play-video">
        <?php echo wp_get_attachment_image($icon_play, 'full') ?>
        </div>
        </div>
        <iframe width="<?php echo $width; ?>" height="<?php echo $height; ?>" src="<?php echo esc_url($link); ?>?feature=oembed" frameborder="0" allowfullscreen=""></iframe>
        </div>
        <?php
        return ob_get_clean();
	}

	add_shortcode( 'jws_button_video', 'blance_shortcode_button_video' );
}
/**
* ------------------------------------------------------------------------------------------------
* instagram shortcode
* ------------------------------------------------------------------------------------------------
*/

if( ! function_exists( 'blance_shortcode_instagram' ) ) {
	function blance_shortcode_instagram( $atts, $content = '' ) {
		$output = '';
        $parsed_atts = shortcode_atts( array_merge( blance_get_owl_atts(), array(
			'title' => '',
			'username' => 'flickr',
			'number' => 9,
            'slides_per_view' => 8 ,
			'size' => 'thumbnail',
			'target' => '_self',
			'link' => '',
			'design' => 'default',
			'space' => 0,
			'rounded' => 0,
			'per_row' => 3,
            'spacing' => '',
		) ), $atts );

        
        extract( $parsed_atts );	

		$carousel_id = 'carousel-' . rand(100,999);

		ob_start();
		$class = 'instagram-widget';


		if( $spacing == 1 ) {
			$class .= ' instagram-with-spaces';
		}

		if( $rounded == 1 ) {
			$class .= ' instagram-rounded';
		}

		$class .= ' instagram-per-row-' . $per_row;

		echo '<div id="' . $carousel_id . '" class="' . $class." ".$design.'">';

		if ($username != '') {

			$media_array = blance_scrape_instagram($username, $number);

			if ( is_wp_error($media_array) ) {
			   echo esc_html( $media_array->get_error_message() );

			} else {
				?><ul class="instagram-pics <?php if( $design == 'slider') echo 'jws-carousel'; ?>" data-slick='{"slidesToShow": <?php echo $slides_per_view; ?> ,"slidesToScroll": 1,"responsive":[{"breakpoint": 1024,"settings":{"slidesToShow": 3}},{"breakpoint": 480,"settings":{"slidesToShow": 2}}]}'><?php
				foreach ($media_array as $item) {
					$image = (! empty( $item[$size] )) ? $item[$size] : $item['thumbnail'];
					echo '<li>
						<a target="_blank" href="'. esc_url( $item['link'] ) .'" target="'. esc_attr( $target ) .'"><span class="ion-social-instagram-outline"></span></a>
						<div class="wrapp-pics">
							<img src="'. esc_url( $image ) .'" />
							<div class="hover-mask"></div>
						</div>
					</li>';
				}
				?></ul><?php
			}
		}

		if ($link != '') {
			?><p class="clear"><a href="//instagram.com/<?php echo trim($username); ?>" rel="me" target="<?php echo esc_attr( $target ); ?>"><?php echo esc_html($link); ?></a></p><?php
		}

	

		echo '</div>';

		$output = ob_get_contents();
		ob_end_clean();

		return $output;

	}

	add_shortcode( 'blance_instagram', 'blance_shortcode_instagram' );
}

if( ! function_exists( 'blance_scrape_instagram' ) ) {
	function blance_scrape_instagram($username, $slice = 9) {
		$username = strtolower( $username );
         
		$by_hashtag = ( substr( $username, 0, 1) == '#' );
		//if ( false === ( $instagram = get_transient( 'instagram-media-new-'.sanitize_title_with_dashes( $username ) ) ) ) {
			$request_param = ( $by_hashtag ) ? 'explore/tags/' . substr( $username, 1) : trim( $username );
			$remote = wp_remote_get( 'http://instagram.com/'. $request_param );
			if ( is_wp_error( $remote ) )
				return new WP_Error( 'site_down', __( 'Unable to communicate with Instagram.', 'blance' ) );
			if ( 200 != wp_remote_retrieve_response_code( $remote ) )
				return new WP_Error( 'invalid_response', __( 'Instagram did not return a 200.', 'blance' ) );
			$shards = explode( 'window._sharedData = ', $remote['body'] );
			$insta_json = explode( ';</script>', $shards[1] );
			$insta_array = json_decode( $insta_json[0], TRUE );
			if ( !$insta_array )
				return new WP_Error( 'bad_json', __( 'Instagram has returned invalid data.', 'blance' ) );
			// old style
			if ( isset( $insta_array['entry_data']['UserProfile'][0]['userMedia'] ) ) {
				$images = $insta_array['entry_data']['UserProfile'][0]['userMedia'];
				$type = 'old';
			// new style
			} else if ( isset( $insta_array['entry_data']['ProfilePage'][0]['graphql']['user']['edge_owner_to_timeline_media']['edges']) ) {
				$images = $insta_array['entry_data']['ProfilePage'][0]['graphql']['user']['edge_owner_to_timeline_media']['edges'];
				$type = 'new';
			} elseif( $by_hashtag && isset( $insta_array['entry_data']['TagPage'][0]['tag']['media']['nodes'] ) ) {
				$images = $insta_array['entry_data']['TagPage'][0]['tag']['media']['nodes'];
				$type = 'new';
			} else {
				return new WP_Error( 'bad_json_2', __( 'Instagram has returned invalid data.', 'blance' ) );
			}
            
			//ar($images);
			if ( !is_array( $images ) )
				return new WP_Error( 'bad_array', __( 'Instagram has returned invalid data.', 'blance' ) );
			$instagram = array();
           
			switch ( $type ) {
			 
				case 'old':
					foreach ( $images as $image ) {
					  
						if ( $image['user']['username'] == $username ) {
							$image['link']						  = $image['link'];
							$image['images']['thumbnail']		   = preg_replace( "/^http:/i", "", $image['images']['thumbnail'] );
							$image['images']['standard_resolution'] = preg_replace( "/^http:/i", "", $image['images']['standard_resolution'] );
							$image['images']['low_resolution']	  = preg_replace( "/^http:/i", "", $image['images']['low_resolution'] );
							$instagram[] = array(
								'description'   => $image['caption']['text'],
								'link'		  	=> $image['link'],
								'time'		  	=> $image['created_time'],
								'comments'	  	=> $image['comments']['count'],
								'likes'		 	=> $image['likes']['count'],
								'thumbnail'	 	=> $image['images']['thumbnail'],
								'large'		 	=> $image['images']['standard_resolution'],
								'small'		 	=> $image['images']['low_resolution'],
								'type'		  	=> $image['type']
							);
						}
					}
				break;
				default:
					foreach ( $images as $imagess ) {
					   foreach ($imagess as $image) {
						$image['thumbnail_src'] = preg_replace( "/^https:/i", "", $image['thumbnail_src'] );
						$image['thumbnail'] = $image['thumbnail_resources'][0]['src'];
						$image['medium'] = $image['thumbnail_resources'][2]['src'];
						$image['large'] = $image['thumbnail_src'];
						if ( $image['is_video'] == true ) {
							$type = 'video';
						} else {
							$type = 'image';
						}
						$caption = esc_html__( 'Instagram Image', 'blance' );
						if ( ! empty( $image['caption'] ) ) {
							$caption = $image['caption'];
						}
						$instagram[] = array(
							'description'   => $caption,
							'link'		  	=> '//instagram.com/p/' . $image['shortcode'],
							'likes'		 	=> $image['edge_media_preview_like']['count'],
							'thumbnail'	 	=> $image['thumbnail'],
							'medium'		=> $image['medium'],
							'large'			=> $image['large'],
							'type'		  	=> $type
						);
                        }
					}
                   
				break;
			}
			// do not set an empty transient - should help catch private or empty accounts
			if ( ! empty( $instagram ) ) {
				$instagram = base64_encode( maybe_serialize( $instagram ) );
				set_transient( 'instagram-media-new-'.sanitize_title_with_dashes( $username ), $instagram, apply_filters( 'null_instagram_cache_time', HOUR_IN_SECONDS*2 ) );
			}
		//}
		if ( ! empty( $instagram ) ) {
		  
			$instagram = maybe_unserialize( base64_decode( $instagram ) );
			return array_slice( $instagram, 0, $slice );
		} else {
			return new WP_Error( 'no_images', __( 'Instagram did not return any images.', 'blance' ) );
		}
	}
}

if( !function_exists( 'blance_instagram_images_only' ) ) {
	function blance_instagram_images_only($media_item) {
		if ($media_item['type'] == 'image')
			return true;
		return false;
	}
}


/**
* ------------------------------------------------------------------------------------------------
* Google Map shortcode
* ------------------------------------------------------------------------------------------------
*/
function jwsthemes_maps_render($params) {
    extract(shortcode_atts(array(
    	'api'					=>	'AIzaSyCyuW48kPjku1h6fle8WYwO1pKI3Hdp4wk',
    	'address'				=>	'New York, United States',
    	'infoclick'				=>	'',
    	'coordinate'			=>	'',
    	'markercoordinate'		=>	'',
    	'markertitle'			=>	'',
    	'markerdesc'			=>	'',
    	'markerlist'			=>	'',
    	'markericon'			=>	'',
    	'infowidth'				=>	'200',
    	'width' 				=> 	'auto',
    	'height' 				=> 	'350px',
    	'type'					=>	'ROADMAP',
    	'style'					=>	'',
    	'zoom'					=>	'13',
    	'scrollwheel'			=>	'',
    	'pancontrol'			=>	'',
    	'zoomcontrol'			=>	'',
    	'scalecontrol'			=>	'',
    	'maptypecontrol'		=>	'',
    	'streetviewcontrol'		=>	'',
    	'overviewmapcontrol'	=>	'',
	), $params));
	
    /* API Key */
    if(!$api){
        $api = 'AIzaSyCyuW48kPjku1h6fle8WYwO1pKI3Hdp4wk';
    }
    $api_js = "https://maps.googleapis.com/maps/api/js?key=$api&sensor=false";
    wp_enqueue_script('maps-googleapis',$api_js,array(),'3.0.0');
    wp_enqueue_script('maps-apiv3', URI_PATH_FR . "/shortcodes/maps.js",array(),'1.0.0');
    /* Map Style defualt */
    $map_styles = array(
    	'Subtle-Grayscale'=>'[{"featureType":"landscape","stylers":[{"saturation":-100},{"lightness":65},{"visibility":"on"}]},{"featureType":"poi","stylers":[{"saturation":-100},{"lightness":51},{"visibility":"simplified"}]},{"featureType":"road.highway","stylers":[{"saturation":-100},{"visibility":"simplified"}]},{"featureType":"road.arterial","stylers":[{"saturation":-100},{"lightness":30},{"visibility":"on"}]},{"featureType":"road.local","stylers":[{"saturation":-100},{"lightness":40},{"visibility":"on"}]},{"featureType":"transit","stylers":[{"saturation":-100},{"visibility":"simplified"}]},{"featureType":"administrative.province","stylers":[{"visibility":"off"}]},{"featureType":"water","elementType":"labels","stylers":[{"visibility":"on"},{"lightness":-25},{"saturation":-100}]},{"featureType":"water","elementType":"geometry","stylers":[{"hue":"#ffff00"},{"lightness":-25},{"saturation":-97}]}]',
    	'Shades-of-Grey'=>'[{"featureType":"all","elementType":"labels.text.fill","stylers":[{"saturation":36},{"color":"#000000"},{"lightness":40}]},{"featureType":"all","elementType":"labels.text.stroke","stylers":[{"visibility":"on"},{"color":"#000000"},{"lightness":16}]},{"featureType":"all","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"administrative","elementType":"geometry.fill","stylers":[{"color":"#000000"},{"lightness":20}]},{"featureType":"administrative","elementType":"geometry.stroke","stylers":[{"color":"#000000"},{"lightness":17},{"weight":1.2}]},{"featureType":"landscape","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":20}]},{"featureType":"poi","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":21}]},{"featureType":"road.highway","elementType":"geometry.fill","stylers":[{"color":"#000000"},{"lightness":17}]},{"featureType":"road.highway","elementType":"geometry.stroke","stylers":[{"color":"#000000"},{"lightness":29},{"weight":0.2}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":18}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":16}]},{"featureType":"transit","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":19}]},{"featureType":"water","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":17}]}]',
    	'Blue-water'=>'[{"featureType":"administrative","elementType":"labels.text.fill","stylers":[{"color":"#444444"}]},{"featureType":"landscape","elementType":"all","stylers":[{"color":"#f2f2f2"}]},{"featureType":"poi","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"road","elementType":"all","stylers":[{"saturation":-100},{"lightness":45}]},{"featureType":"road.highway","elementType":"all","stylers":[{"visibility":"simplified"}]},{"featureType":"road.arterial","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"transit","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"water","elementType":"all","stylers":[{"color":"#46bcec"},{"visibility":"on"}]}]',
    	'Pale-Dawn'=>'[{"featureType":"administrative","elementType":"all","stylers":[{"visibility":"on"},{"lightness":33}]},{"featureType":"landscape","elementType":"all","stylers":[{"color":"#f2e5d4"}]},{"featureType":"poi.park","elementType":"geometry","stylers":[{"color":"#c5dac6"}]},{"featureType":"poi.park","elementType":"labels","stylers":[{"visibility":"on"},{"lightness":20}]},{"featureType":"road","elementType":"all","stylers":[{"lightness":20}]},{"featureType":"road.highway","elementType":"geometry","stylers":[{"color":"#c5c6c6"}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"color":"#e4d7c6"}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"color":"#fbfaf7"}]},{"featureType":"water","elementType":"all","stylers":[{"visibility":"on"},{"color":"#acbcc9"}]}]',
    	'Blue-Essence'=>'[{"featureType":"landscape.natural","elementType":"geometry.fill","stylers":[{"visibility":"on"},{"color":"#e0efef"}]},{"featureType":"poi","elementType":"geometry.fill","stylers":[{"visibility":"on"},{"hue":"#1900ff"},{"color":"#c0e8e8"}]},{"featureType":"road","elementType":"geometry","stylers":[{"lightness":100},{"visibility":"simplified"}]},{"featureType":"road","elementType":"labels","stylers":[{"visibility":"off"}]},{"featureType":"transit.line","elementType":"geometry","stylers":[{"visibility":"on"},{"lightness":700}]},{"featureType":"water","elementType":"all","stylers":[{"color":"#7dcdcd"}]}]',
    	'Apple-Maps-esque'=>'[{"featureType":"landscape.man_made","elementType":"geometry","stylers":[{"color":"#f7f1df"}]},{"featureType":"landscape.natural","elementType":"geometry","stylers":[{"color":"#d0e3b4"}]},{"featureType":"landscape.natural.terrain","elementType":"geometry","stylers":[{"visibility":"off"}]},{"featureType":"poi","elementType":"labels","stylers":[{"visibility":"off"}]},{"featureType":"poi.business","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"poi.medical","elementType":"geometry","stylers":[{"color":"#fbd3da"}]},{"featureType":"poi.park","elementType":"geometry","stylers":[{"color":"#bde6ab"}]},{"featureType":"road","elementType":"geometry.stroke","stylers":[{"visibility":"off"}]},{"featureType":"road","elementType":"labels","stylers":[{"visibility":"off"}]},{"featureType":"road.highway","elementType":"geometry.fill","stylers":[{"color":"#ffe15f"}]},{"featureType":"road.highway","elementType":"geometry.stroke","stylers":[{"color":"#efd151"}]},{"featureType":"road.arterial","elementType":"geometry.fill","stylers":[{"color":"#ffffff"}]},{"featureType":"road.local","elementType":"geometry.fill","stylers":[{"color":"black"}]},{"featureType":"transit.station.airport","elementType":"geometry.fill","stylers":[{"color":"#cfb2db"}]},{"featureType":"water","elementType":"geometry","stylers":[{"color":"#a2daf2"}]}]',
    );
    /* Select Template */
    $map_template = '';
    switch ($style){
    	case '':
    		$map_template = '';
    		break;
    	default:
    		$map_template = rawurlencode($map_styles[$style]);
    		break;
    }
    /* marker render */
    $marker = new stdClass();
    if($markercoordinate){
    	$marker->markercoordinate = $markercoordinate;
    	if($markerdesc || $markertitle){
    	$marker->markerdesc = 	'<div class="ro-maps-info-content">'.
    							'<h5>'.$markertitle.'</h5>'.
    							'<span>'.$markerdesc.'</span>'.
    							'</div>';
    	}
    	if($markericon){
    		$marker->markericon = wp_get_attachment_url($markericon);
    	}
    }
    if($markerlist){
    	$marker->markerlist = $markerlist;
    }
    $marker = rawurlencode(json_encode($marker));
    /* control render */
    $controls = new stdClass();
    if($scrollwheel == true){ $controls->scrollwheel = 1; } else { $controls->scrollwheel = 0; }
    if($pancontrol == true){ $controls->pancontrol = true; } else { $controls->pancontrol = false; }
    if($zoomcontrol == true){ $controls->zoomcontrol = true; } else { $controls->zoomcontrol = false; }
    if($scalecontrol == true){ $controls->scalecontrol = true; } else { $controls->scalecontrol = false; }
    if($maptypecontrol == true){ $controls->maptypecontrol = true; } else { $controls->maptypecontrol = false; }
    if($streetviewcontrol == true){ $controls->streetviewcontrol = true; } else { $controls->streetviewcontrol = false; }
    if($overviewmapcontrol == true){ $controls->overviewmapcontrol = true; } else { $controls->overviewmapcontrol = false; }
    if($infoclick == true){ $controls->infoclick = true; } else { $controls->infoclick = false; }
    $controls->infowidth = $infowidth;
    $controls->style = $style;
    $controls = rawurlencode(json_encode($controls));
    /* data render */
    $setting = array(
    	"data-address='$address'",
    	"data-marker='$marker'",
    	"data-coordinate='$coordinate'",
    	"data-type='$type'",
     	"data-zoom='$zoom'",
    	"data-template='$map_template'",
    	"data-controls='$controls'"
    );
    ob_start();
	$maps_id = uniqid('maps-');
    ?>
    <div class="ro_maps">
    	<div id="<?php echo $maps_id; ?>" class="maps-render" <?php echo implode(' ', $setting); ?> style="width:<?php echo esc_attr($width); ?>;height: <?php echo esc_attr($height); ?>"></div>
    </div>
	<?php
	return ob_get_clean();
}
 add_shortcode('maps', 'jwsthemes_maps_render'); 
/**
* ------------------------------------------------------------------------------------------------
* Login
* ------------------------------------------------------------------------------------------------
*/
function tb_login_form_func($atts, $content = null) {
    extract(shortcode_atts(array(
        'link_facebook' => '#',
        'link_twitter' => '#',
        'el_class' => ''
    ), $atts));
	
    $class = array();
	$class[] = 'tb-login-form';
	$class[] = $el_class;
    ob_start();
    ?>
		<div class="<?php echo esc_attr(implode(' ', $class)); ?>">
			<h5 class="tb-title"><?php _e('Login', 'blance'); ?></h5>
			<p><?php _e('Hello, Welcome your to account', 'blance'); ?></p>
			<div class="tb-social-login">
				<a class="tb-facebook-login" href="<?php echo esc_url($link_facebook); ?>"><i class="fa fa-facebook"></i><?php _e('Sign In With Facebook', 'blance') ?></a>
				<a class="tb-twitter-login" href="<?php echo esc_url($link_twitter); ?>"><i class="fa fa-twitter"></i><?php _e('Sign In With Twitter', 'blance') ?></a>
			</div>
			<?php
				$args = array(
					'echo'           => true,
					'remember'       => true,
					'redirect'       => home_url('/'),
					'form_id'        => 'loginform',
					'id_username'    => 'user_login',
					'id_password'    => 'user_pass',
					'id_remember'    => 'rememberme',
					'id_submit'      => 'wp-submit',
					'label_username' => __( 'Email Address', 'blance' ),
					'label_password' => __( 'Password', 'blance' ),
					'label_remember' => __( 'Remember me!', 'blance' ),
					'label_log_in'   => __( 'LogIn', 'blance' ),
					'value_username' => '',
					'value_remember' => false
				);
				wp_login_form($args); 
			?>
		</div>
		
    <?php
    return ob_get_clean();
    
}

add_shortcode('login_form', 'tb_login_form_func');
add_action( 'login_form_middle', 'tb_add_lost_password_link' );
function tb_add_lost_password_link() {
    return '<a class="forgot-password" href="'.wp_lostpassword_url().'" title="Forgot Your password">Forgot Your password?</a>';
}

/**
* ------------------------------------------------------------------------------------------------
* Blog shortcode
* ------------------------------------------------------------------------------------------------
*/

if( ! function_exists( 'blance_shortcode_blog' ) ) {
	function blance_shortcode_blog( $atts ) {
		global $blance_loop;
	    $parsed_atts = shortcode_atts( array(
	        'post_type'  => 'post',
	        'include'  => '',
	        'custom_query'  => '',
	        'taxonomies'  => '',
	        'pagination'  => '',
	        'parts_title'  => true,
	        'parts_meta'  => true,
	        'parts_text'  => true,
	        'parts_btn'  => true,
	        'items_per_page'  => 12,
	        'offset'  => '',
	        'orderby'  => 'date',
            'blog_design' => 'default',
	        'order'  => 'DESC',
	        'meta_key'  => '',
	        'exclude'  => '',
	        'ajax_page' => '',
	        'img_size' => 'medium',
            'blog_columns' =>'2',
            'readmore_text' => 'Read More'
	    ), $atts );

	    extract( $parsed_atts );

	    $encoded_atts = json_encode( $parsed_atts );
        if ($blog_columns == '2') {
         $class_column = ' col-lg-6 col-md-6 col-sm-12 col-xs-12'; 
         $size_col = "size-6" ;
        }elseif($blog_columns == '3') {
         $class_column = ' col-lg-4 col-md-4 col-sm-4 col-xs-12'; 
         $size_col = "size-4" ;  
        }
        elseif($blog_columns == '4') {
         $class_column = ' col-lg-3 col-md-3 col-sm-6 col-xs-12'; 
         $size_col = "size-3" ;   
        }else{
        $class_column = ' col-lg-2 col-md-2 col-sm-6 col-xs-12'; 
        $size_col = "size-2" ;      
        }
	    $is_ajax = (defined( 'DOING_AJAX' ) && DOING_AJAX);
      

	    $output = '';

		$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

		if( $ajax_page > 1 ) $paged = $ajax_page;

	    $args = array(
	    	'post_type' => 'post',
	    	'status' => 'published',
	    	'paged' => $paged,	
	    	'posts_per_page' => $items_per_page
		);

		if( $post_type == 'ids' && $include != '' ) {
			$args['post__in'] = explode(',', $include);
		}

		if( ! empty( $exclude ) ) {
			$args['post__not_in'] = explode(',', $exclude);
		}

		if( ! empty( $taxonomies ) ) {
			$taxonomy_names = get_object_taxonomies( 'post' );
			$terms = get_terms( $taxonomy_names, array(
				'orderby' => 'name',
				'include' => $taxonomies
			));

			if( ! is_wp_error( $terms ) && ! empty( $terms ) ) {
				$args['tax_query'] = array('relation' => 'OR');
				foreach ($terms as $key => $term) {
					$args['tax_query'][] = array(
				        'taxonomy' => $term->taxonomy,     
				        'field' => 'slug',                  
				        'terms' => array( $term->slug ),   
				        'include_children' => true,        
				        'operator' => 'IN'  
					);
				}
			}
		}

		if( ! empty( $order ) ) {
			$args['order'] = $order;
		}

		if( ! empty( $offset ) ) {
			$args['offset'] = $offset;
		}

		if( ! empty( $meta_key ) ) {
			$args['meta_key'] = $meta_key;
		}

		if( ! empty( $orderby ) ) {
			$args['orderby'] = $orderby;
		}

	    $blog_query = new WP_Query($args);

	    ob_start();
       
        
	    $blance_loop['img_size'] = $img_size;


	    $blance_loop['loop'] = 0;
    
	    $blance_loop['parts']['title'] = $parts_title;
	    $blance_loop['parts']['meta'] = $parts_meta;
	    $blance_loop['parts']['text'] = $parts_text;
     
	    if( ! $parts_btn )
	    	$blance_loop['parts']['btn'] = false;


	       
        $class = 'jws-masonry';
    	$data  = 'data-masonry=\'{"selector":".post-item ", "columnWidth":".grid-sizer","layoutMode":"masonry"}\'';
    	$sizer = '<div class="grid-sizer '.$size_col.'"></div>';
	    if(!$is_ajax) echo '<div class="blance-blog-holder row ' . esc_attr( $class) . '" data-paged="1" data-atts="' . esc_attr( $encoded_atts ) . '" '.wp_kses_post( $data ).' >';
        
 
	   echo wp_kses_post( $sizer );
		while ( $blog_query->have_posts() ) {
			$blog_query->the_post();
            $num_comments = get_comments_number();
            if($blog_design == "default") {
               ?>
                <div class="post-item <?php echo $class_column ; ?>">
                <div class="bog-image">
                <a href="<?php the_permalink() ?>">
                <?php 
                echo blance_get_post_thumbnail('large');
                 ?>
                 </a>
                </div>
                <div class="content-blog">
                    <div class="title">
                        <h5><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
                    </div>
                    <div class="blog-innfo">
                        <span class="author">By <span class="child"><?php the_author() ?></span></span><span class="date">on <span class="child"><?php  echo get_the_date(); ?></span></span><span class="comment"><i class=" fa fa-comment-o"></i><span class="child"></span><?php echo $num_comments?></span>
                    </div>
                </div>
                </div>
            <?php 
            }elseif($blog_design == "border-bottom") {
                ?>
                <div class="post-item layout-2 <?php echo $class_column ; ?>">
                <div class="bog-image">
                <a href="<?php the_permalink() ?>">
                <?php 
                echo blance_get_post_thumbnail('large');
                 ?>
                 </a>
                </div>
                <div class="content-blog">
                <div class="content-inner">
                    <div class="title">
                        <h5><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
                    </div>
                    <div class="blog-excrept">
                        <?php the_excerpt(); ?>
                    </div>
                    <div class="blog-link"><a class="read-more" href="<?php the_permalink(); ?>"><?php echo $readmore_text; ?></a><span class="right-link"><span class="comment"><i class=" fa fa-comment-o"></i><span class="child"></span><?php echo $num_comments?></span></span></div>
                </div>
                </div>
                </div>
            <?php
            }else {
                ?>
                <div class="post-item-menu layout-3 <?php echo $class_column ; ?>">
                <div class="bog-image">
                <a href="<?php the_permalink() ?>">
                <?php 
                echo blance_get_post_thumbnail('large');
                 ?>
                 </a>
                </div>
                <div class="content-blog">
                <div class="content-inner">
                    <div class="title">
                        <h5><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
                    </div>
                    <div class="blog-link-menu"><a style="color: #252525; font-style: italic;" class="read-more" href="<?php the_permalink(); ?>"><?php echo $readmore_text; ?></a></div>
                </div>
                </div>
                </div>
                <?php
            }
			
		}

    	if(!$is_ajax) echo '</div>';
        
		if ( $blog_query->max_num_pages > 1 && !$is_ajax && ! empty( $pagination ) ) {
			?>
		    	<div class="blog-footer">
		    		<?php if ($pagination == 'more-btn'): ?>
		    			<a href="#" class="btn blance-blog-load-more"><?php _e('Load More', 'blance'); ?></a>
                        <p  class="posts-loaded"><?php _e('All Posts Loaded.', 'blance'); ?></p>
	    			<?php elseif( $pagination == 'pagination' ): ?>
		    			<?php query_pagination( $blog_query->max_num_pages ); ?>
		    		<?php endif ?>
		    	</div>
		    <?php 
		}
         ?>
        <?php
	    unset( $blance_loop );
	    
	    wp_reset_postdata();
	    $output .= ob_get_clean();
       
        
	    ob_flush();

	    if( $is_ajax ) {
	    	$output =  array(
	    		'items' => $output,
	    		'status' => ( $blog_query->max_num_pages > $paged ) ? 'have-posts' : 'no-more-posts'
	    	);
	    }
	     
	    return $output;

	}

	add_shortcode( 'blance_blog', 'blance_shortcode_blog' );
}
if( ! function_exists( 'blance_get_blog_shortcode_ajax' ) ) {
	add_action( 'wp_ajax_blance_get_blog_shortcode', 'blance_get_blog_shortcode_ajax' );
	add_action( 'wp_ajax_nopriv_blance_get_blog_shortcode', 'blance_get_blog_shortcode_ajax' );
	function blance_get_blog_shortcode_ajax() {
		if( ! empty( $_POST['atts'] ) ) {
			$atts = $_POST['atts'];
			$paged = (empty($_POST['paged'])) ? 2 : (int) $_POST['paged'] + 1;
			$atts['ajax_page'] = $paged;

			$data = blance_shortcode_blog($atts);
        
			echo json_encode( $data );

			die();
		}
	}
}

/**
* ------------------------------------------------------------------------------------------------
* portfolio shortcode
* ------------------------------------------------------------------------------------------------
*/

if( ! function_exists( 'blance_shortcode_portfolio' ) ) {
	function blance_shortcode_portfolio( $atts ) {
		global $blance_loop;
       
	    $parsed_atts = shortcode_atts( array(
	        'post_type'  => 'post',
	        'include'  => '',
	        'custom_query'  => '',
	        'taxonomies'  => '',
	        'pagination'  => '',
	        'parts_title'  => true,
	        'parts_meta'  => true,
	        'parts_text'  => true,
	        'parts_btn'  => true,
	        'items_per_page'  => 12,
	        'offset'  => '',
	        'orderby'  => 'date',
            'portfolio_design' => 'default',
	        'order'  => 'DESC',
	        'meta_key'  => '',
	        'exclude'  => '',
	        'ajax_page' => '',
	        'img_size' => 'medium',
            'portfolio_columns' =>'2',
            'readmore_text' => 'Read More'
	    ), $atts );

	    extract( $parsed_atts );

	    $encoded_atts = json_encode( $parsed_atts );
        if ($portfolio_columns == '2') {
         $size_col = "size-6" ;
        }elseif($portfolio_columns == '3') {
         $size_col = "size-3" ;  
        }
        elseif($portfolio_columns == '4') {
         $size_col = "size-4" ;   
        }else{
        $size_col = "size-2" ;      
        }
        
	    $is_ajax = (defined( 'DOING_AJAX' ) && DOING_AJAX);
            
	    $output = '';

		$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

		if( $ajax_page > 1 ) $paged = $ajax_page;

	    $args = array(
	    	'post_type' => 'portfolio',
	    	'status' => 'published',
	    	'paged' => $paged,	
	    	'posts_per_page' => $items_per_page
		);

		if( $post_type == 'ids' && $include != '' ) {
			$args['post__in'] = explode(',', $include);
		}

		if( ! empty( $exclude ) ) {
			$args['post__not_in'] = explode(',', $exclude);
		}

		if( ! empty( $taxonomies ) ) {
			$taxonomy_names = get_object_taxonomies( 'post' );
			$terms = get_terms( $taxonomy_names, array(
				'orderby' => 'name',
				'include' => $taxonomies
			));

			if( ! is_wp_error( $terms ) && ! empty( $terms ) ) {
				$args['tax_query'] = array('relation' => 'OR');
				foreach ($terms as $key => $term) {
					$args['tax_query'][] = array(
				        'taxonomy' => $term->taxonomy,     
				        'field' => 'slug',                  
				        'terms' => array( $term->slug ),   
				        'include_children' => true,        
				        'operator' => 'IN'  
					);
				}
			}
		}

		if( ! empty( $order ) ) {
			$args['order'] = $order;
		}

		if( ! empty( $offset ) ) {
			$args['offset'] = $offset;
		}

		if( ! empty( $meta_key ) ) {
			$args['meta_key'] = $meta_key;
		}

		if( ! empty( $orderby ) ) {
			$args['orderby'] = $orderby;
		}

	    $portfolio_query = new WP_Query($args);

	    ob_start();

        
	    $blance_loop['img_size'] = $img_size;


	    $blance_loop['loop'] = 0;
    
	    $blance_loop['parts']['title'] = $parts_title;
	    $blance_loop['parts']['meta'] = $parts_meta;
	    $blance_loop['parts']['text'] = $parts_text;
     
	    if( ! $parts_btn )
	    	$blance_loop['parts']['btn'] = false;


	 
        $class = 'jws-masonry';
    	$data  = 'data-masonry=\'{"selector":".post-item ", "columnWidth":".grid-sizer","layoutMode":"masonry"}\'';
    	$sizer = '<div class="grid-sizer '.$size_col.'"></div>';
	    if(!$is_ajax) echo '<div class="blance-portfolio-holder row ' . esc_attr( $class) . '" data-paged="1" data-atts="' . esc_attr( $encoded_atts ) . '" '.wp_kses_post( $data ).' >';
        
 
        						echo wp_kses_post( $sizer );
		while ( $portfolio_query->have_posts() ) {
			$portfolio_query->the_post();
            get_template_part( 'framework/templates/portfolio/entry' );
		}

    	if(!$is_ajax) echo '</div>';

		if ( $portfolio_query->max_num_pages > 1 && !$is_ajax && ! empty( $pagination ) ) {
			?>
		    	<div class="portfolio-footer">
		    		<?php if ($pagination == 'more-btn'): ?>
		    			<a href="#" class="btn blance-portfolio-load-more"><?php _e('Load more posts', 'blance'); ?></a>
	    			<?php elseif( $pagination == 'pagination' ): ?>
		    			<?php query_pagination( $portfolio_query->max_num_pages ); ?>
		    		<?php endif ?>
		    	</div>
		    <?php 
		}

	    unset( $blance_loop );
	    
	    wp_reset_postdata();

	    $output .= ob_get_clean();

	    ob_flush();

	    if( $is_ajax ) {
	    	$output =  array(
	    		'items' => $output,
	    		'status' => ( $portfolio_query->max_num_pages > $paged ) ? 'have-posts' : 'no-more-posts'
	    	);
	    }
	    
	    return $output;

	}

	add_shortcode( 'blance_portfolio', 'blance_shortcode_portfolio' );
}
if( ! function_exists( 'blance_get_portfolio_shortcode_ajax' ) ) {
	add_action( 'wp_ajax_blance_get_portfolio_shortcode', 'blance_get_portfolio_shortcode_ajax' );
	add_action( 'wp_ajax_nopriv_blance_get_portfolio_shortcode', 'blance_get_portfolio_shortcode_ajax' );
	function blance_get_portfolio_shortcode_ajax() {
		if( ! empty( $_POST['atts'] ) ) {
			$atts = $_POST['atts'];
			$paged = (empty($_POST['paged'])) ? 2 : (int) $_POST['paged'] + 1;
			$atts['ajax_page'] = $paged;

			$data = blance_shortcode_portfolio($atts);

			echo json_encode( $data );

			die();
		}
	}
}

/**
* ------------------------------------------------------------------------------------------------
* Override WP default gallery
* ------------------------------------------------------------------------------------------------
*/


if( ! function_exists( 'blance_gallery_shortcode' ) ) {

	function blance_gallery_shortcode( $attr ) {
		$post = get_post();

		static $instance = 0;
		$instance++;

		if ( ! empty( $attr['ids'] ) ) {
			// 'ids' is explicitly ordered, unless you specify otherwise.
			if ( empty( $attr['orderby'] ) ) {
				$attr['orderby'] = 'post__in';
			}
			$attr['include'] = $attr['ids'];
		}

		/**
		 * Filter the default gallery shortcode output.
		 *
		 * If the filtered output isn't empty, it will be used instead of generating
		 * the default gallery template.
		 *
		 * @since 2.5.0
		 *
		 * @see gallery_shortcode()
		 *
		 * @param string $output The gallery output. Default empty.
		 * @param array  $attr   Attributes of the gallery shortcode.
		 */
		$output = apply_filters( 'post_gallery', '', $attr );
		if ( $output != '' ) {
			return $output;
		}

		$html5 = current_theme_supports( 'html5', 'gallery' );
		$atts = shortcode_atts( array(
			'order'      => 'ASC',
			'orderby'    => 'menu_order ID',
			'id'         => $post ? $post->ID : 0,
			'itemtag'    => $html5 ? 'figure'     : 'dl',
			'icontag'    => $html5 ? 'div'        : 'dt',
			'captiontag' => $html5 ? 'figcaption' : 'dd',
			'columns'    => 3,
			'size'       => 'thumbnail',
			'include'    => '',
			'exclude'    => '',
			'link'       => ''
		), $attr, 'gallery' );

		$atts['link'] = 'file';

		$id = intval( $atts['id'] );

		if ( ! empty( $atts['include'] ) ) {
			$_attachments = get_posts( array( 'include' => $atts['include'], 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $atts['order'], 'orderby' => $atts['orderby'] ) );

			$attachments = array();
			foreach ( $_attachments as $key => $val ) {
				$attachments[$val->ID] = $_attachments[$key];
			}
		} elseif ( ! empty( $atts['exclude'] ) ) {
			$attachments = get_children( array( 'post_parent' => $id, 'exclude' => $atts['exclude'], 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $atts['order'], 'orderby' => $atts['orderby'] ) );
		} else {
			$attachments = get_children( array( 'post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $atts['order'], 'orderby' => $atts['orderby'] ) );
		}

		if ( empty( $attachments ) ) {
			return '';
		}

		if ( is_feed() ) {
			$output = "\n";
			foreach ( $attachments as $att_id => $attachment ) {
				$output .= wp_get_attachment_link( $att_id, $atts['size'], true ) . "\n";
			}
			return $output;
		}

		$itemtag = tag_escape( $atts['itemtag'] );
		$captiontag = tag_escape( $atts['captiontag'] );
		$icontag = tag_escape( $atts['icontag'] );
		$valid_tags = wp_kses_allowed_html( 'post' );
		if ( ! isset( $valid_tags[ $itemtag ] ) ) {
			$itemtag = 'dl';
		}
		if ( ! isset( $valid_tags[ $captiontag ] ) ) {
			$captiontag = 'dd';
		}
		if ( ! isset( $valid_tags[ $icontag ] ) ) {
			$icontag = 'dt';
		}

		$columns = intval( $atts['columns'] );
		$itemwidth = $columns > 0 ? floor(100/$columns) : 100;
		$float = is_rtl() ? 'right' : 'left';

		$selector = "gallery-{$instance}";

		$gallery_style = '';

		/**
		 * Filter whether to print default gallery styles.
		 *
		 * @since 3.1.0
		 *
		 * @param bool $print Whether to print default gallery styles.
		 *                    Defaults to false if the theme supports HTML5 galleries.
		 *                    Otherwise, defaults to true.
		 */
		if ( apply_filters( 'use_default_gallery_style', ! $html5 ) ) {
			$gallery_style = "
			<style type='text/css'>
				#{$selector} {
					margin: auto;
				}
				#{$selector} .gallery-item {
					float: {$float};
					margin-top: 10px;
					text-align: center;
					width: {$itemwidth}%;
				}
				#{$selector} img {
					max-width:100%;
				}
				#{$selector} .gallery-caption {
					margin-left: 0;
				}
			</style>\n\t\t";
		}

		$size_class = sanitize_html_class( $atts['size'] );
		$gallery_div = "<div id='$selector' class='gallery galleryid-{$id} gallery-columns-{$columns} gallery-size-{$size_class}'>";

		/**
		 * Filter the default gallery shortcode CSS styles.
		 *
		 * @since 2.5.0
		 *
		 * @param string $gallery_style Default CSS styles and opening HTML div container
		 *                              for the gallery shortcode output.
		 */
		$output = apply_filters( 'gallery_style', $gallery_style . $gallery_div );

		$rows_width = $thumbs_heights = array();
		$row_i = 0;

		$i = 0;
		foreach ( $attachments as $id => $attachment ) {

			$attr = ( trim( $attachment->post_excerpt ) ) ? array( 'aria-describedby' => "$selector-$id" ) : '';
			if ( ! empty( $atts['link'] ) && 'file' === $atts['link'] ) {
				$image_output = wp_get_attachment_link( $id, $atts['size'], false, false, false, $attr );
			} elseif ( ! empty( $atts['link'] ) && 'none' === $atts['link'] ) {
				$image_output = wp_get_attachment_image( $id, $atts['size'], false, $attr );
			} else {
				$image_output = wp_get_attachment_link( $id, $atts['size'], true, false, false, $attr );
			}
			$image_meta  = wp_get_attachment_metadata( $id );

			$orientation = '';
			if ( isset( $image_meta['height'], $image_meta['width'] ) ) {
				$orientation = ( $image_meta['height'] > $image_meta['width'] ) ? 'portrait' : 'landscape';
			}
			//$output .= "<{$itemtag} class='gallery-item'>";
			$output .= "
					$image_output";
			if ( false && $captiontag && trim($attachment->post_excerpt) ) {
				$output .= "
					<{$captiontag} class='wp-caption-text gallery-caption' id='$selector-$id'>
					" . wptexturize($attachment->post_excerpt) . "
					</{$captiontag}>";
			}
			//$output .= "</{$itemtag}>";
			if ( ! $html5 && $columns > 0 && ++$i % $columns == 0 ) {
				//$output .= '<br style="clear: both" />';
			}

			if($i % $columns == 0) {
				$row_i++;
			}

			$thumb = wp_get_attachment_image_src($id, $atts['size']);

			$thumbs_heights[] = $thumb[2];

			//echo $thumb[1] . '<br>';
		}


		ob_start();


		$rowHeight = 250;
		$maxRowHeight = min($thumbs_heights);

		if( $maxRowHeight < $rowHeight) {
			$rowHeight = $maxRowHeight;
		}


		?>
			<script type="text/javascript">
				jQuery( document ).ready(function() {
					jQuery("#<?php echo esc_js( $selector ); ?>").justifiedGallery({
						rowHeight: <?php echo esc_js( $rowHeight ); ?>,
						maxRowHeight: <?php echo esc_js( $maxRowHeight ); ?>,
						margins: 1
					});
				});
			</script>
		<?php
		$output .= ob_get_clean();


		if ( ! $html5 && $columns > 0 && $i % $columns !== 0 ) {
			//$output .= "<br style='clear: both' />";
		}

		$output .= "
			</div>\n";

		return $output;
	}
		
	remove_shortcode('gallery');
	add_shortcode('gallery', 'blance_gallery_shortcode');

}

/**
* ------------------------------------------------------------------------------------------------
* New gallery shortcode 
* ------------------------------------------------------------------------------------------------
*/
if( ! function_exists( 'blance_images_gallery_shortcode' )) {
	function blance_images_gallery_shortcode($atts) {
		$output = $class = '';

		$parsed_atts = shortcode_atts( array_merge( blance_get_owl_atts(), array(
			'ids'        => '',
			'images'     => '',
			'columns'    => 3,
			'size'       => '',
			'img_size'   => 'medium',
			'link'       => '',
			'spacing' 	 => 30,
			'lightbox'   => '',
			'view'		 => 'grid',
			'el_class' 	 => ''
		) ), $atts );

		extract( $parsed_atts );


		// Override standard wordpress gallery shortcodes

		if ( ! empty( $atts['ids'] ) ) {
			$atts['images'] = $atts['ids'];
		}

		if ( ! empty( $atts['size'] ) ) {
			$atts['img_size'] = $atts['size'];
		}

		extract( $atts );

		$carousel_id = 'gallery_' . rand(100,999);

		$images = explode(',', $images);

		$class .= ' ' . $el_class;
		if( $view != 'justified' ) $class .= ' spacing-' . $spacing;
		$class .= ' columns-' . $columns;
		$class .= ' view-' . $view;

		if( $lightbox ) $class .= ' photoswipe-images';
        $classs = $data = $sizer = '';
       	$data  = 'data-masonry=\'{"selector":".blance-gallery-item ", "columnWidth":".grid-sizer","layoutMode":"masonry"}\'';
       	$sizer = '<div class="grid-sizer size-'.$columns.'"></div>';
        $class_column = "col-md-" . $columns . " col-sm-4 col-xs-4";
		ob_start();
         wp_enqueue_style( 'skin-photo', 'https://cdnjs.cloudflare.com/ajax/libs/photoswipe/4.1.2/default-skin/default-skin.min.css', array(), '4.1.0');
          ?>
          <link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700" rel="stylesheet">
                
			<div id="<?php echo esc_attr( $carousel_id ); ?>" class="blance-images-gallery<?php echo esc_attr( $class ); ?>">
                
				<div class="gallery-images  <?php  if( $view == 'masonry' ) echo "jws-masonry" ?> <?php if ( $view == 'carousel' ) echo 'owl-carousel'; ?>" <?php  if( $view == 'masonry' )  echo wp_kses_post( $data ); ?>>
                    <?php
                    if( $view == 'masonry' )
                    echo wp_kses_post( $sizer );
				    ?>
					<?php if ( count($images) > 0 ): ?>
						<?php $i=0; foreach ($images as $img_id): 
							$i++; 
							$img = wpb_getImageBySize( array( 'attach_id' => $img_id, 'thumb_size' => $img_size, 'class' => 'blance-gallery-image image-' . $i ) );
							?>
							<div class="blance-gallery-item <?php if ( $view != 'carousel' )  echo $class_column; ?>">
								<?php if ( $lightbox ): ?>
								<a href="<?php echo esc_url( $img['p_img_large']['0'] ); ?>" data-index="<?php echo $i; ?>" data-width="<?php echo esc_attr( $img['p_img_large']['1'] ); ?>" data-height="<?php echo esc_attr( $img['p_img_large']['2'] ); ?>">
								<?php endif ?>
									<?php echo $img['thumbnail'];?>
								<?php if ( $lightbox ): ?>
								</a>
								<?php endif ?>
							</div>
						<?php endforeach ?>
					<?php endif ?>
				</div>
			</div>
			<?php if ( $view == 'carousel' ): 

				$parsed_atts['carousel_id'] = $carousel_id;
				blance_owl_carousel_init( $parsed_atts );

        endif;
		$output = ob_get_contents();
		ob_end_clean();

		return $output;

	}

	add_shortcode('blance_gallery', 'blance_images_gallery_shortcode');
}
/**
* ------------------------------------------------------------------------------------------------
* Categories grid shortcode
* ------------------------------------------------------------------------------------------------
*/

if( ! function_exists( 'blance_shortcode_categories' )) {
	function blance_shortcode_categories($atts, $content) {
		global $woocommerce_loop;
		$extra_class = '';	

		$parsed_atts = shortcode_atts( array_merge( blance_get_owl_atts(), array(
			'title' => __( 'Categories', 'blance' ),
			'number'     => null,
			'orderby'    => 'name',
			'order'      => 'ASC',
			'columns'    => '4',
			'hide_empty' => 1,
			'parent'     => '',
			'ids'        => '',
			'spacing' => 30,
			'style'      => 'default',
			'el_class' => '',
            'categories_design' => 'inherit'
		) ), $atts );

		extract( $parsed_atts );

		if ( isset( $ids ) ) {
			$ids = explode( ',', $ids );
			$ids = array_map( 'trim', $ids );
		} else {
			$ids = array();
		}

		$hide_empty = ( $hide_empty == true || $hide_empty == 1 ) ? 1 : 0;

		// get terms and workaround WP bug with parents/pad counts
		$args = array(
			'orderby'    => $orderby,
			'order'      => $order,
			'hide_empty' => $hide_empty,
			'include'    => $ids,
			'pad_counts' => true,
			'child_of'   => $parent
		);

		$product_categories = get_terms( 'product_cat', $args );

		if ( '' !== $parent ) {
			$product_categories = wp_list_filter( $product_categories, array( 'parent' => $parent ) );
		}

		if ( $hide_empty ) {
			foreach ( $product_categories as $key => $category ) {
				if ( $category->count == 0 ) {
					unset( $product_categories[ $key ] );
				}
			}
		}

		if ( $number ) {
			$product_categories = array_slice( $product_categories, 0, $number );
		}
        
        if($columns == "4") {
            $columnsit = "col-md-3 col-sm-6 col-xs-12";
        }elseif($columns == "3") {
            $columnsit = "col-md-4 col-sm-6 col-xs-12";
        }elseif($columns == "2") { 
            $columnsit = "col-md-6 col-sm-6 col-xs-12";
        }else {
            $columnsit = "col-md-2 col-sm-6 col-xs-12";
        }
		$columns = absint( $columns );

		if( $style == 'masonry' ) {
			$extra_class = 'categories-masonry';
		}
		
		if( $style == 'masonry-first' ) {
			$woocommerce_loop['different_sizes'] = array(1);
			$extra_class = 'categories-masonry';
			$columns = 4;
		}

		if( $categories_design != 'inherit' ) {
			$woocommerce_loop['categories_design'] = $categories_design;
		}

		$extra_class .= ' categories-space-' . $spacing;

		$woocommerce_loop['columns'] = $columns;
		$woocommerce_loop['style'] = $style;

		$carousel_id = 'carousel-' . rand(100,999);
		
		ob_start();

		// Reset loop/columns globals when starting a new loop
		$woocommerce_loop['loop'] = '';

		if ( $product_categories ) {
			//woocommerce_product_loop_start();

			if( $style == 'carousel' ) {
				?>

				<div id="<?php echo esc_attr( $carousel_id ); ?>" class="vc_carousel_container">
					<div class="owl-carousel carousel-items">
						<?php foreach ( $product_categories as $category ): ?>
							<div class="category-item">
								<?php 
									wc_get_template( 'content-product_cat.php', array(
										'category' => $category
									) );
								?>
							</div>
						<?php endforeach; ?>
					</div>
				</div> <!-- end #<?php echo esc_html( $carousel_id ); ?> -->

				<?php 
					$parsed_atts['carousel_id'] = $carousel_id;
					blance_owl_carousel_init( $parsed_atts );
			} else {

				foreach ( $product_categories as $category ) {
				    ?> <div class="cat-item <?php echo esc_attr($columnsit); ?>"> <?php
					wc_get_template( 'content-product_cat.php', array(
						'category' => $category
					) );
                    ?></div><?php
				}
			}

			//woocommerce_product_loop_end();
		}

		unset($woocommerce_loop['different_sizes']);

		woocommerce_reset_loop();

		if( $style == 'carousel' ) {
			return '<div class="woocommerce categories-style-'. esc_attr( $style ) . ' ' . esc_attr( $extra_class ) . '">' . ob_get_clean() . '</div>';
		} else {
			return '<div class="woocommerce row categories-style-'. esc_attr( $style ) . ' ' . esc_attr( $extra_class ) . ' columns-' . $columns . '">' . ob_get_clean() . '</div>';
		}

	}

	add_shortcode( 'blance_categories', 'blance_shortcode_categories' );

}

/**
* ------------------------------------------------------------------------------------------------
* Products widget shortcode
* ------------------------------------------------------------------------------------------------
*/

if( ! function_exists( 'blance_shortcode_products_widget' )) {
	function blance_shortcode_products_widget($atts, $content) {
		$output = $title = $el_class = '';
		extract( shortcode_atts( array(
			'title' => __( 'Products', 'blance' ),
			'el_class' => ''
		), $atts ) );

		$output = '<div class="widget_products' . $el_class . '">';
		$type = 'WC_Widget_Products';

		$args = array('widget_id' => rand(10,99));

		ob_start();
		the_widget( $type, $atts, $args );
		$output .= ob_get_clean();

		$output .= '</div>';

		return $output;

	}

	add_shortcode( 'blance_shortcode_products_widget', 'blance_shortcode_products_widget' );

}

/**
* ------------------------------------------------------------------------------------------------
* Counter shortcode
* ------------------------------------------------------------------------------------------------
*/

if( ! function_exists( 'blance_shortcode_animated_counter' )) {
	function blance_shortcode_animated_counter($atts) {
		$output = $label = $el_class = '';
		extract( shortcode_atts( array(
			'label' => '',
			'value' => 100,
			'time' => 1000,
			'size' => 'default',
			'el_class' => ''
		), $atts ) );

		$el_class .= ' counter-' . $size;

		ob_start();
		?>
			<div class="blance-counter <?php echo esc_attr( $el_class ); ?>">
				<span class="counter-value" data-state="new" data-final="<?php echo esc_attr( $value ); ?>"><?php echo esc_attr( $value ); ?></span>
				<?php if ($label != ''): ?>
					<span class="counter-label"><?php echo esc_html( $label ); ?></span>
				<?php endif ?>
			</div>

		<?php
		$output .= ob_get_clean();


		return $output;

	}

	add_shortcode( 'blance_counter', 'blance_shortcode_animated_counter' );

}

/**
* ------------------------------------------------------------------------------------------------
* Team member shortcode
* ------------------------------------------------------------------------------------------------
*/

if( ! function_exists( 'blance_shortcode_team_member' )) {
	function blance_shortcode_team_member($atts, $content = "") {
		$output = $title = $el_class = '';
		extract( shortcode_atts( array(
	        'align' => 'left',
	        'name' => '',
	        'position' => '',
	        'email' => '',
	        'twitter' => '',
	        'facebook' => '',
	        'google_plus' => '',
	        'skype' => '',
	        'linkedin' => '',
	        'instagram' => '',
	        'img' => '',
	        'img_size' => '270x170',
			'style' => 'default', // circle colored 
			'size' => 'default', // circle colored 
			'blance_color_scheme' => 'dark',
			'layout' => 'default',
			'el_class' => ''
		), $atts ) );
		
		$el_class .= ' member-layout-' . $layout;
		$el_class .= ' color-scheme-' . $blance_color_scheme;

		$img_id = preg_replace( '/[^\d]/', '', $img );

		$img = wpb_getImageBySize( array( 'attach_id' => $img_id, 'thumb_size' => $img_size, 'class' => 'team-member-avatar-image' ) );
	    
	    $socials = '';

        if ($linkedin != '' || $twitter != '' || $facebook != '' || $skype != '' || $google_plus != '' || $instagram != '') {
            $socials .= '<div class="member-social"><ul class="social-icons icons-design-' . esc_attr( $style ) . ' icons-size-' . esc_attr( $size ) .'">';
                if ($facebook != '') {
                    $socials .= '<li class="social-facebook"><a href="'.esc_url( $facebook ).'"><i class="fa fa-facebook"></i></a></li>';
                }
                if ($twitter != '') {
                    $socials .= '<li class="social-twitter"><a href="'.esc_url( $twitter ).'"><i class="fa fa-twitter"></i></a></li>';
                }
                if ($google_plus != '') {
                    $socials .= '<li class="social-google-plus"><a href="'.esc_url( $google_plus ).'"><i class="fa fa-google-plus"></i></a></li>';
                }
                if ($linkedin != '') {
                    $socials .= '<li class="social-linkedin"><a href="'.esc_url( $linkedin ).'"><i class="fa fa-linkedin"></i></a></li>';
                }
                if ($skype != '') {
                    $socials .= '<li class="social-skype"><a href="'.esc_url( $skype ).'"><i class="fa fa-skype"></i></a></li>';
                }
                if ($instagram != '') {
                    $socials .= '<li class="social-instagram"><a href="'.esc_url( $instagram ).'"><i class="fa fa-instagram"></i></a></li>';
                }
            $socials .= '</ul></div>';
        }

	    $output .= '<div class="team-member text-' . esc_attr( $align ) . ' '.$el_class.'">';

		    if(@$img['thumbnail'] != ''){

	            $output .= '<div class="member-image-wrapper"><div class="member-image">';
	                $output .=  $img['thumbnail'];
	    			if( $layout == 'hover' ) $output .= $socials;
	            $output .= '</div></div>';
		    }

	        $output .= '<div class="member-details">';
	            if($name != ''){
	                $output .= '<h4 class="member-name">' . $name . '</h4>';
	            }
			    if($position != ''){
				    $output .= '<span class="member-position">' . $position . '</span>';
			    }
	            if($email != ''){
	                $output .= '<p class="member-email"><span>' . __('Email:', 'blance') . '</span> <a href="' . esc_url( $email ) . '">' . $email . '</a></p>';
	            }
			    $output .= '<div class="member-bio">';
			    $output .= do_shortcode($content);
			    $output .=  '</div>';
	    	$output .= '</div>';

	    	if( $layout == 'default' ) $output .= $socials;


	    $output .= '</div>';
	    
	    
	    return $output;
	}

	add_shortcode( 'team_member', 'blance_shortcode_team_member' );

}

/**
* ------------------------------------------------------------------------------------------------
* Testimonials shortcodes
* ------------------------------------------------------------------------------------------------
*/

if( ! function_exists( 'blance_shortcode_testimonials' ) ) {
	function blance_shortcode_testimonials($atts = array(), $content = null) {
		$output = $class = $autoplay = '';

		$parsed_atts = shortcode_atts( array_merge( blance_get_owl_atts(), array(
			'layout' => 'slider', // grid slider
			'style' => 'standard', // standard boxed
			'align' => 'center', // left center
			'columns' => 3,
			'name' => '',
			'title' => '',
			'el_class' => ''
		) ), $atts );

		extract( $parsed_atts );

		$class .= ' testimonials-' . $layout;
		$class .= ' testimon-style-' . $style;
		$class .= ' testimon-columns-' . $columns;
		$class .= ' testimon-align-' . $align;

		if( $layout == 'slider' ) $class .= ' owl-carousel';

		$class .= ' ' . $el_class;

		$carousel_id = 'carousel-' . rand( 1000, 10000);

		ob_start(); ?>
			<div id="<?php echo ($carousel_id); ?>" class="testimonials-wrapper">
				<?php if ( $title != '' ): ?>
					<h2 class="title slider-title"><?php echo esc_html( $title ); ?></h2>
				<?php endif ?>
				<div class="testimonials<?php echo esc_attr( $class ); ?>" >
					<?php echo do_shortcode( $content ); ?>
				</div>
			</div>

			<?php 
				if( $layout == 'slider' ) {
					$parsed_atts['carousel_id'] = $carousel_id;
					blance_owl_carousel_init( $parsed_atts );
				}

			 ?>

		<?php
		$output = ob_get_contents();
		ob_end_clean();

		return $output; 
	}

	add_shortcode( 'testimonials', 'blance_shortcode_testimonials' );
}


if( ! function_exists( 'blance_shortcode_testimonial' ) ) {
	function blance_shortcode_testimonial($atts, $content) {
		if( ! function_exists( 'wpb_getImageBySize' ) ) return;
		$output = $class = '';
		extract(shortcode_atts( array(
			'image' => '',
			'img_size' => '100x100',
			'name' => '',
			'title' => '',
			'el_class' => ''
		), $atts ));

		$img_id = preg_replace( '/[^\d]/', '', $image );

		$img = wpb_getImageBySize( array( 'attach_id' => $img_id, 'thumb_size' => $img_size, 'class' => 'testimonial-avatar-image' ) );

		$class .= ' ' . $el_class;

		ob_start(); ?>
			
			<div class="testimonial<?php echo esc_attr( $class ); ?>" >
                 <i class="fa fa-quote-left" aria-hidden="true"></i>
				<div class="testimonial-inner">
					<?php if ( $img['thumbnail'] != ''): ?>
						<div class="testimonial-avatar">
							<?php echo $img['thumbnail']; ?>
						</div>
					<?php endif ?>
					
					<div class="testimonial-content">
						<?php echo do_shortcode( $content ); ?>
						<footer>
							<h5><?php echo esc_html( $name ); ?> </h5>
							<span><?php echo esc_html( $title ); ?></span>
						</footer>
					</div>
				</div>
			</div>

		<?php
		$output = ob_get_contents();
		ob_end_clean();

		return $output; 
	}

	add_shortcode( 'testimonial', 'blance_shortcode_testimonial' );
}


/**
* ------------------------------------------------------------------------------------------------
* Pricing tables shortcodes
* ------------------------------------------------------------------------------------------------
*/

if( ! function_exists( 'blance_shortcode_pricing_tables' ) ) {
	function blance_shortcode_pricing_tables($atts = array(), $content = null) {
		$output = $class = $autoplay = '';
		extract(shortcode_atts( array(
			'el_class' => ''
		), $atts ));

		$class .= ' ' . $el_class;

		ob_start(); ?>
			<div class="pricing-tables-wrapper">
				<div class="pricing-tables<?php echo esc_attr( $class ); ?>" >
					<?php echo do_shortcode( $content ); ?>
				</div>
			</div>
		<?php
		$output = ob_get_contents();
		ob_end_clean();

		return $output; 
	}

	add_shortcode( 'pricing_tables', 'blance_shortcode_pricing_tables' );
}

if( ! function_exists( 'blance_shortcode_pricing_plan' ) ) {
	function blance_shortcode_pricing_plan($atts, $content) {
		global $wpdb, $post;
		if( ! function_exists( 'wpb_getImageBySize' ) ) return;
		$output = $class = '';
		extract(shortcode_atts( array(
			'name' => '',
			'subtitle' => '',
			'price_value' => '',
			'price_suffix' => 'per month',
			'currency' => '',
			'features_list' => '',
			'label' => '',
			'label_color' => 'red',
			'link' => '',
			'button_label' => '',
			'button_type' => 'custom',
			'id' => '',
			'el_class' => ''
		), $atts ));

		$class .= ' ' . $el_class;
		if( ! empty( $label ) ) {
			$class .= ' price-with-label label-color-' . $label_color;
		}

		$features = explode(PHP_EOL, $features_list);

		$product = false;

		if( $button_type == 'product' && ! empty( $id ) ) {
			$product_data = get_post( $id );
			$product = is_object( $product_data ) && in_array( $product_data->post_type, array( 'product', 'product_variation' ) ) ? wc_setup_product_data( $product_data ) : false;
		}

		ob_start(); ?>
			
			<div class="blance-price-table<?php echo esc_attr( $class ); ?>" >
				<div class="blance-plan">
					<div class="blance-plan-name">
						<span><?php echo  $name; ?></span>
						<?php if (! empty( $subtitle ) ): ?>
							<span class="price-subtitle"><?php echo  $subtitle; ?></span>
						<?php endif ?>
					</div>
				</div>
				<div class="blance-plan-inner">
					<?php if ( ! empty( $label ) ): ?>
						<div class="price-label"><span><?php echo  $label; ?></span></div>
					<?php endif ?>
					<div class="blance-plan-price">
						<span class="blance-price-currency">
							<?php echo  $currency; ?>
						</span>
						<span class="blance-price-value">
							<?php echo  $price_value; ?>
						</span>
						<span class="blance-price-suffix">
							<?php echo  $price_suffix; ?>
						</span>
					</div>
					<?php if ( count( $features ) > 0 ): ?>
						<div class="blance-plan-features">
							<?php foreach ($features as $value): ?>
								<div class="blance-plan-feature">
									<?php echo  $value; ?>
								</div>
							<?php endforeach; ?>
						</div>
					<?php endif ?>
					<div class="blance-plan-footer">
						<?php if ( $button_type == 'product' && $product ): ?>
							<?php woocommerce_template_loop_add_to_cart(  ); //array( 'quantity' => $atts['quantity'] )?>
						<?php else: ?>
							<a href="<?php echo esc_url( $link ); ?>" class="button price-plan-btn">
								<?php echo  $button_label; ?>
							</a>
						<?php endif ?>
					</div>
				</div>
			</div>

		<?php
		$output = ob_get_contents();
		ob_end_clean();

		if ( $button_type == 'product' ) {
			// Restore Product global in case this is shown inside a product post
			wc_setup_product_data( $post );
		}


		return $output; 
	}

	add_shortcode( 'pricing_plan', 'blance_shortcode_pricing_plan' );
}



/**
* ------------------------------------------------------------------------------------------------
* Products tabs shortcode
* ------------------------------------------------------------------------------------------------
*/

if( ! function_exists( 'blance_shortcode_products_tabs' ) ) {
	function blance_shortcode_products_tabs($atts = array(), $content = null) {
		if( ! function_exists( 'wpb_getImageBySize' ) ) return;
		$output = $class = $autoplay = '';
		extract(shortcode_atts( array(
			'title' => '',
			'image' => '',
			'color' => '#1aada3',
			'el_class' => ''
		), $atts ));

		$img_id = preg_replace( '/[^\d]/', '', $image );

		$img = wpb_getImageBySize( array( 'attach_id' => $img_id, 'thumb_size' => 'full', 'class' => 'tabs-icon' ) );

	    // Extract tab titles
	    preg_match_all( '/products_tab([^\]]+)/i', $content, $matches, PREG_OFFSET_CAPTURE );
	    $tab_titles = array();

	    if ( isset( $matches[1] ) ) {
	      	$tab_titles = $matches[1];
	    }

	    $tabs_nav = '';
	    $first_tab_title = '';
	    $tabs_nav .= '<ul class="products-tabs-title">';
	    $_i = 0;
	    foreach ( $tab_titles as $tab ) {
	    	$_i++;
			$tab_atts = shortcode_parse_atts( $tab[0] );
			$tab_atts['carousel_js_inline'] = 'yes';
			$encoded_atts = json_encode( $tab_atts );
			if( $_i == 1 ) $first_tab_title = $tab_atts['title'];
			$class = ( $_i == 1 ) ? 'active-tab-title' : '';
			if ( isset( $tab_atts['title'] ) ) {
				$tabs_nav .= '<li data-atts="' . esc_attr( $encoded_atts ) . '" class="' . esc_attr( $class ) . '""><span class="tab-label">' . $tab_atts['title'] . '</span></li>';
			}
	    }
	    $tabs_nav .= '</ul>';

		$tabs_id = rand(999,9999);

		$class .= ' tabs-' . $tabs_id;

		$class .= ' ' . $el_class;

		ob_start(); ?>
			<div class="blance-products-tabs<?php echo esc_attr( $class ); ?>">
				<div class="blance-products-loader">
                    <div class="overlay-loader">
                <div>
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>
                </div>
				<div class="blance-tabs-header">
					<?php if ( ! empty( $title ) ): ?>
						<div class="tabs-name">
							<?php echo $img['thumbnail']; ?>
							<span><?php echo ($title); ?></span>
						</div>
					<?php endif; ?>
					<div class="tabs-navigation-wrapper">
						<?php 
							echo ($tabs_nav);
						?>
					</div>
				</div>
				<?php 
					$first_tab_atts = shortcode_parse_atts( $tab_titles[0][0] );
					echo blance_shortcode_products_tab( $first_tab_atts );
				?>
				<style type="text/css">
					.tabs-<?php echo esc_html( $tabs_id ); ?> .tabs-name {
						background: <?php echo esc_html( $color ); ?>
					}
					.blance-products-tabs.tabs-<?php echo esc_html( $tabs_id ); ?> .products-tabs-title .active-tab-title {
						color: <?php echo esc_html( $color ); ?>
					}
                    .blance-products-tabs .products-tabs-title li:hover {
						color: <?php echo esc_html( $color ); ?>
					}
					.tabs-<?php echo esc_html( $tabs_id ); ?> .blance-tabs-header {
						border-color: <?php echo esc_html( $color ); ?>
					}
				</style>
			</div>
		<?php
		$output = ob_get_contents();
		ob_end_clean();

		return $output; 
	}

	add_shortcode( 'products_tabs', 'blance_shortcode_products_tabs' );
}

if( ! function_exists( 'blance_shortcode_products_tab' ) ) {
	function blance_shortcode_products_tab($atts) {
		global $wpdb, $post;
		if( ! function_exists( 'wpb_getImageBySize' ) ) return;
		$output = $class = '';

	    $is_ajax = (defined( 'DOING_AJAX' ) && DOING_AJAX);

		$parsed_atts = shortcode_atts( array_merge( array(
			'title' => '',
		), blance_get_default_product_shortcode_atts()), $atts );

		extract( $parsed_atts );

		$parsed_atts['carousel_js_inline'] = 'yes';
		$parsed_atts['force_not_ajax'] = 'yes';

		ob_start(); ?>
			<?php if(!$is_ajax): ?>	
				<div class="blance-tab-content<?php echo esc_attr( $class ); ?>" >
			<?php endif; ?>

				<?php 
					echo blance_shortcode_products( $parsed_atts );
				 ?>
			<?php if(!$is_ajax): ?>	
				</div>
			<?php endif; ?>
		<?php
		$output = ob_get_clean();

	    if( $is_ajax ) {
	    	$output =  array(
	    		'html' => $output
	    	);
	    }
	    
	    return $output;
	}

	add_shortcode( 'products_tab', 'blance_shortcode_products_tab' );
}

if( ! function_exists( 'blance_get_products_tab_ajax' ) ) {
	add_action( 'wp_ajax_blance_get_products_tab_shortcode', 'blance_get_products_tab_ajax' );
	add_action( 'wp_ajax_nopriv_blance_get_products_tab_shortcode', 'blance_get_products_tab_ajax' );
	function blance_get_products_tab_ajax() {
		if( ! empty( $_POST['atts'] ) ) {
			$atts = $_POST['atts'];
			$data = blance_shortcode_products_tab($atts);
			echo json_encode( $data );
			die();
		}
	}
}

/**
* ------------------------------------------------------------------------------------------------
* Mega Menu widget
* ------------------------------------------------------------------------------------------------
*/

if( ! function_exists( 'blance_shortcode_mega_menu' )) {
	function blance_shortcode_mega_menu($atts, $content) {
		$output = $title_html = '';
		extract(shortcode_atts( array(
			'title' => '',
			'nav_menu' => '',
			'style' => '',
			'color' => '',
			'blance_color_scheme' => 'light',
			'el_class' => ''
		), $atts ));

		$class = $el_class;

		if( $title != '' ) {
			$title_html = '<h5 class="widget-title color-scheme-' . $blance_color_scheme . '">' . $title . '</h5>';
		}

		$widget_id = 'widget-' . rand(100,999);


		//if( $nav_menu == '') return;

		ob_start(); ?>
			
			<div id="<?php echo esc_attr( $widget_id ); ?>" class="widget_nav_mega_menu shortcode-mega-menu <?php echo esc_attr( $class ); ?>">
				
				<?php echo $title_html; ?>

				<div class="blance-navigation">
					<?php
						wp_nav_menu( array( 
							'fallback_cb' => '', 
							'menu' => $nav_menu,
							'walker' => new blance_Mega_Menu_Walker()
						) );
					?>
				</div>	
			</div>

			<?php if ( $color != '' ): ?>
				<style type="text/css">
					#<?php echo esc_attr( $widget_id ); ?> {
						border-color: <?php echo esc_attr($color); ?>
					}
					#<?php echo esc_attr( $widget_id ); ?> .widget-title {
						background-color: <?php echo esc_attr($color); ?>
					}
				</style>
			<?php endif ?>
			
		<?php
		$output = ob_get_contents();
		ob_end_clean();

		return $output; 

	}

	add_shortcode( 'blance_mega_menu', 'blance_shortcode_mega_menu' );

}


/**
* ------------------------------------------------------------------------------------------------
* Widget user panel
* ------------------------------------------------------------------------------------------------
*/

if( ! function_exists( 'blance_shortcode_user_panel' )) {
	function blance_shortcode_user_panel($atts) {
		if( ! blance_woocommerce_installed() ) return;
		$click = $output = $title_out = $class = '';
		extract(shortcode_atts( array(
			'title' => '',
		), $atts ));

		$class .= ' ';

		$user = wp_get_current_user();

		ob_start(); ?>
				
			<div class="blance-user-panel<?php echo esc_attr( $class ); ?>">

				<?php if ( ! is_user_logged_in() ): ?>
					<?php printf(__('Please, <a href="%s">log in</a>', 'blance'), get_permalink( get_option('woocommerce_myaccount_page_id') )); ?>
				<?php else: ?>


					<div class="user-avatar">
						<?php echo get_avatar( $user->ID, 92 ); ?> 
					</div>

					<div class="user-info">
						<span><?php printf( __('Welcome, <strong>%s</strong>', 'blance'), $user->user_login ) ?></span>
						<a href="<?php echo esc_url( wp_logout_url( home_url('/') ) ); ?>" class="logout-link"><?php _e('Logout', 'blance'); ?></a>
					</div>

				<?php endif ?>
				
	
			</div>


		<?php
		$output = ob_get_contents();
		ob_end_clean();

		return $output; 
	}

	add_shortcode( 'user_panel', 'blance_shortcode_user_panel' );
}



/**
* ------------------------------------------------------------------------------------------------
* Widget with author info
* ------------------------------------------------------------------------------------------------
*/

if( ! function_exists( 'blance_shortcode_author_area' )) {
	function blance_shortcode_author_area($atts, $content) {
		if( ! function_exists( 'wpb_getImageBySize' ) ) return;
		$click = $output = $title_out = $class = '';
		extract(shortcode_atts( array(
			'title' => '',
			'image' => '',
			'img_size' => '800x600',
			'link' => '',
			'link_text' => '',
			'alignment' => 'left',
			'style' => '',
			'blance_color_scheme' => 'dark',
			'el_class' => ''
		), $atts ));

		$img_id = preg_replace( '/[^\d]/', '', $image );

		$img = wpb_getImageBySize( array( 'attach_id' => $img_id, 'thumb_size' => $img_size, 'class' => 'author-area-image' ) );


		$class .= ' text-' . $alignment;
		$class .= ' color-scheme-' . $blance_color_scheme;
		$class .= ' ' . $el_class;

		if( $title != '' ) {
			$title_out = '<h3 class="title author-title">' . esc_html($title) . '</h3>';
		}

		if( $link != '') {
			$link = '<a href="' . esc_url( $link ) . '">' . esc_html($link_text) . '</a>';
		}

		ob_start(); ?>
				
			<div class="author-area<?php echo esc_attr( $class ); ?>">

				<?php echo $title_out; ?>

				<div class="author-avatar">
					<?php echo $img['thumbnail']; ?>
				</div>
				
				<div class="author-info">
					<?php echo do_shortcode( $content ); ?>
				</div>
				
				<?php echo $link; ?>
	
			</div>


		<?php
		$output = ob_get_contents();
		ob_end_clean();

		return $output; 
	}

	add_shortcode( 'author_area', 'blance_shortcode_author_area' );
}

/**
* ------------------------------------------------------------------------------------------------
* Promo banner - image with text and hover effect
* ------------------------------------------------------------------------------------------------
*/

if( ! function_exists( 'blance_shortcode_promo_banner' )) {
	function blance_shortcode_promo_banner($atts, $content) {
		if( ! function_exists( 'wpb_getImageBySize' ) ) return;
		$click = $output = $class = '';
		extract(shortcode_atts( array(
			'image' => '',
			'img_size' => '800x600',
			'link' => '',
			'alignment' => 'left',
			'vertical_alignment' => 'top',
			'style' => '',
			'hover' => '',
			'blance_color_scheme' => 'left',
			'el_class' => ''
		), $atts ));


		//$img_id = preg_replace( '/[^\d]/', '', $image );

		$images = explode(',', $image);

		if( $link != '') {
			$class .= ' cursor-pointer'; 
		}

		$class .= ' text-' . $alignment;
		$class .= ' vertical-alignment-' . $vertical_alignment;
		$class .= ' banner-' . $style;
		$class .= ' hover-' . $hover;
		$class .= ' position-' . $blance_color_scheme;
		$class .= ' ' . $el_class;

		if ( count($images) > 1 ) {
			$class .= ' multi-banner';
		}

		ob_start(); ?>

			<div class="promo-banner<?php echo esc_attr( $class ); ?>" <?php if( ! empty( $link ) ): ?>onclick="window.location.href='<?php echo esc_js( $link ) ?>'"<?php endif; ?> >

				<div class="main-wrapp-img">
					<div class="banner-image">
						<?php if ( count($images) > 0 ): ?>
							<?php $i=0; foreach ($images as $img_id): $i++; ?>
								<?php $img = wpb_getImageBySize( array( 'attach_id' => $img_id, 'thumb_size' => $img_size, 'class' => 'promo-banner-image image-' . $i ) ); ?>
								<?php echo $img['thumbnail']; ?>
							<?php endforeach ?>
						<?php endif ?>
					</div>
				</div>
				
				<div class="wrapper-content-baner ">
					<div class="banner-inner">
						<?php echo do_shortcode( $content ); ?>
					</div>
				</div>
				
			</div>


		<?php
		$output = ob_get_contents();
		ob_end_clean();

		return $output; 
	}

	add_shortcode( 'promo_banner', 'blance_shortcode_promo_banner' );

}


if( ! function_exists( 'blance_shortcode_banners_carousel' ) ) {
	function blance_shortcode_banners_carousel($atts = array(), $content = null) {
		$output = $class = $autoplay = '';

		$parsed_atts = shortcode_atts( array_merge( blance_get_owl_atts(), array(
			'el_class' => '',
		) ), $atts );

		extract( $parsed_atts );

		$class .= ' ' . $el_class;

		$carousel_id = 'carousel-' . rand(100,999);

		ob_start(); ?>
			<div id="<?php echo ($carousel_id); ?>" class="banners-carousel-wrapper">
				<div class="owl-carousel banners-carousel<?php echo esc_attr( $class ); ?>" >
					<?php echo do_shortcode( $content ); ?>
				</div>
			</div>

			<?php 

				$parsed_atts['carousel_id'] = $carousel_id;
				blance_owl_carousel_init( $parsed_atts );

			 ?>

		<?php
		$output = ob_get_contents();
		ob_end_clean();

		return $output; 
	}

	add_shortcode( 'banners_carousel', 'blance_shortcode_banners_carousel' );
}


/**
* ------------------------------------------------------------------------------------------------
* Info box
* ------------------------------------------------------------------------------------------------
*/

if( ! function_exists( 'blance_shortcode_info_box' )) {
	function blance_shortcode_info_box($atts, $content) {
		if( ! function_exists( 'wpb_getImageBySize' ) ) return;
		$click = $output = $class = '';
		extract(shortcode_atts( array(
			'image' => '',
			'img_size' => '800x600',
			'link' => '',
			'link_target' => '_self',
			'alignment' => 'left',
			'image_alignment' => 'top',
			'style' => 'base',
			'hover' => '',
			'blance_color_scheme' => 'dark',
			'css' => 'light',
			'btn_text' => '',
			'btn_position' => 'hover',
			'btn_color' 	 => 'default',
			'btn_style'   	 => 'link',
			'btn_size' 		 => 'default',
			'new_styles' => 'no',
			'el_class' => '',
            'icon' => '',
		), $atts ));


		$images = explode(',', $image);

		if( $link != '') {
			$class .= ' cursor-pointer'; 
		}

		$class .= ( $new_styles == 'yes') ? ' blance-info-box2' : ' blance-info-box';
		$class .= ' text-' . $alignment;
		$class .= ' icon-alignment-' . $image_alignment;
		$class .= ' box-style-' . $style;
		// $class .= ' hover-' . $hover;
		$class .= ' color-scheme-' . $blance_color_scheme;
		$class .= ' ' . $el_class;

		if ( count($images) > 1 ) {
			$class .= ' multi-icons';
		}

		if( ! empty( $btn_text ) ) {
			$class .= ' with-btn';
			$class .= ' btn-position-' . $btn_position;
		}

		if( function_exists( 'vc_shortcode_custom_css_class' ) ) {
			$class .= ' ' . vc_shortcode_custom_css_class( $css );
		}

		$rand = "svg-" . rand(1000,9999);

		$sizes = explode( 'x', $img_size );

		$width = $height = 128;
		if( count( $sizes ) == 2 ) {
			$width = $sizes[0];		
			$height = $sizes[1];		
		} 
        if( $link_target == '_blank' ) {
        	$onclick = 'onclick="window.open(\''. esc_url( $link ).'\',\'_blank\')"';
        } else {
        	$onclick = 'onclick="window.location.href=\''. esc_url( $link ).'\'"';
        }

		ob_start(); ?>
			<div class="<?php echo esc_attr( $class ); ?>" <?php if( ! empty( $link ) ) echo $onclick; ?> >
				<?php if ( count($images) > 0 ): ?>
					<div class="box-icon-wrapper">
						<div class="info-box-icon">
								<?php $i=0; foreach ($images as $img_id): $i++; ?>
									<?php $img = wpb_getImageBySize( array( 'attach_id' => $img_id, 'thumb_size' => $img_size, 'class' => 'info-icon image-' . $i ) ); ?>
									<?php 
										$src = $img['p_img_large'][0];
										if( substr($src, -3, 3) == 'svg' ) {
											echo '<div id="' . $rand . '" class="info-svg-wrapper" style="width: ' . $width . 'px;height: ' . $height . 'px;"></div>';
											?>
											<script type="text/javascript">
												jQuery(document).ready(function($) {
													new Vivus('<?php echo $rand; ?>', {
													    type: 'delayed',
													    duration: 200,
													    start: 'inViewport',
													    file: '<?php echo $src; ?>',
													    animTimingFunction: Vivus.EASE_OUT
													});
												});
											</script>
											<?php
										} else {
											echo $img['thumbnail'];
										}
									 ?>
								<?php endforeach ?>
                                <?php 
                                    if($icon) {
                                        echo '<i class="'.$icon.'"></i>';
                                    }
                                 ?>
						</div>
					</div>
				<?php endif ?>
				<div class="info-box-content">
					<div class="info-box-inner">
                    <p>
						<?php 
							echo do_shortcode( $content ); 
							if( ! empty( $btn_text ) ) {
								printf( '<div class="info-btn-wrapper"><a href="%s" class="btn btn-style-link btn-color-primary info-box-btn">%s</a></div>', $link, $btn_text );
							}
						?>
					</div>
				</div>
			</div>
		<?php
		$output = ob_get_contents();
		ob_end_clean();

		return $output; 
	}

	add_shortcode( 'blance_info_box', 'blance_shortcode_info_box' );

}


/**
* ------------------------------------------------------------------------------------------------
* 3D view - images in 360 slider
* ------------------------------------------------------------------------------------------------
*/

if( ! function_exists( 'blance_shortcode_3d_view' )) {
	function blance_shortcode_3d_view($atts, $content) {
		if( ! function_exists( 'wpb_getImageBySize' ) ) return;
		$click = $output = $class = '';
		extract(shortcode_atts( array(
			'images' => '',
			'img_size' => 'full',
			'title' => '',
			'link' => '',
			'style' => '',
			'el_class' => ''
		), $atts ));

		$id = rand(100,999);

		$images = explode(',', $images);

		if( $link != '') {
			$class .= ' cursor-pointer'; 
		}

		$class .= ' ' . $el_class;

		$frames_count = count($images);

		if ( $frames_count < 2 ) return;

		$images_js_string = '';

		$width = $height = 0;

		ob_start(); ?>
			<div class="blance-threed-view<?php echo esc_attr( $class ); ?> threed-id-<?php echo esc_attr( $id ); ?>" <?php if( ! empty( $link ) ): ?>onclick="window.location.href='<?php echo esc_js( $link ) ?>'"<?php endif; ?> >
				<?php if ( ! empty( $title ) ): ?>
					<h3 class="threed-title"><span><?php echo ($title); ?></span></h3>
				<?php endif ?>
				<ul class="threed-view-images">
					<?php if ( count($images) > 0 ): ?>
						<?php $i=0; foreach ($images as $img_id): $i++; ?>
							<?php 
								$img = wpb_getImageBySize( array( 'attach_id' => $img_id, 'thumb_size' => $img_size, 'class' => 'threed-view-image image-' . $i ) );
								$width = $img['p_img_large'][1];
								$height = $img['p_img_large'][2];
								$images_js_string .= "'" . $img['p_img_large'][0] . "'"; 
								if( $i < $frames_count ) {
									$images_js_string .= ","; 
								}
							?>
						<?php endforeach ?>
					<?php endif ?>
				</ul>
			    <div class="spinner">
			        <span>0%</span>
			    </div>
			</div>
			<script type="text/javascript">
				jQuery(document).ready(function( $ ) {
				    $('.threed-id-<?php echo esc_attr( $id ); ?>').ThreeSixty({
				        totalFrames: <?php echo $frames_count; ?>,
				        endFrame: <?php echo $frames_count; ?>, 
				        currentFrame: 1, 
				        imgList: '.threed-view-images', 
				        progress: '.spinner',
				        imgArray: [<?php echo $images_js_string; ?>],
				        height: <?php echo $height ?>,
				        width: <?php echo $width ?>,
				        responsive: true,
				        navigation: true
				    });
				});
			</script>
		<?php
		$output = ob_get_contents();
		ob_end_clean();

		return $output; 
	}

	add_shortcode( 'blance_3d_view', 'blance_shortcode_3d_view' );
}


/**
* ------------------------------------------------------------------------------------------------
* Menu price element
* ------------------------------------------------------------------------------------------------
*/

if( ! function_exists( 'blance_shortcode_menu_price' )) {
	function blance_shortcode_menu_price($atts, $content) {
		if( ! function_exists( 'wpb_getImageBySize' ) ) return;
		$click = $output = $class = '';
		extract(shortcode_atts( array(
			'img_id' => '',
			'img_size' => 'full',
			'title' => '',
			'description' => '',
			'price' => '',
			'link' => '',
			'el_class' => ''
		), $atts ));


		if( $link != '') {
			$class .= ' cursor-pointer'; 
		}

		$class .= ' ' . $el_class;

		ob_start(); ?>
			<div class="blance-menu-price<?php echo esc_attr( $class ); ?>" <?php if( ! empty( $link ) ): ?>onclick="window.location.href='<?php echo esc_js( $link ) ?>'"<?php endif; ?> >
				<div class="menu-price-image">
					<?php 
						$img = wpb_getImageBySize( array( 'attach_id' => $img_id, 'thumb_size' => $img_size, 'class' => '' ) );
						echo $img['thumbnail'];
					?>
				</div>
				<div class="menu-price-description-wrapp">
					<?php if ( ! empty( $title ) ): ?>
						<h3 class="menu-price-title font-title"><span><?php echo ($title); ?></span></h3>
					<?php endif ?>
					<div class="menu-price-description">
						<div class="menu-price-details"><?php echo ($description); ?></div>
						<div class="menu-price-price"><?php echo ($price); ?></div>
					</div>
				</div>
			</div>
		<?php
		$output = ob_get_contents();
		ob_end_clean();

		return $output; 
	}

	add_shortcode( 'blance_menu_price', 'blance_shortcode_menu_price' );
}

/**
* ------------------------------------------------------------------------------------------------
* Countdown timer
* ------------------------------------------------------------------------------------------------
*/

if( ! function_exists( 'blance_shortcode_countdown_timer' )) {
	function blance_shortcode_countdown_timer($atts, $content) {
		if( ! function_exists( 'wpb_getImageBySize' ) ) return;
		$click = $output = $class = '';
		extract(shortcode_atts( array(
			'date' => '2018/12/12',
			'blance_color_scheme' => 'light',
			'size' => 'medium',
			'align' => 'center',
			'style' => 'base',
			'el_class' => ''
		), $atts ));

		$class .= ' ' . $el_class;
		$class .= ' color-scheme-' . $blance_color_scheme;
		$class .= ' timer-align-' . $align;
		$class .= ' timer-size-' . $size;
		$class .= ' timer-style-' . $style;

		ob_start(); ?>
			<div class="blance-countdown-timer<?php echo esc_attr( $class ); ?>">
				<div class="blance-timer" data-end-date="<?php echo esc_attr( $date ) ?>"></div>
			</div>
		<?php
		$output = ob_get_contents();
		ob_end_clean();

		return $output; 
	}

	add_shortcode( 'blance_countdown_timer', 'blance_shortcode_countdown_timer' );
}




/**
* ------------------------------------------------------------------------------------------------
* Shortcode function to display posts teaser
* ------------------------------------------------------------------------------------------------
*/

if( ! function_exists( 'blance_shortcode_posts_teaser' )) {
	function blance_shortcode_posts_teaser($atts, $query = false) {
		global $woocommerce_loop;
		$posts_query = $el_class = $args = $my_query = $title_out = $output = '';
		$posts = array();
		extract( shortcode_atts( array(
			'el_class' => '',
			'posts_query' => '',
			'style' => 'default',
			'title' => '',
		), $atts ) );

		if( ! $query ) {
			list( $args, $query ) = vc_build_loop_query( $posts_query ); //
		}

		$carousel_id = 'teaser-' . rand(100,999);

		if( $title != '' ) {
			$title_out = '<h3 class="title teaser-title">' . $title . '</h3>';
		}

		ob_start();

		if($query->have_posts()) {
			echo $title_out;
			?>
				<div id="<?php echo esc_html( $carousel_id ); ?>">
					<div class="posts-teaser teaser-style-<?php echo esc_attr( $style ); ?> <?php echo esc_attr( $el_class ); ?>">

						<?php
							$_i = 0;
							while ( $query->have_posts() ) {
								$_i++;
								$query->the_post(); // Get post from query
								?>
									<div class="post-teaser-item teaser-item-<?php echo esc_attr( $_i ); ?>">

										<?php if( has_post_thumbnail() ) {
											?>
												<a href="<?php echo esc_url( get_permalink() ); ?>"><?php the_post_thumbnail( ( $_i == 1 ) ? 'large' : 'medium' ); ?></a>
											<?php
										} ?>

										<a href="<?php echo esc_url( get_permalink() ); ?>" class="post-title"><?php the_title(); ?></a> 

										<?php blance_post_meta(array(
											'author' => 0,
											'labels' => 1,
											'cats' => 0,
											'tags' => 0
										)); ?>

									</div>
								<?php
							}	
						?>

					</div> <!-- end posts-teaser -->
				</div> <!-- end #<?php echo esc_html( $carousel_id ); ?> -->
				<?php

		}
		wp_reset_postdata();

		$output = ob_get_contents();
		ob_end_clean();

		return $output; 
	}

	add_shortcode( 'blance_posts_teaser', 'blance_shortcode_posts_teaser' );
}



/**
* ------------------------------------------------------------------------------------------------
* Shortcode function to display posts as a slider or as a grid
* ------------------------------------------------------------------------------------------------
*/

if( ! function_exists( 'blance_shortcode_posts' ) ) {

	function blance_shortcode_posts( $atts ) {
		return blance_generate_posts_slider( $atts );
	}

	add_shortcode( 'blance_posts', 'blance_shortcode_posts' );
}

if( ! function_exists( 'blance_generate_posts_slider' )) {
	function blance_generate_posts_slider($atts, $query = false) {
		global $woocommerce_loop, $blance_loop;
		$posts_query = $el_class = $args = $my_query = $speed = '';
		$slides_per_view = $wrap = $scroll_per_page = $title_out = '';
		$autoplay = $hide_pagination_control = $hide_prev_next_buttons = $output = '';
		$posts = array();

		$parsed_atts = shortcode_atts( array_merge( blance_get_owl_atts(), array(
			'el_class' => '',
			'posts_query' => '',
	        'img_size' => 'large',
            'blog_layout' => '1',
			'title' => '',
            'readmore_text' => 'Read More',
		) ), $atts );

		extract( $parsed_atts );

		$blance_loop['img_size'] = $img_size;
        $blance_loop['readmore_text'] = $readmore_text;
        $blance_loop['blog_layout'] = $blog_layout;

		if( ! $query ) {
			list( $args, $query ) = vc_build_loop_query( $posts_query ); //
		}

		$carousel_id = 'carousel-' . rand(100,999);

		if( $title != '' ) {
			$title_out = '<h3 class="title slider-title">' . $title . '</h3>';
		}

		ob_start();

		if($query->have_posts()) {
			echo $title_out;
			?>
				<div id="<?php echo esc_attr( $carousel_id ); ?>" class="vc_carousel_container">
					<div class="owl-carousel post-slider  product-items <?php echo esc_attr( $el_class ); if ($blog_layout == '2') echo "ct-margin" ?>">

						<?php
							while ( $query->have_posts() ) {
								$query->the_post(); // Get post from query
								?>
									<div class="product-item owl-carousel-item">
										<div class="owl-carousel-item-inner">	
											<?php if ( $blog_layout == '1' ){ ?>
												<?php get_template_part( 'framework/templates/blog/entry' ); ?>
											<?php } elseif ($blog_layout == '2') {?>
												<?php get_template_part( 'framework/templates/blog/entry2' ); ?>
											<?php }  ?>

										</div>
									</div>
								<?php
							}	

							unset( $woocommerce_loop['slider'] );

						?>

					</div> <!-- end product-items -->
				</div> <!-- end #<?php echo esc_html( $carousel_id ); ?> -->

			<?php

				$parsed_atts['carousel_id'] = $carousel_id;
				blance_owl_carousel_init( $parsed_atts );

		}
		wp_reset_postdata();
		unset($blance_loop['img_size']);

		$output = ob_get_contents();
		ob_end_clean();

		return $output; 
	}
}


/**
* ------------------------------------------------------------------------------------------------
* Shortcode function to display posts as a slider or as a grid
* ------------------------------------------------------------------------------------------------
*/

if( ! function_exists( 'blance_shortcode_products' ) ) {
	add_shortcode( 'blance_products', 'blance_shortcode_products' );
	function blance_shortcode_products($atts, $query = false) {
		global $woocommerce_loop, $blance_loop;
	    $parsed_atts = shortcode_atts( blance_get_default_product_shortcode_atts(), $atts );

	    extract( $parsed_atts );

		$blance_loop['img_size'] = $img_size;

	    $is_ajax = (defined( 'DOING_AJAX' ) && DOING_AJAX && $force_not_ajax != 'yes' );

	    $parsed_atts['force_not_ajax'] = 'no'; // :)

	    $encoded_atts = json_encode( $parsed_atts );

		$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

		if( $ajax_page > 1 ) $paged = $ajax_page;

		$ordering_args = WC()->query->get_catalog_ordering_args( $orderby, $order );

		$meta_query   = WC()->query->get_meta_query();

		if( $post_type == 'featured' ) {
			$meta_query[] = array(
				'key'   => '_featured',
				'value' => 'yes'
			);
		}

		if( $orderby == 'post__in' ) {
			$ordering_args['orderby'] = $orderby;
		}

	    $args = array(
	    	'post_type' 			=> 'product',
	    	'status' 				=> 'published',
			'ignore_sticky_posts' 	=> 1,
	    	'paged' 			  	=> $paged,	
			'orderby'             	=> $ordering_args['orderby'],
			'order'               	=> $ordering_args['order'],
	    	'posts_per_page' 		=> $items_per_page,
	    	'meta_query' 			=> $meta_query
		);

		if( ! empty( $ordering_args['meta_key'] ) ) {
			$args['meta_key'] = $ordering_args['meta_key'];
		}


		if( $post_type == 'ids' && $include != '' ) {
			$args['post__in'] = explode(',', $include);
		}

		if( ! empty( $exclude ) ) {
			$args['post__not_in'] = explode(',', $exclude);
		}

		if( ! empty( $taxonomies ) ) {
			$taxonomy_names = get_object_taxonomies( 'product' );
			$terms = get_terms( $taxonomy_names, array(
				'orderby' => 'name',
				'include' => $taxonomies
			));

			if( ! is_wp_error( $terms ) && ! empty( $terms ) ) {
				$args['tax_query'] = array('relation' => 'OR');
				foreach ($terms as $key => $term) {
					$args['tax_query'][] = array(
				        'taxonomy' => $term->taxonomy,     
				        'field' => 'slug',                  
				        'terms' => array( $term->slug ),   
				        'include_children' => true,        
				        'operator' => 'IN'  
					);
				}
			}
		}

		if( ! empty( $order ) ) {
			$args['order'] = $order;
		}

		if( ! empty( $offset ) ) {
			$args['offset'] = $offset;
		}


		if( $post_type == 'sale' ) {
			$args['post__in'] = array_merge( array( 0 ), wc_get_product_ids_on_sale() );
		}

		if( $post_type == 'bestselling' ) {
			$args['orderby'] = 'meta_value_num';
			$args['meta_key'] = 'total_sales';
		}

		$woocommerce_loop['timer']   = $sale_countdown;


		$products                    = new WP_Query( $args );

		// Simple products carousel
		

		$woocommerce_loop['columns'] = $columns;
		$woocommerce_loop['masonry'] = false;
        if($columns =="2") {
            $vccolumns = "col-md-6 col-sm-6 col-xs-6";
            $columns_layout = "6";
        }elseif($columns == "3" ) {
            $vccolumns = "col-md-4 col-sm-6 col-xs-6";
            $columns_layout = "4";
        }elseif($columns == "4" ) {
           $vccolumns = "col-md-3 col-sm-6 col-xs-6" ;
           $columns_layout = "3";
        }elseif($columns == "5" ) {
           $vccolumns = " col-md-20 col-sm-6 col-xs-6" ; 
           $columns_layout = "20";
        }else {
             $vccolumns = " col-md-2 col-sm-6 col-xs-6" ; 
           $columns_layout = "2";
        }
        
		if ( $pagination == 'more-btn' ) {
			$woocommerce_loop['masonry'] = true;
		}

		if ( $pagination != 'arrows' ) {
			$woocommerce_loop['loop'] = $items_per_page * ( $paged - 1 );
		}
        $carousel_id = 'carousel-' . rand(100,999);
		$class .= ' pagination-' . $pagination;
		$class .= ' grid-columns-' . $columns;
		if( $woocommerce_loop['masonry'] ) {
			$class .= ' grid-masonry';
		}
        $classne = $data = $sizer = '';
        if ($layout != "carousel") {
       	$classne = ' jws-masonry';
       	$data  = 'data-masonry=\'{"selector":".tb-products-grid ", "columnWidth":".grid-sizer","layoutMode":"fitRows"}\'';
       	$sizer = '<div class="grid-sizer size-'.$columns_layout.'"></div>';
        }
		ob_start();

		if(!$is_ajax) echo '<div class="blance-products-element ' .$pagination.'">';

	    if(!$is_ajax && $pagination != 'more-btn') echo '<div class="blance-products-loader"><div class="overlay-loader">
                <div>
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div></div>';
	    if(!$is_ajax) echo '<div class="products elements-grid row blance-products-holder ' . esc_attr( $class) . ''.esc_attr( $classne ).'" data-paged="1" data-atts="' . esc_attr( $encoded_atts ) . '" '.wp_kses_post( $data ).' >';
		
		if ( $products->have_posts() ) : 
            if( $layout == 'carousel' ) echo '<div id="ptcarousel" ><div class="owl-carousel  product-items owl-theme owl-loaded"> ';
             echo wp_kses_post( $sizer );
			while ( $products->have_posts() ) :
			    
				$products->the_post();
                ?> <div class="tb-products-grid <?php if ($layout == "grid") echo $vccolumns; ?>"> <?php
				wc_get_template_part( 'content', 'productvc' ); 
                ?></div><?php
                
			endwhile; 
            if( $layout == 'carousel' ) echo '</div></div> ';
		endif;

    	if(!$is_ajax) echo '</div>';

		woocommerce_reset_loop();
		wp_reset_postdata();

		if ( $products->max_num_pages > 1 && !$is_ajax ) {
			?>
		    	<div class="products-footer">
		    		<?php if ($pagination == 'more-btn'): ?>
		    			<a href="#" class=" blance-products-load-more"><?php _e('Load More', 'blance'); ?></a>
                        <p style="display: none;" class="loaded-all"><?php esc_html_e('All Product Loaded.' , 'blance') ?></p>
		    		<?php elseif ($pagination == 'arrows'): ?>
		    			<a href="#" class="btn blance-products-load-prev disabled"><?php _e('Prev', 'blance'); ?></a>
		    			<a href="#" class="btn blance-products-load-next"><?php _e('Next', 'blance'); ?></a>
		    		<?php endif ?>
		    	</div>
                <div class="clear"></div>
		    <?php 
		}

    	if(!$is_ajax) echo '</div>';
        if ($layout == "carousel") {
           $items = array();
			$items['desktop'] = ($slides_per_view > 0) ? $slides_per_view : 1;
			$items['desktop_small'] = ($items['desktop'] > 1) ? $items['desktop'] - 1 : 1;
			$items['tablet'] = ($items['desktop_small'] > 1) ? $items['desktop_small'] -1 : 2;
			$items['mobile'] = ($items['tablet'] > 2) ? $items['tablet'] - 2 : 1;

			if($items['mobile'] > 2) {
				$items['mobile'] = 2;
			}

			?>
            
			<script type="text/javascript">
				jQuery( document ).ready(function( $ ) {

	                var owl = $("#ptcarousel .owl-carousel");

					$( window ).bind( "vc_js", function() {
						owl.trigger('refresh.owl.carousel');
					} );

					var options = {
	            		rtl: $('body').hasClass('rtl'),
			            items: <?php echo esc_js( $items['desktop'] ); ?>, 
			            responsive: {
			            	979: {
			            		items: <?php echo esc_js( $items['desktop'] ); ?>,
                                margin: 30,

			            	},
			            	768: {
			            		items: <?php echo esc_js( $items['desktop_small'] ); ?>,
                                margin: 10,
			            	},
			            	479: {
			            		items: <?php echo esc_js( $items['tablet'] ); ?>,
                                margin: 5,
			            	},
			            	0: {
			            		items: <?php echo esc_js( $items['tablet'] ); ?>,
                                margin: 0,
			            	}
			            },
			            autoplay: <?php echo ($autoplay == 'no') ? 'true' : 'false'; ?>,
			            autoplayTimeout: <?php echo $speed; ?>,
			            dots: <?php echo ($hide_dots == 'yes') ? 'false' : 'true'; ?>,
			            nav: <?php echo ($hide_prev_next_buttons == 'yes') ? 'false' : 'true'; ?>,
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
        
        }
        
		$output = ob_get_clean();

	    if( $is_ajax ) {
	    	$output =  array(
	    		'items' => $output,
	    		'status' => ( $products->max_num_pages > $paged ) ? 'have-posts' : 'no-more-posts'
	    	);
	    }
	    
	    return $output;

	}



}

if( ! function_exists( 'blance_get_shortcode_products_ajax' ) ) {
	add_action( 'wp_ajax_blance_get_products_shortcode', 'blance_get_shortcode_products_ajax' );
	add_action( 'wp_ajax_nopriv_blance_get_products_shortcode', 'blance_get_shortcode_products_ajax' );
	function blance_get_shortcode_products_ajax() {
		if( ! empty( $_POST['atts'] ) ) {
			$atts = $_POST['atts'];
			$paged = (empty($_POST['paged'])) ? 2 : (int) $_POST['paged'];
			$atts['ajax_page'] = $paged;

			$data = blance_shortcode_products($atts);

			echo json_encode( $data );

			die();
		}
	}
}

if( ! function_exists( 'blance_get_default_product_shortcode_atts' ) ) {
	function blance_get_default_product_shortcode_atts() {
		return array(
	        'post_type'  => 'product',
	        'layout' => 'grid',
	        'include'  => '',
	        'custom_query'  => '',
	        'taxonomies'  => '',
	        'pagination'  => '',
	        'items_per_page'  => 12,
	        'columns'  => 4,
	        'sale_countdown'  => 0,
	        'offset'  => '',
	        'orderby'  => 'date',
	        'order'  => 'DESC',
	        'meta_key'  => '',
	        'exclude'  => '',
	        'class'  => '',
            'space' => '30',
	        'ajax_page' => '',
			'speed' => '5000',
			'slides_per_view' => '1',
			'wrap' => '',
			'autoplay' => 'no',
            'hide_dots' => ' ',
			'hide_pagination_control' => '',
			'hide_prev_next_buttons' => '',
			'scroll_per_page' => 'yes',
			'carousel_js_inline' => 'no',
	        'img_size' => 'shop_catalog',
	        'force_not_ajax' => 'no',
	    );
	}
}

// Register shortcode [html_block id="111"]
add_shortcode('vc_content', 'blance_html_block_shortcode');

if( ! function_exists( 'blance_html_block_shortcode' ) ) {
	function blance_html_block_shortcode($atts) {
		extract(shortcode_atts(array(
			'id' => 0
		), $atts));

		return blance_get_html_block($id);
	}
}