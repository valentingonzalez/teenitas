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