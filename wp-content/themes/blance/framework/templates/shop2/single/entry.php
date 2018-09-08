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

<div itemscope itemtype="<?php echo woocommerce_get_product_schema(); ?>" id="product-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="jwss-shop-single-wrap temp-shop2">
		<div class="jwss-shop-header">
			<div class="row">
				<div class="col-md-6">
					<div class="image-meta">
						<?php 
						do_action( 'woocommerce_show_product_sale_flash' ); 
						do_action( 'woocommerce_show_product_images' ); 
						//do_action( 'woocommerce_product_thumbnails' );
						?>
					</div>
				</div>
				<div class="col-md-6">
					<div class="extra-meta">
						<div class="item-meta block-title">
							<?php do_action( 'woocommerce_template_single_title' );  ?>
						</div>
						<div class="item-meta block-rating">
							<?php do_action( 'woocommerce_template_single_rating' );  ?>
						</div>
						<div class="item-meta block-excerpt">
							<?php do_action( 'woocommerce_template_single_excerpt' );  ?>
						</div>
						<div class="item-meta block-price">
							<?php do_action( 'woocommerce_template_single_price' );  ?>
						</div>
						<div class="item-meta block-cart">
							<?php do_action( 'woocommerce_template_single_add_to_cart' ); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="bt-content">
			<?php 
				do_action( 'woocommerce_output_product_data_tabs' );
				do_action( 'woocommerce_output_related_products' );
			?>
		</div>

		<meta itemprop="url" content="<?php the_permalink(); ?>" />
	</div>
</div><!-- #product-<?php the_ID(); ?> -->

<?php do_action( 'woocommerce_after_single_product' ); ?>