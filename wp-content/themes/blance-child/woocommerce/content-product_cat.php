<?php
/**
 * The template for displaying product category thumbnails within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product_cat.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.6.1
 */
?>
<div <?php wc_product_cat_class( $category); ?>>
	
	<div class="category-content">

			<?php do_action( 'woocommerce_before_subcategory', $category ); ?>
			<div class="product-category-thumbnail">
				<?php
					/**
					 * woocommerce_before_subcategory_title hook
					 *
					 * @hooked blance_category_thumb_double_size - 10
					 */
					do_action( 'woocommerce_before_subcategory_title', $category );
				?>
			</div>
            <div class="inner">
            <h3 class="name-inner">
                <?php 
                    echo esc_html( $category->name );
                 ?>
            </h3>
            </div>
	
		<?php do_action( 'woocommerce_after_subcategory', $category ); ?>
	</div>
</div>