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
global $product;
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

<div  id="product-<?php the_ID(); ?>" <?php post_class(); ?>> 
    <div class="product-top row">
    <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-562f7aa6d38d8980" async="async"></script>
	<div class="content-product-left col-lg-6">
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
    <div class="content-product-right col-lg-6">
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
                            global $product;
                            $product_id = yit_get_base_product_id( $product );
                            echo do_shortcode( '[ywfbt_form product_id="' . $product_id . '"]' );
			         ?>
                      </div>
                     <div class="info-product">
                     <?php 
                            do_action('woocommerce_template_single_meta');
                            jws_theme_woocommerce_sharing();
                      ?>
                     </div>
				</div>
	</div>
    </div>
    </div>
    <div class="product-bottom row">
    <div class="col-lg-9">
            <div class="tab-product">
        		<?php do_action( 'woocommerce_output_product_data_tabs' ); ?>
        	</div>
    </div>        
    </div>
    <?php 
        echo woocommerce_output_related_products();
     ?>
	

	<meta itemprop="url" content="<?php the_permalink(); ?>" />
<!-- #product-<?php the_ID(); ?> -->
</div>
<?php do_action( 'woocommerce_after_single_product' ); ?>