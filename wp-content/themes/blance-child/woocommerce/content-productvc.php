<?php
/**
 * The template for displaying product content within loops.
 *
 * Override this template by copying it to yourtheme/woocommerce/content-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $product;
$attributes = $product->get_attributes();
$options = get_post_meta( get_the_ID(), '_custom_wc_thumb_options', true );
$options2 = get_post_meta( get_the_ID(), '_custom_wc_options', true );
?>
<article <?php post_class(); ?>>
	<div class="product-thumb">
            <div class="overlay-loader">
                <div>
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>
            
	       <?php       
                    // Get time to set new product (day(s))
            			$new = isset( $options['wc-single-new-arrival'] ) ? $options['wc-single-new-arrival'] : '5';
            
            			$postdate      = get_the_time( 'Y-m-d' );
            			$postdatestamp = strtotime( $postdate );
            
            			if ( ( time() - ( 60 * 60 * 24 * (int) $new ) ) < $postdatestamp ) {
            				//echo '<span class="newpt">' . esc_html__( 'New', 'blance' ) . '</span>';
            			}

					echo '<a  href="' . esc_url( get_permalink() ) . '">';
						/**
						 * woocommerce_before_shop_loop_item_title hook.
						 *
						 * @hooked woocommerce_show_product_loop_sale_flash - 10
						 * @hooked woocommerce_template_loop_product_thumbnail - 10
						 */
						do_action( 'woocommerce_before_shop_loop_item_title' );
                    	echo '</a>';
                        if ( version_compare( WC_VERSION, '3.0.0', '<' ) ) {
                        	$attachment_ids = $product->get_gallery_image_ids();
                        } else {
                        	$attachment_ids = $product->get_gallery_image_ids();
                        }
                        if ( isset( $attachment_ids[0] ) ) {

                    		$attachment_id = $attachment_ids[0];
                    
                    		$title = get_the_title();
                    		$link  = get_the_permalink();
                    		$image = wp_get_attachment_image( $attachment_id, 'shop_catalog' );
                    
                    		echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', sprintf( '<a href="%s" class="gallery" title="%s">%s</a>', $link, $title, $image ), $attachment_id, $post->ID );
                    	}
                        
				
				
			?>
        <div class="inner">
        <div class="btn-inner-center">
            <?php 
                echo '<a href="' . $product->get_permalink() . '"  class="product-quick-view">'.esc_html('Vista rápida' , 'blance').'</a>';
                do_action('woocommerce_template_loop_add_to_cart'); 
             ?>
        </div>
        <div class="btn-inner-top">
          <?php 
          echo blance_wishlist_btn();
          echo blance_compare_btn();
          echo '<a href="' . $product->get_permalink() . '"  class="product-quick-view hidden-lg hidden-md"></a>'; 
                
           ?>
        </div>
        </div>
         <?php
            
            if(isset( $options2['wc-count-down'] ) && $options2['wc-count-down']  ) :
       ?>
       
        <div class="blance-countdown-timer">
				<div class="blance-timer" data-end-date="<?php echo esc_attr( $options2['wc-count-down'] ) ?>"></div>
        </div>
        
        <?php endif; ?>
         <?php
				if ( isset($options2['wc-attr']) && $options2['wc-attr'] ) {
                    $attrs = $options2['wc-attr'];
					echo '<div class="product-attr">';
		
							foreach ( $attrs as $attr ) {
							$attr_op = 'pa_' . $attr;
							foreach ( $attributes as $attribute ) {
								$values = wc_get_product_terms( absint( $product->get_id() ), $attribute['name'], array( 'fields' => 'names' ) );
								if ( $attr_op == $attribute['name'] ) {
									echo apply_filters( 'woocommerce_attribute', wpautop( wptexturize( implode( ', ', $values ) ) ), $attribute, $values );
								}
							}
						  }
						
					echo '</div>';
				}   	?>
	</div>
	<div class="product-content">
        <div class="item-top">
            <h5 class="product-title"> <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
            <?php do_action( 'woocommerce_after_shop_loop_item' );  ?>
        </div>
        <div class="item-bottom">
		<?php
        echo wc_get_product_category_list( get_the_id() );
        do_action('woocommerce_template_loop_price');
        
		?>
        </div>
        <div class="mobile-addtocart hidden-md hidden-lg hidden-sm"><?php do_action('woocommerce_template_loop_add_to_cart');  ?></div>
	</div>
</article>