<?php
/**
 * The Template for displaying all single products.
 *
 * Override this template by copying it to yourtheme/woocommerce/single-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
// Get page options
$options = get_post_meta( get_the_ID(), '_custom_wc_options', true );
// Get product single style
$style = ( is_array( $options ) && $options['wc-single-style'] ) ? $options['wc-single-style'] : ( cs_get_option( 'wc-single-style' ) ? cs_get_option( 'wc-single-style' ) : '1' );
if(isset($options['wc-sidebar-detail'])) {
    $sidebar = $options['wc-sidebar-detail'];
}


get_header( 'shop' ); ?>
     <?php $page_title = cs_get_option('wc-detail-enable-page-title'); if($page_title == "1") : ?>
        <div class="page-header">
    	<div class="no_container">
    			<div class="page-breadcrumbs">
    				<?php
    			   jws_get_breadcrumbs();
                    //blance_products_links();
    				?>
    			</div>
    	
    	</div>
    </div>
    <?php endif; ?>
	<?php
		/**
		 * woocommerce_before_main_content hook
		 *
		 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
		 * @hooked woocommerce_breadcrumb - 20
		 */
		do_action( 'woocommerce_output_content_wrapper' );
	?>
    <div class="container">
	<div class="row <?php if($style == '1' &&  isset($options['enble-sidebar']) && $options['enble-sidebar'] ) {echo "row-same-height";} ?> ">
		
			<div class="<?php if($style == '1' &&  isset($options['enble-sidebar']) && $options['enble-sidebar'] ) : echo "col-lg-9 col-md-9 col-sm-12 col-xs-12 side-in " ; endif; ?> product-content">
					<?php while ( have_posts() ) : the_post(); ?>
						
						<?php wc_get_template_part( 'content', 'single-product' ); ?>
							
					<?php endwhile; // end of the loop. ?>
			</div>
            <?php if($style == '1' &&  isset($options['enble-sidebar']) && $options['enble-sidebar'] ) : ?>
            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 shop-detail-sidebar ">
            <div class="sticky-move">
                    <?php if ( is_active_sidebar( $sidebar ) ) {
               		   dynamic_sidebar( $sidebar );
                	} elseif ( is_active_sidebar( 'jws-sidebar-shop-detail' ) ) {
               		   dynamic_sidebar( 'jws-sidebar-shop-detail' );
                	} ?>
            </div>
            </div>	
            <?php endif; ?>		
		
	</div>
    </div>
	<?php
		/**
		 * woocommerce_after_main_content hook
		 *
		 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
		 */
		do_action( 'woocommerce_output_content_wrapper_end' );
	?>

<?php get_footer( 'shop' ); ?>
