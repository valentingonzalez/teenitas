<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see 	    http://docs.woothemes.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
// Get page options
$options = get_post_meta( get_the_ID(), '_custom_wc_options', true );
$thumb_position = ( is_array( $options ) && $options['wc-single-style'] == 1 && $options['wc-thumbnail-position'] ) ? $options['wc-thumbnail-position'] : ( cs_get_option( 'wc-thumbnail-position' ) ? cs_get_option( 'wc-thumbnail-position' ) : 'left' );
global $product;
// Get image to display size guide
$banner = ( isset( $options['wc-single-banner'] ) && $options['wc-single-banner'] ) ? $options['wc-single-banner'] : cs_get_option( 'wc-single-banner' );
$thumb_position = ( is_array( $options ) && $options['wc-single-style'] == 1 && $options['wc-thumbnail-position'] ) ? $options['wc-thumbnail-position'] : ( cs_get_option( 'wc-thumbnail-position' ) ? cs_get_option( 'wc-thumbnail-position' ) : 'left' );
?>

<?php
	/**
	 * woocommerce_before_single_product hook.
	 *
	 * @hooked wc_print_notices - 10
	 */
	do_action( 'woocommerce_before_single_product' );

	if ( post_password_required() ) { echo get_the_password_form(); return;  }
?>

<div  id="product-<?php the_ID(); ?>" <?php post_class('layout-1'); ?>> 
    <div class="product-top row row-same-height">
    <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-562f7aa6d38d8980" async="async"></script>
	<div class="content-product-left col-md-6 col-sm-7 col-xs-12">
		          <?php
					/**
					 * woocommerce_before_single_product_summary hook.
					 *
					 * @hooked woocommerce_show_product_sale_flash - 10
					 * @hooked woocommerce_show_product_images - 20
					 */
					do_action( 'woocommerce_before_single_product_summary' );
					?>
	</div>
    <div class="<?php echo $thumb_position; ?> content-product-right col-md-6 col-sm-5 col-xs-12">
				<div class="shop-top">
                        <?php 
                            do_action( 'woocommerce_template_single_title' ); 
                            do_action( 'woocommerce_template_single_price' ); 
                            do_action( 'woocommerce_template_single_rating' );
                         ?>
				</div>
				<div class="shop-bottom action <?php if( !$product->is_type( 'grouped' ) &&  !$product->is_type( 'external' )  ){ echo "quick-view-modal"; } ?> ">
                    <div class="description">
					<?php 
                        the_excerpt();
                    ?>
                    </div>
                    <?php    
                        do_action( 'woocommerce_template_single_add_to_cart' );
                        
                     ?>
                     <?php if( !$product->is_type( 'grouped' ) ){  ?>
                     <div class="yith-btn">
                        <?php 
                        echo blance_wishlist_btn();
                        echo blance_compare_btn(); 
                        ?>
                     </div>
                      <?php } ?>
                      <?php jws_blance_wc_add_extra_link_after_cart(); ?>
                      <div class="strap-product">
                       <?php
                        if ( defined( 'YITH_WFBT' ) ) {
                            global $product;
                            $product_id = yit_get_base_product_id( $product );
                            echo do_shortcode( '[ywfbt_form product_id="' . $product_id . '"]' );
                            }
			         ?>
                      </div>
                     <div class="info-product">
                     <?php 
                            do_action('woocommerce_template_single_meta');
                            jws_theme_woocommerce_sharing();
                      ?>
                     </div>
                     <?php
                		if ( $thumb_position == 'outside' ) {
                		  do_action( 'blance_after_single_product_image' );
                		}
                	?>
				</div>
	</div>
    </div>
    </div>
    <?php if($banner): ?>
     <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 text-center">
            <div class="banner-product">
                <?php jws_add_banner(); ?>
            </div>
    </div>
    <?php endif; ?>         
    </div>
    <?php 
        echo woocommerce_output_related_products();
     ?>
	<meta itemprop="url" content="<?php the_permalink(); ?>" />
<!-- #product-<?php the_ID(); ?> -->
<?php do_action( 'woocommerce_after_single_product' ); ?>